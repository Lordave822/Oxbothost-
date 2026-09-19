<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf($_POST['csrf'] ?? null)) {
    http_response_code(400);
    exit('Invalid request.');
}
logout_user();
redirect_to('login.php');
