<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="color-scheme" content="light dark">
<title>Create account | oxbothost</title>
<meta name="description" content="Create your oxbothost account. VPS from $4 a month, plus web hosting, domains and dedicated servers.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,300..800&display=swap" rel="stylesheet">
<!--
  oxbothost register page: one file, plain HTML + CSS, no build step.
  Save it as register.html next to index.html and login.html.

  HOW TO CONNECT THIS PAGE TO YOUR BACKEND
  1. Form:    <form action="/register" method="post"> posts these fields:
                name, email, country (2-letter code like NG), dial_code (like 234),
                phone (number as typed), password, terms.
              Your backend should build the full number from dial_code + phone
              (drop a leading 0), and validate everything again on the server.
  2. Google / GitHub: the two buttons go to /auth/google and /auth/github
              (start your OAuth flow there).
  3. Errors:  redirect back with ?error=exists (email already used) or ?error=invalid
              to show a message at the top of the form.
  4. Last step: in the script at the bottom, change  var DEMO = true;  to  false.
              While DEMO is true nothing is sent, buttons only show a preview message.
  Add a hidden CSRF token input inside the form if your backend uses one.
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
button,input,select{font:inherit;color:inherit}
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
.perks{margin-top:28px;display:grid;gap:12px;list-style:none}
.perks li{display:flex;align-items:center;gap:10px}

/* ---------- form side ---------- */
.main{display:flex;align-items:center;justify-content:center;padding:clamp(32px,6vw,64px) max(var(--gutter),env(safe-area-inset-left)) clamp(32px,6vw,64px) max(var(--gutter),env(safe-area-inset-right))}
.card{width:100%;max-width:440px}
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
input[type="email"],input[type="password"],input[type="text"],input[type="tel"],select{
  width:100%;height:56px;padding:0 16px;border:1.5px solid var(--fg);border-radius:14px;background:var(--bg);color:var(--fg);font-size:1rem;
}
input::placeholder{color:var(--muted);opacity:1}
input:focus-visible,select:focus-visible{outline:2px solid var(--fg);outline-offset:2px}
input:user-invalid,select:user-invalid{border-width:3px}
.hint{margin-top:6px;color:var(--muted);font-size:.86rem}

/* country select */
.sel{position:relative}
.sel::after{content:"";position:absolute;right:20px;top:50%;width:8px;height:8px;border:solid var(--fg);border-width:0 2px 2px 0;transform:translateY(-70%) rotate(45deg);pointer-events:none}
select{appearance:none;-webkit-appearance:none;padding-right:48px;cursor:pointer;text-overflow:ellipsis}
select:invalid{color:var(--muted)}
option{background:var(--bg);color:var(--fg)}

/* phone: dial code box + number */
.phone{display:flex;gap:10px}
.phone input{flex:1;min-width:0}
.dial{display:none;align-items:center;justify-content:center;min-width:78px;height:56px;padding:0 14px;border:1.5px solid var(--fg);border-radius:14px;font-weight:600;white-space:nowrap;font-variant-numeric:tabular-nums}
.js .dial{display:flex}

/* password */
.pw{position:relative}
.pw input{padding-right:76px}
.toggle{display:none;position:absolute;right:8px;top:50%;transform:translateY(-50%);height:40px;padding:0 12px;border:0;border-radius:999px;background:transparent;font-weight:600;font-size:.9rem;cursor:pointer}
.js .toggle{display:block}

/* errors: shown only after the person has touched a field */
.err{display:none;margin-top:8px;font-size:.88rem;font-weight:500}
.err::before{content:"!";display:inline-grid;place-items:center;width:18px;height:18px;margin-right:8px;border:1.5px solid var(--fg);border-radius:50%;font-size:.72rem;font-weight:800;line-height:1}
.field:has(:user-invalid) .err{display:block}

