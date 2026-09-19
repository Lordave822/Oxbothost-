<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="color-scheme" content="light dark">
<title>Log in | oxbothost</title>
<meta name="description" content="Log in to your oxbothost account to manage VPS, web hosting and domains.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,300..800&display=swap" rel="stylesheet">
<!--
  HOW TO CONNECT THIS PAGE TO YOUR BACKEND
  1. Form:        <form action="/login" method="post">  posts "email", "password" and "remember".
  2. Google:      the "Continue with Google" link goes to /auth/google  (start your OAuth flow there).
  3. GitHub:      the "Continue with GitHub" link goes to /auth/github  (start your OAuth flow there).
  4. Errors:      redirect back to this page with ?error=invalid or ?error=oauth to show a message.
  5. Last step:   in the script at the bottom, change  var DEMO = true;  to  false.
                  While DEMO is true, buttons only show a preview message and nothing is sent.
  Add a CSRF token as a hidden input inside the form if your backend uses one.
-->
<style>
:root{
  color-scheme:light dark;
  --bg:#fff; --fg:#000; --muted:#4d4d4d; --line:#000; --soft:#d9d9d9;
  --ibg:#000; --ifg:#fff; --imuted:#d0d0d0; --iline:#fff; --isoft:#4d4d4d;
  --gutter:clamp(20px,5vw,40px);
}
@media (prefers-color-scheme: dark){
  :root:not([data-theme="light"]){
    --bg:#000; --fg:#fff; --muted:#d0d0d0; --line:#fff; --soft:#4d4d4d;
    --ibg:#fff; --ifg:#000; --imuted:#4d4d4d; --iline:#000; --isoft:#d9d9d9;
  }
}
:root[data-theme="dark"]{
  color-scheme:dark;
  --bg:#000; --fg:#fff; --muted:#d0d0d0; --line:#fff; --soft:#4d4d4d;
  --ibg:#fff; --ifg:#000; --imuted:#4d4d4d; --iline:#000; --isoft:#d9d9d9;
}
:root[data-theme="light"]{color-scheme:light}

*{box-sizing:border-box;margin:0;padding:0}
html{-webkit-text-size-adjust:100%}
body{
  background:var(--bg);color:var(--fg);
  font-family:"Bricolage Grotesque",ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;
  font-size:17px;line-height:1.5;-webkit-font-smoothing:antialiased;
}
a{color:inherit;-webkit-tap-highlight-color:transparent}
button,input{font:inherit;color:inherit}
svg{display:block;max-width:100%}
:focus-visible{outline:2px solid var(--fg);outline-offset:3px}

/* the black side swaps the tokens, so everything inside just works */
.inv{--bg:var(--ibg);--fg:var(--ifg);--muted:var(--imuted);--line:var(--iline);--soft:var(--isoft);background:var(--bg);color:var(--fg)}

.page{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);min-height:100vh;min-height:100dvh}

/* ---------- brand side ---------- */
.side{position:relative;overflow:hidden;padding:clamp(28px,4vw,52px);display:flex;flex-direction:column;justify-content:space-between;gap:48px}
.side>*{position:relative;z-index:1}
.brand{display:inline-flex;align-items:center;gap:10px;font-size:1.4rem;letter-spacing:-.04em;text-decoration:none;width:max-content}
.brand b{font-weight:800}
.brand span span{font-weight:400}
.rings{position:absolute!important;z-index:0!important;width:760px;height:760px;right:-300px;top:-220px;pointer-events:none}
.side h2{font-size:clamp(2.6rem,4.6vw,4.4rem);font-weight:800;letter-spacing:-.05em;line-height:.95;max-width:11ch;text-wrap:balance}
.side p{margin-top:20px;color:var(--muted);font-size:1.1rem;max-width:34ch}
.side .fine{margin-top:0;font-size:.86rem}

/* ---------- form side ---------- */
.main{display:flex;align-items:center;justify-content:center;padding:clamp(32px,6vw,64px) max(var(--gutter),env(safe-area-inset-left)) clamp(32px,6vw,64px) max(var(--gutter),env(safe-area-inset-right))}
.card{width:100%;max-width:420px}
h1{font-size:clamp(2.4rem,5vw,3.2rem);font-weight:800;letter-spacing:-.05em;line-height:1}
.lead{margin-top:12px;color:var(--muted)}

