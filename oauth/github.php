<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';

try {
    $cfg = oauth_config('github');
    $redirectUri = app_url('oauth/github.php');

    if (!isset($_GET['code'])) {
        if (isset($_GET['error'])) {
            redirect_to('../login.php?error=oauth');
        }

        $state = oauth_state('github');
        $query = http_build_query([
            'client_id' => $cfg['client_id'],
            'redirect_uri' => $redirectUri,
            'scope' => 'read:user user:email',
            'state' => $state,
        ]);
        header('Location: https://github.com/login/oauth/authorize?' . $query, true, 302);
        exit;
    }

    if (!verify_oauth_state('github', $_GET['state'] ?? null)) {
        redirect_to('../login.php?error=oauth');
    }

    $token = http_json(
        'https://github.com/login/oauth/access_token',
        'POST',
        ['Accept: application/json'],
        [
            'client_id' => $cfg['client_id'],
            'client_secret' => $cfg['client_secret'],
            'code' => (string)$_GET['code'],
            'redirect_uri' => $redirectUri,
        ]
    );

    if (empty($token['access_token'])) {
        throw new RuntimeException('GitHub did not return an access token.');
    }

    $headers = [
        'Authorization: Bearer ' . $token['access_token'],
        'X-GitHub-Api-Version: 2022-11-28',
    ];

    $profile = http_json('https://api.github.com/user', 'GET', $headers);
    $emails = http_json('https://api.github.com/user/emails', 'GET', $headers);

    $email = '';
    $verified = false;
    foreach ($emails as $item) {
        if (!is_array($item) || empty($item['email'])) continue;
        if (($item['primary'] ?? false) && ($item['verified'] ?? false)) {
            $email = (string)$item['email'];
            $verified = true;
            break;
        }
    }
    if ($email === '') {
        foreach ($emails as $item) {
            if (is_array($item) && !empty($item['email']) && ($item['verified'] ?? false)) {
                $email = (string)$item['email'];
                $verified = true;
                break;
            }
        }
    }

    if ($email === '') {
        throw new RuntimeException('GitHub did not provide a verified email address.');
    }

    $displayName = trim((string)($profile['name'] ?? ''));
    if ($displayName === '') $displayName = trim((string)($profile['login'] ?? ''));

    oauth_login_user(
        'github',
        (string)($profile['id'] ?? ''),
        $email,
        $displayName,
        isset($profile['avatar_url']) ? (string)$profile['avatar_url'] : null,
        $verified
    );

    redirect_to('../dashboard.php');
} catch (Throwable $e) {
    error_log('GitHub OAuth: ' . $e->getMessage());
    redirect_to('../login.php?error=oauth');
}