.check{display:flex;align-items:flex-start;gap:12px;font-weight:500;cursor:pointer;font-size:.95rem}
.check input{appearance:none;-webkit-appearance:none;flex:none;width:24px;height:24px;margin-top:1px;border:1.5px solid var(--fg);border-radius:7px;display:grid;place-content:center;cursor:pointer;background:var(--bg)}
.check input::before{content:"";width:12px;height:12px;background:var(--bg);clip-path:polygon(14% 44%,0 65%,50% 100%,100% 16%,80% 0,43% 62%);transform:scale(0)}
.check input:checked{background:var(--fg)}
.check input:checked::before{transform:scale(1)}
.check a{font-weight:600}

.notice{display:none;margin-bottom:18px;padding:14px 16px;border:1.5px solid var(--fg);border-radius:14px;font-size:.95rem}
.notice.show{display:block}

.submit-row{margin-top:24px}
.alt{margin-top:26px;text-align:center;color:var(--muted)}
.alt a{color:var(--fg);font-weight:600}
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
  .dial{min-width:72px;padding:0 10px}
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

    <a class="brand" href="index.html" data-backend aria-label="oxbothost home">
      <svg width="30" height="30" viewBox="0 0 30 30" aria-hidden="true"><rect width="30" height="30" rx="8" fill="currentColor"/><circle cx="15" cy="15" r="6.5" fill="none" stroke="var(--bg)" stroke-width="2.6"/><circle cx="15" cy="15" r="2" fill="var(--bg)"/></svg>
      <span><b>oxbot</b><span>host</span></span>
    </a>
    <a class="back" href="index.html" data-backend>Back to site</a>

    <div class="copy">
      <h2>Start with a $4 VPS.</h2>
      <p>Create your account, pick a plan, and your server can be live in minutes.</p>
      <ul class="perks">
        <li><svg width="16" height="16" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2.5 7.5l3 3 6-7"/></svg>Full root access</li>
        <li><svg width="16" height="16" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2.5 7.5l3 3 6-7"/></svg>Free SSL and DNS</li>
        <li><svg width="16" height="16" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2.5 7.5l3 3 6-7"/></svg>24/7 live chat</li>
      </ul>
    </div>
    <p class="fine copy">&copy; 2026 oxbothost</p>
  </aside>

  <main class="main">
    <div class="card">
      <h1>Create account</h1>
      <p class="lead">It takes a minute. Sign up with Google or GitHub, or fill in your details.</p>

      <div class="social">
        <a class="btn ghost" href="/auth/google" data-backend>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"/></svg>
          Sign up with Google
        </a>
        <a class="btn ghost" href="/auth/github" data-backend>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
          Sign up with GitHub
        </a>
      </div>

      <div class="or" role="separator">or use your email</div>

      <div id="notice" class="notice" role="alert"></div>

      <form id="register-form" action="/register" method="post">
        <!-- add a hidden CSRF token input here if your backend uses one -->

        <div class="field">
          <div class="label-row"><label for="name">Full name</label></div>
          <input id="name" name="name" type="text" autocomplete="name" autocapitalize="words" minlength="2" maxlength="80" placeholder="Your full name" required>
          <p class="err">Enter your full name.</p>
        </div>

        <div class="field">
          <div class="label-row"><label for="email">Email</label></div>
          <input id="email" name="email" type="email" inputmode="email" autocomplete="email" autocapitalize="none" spellcheck="false" placeholder="you@example.com" required>
          <p class="err">Enter a valid email address.</p>
        </div>

        <div class="field">
          <div class="label-row"><label for="country">Country</label></div>
          <div class="sel">
            <select id="country" name="country" autocomplete="country" required>
              <option value="" selected disabled>Select your country</option>
              <option value="AF" data-dial="93">Afghanistan</option>
              <option value="AL" data-dial="355">Albania</option>
              <option value="DZ" data-dial="213">Algeria</option>
              <option value="AD" data-dial="376">Andorra</option>
              <option value="AO" data-dial="244">Angola</option>
              <option value="AG" data-dial="1268">Antigua and Barbuda</option>
              <option value="AR" data-dial="54">Argentina</option>
              <option value="AM" data-dial="374">Armenia</option>
              <option value="AU" data-dial="61">Australia</option>
              <option value="AT" data-dial="43">Austria</option>
              <option value="AZ" data-dial="994">Azerbaijan</option>
              <option value="BS" data-dial="1242">Bahamas</option>
              <option value="BH" data-dial="973">Bahrain</option>
              <option value="BD" data-dial="880">Bangladesh</option>
              <option value="BB" data-dial="1246">Barbados</option>
              <option value="BY" data-dial="375">Belarus</option>
              <option value="BE" data-dial="32">Belgium</option>
              <option value="BZ" data-dial="501">Belize</option>
              <option value="BJ" data-dial="229">Benin</option>
              <option value="BT" data-dial="975">Bhutan</option>
              <option value="BO" data-dial="591">Bolivia</option>
              <option value="BA" data-dial="387">Bosnia and Herzegovina</option>
              <option value="BW" data-dial="267">Botswana</option>
              <option value="BR" data-dial="55">Brazil</option>
              <option value="BN" data-dial="673">Brunei</option>
              <option value="BG" data-dial="359">Bulgaria</option>
              <option value="BF" data-dial="226">Burkina Faso</option>
              <option value="BI" data-dial="257">Burundi</option>
              <option value="CV" data-dial="238">Cabo Verde</option>
              <option value="KH" data-dial="855">Cambodia</option>
              <option value="CM" data-dial="237">Cameroon</option>
              <option value="CA" data-dial="1">Canada</option>
              <option value="CF" data-dial="236">Central African Republic</option>
              <option value="TD" data-dial="235">Chad</option>
              <option value="CL" data-dial="56">Chile</option>
              <option value="CN" data-dial="86">China</option>
              <option value="CO" data-dial="57">Colombia</option>
              <option value="KM" data-dial="269">Comoros</option>
              <option value="CD" data-dial="243">Congo (DR)</option>
              <option value="CG" data-dial="242">Congo (Republic)</option>
              <option value="CR" data-dial="506">Costa Rica</option>
              <option value="CI" data-dial="225">Côte d&#x27;Ivoire</option>
              <option value="HR" data-dial="385">Croatia</option>
              <option value="CU" data-dial="53">Cuba</option>
              <option value="CY" data-dial="357">Cyprus</option>
              <option value="CZ" data-dial="420">Czechia</option>
              <option value="DK" data-dial="45">Denmark</option>
              <option value="DJ" data-dial="253">Djibouti</option>
              <option value="DM" data-dial="1767">Dominica</option>
              <option value="DO" data-dial="1">Dominican Republic</option>
              <option value="EC" data-dial="593">Ecuador</option>
              <option value="EG" data-dial="20">Egypt</option>
              <option value="SV" data-dial="503">El Salvador</option>
              <option value="GQ" data-dial="240">Equatorial Guinea</option>
              <option value="ER" data-dial="291">Eritrea</option>
              <option value="EE" data-dial="372">Estonia</option>
              <option value="SZ" data-dial="268">Eswatini</option>
              <option value="ET" data-dial="251">Ethiopia</option>
              <option value="FJ" data-dial="679">Fiji</option>
              <option value="FI" data-dial="358">Finland</option>
              <option value="FR" data-dial="33">France</option>
              <option value="GA" data-dial="241">Gabon</option>
              <option value="GM" data-dial="220">Gambia</option>
              <option value="GE" data-dial="995">Georgia</option>
              <option value="DE" data-dial="49">Germany</option>
              <option value="GH" data-dial="233">Ghana</option>
              <option value="GR" data-dial="30">Greece</option>
              <option value="GD" data-dial="1473">Grenada</option>
              <option value="GT" data-dial="502">Guatemala</option>
              <option value="GN" data-dial="224">Guinea</option>
              <option value="GW" data-dial="245">Guinea-Bissau</option>
              <option value="GY" data-dial="592">Guyana</option>
              <option value="HT" data-dial="509">Haiti</option>
              <option value="HN" data-dial="504">Honduras</option>
              <option value="HK" data-dial="852">Hong Kong</option>
              <option value="HU" data-dial="36">Hungary</option>
              <option value="IS" data-dial="354">Iceland</option>
              <option value="IN" data-dial="91">India</option>
              <option value="ID" data-dial="62">Indonesia</option>
              <option value="IR" data-dial="98">Iran</option>
              <option value="IQ" data-dial="964">Iraq</option>
              <option value="IE" data-dial="353">Ireland</option>
              <option value="IL" data-dial="972">Israel</option>
              <option value="IT" data-dial="39">Italy</option>
              <option value="JM" data-dial="1876">Jamaica</option>
              <option value="JP" data-dial="81">Japan</option>
              <option value="JO" data-dial="962">Jordan</option>
              <option value="KZ" data-dial="7">Kazakhstan</option>
              <option value="KE" data-dial="254">Kenya</option>
              <option value="KI" data-dial="686">Kiribati</option>
              <option value="XK" data-dial="383">Kosovo</option>
              <option value="KW" data-dial="965">Kuwait</option>
              <option value="KG" data-dial="996">Kyrgyzstan</option>
              <option value="LA" data-dial="856">Laos</option>
              <option value="LV" data-dial="371">Latvia</option>
              <option value="LB" data-dial="961">Lebanon</option>
              <option value="LS" data-dial="266">Lesotho</option>
              <option value="LR" data-dial="231">Liberia</option>
              <option value="LY" data-dial="218">Libya</option>
              <option value="LI" data-dial="423">Liechtenstein</option>
              <option value="LT" data-dial="370">Lithuania</option>
              <option value="LU" data-dial="352">Luxembourg</option>
              <option value="MO" data-dial="853">Macao</option>
              <option value="MG" data-dial="261">Madagascar</option>
              <option value="MW" data-dial="265">Malawi</option>
              <option value="MY" data-dial="60">Malaysia</option>
              <option value="MV" data-dial="960">Maldives</option>
              <option value="ML" data-dial="223">Mali</option>
              <option value="MT" data-dial="356">Malta</option>
              <option value="MH" data-dial="692">Marshall Islands</option>
              <option value="MR" data-dial="222">Mauritania</option>
              <option value="MU" data-dial="230">Mauritius</option>
              <option value="MX" data-dial="52">Mexico</option>
              <option value="FM" data-dial="691">Micronesia</option>
              <option value="MD" data-dial="373">Moldova</option>
              <option value="MC" data-dial="377">Monaco</option>
              <option value="MN" data-dial="976">Mongolia</option>
              <option value="ME" data-dial="382">Montenegro</option>
              <option value="MA" data-dial="212">Morocco</option>
              <option value="MZ" data-dial="258">Mozambique</option>
              <option value="MM" data-dial="95">Myanmar</option>
              <option value="NA" data-dial="264">Namibia</option>
              <option value="NR" data-dial="674">Nauru</option>
              <option value="NP" data-dial="977">Nepal</option>
              <option value="NL" data-dial="31">Netherlands</option>
              <option value="NZ" data-dial="64">New Zealand</option>
              <option value="NI" data-dial="505">Nicaragua</option>
              <option value="NE" data-dial="227">Niger</option>
              <option value="NG" data-dial="234">Nigeria</option>
              <option value="KP" data-dial="850">North Korea</option>
              <option value="MK" data-dial="389">North Macedonia</option>
              <option value="NO" data-dial="47">Norway</option>
              <option value="OM" data-dial="968">Oman</option>
              <option value="PK" data-dial="92">Pakistan</option>
              <option value="PW" data-dial="680">Palau</option>
              <option value="PS" data-dial="970">Palestine</option>
              <option value="PA" data-dial="507">Panama</option>
              <option value="PG" data-dial="675">Papua New Guinea</option>
              <option value="PY" data-dial="595">Paraguay</option>
              <option value="PE" data-dial="51">Peru</option>
              <option value="PH" data-dial="63">Philippines</option>
              <option value="PL" data-dial="48">Poland</option>
              <option value="PT" data-dial="351">Portugal</option>
              <option value="PR" data-dial="1">Puerto Rico</option>
              <option value="QA" data-dial="974">Qatar</option>
              <option value="RO" data-dial="40">Romania</option>
              <option value="RU" data-dial="7">Russia</option>
              <option value="RW" data-dial="250">Rwanda</option>
              <option value="KN" data-dial="1869">Saint Kitts and Nevis</option>
              <option value="LC" data-dial="1758">Saint Lucia</option>
              <option value="VC" data-dial="1784">Saint Vincent and the Grenadines</option>
              <option value="WS" data-dial="685">Samoa</option>
              <option value="SM" data-dial="378">San Marino</option>
              <option value="ST" data-dial="239">São Tomé and Príncipe</option>
              <option value="SA" data-dial="966">Saudi Arabia</option>
              <option value="SN" data-dial="221">Senegal</option>
              <option value="RS" data-dial="381">Serbia</option>
              <option value="SC" data-dial="248">Seychelles</option>
              <option value="SL" data-dial="232">Sierra Leone</option>
              <option value="SG" data-dial="65">Singapore</option>
              <option value="SK" data-dial="421">Slovakia</option>
              <option value="SI" data-dial="386">Slovenia</option>
              <option value="SB" data-dial="677">Solomon Islands</option>
              <option value="SO" data-dial="252">Somalia</option>
              <option value="ZA" data-dial="27">South Africa</option>
              <option value="KR" data-dial="82">South Korea</option>
              <option value="SS" data-dial="211">South Sudan</option>
              <option value="ES" data-dial="34">Spain</option>
              <option value="LK" data-dial="94">Sri Lanka</option>
              <option value="SD" data-dial="249">Sudan</option>
              <option value="SR" data-dial="597">Suriname</option>
              <option value="SE" data-dial="46">Sweden</option>
              <option value="CH" data-dial="41">Switzerland</option>
              <option value="SY" data-dial="963">Syria</option>
              <option value="TW" data-dial="886">Taiwan</option>
              <option value="TJ" data-dial="992">Tajikistan</option>
              <option value="TZ" data-dial="255">Tanzania</option>
              <option value="TH" data-dial="66">Thailand</option>
              <option value="TL" data-dial="670">Timor-Leste</option>
              <option value="TG" data-dial="228">Togo</option>
              <option value="TO" data-dial="676">Tonga</option>
              <option value="TT" data-dial="1868">Trinidad and Tobago</option>
              <option value="TN" data-dial="216">Tunisia</option>
              <option value="TR" data-dial="90">Türkiye</option>
              <option value="TM" data-dial="993">Turkmenistan</option>
              <option value="TV" data-dial="688">Tuvalu</option>
              <option value="UG" data-dial="256">Uganda</option>
              <option value="UA" data-dial="380">Ukraine</option>
              <option value="AE" data-dial="971">United Arab Emirates</option>
              <option value="GB" data-dial="44">United Kingdom</option>
              <option value="US" data-dial="1">United States</option>
              <option value="UY" data-dial="598">Uruguay</option>
              <option value="UZ" data-dial="998">Uzbekistan</option>
              <option value="VU" data-dial="678">Vanuatu</option>
              <option value="VA" data-dial="379">Vatican City</option>
              <option value="VE" data-dial="58">Venezuela</option>
              <option value="VN" data-dial="84">Vietnam</option>
              <option value="YE" data-dial="967">Yemen</option>
              <option value="ZM" data-dial="260">Zambia</option>
              <option value="ZW" data-dial="263">Zimbabwe</option>
            </select>
          </div>
          <p class="err">Choose your country.</p>
        </div>

        <div class="field">
          <div class="label-row"><label for="phone">Phone number</label></div>
          <div class="phone">
            <span class="dial" id="dial-box" aria-hidden="true">+</span>
            <input id="phone" name="phone" type="tel" inputmode="tel" autocomplete="tel-national" placeholder="Phone number with country code" pattern="\+?[0-9 \(\)\-]{6,18}" title="Digits only, 6 to 18 characters" required>
          </div>
          <input type="hidden" id="dial" name="dial_code" value="">
          <p class="hint" id="phone-hint">Choose your country and the code is added for you.</p>
          <p class="err">Enter a valid phone number.</p>
        </div>

        <div class="field">
          <div class="label-row"><label for="password">Password</label></div>
          <div class="pw">
            <input id="password" name="password" type="password" autocomplete="new-password" minlength="8" maxlength="128" placeholder="At least 8 characters" required>
            <button class="toggle" id="toggle-pw" type="button" aria-label="Show password" aria-pressed="false">Show</button>
          </div>
          <p class="err">Use at least 8 characters.</p>
        </div>

        <div class="field">
          <label class="check"><input type="checkbox" name="terms" value="1" required><span>I agree to the <a href="/terms" data-backend>Terms</a> and <a href="/privacy" data-backend>Privacy Policy</a>.</span></label>
          <p class="err">You need to accept to create an account.</p>
        </div>

        <div class="submit-row"><button class="btn" type="submit">Create account</button></div>
      </form>

      <p class="alt">Already have an account? <a href="login.html" data-backend>Log in</a></p>
    </div>
  </main>

