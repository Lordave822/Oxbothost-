<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $secure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function app_config(): array {
    static $config = null;
    if ($config !== null) return $config;

    $file = __DIR__ . '/config.php';
    if (is_file($file)) {
        $config = require $file;
    } else {
        $config = [
            'app' => ['base_url' => rtrim((string)(getenv('OXBO_BASE_URL') ?: ''), '/')],
            'db' => [
                'host' => (string)(getenv('OXBO_DB_HOST') ?: 'localhost'),
                'port' => (int)(getenv('OXBO_DB_PORT') ?: 3306),
                'name' => (string)(getenv('OXBO_DB_NAME') ?: 'oxbothost'),
                'user' => (string)(getenv('OXBO_DB_USER') ?: ''),
                'password' => (string)(getenv('OXBO_DB_PASSWORD') ?: ''),
            ],
            'oauth' => [
                'google' => [
                    'client_id' => (string)(getenv('GOOGLE_CLIENT_ID') ?: ''),
                    'client_secret' => (string)(getenv('GOOGLE_CLIENT_SECRET') ?: ''),
                ],
                'github' => [
                    'client_id' => (string)(getenv('GITHUB_CLIENT_ID') ?: ''),
                    'client_secret' => (string)(getenv('GITHUB_CLIENT_SECRET') ?: ''),
                ],
            ],
        ];
    }

    return $config;
}

function db(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;

    $cfg = app_config();
    foreach (['host', 'port', 'name', 'user'] as $key) {
        if (!isset($cfg['db'][$key]) || $cfg['db'][$key] === '') {
            throw new RuntimeException('MySQL database configuration is incomplete.');
        }
    }

    $dsn = sprintf(
        'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
        $cfg['db']['host'],
        (int)$cfg['db']['port'],
        $cfg['db']['name']
    );

    $pdo = new PDO($dsn, (string)$cfg['db']['user'], (string)($cfg['db']['password'] ?? ''), [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    $pdo->exec('
        CREATE TABLE IF NOT EXISTS users (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(120) NOT NULL,
            email VARCHAR(190) NOT NULL,
            country CHAR(2) NOT NULL DEFAULT "",
            dial_code VARCHAR(8) NOT NULL DEFAULT "",
            phone VARCHAR(24) NOT NULL DEFAULT "",
            password_hash VARCHAR(255) NULL,
            avatar_url VARCHAR(500) NULL,
            email_verified TINYINT(1) NOT NULL DEFAULT 0,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY uq_users_email (email)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ');

    $pdo->exec('
        CREATE TABLE IF NOT EXISTS user_identities (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            user_id BIGINT UNSIGNED NOT NULL,
            provider VARCHAR(20) NOT NULL,
            provider_user_id VARCHAR(190) NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY uq_identity (provider, provider_user_id),
            KEY idx_identity_user (user_id),
            CONSTRAINT fk_identity_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ');

    return $pdo;
}

function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}

function verify_csrf(?string $token): bool {
    return is_string($token) && isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}

function redirect_to(string $path): never {
    header('Location: ' . $path, true, 303);
    exit;
}

function login_user(array $user): void {
    session_regenerate_id(true);
    $_SESSION['user_id'] = (int)$user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_email'] = $user['email'];
    unset($_SESSION['csrf']);
}

function current_user(): ?array {
    if (empty($_SESSION['user_id'])) return null;

    $stmt = db()->prepare('SELECT id, name, email, country, dial_code, phone, avatar_url, email_verified, created_at FROM users WHERE id = ? LIMIT 1');
    $stmt->execute([(int)$_SESSION['user_id']]);
    $user = $stmt->fetch();

    if (!$user) {
        unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_email']);
        return null;
    }
    return $user;
}

function require_login(): array {
    $user = current_user();
    if (!$user) redirect_to('login.php?error=auth');
    return $user;
}

function logout_user(): void {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, [
            'expires' => time() - 42000,
            'path' => $params['path'],
            'domain' => $params['domain'] ?? '',
            'secure' => (bool)$params['secure'],
            'httponly' => (bool)$params['httponly'],
            'samesite' => $params['samesite'] ?? 'Lax',
        ]);
    }
    session_destroy();
}
