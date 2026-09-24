<?php
declare(strict_types=1);
require __DIR__.'/bootstrap.php';
require_once __DIR__.'/wallet.php';
$user=require_login();
if($_SERVER['REQUEST_METHOD']!=='POST' || !verify_csrf($_POST['csrf']??null)){http_response_code(400);exit('Invalid request.');}
$amount=round((float)($_POST['amount']??0),2);
if($amount<1 || $amount>5000){header('Location: dashboard.php?wallet_error='.rawurlencode('Deposit amount must be between $1 and $5,000.'),true,303);exit;}
$pdo=db();
$pdo->exec('CREATE TABLE IF NOT EXISTS wallet_deposits (id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,user_id BIGINT UNSIGNED NOT NULL,amount DECIMAL(12,2) NOT NULL,reference VARCHAR(120) NOT NULL UNIQUE,status VARCHAR(20) NOT NULL DEFAULT "pending",provider VARCHAR(40) NOT NULL DEFAULT "unconfigured",created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,paid_at TIMESTAMP NULL,KEY idx_deposits_user (user_id,created_at),CONSTRAINT fk_deposit_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');
$reference='deposit-'.bin2hex(random_bytes(10));
$pdo->prepare('INSERT INTO wallet_deposits(user_id,amount,reference) VALUES(?,?,?)')->execute([(int)$user['id'],$amount,$reference]);
header('Location: dashboard.php?wallet_error='.rawurlencode('Deposit created as pending. Connect your payment provider webhook to credit the balance.'),true,303);exit;