</div>

<script>
(function () {
  // Set to false once the form action and OAuth links above point at your live backend.
  var DEMO = true;

  document.documentElement.classList.add('js');
  var form = document.getElementById('register-form');
  var notice = document.getElementById('notice');
  var submit = form.querySelector('button[type="submit"]');

  function say(msg) { notice.textContent = msg; notice.classList.add('show'); }
  function reset() { submit.disabled = false; submit.textContent = 'Create account'; }

  // country -> dial code
  var country = document.getElementById('country');
  var dialBox = document.getElementById('dial-box');
  var dialInput = document.getElementById('dial');
  var phone = document.getElementById('phone');
  var hint = document.getElementById('phone-hint');
  function fmt(d) { return d.length > 1 && d.charAt(0) === '1' ? '+1 ' + d.slice(1) : '+' + d; }
  function syncDial() {
    var opt = country.options[country.selectedIndex];
    var d = opt && opt.getAttribute('data-dial');
    if (!d) return;
    dialBox.textContent = fmt(d);
    dialInput.value = d;
    phone.placeholder = 'Phone number';
    hint.textContent = 'We will use ' + fmt(d) + ' as the country code.';
  }
  country.addEventListener('change', syncDial);

  // guess the country from the browser language, e.g. en-NG
  try {
    var region = ((navigator.language || '').split('-')[1] || '').toUpperCase();
    if (region && !country.value) {
      var pick = country.querySelector('option[value="' + region + '"]');
      if (pick) { country.value = region; syncDial(); }
    }
  } catch (e) {}

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

  // messages from your backend, e.g. /register?error=exists
  var MSG = {
    exists: 'That email already has an account. Try logging in instead.',
    invalid: 'Some details look wrong. Check them and try again.',
    oauth: 'We could not sign you up with that provider. Try again or use your email.'
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
      submit.disabled = true; submit.textContent = 'Creating account...';
      setTimeout(function () {
        reset();
        say('Preview only. The form would send your details to ' + form.getAttribute('action') + ' once DEMO is set to false.');
      }, 900);
    });
  } else {
    form.addEventListener('submit', function () {
      submit.disabled = true; submit.textContent = 'Creating account...';
    });
  }
})();
</script>
</body>
</html>