.social{display:grid;gap:10px;margin-top:30px}
.btn{
  display:inline-flex;align-items:center;justify-content:center;gap:12px;width:100%;height:54px;padding:0 24px;
  border-radius:999px;border:1.5px solid var(--fg);background:var(--fg);color:var(--bg);
  font-weight:600;font-size:1.02rem;text-decoration:none;cursor:pointer;touch-action:manipulation;
  transition:background .15s,color .15s;
}
.btn:hover{background:transparent;color:var(--fg)}
.btn.ghost{background:transparent;color:var(--fg)}
.btn.ghost:hover{background:var(--fg);color:var(--bg)}
.btn:disabled{opacity:.6;cursor:progress}
.btn svg{flex:none}

.or{display:flex;align-items:center;gap:14px;margin:26px 0;color:var(--muted);font-size:.9rem}
.or::before,.or::after{content:"";flex:1;border-top:1px solid var(--soft)}

.field{margin-bottom:18px}
.label-row{display:flex;justify-content:space-between;align-items:baseline;gap:12px;margin-bottom:8px}
label,.label{font-weight:600;font-size:.95rem}
.label-row a{font-size:.9rem;color:var(--muted)}
.label-row a:hover{color:var(--fg)}
input[type="email"],input[type="password"],input[type="text"]{
  width:100%;height:56px;padding:0 16px;border:1.5px solid var(--fg);border-radius:14px;background:var(--bg);color:var(--fg);font-size:1rem;
}
input::placeholder{color:var(--muted);opacity:1}
input:focus-visible{outline:2px solid var(--fg);outline-offset:2px}
.pw{position:relative}
.pw input{padding-right:76px}
.toggle{display:none;position:absolute;right:8px;top:50%;transform:translateY(-50%);height:40px;padding:0 12px;border:0;border-radius:999px;background:transparent;font-weight:600;font-size:.9rem;cursor:pointer}
.js .toggle{display:block}
.err{display:none;margin-top:8px;font-size:.88rem;font-weight:500}
.err::before{content:"!";display:inline-grid;place-items:center;width:18px;height:18px;margin-right:8px;border:1.5px solid var(--fg);border-radius:50%;font-size:.72rem;font-weight:800;line-height:1}
.field:has(input:user-invalid) .err{display:block}
.field:has(input:user-invalid) input{border-width:3px}

.check{display:flex;align-items:center;gap:12px;margin:2px 0 24px;font-weight:500;cursor:pointer;width:max-content;max-width:100%}
.check input{appearance:none;-webkit-appearance:none;flex:none;width:24px;height:24px;border:1.5px solid var(--fg);border-radius:7px;display:grid;place-content:center;cursor:pointer;background:var(--bg)}
.check input::before{content:"";width:12px;height:12px;background:var(--bg);clip-path:polygon(14% 44%,0 65%,50% 100%,100% 16%,80% 0,43% 62%);transform:scale(0)}
.check input:checked{background:var(--fg)}
.check input:checked::before{transform:scale(1)}

.notice{display:none;margin-bottom:18px;padding:14px 16px;border:1.5px solid var(--fg);border-radius:14px;font-size:.95rem}
.notice.show{display:block}

.alt{margin-top:26px;text-align:center;color:var(--muted)}
.alt a{color:var(--fg);font-weight:600}
.terms{margin-top:14px;text-align:center;color:var(--muted);font-size:.85rem}
.terms a{color:var(--muted)}
.terms a:hover{color:var(--fg)}
.back{display:none;color:var(--muted);text-decoration:none;font-size:.95rem}

