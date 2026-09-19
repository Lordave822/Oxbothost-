<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';

try {
    $cfg = oauth_config('google');
    $redirectUri = app_url('oauth/google.php');

    if (!isset($_GET['code'])) {
        if (isset($_GET['error'])) {
            redirect_to('../login.php?error=oauth');
        }

        $state = oauth_state('google');
        $query = http_build_query([
            'client_id' => $cfg['client_id'],
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'prompt' => 'select_account',
        ]);
        header('Location: https://accounts.google.com/o/oauth2/v2/auth?' . $query, true, 302);
        exit;
    }

    if (!verify_oauth_state('google', $_GET['state'] ?? null)) {
        redirect_to('../login.php?error=oauth');
    }

    $token = http_json('https://oauth2.googleapis.com/token', 'POST', [], [
        'code' => (string)$_GET['code'],
        'client_id' => $cfg['client_id'],
        'client_secret' => $cfg['client_secret'],
        'redirect_uri' => $redirectUri,
        'grant_type' => 'authorization_code',
    ]);

    if (empty($token['access_token'])) {
        throw new RuntimeException('Google did not return an access token.');
    }

    $profile = http_json(
        'https://openidconnect.googleapis.com/v1/userinfo',
        'GET',
        ['Authorization: Bearer ' . $token['access_token']]
    );

    oauth_login_user(
        'google',
        (string)($profile['sub'] ?? ''),
        (string)($profile['email'] ?? ''),
        (string)($profile['name'] ?? ''),
        isset($profile['picture']) ? (string)$profile['picture'] : null,
        (bool)($profile['email_verified'] ?? false)
    );

    redirect_to('../dashboard.php');
} catch (Throwable $e) {
    error_log('Google OAuth: ' . $e->getMessage());
    redirect_to('../login.php?error=oauth');
}
