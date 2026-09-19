<?php
declare(strict_types=1);

/*
 * Copy this file to config.php on your server and fill in your real values.
 * NEVER commit config.php or OAuth client secrets to Git.
 */
return [
    'app' => [
        // Exact public URL of this installation, without a trailing slash.
        // Example: https://oxbothost.com
        'base_url' => 'https://YOUR-DOMAIN.example',
    ],

    'db' => [
        'host' => 'localhost',
        'port' => 3306,
        'name' => 'oxbothost',
        'user' => 'YOUR_MYSQL_USER',
        'password' => 'YOUR_MYSQL_PASSWORD',
    ],

    'oauth' => [
        'google' => [
            'client_id' => 'YOUR_GOOGLE_CLIENT_ID',
            'client_secret' => 'YOUR_GOOGLE_CLIENT_SECRET',
        ],
        'github' => [
            'client_id' => 'YOUR_GITHUB_CLIENT_ID',
            'client_secret' => 'YOUR_GITHUB_CLIENT_SECRET',
        ],
    ],
];
