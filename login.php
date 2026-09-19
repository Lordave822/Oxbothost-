<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';

if (current_user()) redirect_to('dashboard.php');

$error = $_GET['error'] ?? '';
$messages = [
    'invalid' => 'Incorrect email or password. Try again.',
    'auth' => 'Please log in to continue.',
    'oauth' => 'We could not complete social sign-in. Please try again or use your email.'
];
$notice = $messages[$error] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf'] ?? null)) {
        $notice = 'Your session expired. Please refresh and try again.';
    } else {
        $email = strtolower(trim((string)($_POST['email'] ?? '')));
        $password = (string)($_POST['password'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            redirect_to('login.php?error=invalid');
        }
        $stmt = db()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if (!$user || !password_verify($password, $user['password_hash'])) {
            redirect_to('login.php?error=invalid');
        }
        if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $update = db()->prepare('UPDATE users SET password_hash = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?');
            $update->execute([$hash, $user['id']]);
        }
        login_user($user);
        redirect_to('dashboard.php');
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="color-scheme" content="light dark">
<title>Log in | oxbothost</title>
<meta name="description" content="Log in to your oxbothost account.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,300..800&display=swap" rel="stylesheet">
<style>
:root{color-scheme:light dark;--bg:#fff;--fg:#000;--muted:#4d4d4d;--line:#000;--soft:#d9d9d9;--ibg:#000;--ifg:#fff;--imuted:#d0d0d0;--iline:#fff;--isoft:#4d4d4d;--gutter:clamp(16px,4vw,32px)}
@media(prefers-color-scheme:dark){:root:not([data-theme="light"]){--bg:#000;--fg:#fff;--muted:#d0d0d0;--line:#fff;--soft:#4d4d4d;--ibg:#fff;--ifg:#000;--imuted:#4d4d4d;--iline:#000;--isoft:#d9d9d9}}
:root[data-theme="dark"]{color-scheme:dark;--bg:#000;--fg:#fff;--muted:#d0d0d0;--line:#fff;--soft:#4d4d4d;--ibg:#fff;--ifg:#000;--imuted:#4d4d4d;--iline:#000;--isoft:#d9d9d9}
*{box-sizing:border-box;margin:0;padding:0}html{-webkit-text-size-adjust:100%}body{background:var(--bg);color:var(--fg);font-family:"Bricolage Grotesque",ui-sans-serif,system-ui,sans-serif;font-size:15px;line-height:1.45;-webkit-font-smoothing:antialiased}a{color:inherit}button,input{font:inherit;color:inherit}svg{display:block;max-width:100%}:focus-visible{outline:2px solid var(--fg);outline-offset:3px}
.page{display:grid;grid-template-columns:1fr 1fr;min-height:100vh;min-height:100dvh}.side{position:relative;overflow:hidden;padding:clamp(24px,4vw,44px);display:flex;flex-direction:column;justify-content:space-between;gap:40px}.side>*{position:relative;z-index:1}.inv{background:var(--ibg);color:var(--ifg);--bg:var(--ibg);--fg:var(--ifg);--muted:var(--imuted);--line:var(--iline);--soft:var(--isoft)}.brand{display:inline-flex;align-items:center;gap:9px;font-size:1.2rem;letter-spacing:-.04em;text-decoration:none;width:max-content}.brand b{font-weight:800}.brand span span{font-weight:400}.rings{position:absolute!important;z-index:0!important;width:650px;height:650px;right:-280px;top:-180px;pointer-events:none}.side h2{font-size:clamp(2.1rem,4vw,3.7rem);font-weight:800;letter-spacing:-.05em;line-height:.95;max-width:11ch}.side p{margin-top:16px;color:var(--muted);font-size:.98rem;max-width:32ch}.side .fine{margin-top:0;font-size:.78rem}.main{display:flex;align-items:center;justify-content:center;padding:clamp(24px,5vw,48px) max(var(--gutter),env(safe-area-inset-left)) clamp(24px,5vw,48px) max(var(--gutter),env(safe-area-inset-right))}.card{width:100%;max-width:400px}h1{font-size:clamp(2rem,4.5vw,2.8rem);font-weight:800;letter-spacing:-.05em;line-height:1}.lead{margin-top:9px;color:var(--muted);font-size:.95rem}.notice{margin:16px 0;padding:12px 14px;border:1.5px solid var(--fg);border-radius:12px;font-size:.9rem}.social{display:grid;gap:8px;margin-top:22px}.btn{display:inline-flex;align-items:center;justify-content:center;gap:10px;width:100%;min-height:48px;padding:0 18px;border-radius:999px;border:1.5px solid var(--fg);background:var(--fg);color:var(--bg);font-weight:600;font-size:.94rem;text-decoration:none;cursor:pointer}.btn.ghost{background:transparent;color:var(--fg)}.btn:hover{opacity:.78}.btn:disabled{opacity:.6;cursor:progress}.or{display:flex;align-items:center;gap:12px;margin:20px 0;color:var(--muted);font-size:.82rem}.or:before,.or:after{content:"";flex:1;border-top:1px solid var(--soft)}.field{margin-bottom:14px}.label-row{display:flex;justify-content:space-between;align-items:baseline;gap:10px;margin-bottom:6px}label{font-weight:600;font-size:.86rem}.label-row a{font-size:.82rem;color:var(--muted)}input[type=email],input[type=password]{width:100%;height:50px;padding:0 14px;border:1.5px solid var(--fg);border-radius:12px;background:var(--bg);color:var(--fg);font-size:.94rem}input::placeholder{color:var(--muted);opacity:1}.pw{position:relative}.pw input{padding-right:68px}.toggle{position:absolute;right:6px;top:50%;transform:translateY(-50%);height:38px;padding:0 10px;border:0;border-radius:999px;background:transparent;font-weight:600;font-size:.82rem;cursor:pointer}.check{display:flex;align-items:center;gap:10px;margin:2px 0 18px;font-size:.88rem}.check input{width:20px;height:20px;accent-color:var(--fg)}.alt{margin-top:20px;text-align:center;color:var(--muted);font-size:.9rem}.alt a{color:var(--fg);font-weight:600}.terms{margin-top:10px;text-align:center;color:var(--muted);font-size:.76rem}.terms a{color:var(--muted)}
@media(max-width:800px){.page{grid-template-columns:1fr;grid-template-rows:auto 1fr}.side{height:56px;flex-direction:row;align-items:center;padding:0 max(var(--gutter),env(safe-area-inset-left));border-bottom:1px solid var(--soft)}.side .copy,.side .fine,.rings{display:none}.main{align-items:flex-start;padding-top:26px}.card{max-width:430px}}
@media(max-width:430px){body{font-size:14px}.main{padding-top:22px}.btn{min-height:46px}.social{margin-top:18px}.or{margin:17px 0}}
</style>
</head>
<body>
<div class="page">
<aside class="side inv">
<svg class="rings" viewBox="0 0 650 650" aria-hidden="true" fill="none" stroke="currentColor"><circle cx="325" cy="325" r="318"/><circle cx="325" cy="325" r="255"/><circle cx="325" cy="325" r="192"/><circle cx="325" cy="325" r="129"/><circle cx="325" cy="325" r="45" fill="currentColor" stroke="none"/></svg>
<a class="brand" href="index.php" aria-label="oxbothost home"><img class="brand-logo" src="assets/oxbothost-logo.svg" alt="oxbothost home" width="30" height="30" loading="eager"><span><b>oxbothost</b></span></a>
<div class="copy"><h2>Your servers are waiting.</h2><p>Log in to manage your VPS, web hosting and domains from one dashboard.</p></div><p class="fine">&copy; 2026 oxbothost</p>
</aside>
<main class="main"><div class="card">
<h1>Log in</h1><p class="lead">Welcome back. Sign in to continue.</p>
<?php if ($notice): ?><div class="notice" role="alert"><?= htmlspecialchars($notice, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
<div class="social"><a class="btn ghost" href="/auth/google">Continue with Google</a><a class="btn ghost" href="/auth/github">Continue with GitHub</a></div>
<div class="or" role="separator">or use your email</div>
<form method="post" action="login.php">
<input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
<div class="field"><div class="label-row"><label for="email">Email</label></div><input id="email" name="email" type="email" autocomplete="username" required></div>
<div class="field"><div class="label-row"><label for="password">Password</label><a href="/forgot-password">Forgot password?</a></div><div class="pw"><input id="password" name="password" type="password" autocomplete="current-password" required><button class="toggle" type="button" onclick="togglePassword()">Show</button></div></div>
<label class="check"><input type="checkbox" name="remember" value="1"><span>Keep me signed in</span></label>
<button class="btn" type="submit">Log in</button>
</form>
<p class="alt">New to oxbothost? <a href="register.php">Create an account</a></p><p class="terms">By continuing you agree to our <a href="/terms">Terms</a> and <a href="/privacy">Privacy Policy</a>.</p>
</div></main></div>
<script>function togglePassword(){const p=document.getElementById('password'),b=document.querySelector('.toggle');p.type=p.type==='password'?'text':'password';b.textContent=p.type==='password'?'Show':'Hide';}</script>
</body></html>