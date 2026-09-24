<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';

function cfg(?string $key = null, mixed $default = null): mixed {
    $config = app_config();
    if ($key === null) return $config;
    $value = $config;
    foreach (explode('.', $key) as $part) {
        if (!is_array($value) || !array_key_exists($part, $value)) {
            $env = [
                'interserver.api_key' => getenv('INTERSERVER_API_KEY') ?: null,
                'interserver.username' => getenv('INTERSERVER_USERNAME') ?: null,
                'interserver.markup' => getenv('INTERSERVER_MARKUP') !== false ? (float)getenv('INTERSERVER_MARKUP') : null,
                'pages.login' => 'login.php',
            ];
            return array_key_exists($key, $env) && $env[$key] !== null ? $env[$key] : $default;
        }
        $value = $value[$part];
    }
    return $value;
}

function oxb_install_tables(): void {
    $pdo = db();
    $pdo->exec('CREATE TABLE IF NOT EXISTS wallet_accounts (
        user_id BIGINT UNSIGNED NOT NULL PRIMARY KEY,
        balance DECIMAL(12,2) NOT NULL DEFAULT 0.00,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        CONSTRAINT fk_wallet_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');
    $pdo->exec('CREATE TABLE IF NOT EXISTS wallet_transactions (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id BIGINT UNSIGNED NOT NULL,
        type VARCHAR(30) NOT NULL,
        amount DECIMAL(12,2) NOT NULL,
        description VARCHAR(255) NOT NULL DEFAULT "",
        reference VARCHAR(120) NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        KEY idx_wallet_tx_user_date (user_id, created_at),
        UNIQUE KEY uq_wallet_reference (reference),
        CONSTRAINT fk_wallet_tx_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');
    $pdo->exec('CREATE TABLE IF NOT EXISTS oxb_orders (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id BIGINT UNSIGNED NOT NULL,
        category VARCHAR(40) NOT NULL,
        product_id VARCHAR(120) NOT NULL,
        title VARCHAR(190) NOT NULL,
        amount DECIMAL(12,2) NOT NULL,
        provider_service_id VARCHAR(120) NULL,
        provider_invoice_id VARCHAR(120) NULL,
        status VARCHAR(30) NOT NULL DEFAULT "pending",
        metadata_json LONGTEXT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        KEY idx_oxb_orders_user_date (user_id, created_at),
        CONSTRAINT fk_oxb_order_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');
}

oxb_install_tables();
