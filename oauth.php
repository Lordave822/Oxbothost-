<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';

$provider = strtolower(trim((string)($_GET['provider'] ?? '')));
$action = ($_GET['action'] ?? '') === 'callback' ? 'callback' : 'start';

if (!in_array($provider, ['google', 'github'], true)) {
    http_response_code(404);
    exit('Unknown sign-in provider.');
}

$config = app_config();
$oauth = $config['oauth'][$provider] ?? null;
if (!is_array($oauth) || empty($oauth['client_id']) || empty($oauth['client_secret'])) {
    http_response_code(503);
    exit('This sign-in provider is not configured yet.');
}

$baseUrl = rtrim((string)$config['app']['base_url'], '/');
$redirectUri = $baseUrl . '/auth/' . $provider . '/callback';

if ($action === 'start') {
    $state = bin2hex(random_bytes(32));
    $_SESSION['oauth_state'] = $state;
    $_SESSION['oauth_provider'] = $provider;

    if ($provider === 'google') {
        $params = [
            'client_id' => $oauth['client_id'],
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'access_type' => 'online',
            'prompt' => 'select_account',
        ];
        redirect_external('https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params));
    }

    $params = [
        'client_id' => $oauth['client_id'],
        'redirect_uri' => $redirectUri,
        'scope' => 'read:user user:email',
        'state' => $state,
        'allow_signup' => 'true',
    ];
    redirect_external('https://github.com/login/oauth/authorize?' . http_build_query($params));
}

if (!hash_equals((string)($_SESSION['oauth_state'] ?? ''), (string)($_GET['state'] ?? '')) ||
    ($_SESSION['oauth_provider'] ?? '') !== $provider) {
    unset($_SESSION['oauth_state'], $_SESSION['oauth_provider']);
    redirect_to('login.php?error=oauth');
}

if (!empty($_GET['error'])) {
    unset($_SESSION['oauth_state'], $_SESSION['oauth_provider']);
    redirect_to('login.php?error=oauth');
}

$code = trim((string)($_GET['code'] ?? ''));
if ($code === '') {
    redirect_to('login.php?error=oauth');
}

try {
    $token = oauth_post_token($provider, $oauth, $code, $redirectUri);
    $profile = $provider === 'google'
        ? google_profile($token['access_token'])
        : github_profile($token['access_token']);

    $email = strtolower(trim((string)($profile['email'] ?? '')));
    $providerId = trim((string)($profile['provider_id'] ?? ''));
    $name = trim((string)($profile['name'] ?? ''));
    $avatar = trim((string)($profile['avatar_url'] ?? ''));

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $providerId === '') {
        throw new RuntimeException('The provider did not return the required account details.');
    }

    $pdo = db();
    $pdo->beginTransaction();

    $identityStmt = $pdo->prepare('SELECT u.* FROM user_identities i INNER JOIN users u ON u.id = i.user_id WHERE i.provider = ? AND i.provider_user_id = ? LIMIT 1');
    $identityStmt->execute([$provider, $providerId]);
    $user = $identityStmt->fetch();

    if (!$user) {
        $emailStmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $emailStmt->execute([$email]);
        $user = $emailStmt->fetch();

        if ($user) {
            $update = $pdo->prepare('UPDATE users SET name = ?, avatar_url = ?, email_verified = 1, updated_at = CURRENT_TIMESTAMP WHERE id = ?');
            $update->execute([$name !== '' ? $name : $user['name'], $avatar !== '' ? $avatar : ($user['avatar_url'] ?? null), $user['id']]);
        } else {
            $insert = $pdo->prepare('INSERT INTO users (name, email, country, dial_code, phone, password_hash, avatar_url, email_verified) VALUES (?, ?, ?, ?, ?, NULL, ?, 1)');
            $insert->execute([$name !== '' ? $name : $email, $email, '', '', '', $avatar !== '' ? $avatar : null]);
            $user = $pdo->query('SELECT * FROM users WHERE id = ' . (int)$pdo->lastInsertId())->fetch();
        }

        $link = $pdo->prepare('INSERT INTO user_identities (user_id, provider, provider_user_id) VALUES (?, ?, ?)');
        $link->execute([$user['id'], $provider, $providerId]);
    }

    $pdo->commit();

    unset($_SESSION['oauth_state'], $_SESSION['oauth_provider']);
    login_user($user);
    redirect_to('dashboard.php');
} catch (Throwable $e) {
    if (isset($pdo) && $pdo instanceof PDO && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log('OAuth login failed: ' . $e->getMessage());
    redirect_to('login.php?error=oauth');
}

function redirect_external(string $url): never {
    header('Location: ' . $url, true, 302);
    exit;
}

function oauth_post_token(string $provider, array $oauth, string $code, string $redirectUri): array {
    if ($provider === 'google') {
        $url = 'https://oauth2.googleapis.com/token';
        $body = [
            'code' => $code,
            'client_id' => $oauth['client_id'],
            'client_secret' => $oauth['client_secret'],
            'redirect_uri' => $redirectUri,
            'grant_type' => 'authorization_code',
        ];
    } else {
        $url = 'https://github.com/login/oauth/access_token';
        $body = [
            'code' => $code,
            'client_id' => $oauth['client_id'],
            'client_secret' => $oauth['client_secret'],
            'redirect_uri' => $redirectUri,
        ];
    }

    $response = http_request($url, 'POST', $body, [
        'Accept: application/json',
        'Content-Type: application/x-www-form-urlencoded',
    ]);

    $json = json_decode($response, true);
    if (!is_array($json) || empty($json['access_token'])) {
        throw new RuntimeException('OAuth token exchange failed.');
    }
    return $json;
}

function google_profile(string $accessToken): array {
    $response = http_request('https://openidconnect.googleapis.com/v1/userinfo', 'GET', null, [
        'Authorization: Bearer ' . $accessToken,
        'Accept: application/json',
    ]);
    $json = json_decode($response, true);
    if (!is_array($json)) throw new RuntimeException('Invalid Google profile response.');

    return [
        'provider_id' => (string)($json['sub'] ?? ''),
        'email' => (string)($json['email'] ?? ''),
        'name' => (string)($json['name'] ?? ''),
        'avatar_url' => (string)($json['picture'] ?? ''),
    ];
}

function github_profile(string $accessToken): array {
    $headers = [
        'Authorization: Bearer ' . $accessToken,
        'Accept: application/vnd.github+json',
        'X-GitHub-Api-Version: 2022-11-28',
        'User-Agent: Oxbothost',
    ];
    $userResponse = http_request('https://api.github.com/user', 'GET', null, $headers);
    $user = json_decode($userResponse, true);
    if (!is_array($user) || empty($user['id'])) throw new RuntimeException('Invalid GitHub profile response.');

    $email = strtolower(trim((string)($user['email'] ?? '')));
    if ($email === '') {
        $emailResponse = http_request('https://api.github.com/user/emails', 'GET', null, $headers);
        $emails = json_decode($emailResponse, true);
        if (is_array($emails)) {
            foreach ($emails as $item) {
                if (!empty($item['email']) && !empty($item['verified']) && !empty($item['primary'])) {
                    $email = strtolower(trim((string)$item['email']));
                    break;
                }
            }
            if ($email === '') {
                foreach ($emails as $item) {
                    if (!empty($item['email']) && !empty($item['verified'])) {
                        $email = strtolower(trim((string)$item['email']));
                        break;
                    }
                }
            }
        }
    }

    return [
        'provider_id' => (string)$user['id'],
        'email' => $email,
        'name' => trim((string)($user['name'] ?? $user['login'] ?? '')),
        'avatar_url' => trim((string)($user['avatar_url'] ?? '')),
    ];
}

function http_request(string $url, string $method, ?array $form, array $headers): string {
    if (!function_exists('curl_init')) {
        throw new RuntimeException('PHP cURL is required for social login.');
    }

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => $headers,
    ]);
    if ($form !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($form));
    }

    $body = curl_exec($ch);
    $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($body === false || $error !== '') throw new RuntimeException('OAuth network request failed.');
    if ($status < 200 || $status >= 300) throw new RuntimeException('OAuth provider returned HTTP ' . $status . '.');

    return (string)$body;
}