/* ---------- phone and tablet ---------- */
@media (max-width:900px){
  .page{grid-template-columns:1fr;grid-template-rows:auto 1fr;min-height:100vh;min-height:100dvh}
  .side{flex-direction:row;align-items:center;justify-content:space-between;padding:0 max(var(--gutter),env(safe-area-inset-left));height:60px;gap:16px;border-bottom:1px solid var(--soft)}
  .side .copy,.rings{display:none}
  .brand{font-size:1.25rem}
  .back{display:inline}
  .main{align-items:flex-start;padding-top:32px}
}
@media (max-width:480px){
  body{font-size:16px}
  .social{margin-top:26px}
  .or{margin:22px 0}
}
@media (prefers-reduced-motion:reduce){.btn{transition:none}}
</style>
</head>
<body>
<div class="page">

  <aside class="side inv">
    <svg class="rings" viewBox="0 0 760 760" aria-hidden="true" fill="none" stroke="currentColor">
      <circle cx="380" cy="380" r="372" stroke-width="1"/>
      <circle cx="380" cy="380" r="298" stroke-width="1"/>
      <circle cx="380" cy="380" r="224" stroke-width="1"/>
      <circle cx="380" cy="380" r="150" stroke-width="1"/>
      <circle cx="380" cy="380" r="52" fill="currentColor" stroke="none"/>
    </svg>

    <a class="brand" href="/" data-backend aria-label="oxbothost home">
      <svg width="30" height="30" viewBox="0 0 30 30" aria-hidden="true"><rect width="30" height="30" rx="8" fill="currentColor"/><circle cx="15" cy="15" r="6.5" fill="none" stroke="var(--bg)" stroke-width="2.6"/><circle cx="15" cy="15" r="2" fill="var(--bg)"/></svg>
      <span><b>oxbot</b><span>host</span></span>
    </a>
    <a class="back" href="/" data-backend>Back to site</a>

    <div class="copy">
      <h2>Your servers are waiting.</h2>
      <p>Log in to manage your VPS, web hosting and domains from one dashboard.</p>
    </div>
    <p class="fine copy">&copy; 2026 oxbothost</p>
  </aside>

  <main class="main">
    <div class="card">
      <h1>Log in</h1>
      <p class="lead">Welcome back. Pick how you want to log in.</p>

      <div class="social">
        <a class="btn ghost" href="/auth/google" data-backend>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"/></svg>
          Continue with Google
        </a>
        <a class="btn ghost" href="/auth/github" data-backend>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
          Continue with GitHub
        </a>
      </div>

      <div class="or" role="separator">or use your email</div>

      <div id="notice" class="notice" role="alert"></div>

      <form id="login-form" action="/login" method="post">
        <!-- add a hidden CSRF token input here if your backend uses one -->
        <div class="field">
          <div class="label-row"><label for="email">Email</label></div>
          <input id="email" name="email" type="email" inputmode="email" autocomplete="username" autocapitalize="none" spellcheck="false" placeholder="you@example.com" required>
          <p class="err">Enter a valid email address.</p>
        </div>

        <div class="field">
          <div class="label-row"><label for="password">Password</label><a href="/forgot-password" data-backend>Forgot password?</a></div>
          <div class="pw">
            <input id="password" name="password" type="password" autocomplete="current-password" placeholder="Your password" required>
            <button class="toggle" id="toggle-pw" type="button" aria-label="Show password" aria-pressed="false">Show</button>
          </div>
          <p class="err">Enter your password.</p>
        </div>

        <label class="check"><input type="checkbox" name="remember" value="1"><span>Keep me signed in</span></label>

        <button class="btn" type="submit">Log in</button>
      </form>

      <p class="alt">New to oxbothost? <a href="/register" data-backend>Create an account</a></p>
      <p class="terms">By continuing you agree to our <a href="/terms" data-backend>Terms</a> and <a href="/privacy" data-backend>Privacy Policy</a>.</p>
    </div>
  </main>

</div>

<script>
(function () {
  // Set to false once the form action and OAuth links above point at your live backend.
  var DEMO = true;

  var root = document.documentElement;
  root.classList.add('js');
  var form = document.getElementById('login-form');
  var notice = document.getElementById('notice');
  var submit = form.querySelector('button[type="submit"]');

  function say(msg) { notice.textContent = msg; notice.classList.add('show'); }
  function reset() { submit.disabled = false; submit.textContent = 'Log in'; }

  // show / hide password
  var pw = document.getElementById('password');
  var tg = document.getElementById('toggle-pw');
  tg.addEventListener('click', function () {
    var show = pw.type === 'password';
    pw.type = show ? 'text' : 'password';
    tg.textContent = show ? 'Hide' : 'Show';
    tg.setAttribute('aria-pressed', show ? 'true' : 'false');
    tg.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
    pw.focus();
  });

  // messages from your backend, e.g. /login?error=invalid
  var MSG = {
    invalid: 'Incorrect email or password. Try again.',
    oauth: 'We could not log you in with that provider. Try again or use your email.'
  };
  var err = new URLSearchParams(location.search).get('error');
  if (err && MSG[err]) say(MSG[err]);

  window.addEventListener('pageshow', reset);

  if (DEMO) {
    var links = document.querySelectorAll('[data-backend]');
    for (var i = 0; i < links.length; i++) {
      links[i].addEventListener('click', function (e) {
        e.preventDefault();
        say('Preview only. This link goes to ' + this.getAttribute('href') + ' once DEMO is set to false.');
      });
    }
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (!form.checkValidity()) { form.reportValidity(); return; }
      submit.disabled = true; submit.textContent = 'Logging in...';
      setTimeout(function () {
        reset();
        say('Preview only. The form would send your email and password to ' + form.getAttribute('action') + ' once DEMO is set to false.');
      }, 900);
    });
  } else {
    form.addEventListener('submit', function () {
      submit.disabled = true; submit.textContent = 'Logging in...';
    });
  }
})();
</script>
</body>
</html>
