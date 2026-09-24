<?php
declare(strict_types=1);

/* Copy this file to config.php on the server. Never commit config.php. */
return [
    'app' => [
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
        'google' => ['client_id' => 'YOUR_GOOGLE_CLIENT_ID', 'client_secret' => 'YOUR_GOOGLE_CLIENT_SECRET'],
        'github' => ['client_id' => 'YOUR_GITHUB_CLIENT_ID', 'client_secret' => 'YOUR_GITHUB_CLIENT_SECRET'],
    ],
    'interserver' => [
        'wsdl' => 'https://my.interserver.net/api.php?wsdl',
        'username' => 'YOUR_INTERSERVER_ACCOUNT_EMAIL',
        'api_key' => 'SET_ON_SERVER_ONLY',
        'markup' => 1.00,
    ],
    'pages' => [
        'login' => 'login.php',
    ],
];
