# Oxbothost live MySQL + Google/GitHub login

## 1. Server requirements

Your PHP hosting should have:
- PHP 8.1+ recommended
- PDO MySQL (`pdo_mysql`)
- cURL
- HTTPS enabled

## 2. MySQL

Create a MySQL database and database user, then copy `config.example.php` to `config.php`.

Fill in:
- `app.base_url`
- `db.host`
- `db.port`
- `db.name`
- `db.user`
- `db.password`

The PHP backend automatically creates the `users` and `user_identities` tables the first time the database connection succeeds.

## 3. Google OAuth

Create an OAuth 2.0 Web application in Google Cloud Console.

Set the authorized redirect URI to exactly:

`https://YOUR-DOMAIN.com/oauth/google.php`

Put the generated Client ID and Client Secret in `config.php` under `oauth.google`.

Google login requests the OpenID Connect `openid email profile` scopes.

## 4. GitHub OAuth

Create a GitHub OAuth App.

Set the callback URL to exactly:

`https://YOUR-DOMAIN.com/oauth/github.php`

Put the Client ID and Client Secret in `config.php` under `oauth.github`.

GitHub login requests `read:user user:email` so the account can be matched to a verified email.

## 5. Important

Do not commit `config.php`. It is ignored by Git.

The application links a social identity to an existing Oxbothost account when the verified provider email matches an existing email address. Otherwise it creates a new Oxbothost account.

OAuth state tokens are stored in the PHP session and expire after 10 minutes to prevent login CSRF.
