<!doctype html>
<html lang="en" id="top">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="color-scheme" content="light dark">
<title>oxbothost | VPS, web hosting, domains and servers</title>
<meta name="description" content="VPS from $4 a month. Web hosting, domains and dedicated servers from one dashboard.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,300..800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
:root{
  color-scheme:light dark;
  --bg:#fff; --fg:#000; --muted:#4d4d4d; --line:#000; --soft:#d9d9d9; --surface:#f5f5f5;
  --m0:#4d4d4d; --l0:#000; --s0:#d9d9d9;
  --ibg:#000; --ifg:#fff; --imuted:#d0d0d0; --iline:#fff; --isoft:#4d4d4d;
  --term-bg:#000; --term-fg:#f5f5f5; --term-muted:#a8a8a8; --tline:#000; --tsoft:#4d4d4d;
  --gutter:clamp(20px,4vw,40px);
}
@media (prefers-color-scheme: dark){
  :root:not([data-theme="light"]){
    --bg:#000; --fg:#fff; --muted:#d0d0d0; --line:#fff; --soft:#4d4d4d; --surface:#0e0e0e;
    --m0:#d0d0d0; --l0:#fff; --s0:#4d4d4d;
    --ibg:#fff; --ifg:#000; --imuted:#4d4d4d; --iline:#000; --isoft:#d9d9d9;
    --term-bg:#0e0e0e; --term-fg:#f5f5f5; --term-muted:#a8a8a8; --tline:#fff; --tsoft:#4d4d4d;
  }
}
:root[data-theme="dark"]{
  color-scheme:dark;
  --bg:#000; --fg:#fff; --muted:#d0d0d0; --line:#fff; --soft:#4d4d4d; --surface:#0e0e0e;
  --m0:#d0d0d0; --l0:#fff; --s0:#4d4d4d;
  --ibg:#fff; --ifg:#000; --imuted:#4d4d4d; --iline:#000; --isoft:#d9d9d9;
  --term-bg:#0e0e0e; --term-fg:#f5f5f5; --term-muted:#a8a8a8; --tline:#fff; --tsoft:#4d4d4d;
}
:root[data-theme="light"]{color-scheme:light}

*{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth;-webkit-text-size-adjust:100%}
[id]{scroll-margin-top:68px}
body{
  background:var(--bg); color:var(--fg);
  font-family:"Bricolage Grotesque",ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;
  font-size:15px; line-height:1.5; -webkit-font-smoothing:antialiased;
}
a{color:inherit;-webkit-tap-highlight-color:transparent}
label,summary,.btn{touch-action:manipulation;-webkit-tap-highlight-color:transparent}
ul{list-style:none}
svg{display:block;max-width:100%}
:focus-visible{outline:2px solid var(--fg);outline-offset:3px}
.sr{position:absolute;opacity:0;pointer-events:none;width:1px;height:1px}

.wrap{max-width:1160px;margin:0 auto;padding-inline:max(var(--gutter),env(safe-area-inset-left)) max(var(--gutter),env(safe-area-inset-right))}
h1,h2,h3{font-weight:700;letter-spacing:-.035em;line-height:1.02;text-wrap:balance}
h1{font-size:clamp(2.9rem,7.4vw,5.9rem);font-weight:800;letter-spacing:-.045em;line-height:.95}
h2{font-size:clamp(2rem,4.4vw,3.4rem)}
.sub{color:var(--muted);font-size:clamp(1.05rem,1.5vw,1.2rem);max-width:46ch;margin-top:18px}
.mono{font-family:"JetBrains Mono",ui-monospace,SFMono-Regular,Menlo,Consolas,monospace}
.hero-grid>*,.band-grid>*,.split>*{min-width:0}

/* inverted sections swap the tokens, so everything inside just works */
.inv{--bg:var(--ibg);--fg:var(--ifg);--muted:var(--imuted);--line:var(--iline);--soft:var(--isoft);background:var(--bg);color:var(--fg)}

/* buttons */
.btn{
  display:inline-flex;align-items:center;justify-content:center;gap:8px;height:48px;padding:0 24px;
  border-radius:999px;border:1.5px solid var(--fg);background:var(--fg);color:var(--bg);
  font-weight:600;font-size:1rem;text-decoration:none;white-space:nowrap;
  transition:background .15s,color .15s;
}
.btn:hover{background:transparent;color:var(--fg)}
.btn.ghost{background:transparent;color:var(--fg)}
.btn.ghost:hover{background:var(--fg);color:var(--bg)}
.btn.sm{height:38px;padding:0 16px;font-size:.9rem}

/* nav */
.nav{position:sticky;top:0;z-index:20;background:var(--bg);border-bottom:1px solid var(--line)}
.nav-row{display:flex;align-items:center;justify-content:space-between;height:68px;gap:24px}
.brand{display:flex;align-items:center;gap:10px;font-size:1.4rem;letter-spacing:-.04em;text-decoration:none}
.brand b{font-weight:800}
.brand span span{font-weight:400}
.links{display:flex;gap:30px;font-size:.96rem}
.links a{text-decoration:none;color:var(--muted)}
.links a:hover{color:var(--fg)}
.navr{display:flex;align-items:center;gap:18px}
.login{text-decoration:none;font-weight:500;font-size:.96rem}
.menu-btn{display:none;align-items:center;height:38px;padding:0 14px;border-radius:999px;border:1px solid var(--line);font-size:.9rem;cursor:pointer}
.m-close{display:none}
#nav-toggle:checked ~ .nav-row .m-open{display:none}
#nav-toggle:checked ~ .nav-row .m-close{display:inline}
#nav-toggle:focus-visible ~ .nav-row .menu-btn{outline:2px solid var(--fg);outline-offset:3px}
.mobile-menu{display:none;border-top:1px solid var(--line);background:var(--bg)}
.mobile-menu .wrap{padding-block:6px 26px}
.mobile-menu a:not(.btn){display:block;padding:16px 0;border-bottom:1px solid var(--soft);text-decoration:none;font-weight:600;font-size:1.3rem;letter-spacing:-.02em}
.mobile-menu .btn{margin-top:22px;width:100%;height:54px;font-size:1.05rem}
@media (max-width:820px){
  .links,.login{display:none}
  .menu-btn{display:inline-flex}
  #nav-toggle:checked ~ .mobile-menu{display:block}
}

/* hero */
.hero{padding:clamp(48px,8vw,96px) 0 clamp(56px,8vw,96px)}
.hero-grid{display:grid;grid-template-columns:1.05fr .95fr;gap:clamp(32px,5vw,72px);align-items:center}
@media (max-width:920px){.hero-grid{grid-template-columns:1fr}}
.actions{display:flex;flex-wrap:wrap;gap:12px;margin-top:32px}
.notes{margin-top:26px;display:flex;flex-wrap:wrap;gap:10px 22px;color:var(--muted);font-size:.93rem}
.notes li{display:inline-flex;align-items:center;gap:7px}

/* terminal: typed with CSS only */
.term{background:var(--term-bg);color:var(--term-fg);border-radius:14px;border:1px solid var(--tline);overflow:hidden}
.term-bar{white-space:nowrap;display:flex;align-items:center;justify-content:space-between;gap:12px;padding:13px 18px;border-bottom:1px solid var(--tsoft);font-size:.78rem;color:var(--term-muted)}
.term-bar div{display:flex;align-items:center;gap:9px}
.dot{width:8px;height:8px;border-radius:50%;background:var(--term-fg)}
.term-body{padding:18px 18px 24px;font-size:clamp(10px,calc((100vw - 76px) / 24.5),13px);line-height:1.75;min-height:300px;overflow:hidden}
.tl{width:0;overflow:hidden;white-space:pre;animation:type var(--dur) steps(var(--n),start) var(--d) both}
@keyframes type{from{width:0}to{width:calc(var(--n) * 1ch + 1ch)}}
.pr,.out{color:var(--term-muted)}
.cur{display:inline-block;width:.6em;height:1.15em;background:var(--term-fg);vertical-align:text-bottom;margin-left:1px;animation:blink 1.1s steps(1) infinite}
@keyframes blink{50%{opacity:0}}
@media (max-width:480px){.term-bar{font-size:.72rem}}
@media (max-width:430px){.term-bar span:last-child{display:none}}

/* domain band */
.band{background:var(--surface);border-block:1px solid var(--line);padding:clamp(44px,6vw,72px) 0}
.band-grid{display:grid;grid-template-columns:.8fr 1.2fr;gap:clamp(28px,5vw,72px);align-items:start}
@media (max-width:860px){.band-grid{grid-template-columns:1fr}}
.search{display:flex;align-items:center;gap:12px;height:64px;padding:0 24px;background:var(--bg);border:1.5px solid var(--fg);border-radius:999px}
.search:focus-within{outline:2px solid var(--fg);outline-offset:3px}
.search input{flex:1;min-width:0;border:0;outline:0;background:transparent;color:var(--fg);font:inherit;font-size:1.15rem}
.search input::placeholder{color:var(--muted);opacity:1}
.dom-list{margin-top:14px}
.dom-row{display:grid;grid-template-columns:1fr auto auto;grid-template-areas:"n p b";align-items:center;gap:20px;padding:14px 0;border-bottom:1px solid var(--soft)}
.dom-name{grid-area:n;font-size:1.3rem;font-weight:600;letter-spacing:-.02em;overflow-wrap:anywhere}
.dom-name span:last-child{color:var(--muted)}
.dom-price{grid-area:p;color:var(--muted);font-variant-numeric:tabular-nums}
.dom-row .btn{grid-area:b}
.swipe{display:none}
.fine{margin-top:16px;color:var(--muted);font-size:.9rem}

/* pricing (tabs run on radio buttons, no JS) */
.pricing{padding:clamp(64px,9vw,120px) 0}
.p-controls{display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;margin-top:36px}
.tabs{display:flex;gap:8px;flex-wrap:wrap}
.tab{display:inline-flex;align-items:center;white-space:nowrap;height:42px;padding:0 20px;border-radius:999px;border:1px solid var(--line);font-weight:500;font-size:.95rem;cursor:pointer;user-select:none}
.panel{display:none}
#t-vps:checked ~ .panels .p-vps, #t-hosting:checked ~ .panels .p-hosting, #t-domains:checked ~ .panels .p-domains, #t-servers:checked ~ .panels .p-servers{display:block}
#t-vps:checked ~ .p-controls label[for="t-vps"], #t-hosting:checked ~ .p-controls label[for="t-hosting"], #t-domains:checked ~ .p-controls label[for="t-domains"], #t-servers:checked ~ .p-controls label[for="t-servers"], #b-y:checked ~ .p-controls label[for="b-y"], #b-m:checked ~ .p-controls label[for="b-m"]{background:var(--fg);color:var(--bg);border-color:var(--fg)}
#t-vps:focus-visible ~ .p-controls label[for="t-vps"], #t-hosting:focus-visible ~ .p-controls label[for="t-hosting"], #t-domains:focus-visible ~ .p-controls label[for="t-domains"], #t-servers:focus-visible ~ .p-controls label[for="t-servers"], #b-y:focus-visible ~ .p-controls label[for="b-y"], #b-m:focus-visible ~ .p-controls label[for="b-m"]{outline:2px solid var(--fg);outline-offset:3px}
#b-m:checked ~ .panels .py{display:none}
#b-y:checked ~ .panels .pm{display:none}
#t-domains:checked ~ .p-controls .billing, #t-servers:checked ~ .p-controls .billing{display:none}

.panel-copy{margin:26px 0 22px;color:var(--muted);max-width:56ch}
.plans{display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));border-top:1px solid var(--line);border-left:1px solid var(--line)}
.plan{padding:28px 24px 26px;display:flex;flex-direction:column;gap:20px;border-right:1px solid var(--line);border-bottom:1px solid var(--line)}
.plan.feat{background:var(--ifg);color:var(--ibg);--fg:var(--ibg);--bg:var(--ifg);--muted:var(--m0);--line:var(--l0);--soft:var(--s0)}
.plan-top{display:flex;align-items:center;justify-content:space-between;gap:10px;min-height:28px}
.plan h3{font-size:1.25rem;letter-spacing:-.02em}
.badge{font-size:.75rem;font-weight:600;padding:3px 10px;border-radius:999px;border:1px solid var(--fg)}
.amt{font-size:3.6rem;font-weight:800;letter-spacing:-.055em;line-height:1}
.per{color:var(--muted);margin-left:4px}
.billed{color:var(--muted);font-size:.86rem;margin-top:4px}
.specs li{display:flex;justify-content:space-between;gap:12px;padding:10px 0;border-top:1px solid var(--soft);font-size:.95rem}
.specs li span{color:var(--muted)}
.specs li b{font-weight:600;text-align:right}
.plan .btn{margin-top:auto}
.tlds{display:grid;grid-template-columns:repeat(4,1fr);border-top:1px solid var(--line);border-left:1px solid var(--line)}
@media (max-width:900px){.tlds{grid-template-columns:repeat(2,1fr)}}
.tld{padding:26px 22px;display:flex;flex-direction:column;align-items:flex-start;gap:14px;border-right:1px solid var(--line);border-bottom:1px solid var(--line)}
.tld-name{font-size:2.2rem;font-weight:800;letter-spacing:-.04em;line-height:1}
.tld-price{color:var(--muted);font-variant-numeric:tabular-nums}

/* features */
.features{padding:clamp(64px,9vw,120px) 0}
.split{display:grid;grid-template-columns:.9fr 1.1fr;gap:clamp(32px,6vw,96px);align-items:start}
@media (max-width:920px){.split{grid-template-columns:1fr}}
.sticky{position:sticky;top:110px}
@media (max-width:920px){.sticky{position:static}}
.feature-list{display:grid;grid-template-columns:1fr 1fr;gap:0 40px}
@media (max-width:600px){.feature-list{grid-template-columns:1fr}}
.feature{padding:22px 0 30px;border-top:1px solid var(--fg)}
.feature h3{font-size:1.2rem;letter-spacing:-.02em;margin-bottom:8px}
.feature p{color:var(--muted);font-size:.97rem}

/* faq */
.faq{padding:0 0 clamp(64px,9vw,120px)}
details{border-top:1px solid var(--line)}
details:last-child{border-bottom:1px solid var(--line)}
summary{display:flex;justify-content:space-between;align-items:center;gap:20px;padding:22px 0;font-size:1.2rem;font-weight:600;letter-spacing:-.02em;cursor:pointer;list-style:none}
summary::-webkit-details-marker{display:none}
summary::after{content:"+";font-size:1.6rem;font-weight:400;line-height:1}
details[open] summary::after{content:"\2212"}
details p{padding:0 0 24px;color:var(--muted);max-width:60ch}

/* footer */
.foot{padding:clamp(64px,9vw,112px) 0 36px}
.cta-title{font-size:clamp(2.4rem,6.6vw,5.4rem);font-weight:800;letter-spacing:-.05em;line-height:.95;max-width:14ch}
.foot-grid{display:grid;grid-template-columns:1.4fr repeat(3,1fr);gap:40px;margin-top:clamp(56px,8vw,96px);padding-top:40px;border-top:1px solid var(--line)}
@media (max-width:760px){.foot-grid{grid-template-columns:1fr 1fr}.foot-grid>div:first-child{grid-column:1/-1}}
.foot h4{font-size:.95rem;font-weight:600;margin-bottom:14px}
.foot li{margin-bottom:10px}
.foot li a{text-decoration:none;color:var(--muted);font-size:.95rem}
.foot li a:hover{color:var(--fg)}
.foot .blurb{color:var(--muted);font-size:.95rem;max-width:32ch;margin-top:14px}
.legal{margin-top:48px;color:var(--muted);font-size:.86rem}

/* ---------- phone ---------- */
@media (max-width:700px){
  body{font-size:16px}
  [id]{scroll-margin-top:60px}
  .nav-row{height:60px;gap:12px}
  .navr{gap:10px}
  .brand{font-size:1.25rem}
  .hero{padding:36px 0 52px}
  h1{font-size:clamp(2.7rem,13vw,3.4rem)}
  h2{font-size:clamp(1.9rem,9vw,2.4rem)}
  .sub{margin-top:14px}
  .actions{flex-direction:column;align-items:stretch;gap:10px;margin-top:28px}
  .actions .btn{width:100%;height:54px;font-size:1.05rem}
  .notes{display:grid;grid-template-columns:1fr 1fr;gap:12px 14px;margin-top:24px}
  .hero-grid{gap:36px}
  .term-body{min-height:250px;padding:16px 16px 20px}
  .band{padding:48px 0}
  .band-grid{gap:24px}
  .search{height:58px;padding:0 20px}
  .dom-row{grid-template-columns:1fr auto;grid-template-areas:"n b" "p b";gap:0 12px;padding:14px 0}
  .dom-name{font-size:1.15rem}
  .dom-price{font-size:.9rem}
  .btn.sm{height:44px}
  .pricing{padding:64px 0 72px}
  .p-controls{flex-direction:column;flex-wrap:nowrap;align-items:stretch;gap:12px;margin-top:26px}
  .tabs-scroll{flex-wrap:nowrap;overflow-x:auto;margin-inline:calc(-1 * var(--gutter));padding-inline:var(--gutter);scroll-padding-inline:var(--gutter);scrollbar-width:none}
  .tabs-scroll::-webkit-scrollbar{display:none}
  .tab{height:44px;flex:none}
  .billing{display:grid;grid-template-columns:1fr 1fr}
  .billing .tab{justify-content:center;flex:auto;padding:0 10px;font-size:.9rem;white-space:nowrap}
  .panel-copy{margin:22px 0 18px}
  .plans{display:flex;gap:12px;overflow-x:auto;scroll-snap-type:x mandatory;scroll-padding-inline:var(--gutter);margin-inline:calc(-1 * var(--gutter));padding-inline:var(--gutter);padding-bottom:4px;border:0;scrollbar-width:none;-webkit-overflow-scrolling:touch}
  .plans::-webkit-scrollbar{display:none}
  .plans::after{content:"";flex:0 0 1px}
  .plan{flex:0 0 min(82%,320px);scroll-snap-align:start;border:1px solid var(--line);border-radius:16px;padding:24px 20px 22px}
  .amt{font-size:3.2rem}
  .swipe{display:block;margin-top:14px;color:var(--muted);font-size:.86rem}
  .tlds{border:0;gap:10px;grid-template-columns:1fr 1fr}
  .tld{border:1px solid var(--line);border-radius:16px;padding:20px 16px;gap:12px}
  .tld-name{font-size:2rem}
  .features{padding:64px 0}
  .split{gap:28px}
  .feature{padding:20px 0 24px}
  .faq{padding-bottom:64px}
  summary{font-size:1.1rem;min-height:64px;padding:16px 0}
  .foot{padding:64px 0 32px}
  .foot-grid{gap:32px 24px;margin-top:56px}
  .legal{margin-top:36px}
}
@media (max-width:380px){.navr .btn{display:none}}

@media (prefers-reduced-motion:reduce){
  html{scroll-behavior:auto}
  .cur{animation:none}
  .btn{transition:none}
  .tl{animation:none;width:calc(var(--n) * 1ch + 1ch)}
}

</style>
</head>
<body>

<!--
  oxbothost landing page: one file, plain HTML + CSS, no build step.
  Save it as index.html. Save the login page next to it as login.html (the Log in links point there).
  Replace href="#signup" everywhere with your order / billing link.
  Prices and plans live in the markup: search for "$4" or ".com" to edit them.
-->

<header class="nav">
  <input class="sr" type="checkbox" id="nav-toggle" aria-label="Toggle menu">
  <div class="wrap nav-row">
    <a class="brand" href="#top" aria-label="oxbothost home"><svg width="30" height="30" viewBox="0 0 30 30" aria-hidden="true"><rect width="30" height="30" rx="8" fill="currentColor"/><circle cx="15" cy="15" r="6.5" fill="none" stroke="var(--bg)" stroke-width="2.6"/><circle cx="15" cy="15" r="2" fill="var(--bg)"/></svg><span><b>oxbot</b><span>host</span></span></a>
    <nav class="links" aria-label="Main">
      <a href="#pricing">Products</a><a href="#domains">Domains</a><a href="#features">Why oxbothost</a><a href="#faq">FAQ</a>
    </nav>
    <div class="navr">
      <a class="login" href="login.html">Log in</a>
      <a class="btn sm" href="#signup">Get started</a>
      <label class="menu-btn" for="nav-toggle"><span class="m-open">Menu</span><span class="m-close">Close</span></label>
    </div>
  </div>
  <div class="mobile-menu"><div class="wrap">
    <a href="#pricing">Products</a><a href="#domains">Domains</a><a href="#features">Why oxbothost</a><a href="#faq">FAQ</a><a href="login.html">Log in</a>
    <a class="btn" href="#signup">Get started</a>
  </div></div>
</header>

<main>
<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <h1>Hosting that just stays on.</h1>
      <p class="sub">VPS, web hosting, domains and dedicated servers in one place. Start with a VPS at $4 a month and upgrade when you grow.</p>
      <div class="actions">
        <a class="btn" href="#pricing">Get a VPS from $4/mo</a>
        <a class="btn ghost" href="#domains">Find a domain</a>
      </div>
      <ul class="notes"><li><svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2.5 7.5l3 3 6-7"/></svg>Full root access</li><li><svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2.5 7.5l3 3 6-7"/></svg>Free SSL</li><li><svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2.5 7.5l3 3 6-7"/></svg>24/7 live chat</li><li><svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2.5 7.5l3 3 6-7"/></svg>99.9% uptime</li></ul>
    </div>
    <div>
      <div class="term mono" role="img" aria-label="Example SSH session on an oxbothost VPS running nginx">
        <div class="term-bar"><div><span class="dot"></span>starter vps online</div><span>1 vCPU / 1 GB / 20 GB NVMe</span></div>
        <div class="term-body" aria-hidden="true">
<div class="tl cmd" style="--n:35;--d:.6s;--dur:1.4s"><span class="pr">you@laptop:~$ </span>ssh root@203.0.113.24</div>
<div class="tl out" style="--n:40;--d:2.2s;--dur:.3s">Welcome to Ubuntu 24.04 LTS on oxbothost</div>
<div class="tl cmd" style="--n:21;--d:2.7s;--dur:.84s"><span class="pr">root@starter:~# </span>nproc</div>
<div class="tl out" style="--n:1;--d:3.7s;--dur:.05s">1</div>
<div class="tl cmd" style="--n:36;--d:4s;--dur:1.44s"><span class="pr">root@starter:~# </span>apt install -y nginx</div>
<div class="tl out" style="--n:20;--d:5.6s;--dur:.3s">Setting up nginx ...</div>
<div class="tl cmd" style="--n:33;--d:5.9s;--dur:1.32s"><span class="pr">root@starter:~# </span>curl -I localhost</div>
<div class="tl out" style="--n:15;--d:7.4s;--dur:.3s">HTTP/1.1 200 OK</div>
<div class="tl" style="--n:17;--d:7.7s;--dur:.3s"><span class="pr">root@starter:~# </span><span class="cur"></span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="domains" class="band">
  <div class="wrap band-grid">
    <div>
      <h2>Find your domain</h2>
      <p class="sub">Type a name and see the price for every extension. Manage DNS right next to your server.</p>
    </div>
    <div>
      <label class="search"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="9" cy="9" r="6"/><path d="M14 14l4 4"/></svg><input id="dq" type="text" placeholder="Type a name, like yourbrand" aria-label="Domain name" autocomplete="off" autocapitalize="none" spellcheck="false"></label>
      <div class="dom-list"><div class="dom-row"><div class="dom-name"><span class="nm">yourbrand</span><span>.com</span></div><div class="dom-price">$11.99/yr</div><a class="btn sm ghost" href="#signup">Register</a></div><div class="dom-row"><div class="dom-name"><span class="nm">yourbrand</span><span>.net</span></div><div class="dom-price">$13.99/yr</div><a class="btn sm ghost" href="#signup">Register</a></div><div class="dom-row"><div class="dom-name"><span class="nm">yourbrand</span><span>.org</span></div><div class="dom-price">$12.99/yr</div><a class="btn sm ghost" href="#signup">Register</a></div><div class="dom-row"><div class="dom-name"><span class="nm">yourbrand</span><span>.xyz</span></div><div class="dom-price">$2.99/yr</div><a class="btn sm ghost" href="#signup">Register</a></div><div class="dom-row"><div class="dom-name"><span class="nm">yourbrand</span><span>.dev</span></div><div class="dom-price">$14.99/yr</div><a class="btn sm ghost" href="#signup">Register</a></div><div class="dom-row"><div class="dom-name"><span class="nm">yourbrand</span><span>.co</span></div><div class="dom-price">$24.99/yr</div><a class="btn sm ghost" href="#signup">Register</a></div></div>
      <p class="fine">Availability is confirmed when you register. Prices are per year.</p>
    </div>
  </div>
</section>

<section id="pricing" class="inv pricing">
  <div class="wrap">
    <h2>Simple plans. Start at $4.</h2>
    <input class="sr" type="radio" name="tab" id="t-vps" checked><input class="sr" type="radio" name="tab" id="t-hosting"><input class="sr" type="radio" name="tab" id="t-domains"><input class="sr" type="radio" name="tab" id="t-servers"><input class="sr" type="radio" name="bill" id="b-y" checked><input class="sr" type="radio" name="bill" id="b-m">
    <div class="p-controls">
      <div class="tabs tabs-scroll" role="group" aria-label="Products"><label class="tab" for="t-vps">VPS</label><label class="tab" for="t-hosting">Web hosting</label><label class="tab" for="t-domains">Domains</label><label class="tab" for="t-servers">Dedicated servers</label></div>
      <div class="tabs billing" role="group" aria-label="Billing period"><label class="tab" for="b-m">Monthly</label><label class="tab" for="b-y">Yearly, save 20%</label></div>
    </div>
    <div class="panels">
<div class="panel p-vps"><p class="panel-copy">Full root access on NVMe storage. Pick a Linux image, log in, and build.</p><div class="plans"><div class="plan"><div class="plan-top"><h3>Starter</h3></div><div><div class="py"><span class="amt">$4</span><span class="per">/mo</span><div class="billed">billed $48 yearly</div></div><div class="pm"><span class="amt">$5</span><span class="per">/mo</span><div class="billed">billed monthly</div></div></div><ul class="specs"><li><span>CPU</span><b>1 vCPU</b></li><li><span>Memory</span><b>1 GB</b></li><li><span>Storage</span><b>20 GB NVMe</b></li><li><span>Transfer</span><b>1 TB</b></li></ul><a class="btn ghost" href="#signup">Choose Starter</a></div><div class="plan"><div class="plan-top"><h3>Plus</h3></div><div><div class="py"><span class="amt">$8</span><span class="per">/mo</span><div class="billed">billed $96 yearly</div></div><div class="pm"><span class="amt">$10</span><span class="per">/mo</span><div class="billed">billed monthly</div></div></div><ul class="specs"><li><span>CPU</span><b>2 vCPU</b></li><li><span>Memory</span><b>4 GB</b></li><li><span>Storage</span><b>60 GB NVMe</b></li><li><span>Transfer</span><b>3 TB</b></li></ul><a class="btn ghost" href="#signup">Choose Plus</a></div><div class="plan feat"><div class="plan-top"><h3>Pro</h3><span class="badge">Most popular</span></div><div><div class="py"><span class="amt">$16</span><span class="per">/mo</span><div class="billed">billed $192 yearly</div></div><div class="pm"><span class="amt">$20</span><span class="per">/mo</span><div class="billed">billed monthly</div></div></div><ul class="specs"><li><span>CPU</span><b>4 vCPU</b></li><li><span>Memory</span><b>8 GB</b></li><li><span>Storage</span><b>120 GB NVMe</b></li><li><span>Transfer</span><b>5 TB</b></li></ul><a class="btn" href="#signup">Choose Pro</a></div><div class="plan"><div class="plan-top"><h3>Max</h3></div><div><div class="py"><span class="amt">$32</span><span class="per">/mo</span><div class="billed">billed $384 yearly</div></div><div class="pm"><span class="amt">$40</span><span class="per">/mo</span><div class="billed">billed monthly</div></div></div><ul class="specs"><li><span>CPU</span><b>8 vCPU</b></li><li><span>Memory</span><b>16 GB</b></li><li><span>Storage</span><b>240 GB NVMe</b></li><li><span>Transfer</span><b>8 TB</b></li></ul><a class="btn ghost" href="#signup">Choose Max</a></div></div><p class="swipe">Swipe to see more plans</p></div>
<div class="panel p-hosting"><p class="panel-copy">Managed hosting for websites and stores, with free SSL and one-click WordPress.</p><div class="plans"><div class="plan"><div class="plan-top"><h3>Single</h3></div><div><div class="py"><span class="amt">$2</span><span class="per">/mo</span><div class="billed">billed $24 yearly</div></div><div class="pm"><span class="amt">$3</span><span class="per">/mo</span><div class="billed">billed monthly</div></div></div><ul class="specs"><li><span>Websites</span><b>1</b></li><li><span>Storage</span><b>10 GB NVMe</b></li><li><span>Email</span><b>1 account</b></li><li><span>SSL</span><b>Free</b></li></ul><a class="btn ghost" href="#signup">Choose Single</a></div><div class="plan feat"><div class="plan-top"><h3>Premium</h3><span class="badge">Most popular</span></div><div><div class="py"><span class="amt">$5</span><span class="per">/mo</span><div class="billed">billed $60 yearly</div></div><div class="pm"><span class="amt">$7</span><span class="per">/mo</span><div class="billed">billed monthly</div></div></div><ul class="specs"><li><span>Websites</span><b>25</b></li><li><span>Storage</span><b>50 GB NVMe</b></li><li><span>Email</span><b>25 accounts</b></li><li><span>SSL</span><b>Free</b></li></ul><a class="btn" href="#signup">Choose Premium</a></div><div class="plan"><div class="plan-top"><h3>Business</h3></div><div><div class="py"><span class="amt">$9</span><span class="per">/mo</span><div class="billed">billed $108 yearly</div></div><div class="pm"><span class="amt">$12</span><span class="per">/mo</span><div class="billed">billed monthly</div></div></div><ul class="specs"><li><span>Websites</span><b>100</b></li><li><span>Storage</span><b>150 GB NVMe</b></li><li><span>Email</span><b>100 accounts</b></li><li><span>SSL</span><b>Free</b></li></ul><a class="btn ghost" href="#signup">Choose Business</a></div></div><p class="swipe">Swipe to see more plans</p></div>
<div class="panel p-domains"><p class="panel-copy">Register or transfer a domain and manage DNS from the same dashboard as your server.</p><div class="tlds"><div class="tld"><div class="tld-name">.com</div><div class="tld-price">$11.99/yr</div><a class="btn sm" href="#signup">Register</a></div><div class="tld"><div class="tld-name">.net</div><div class="tld-price">$13.99/yr</div><a class="btn sm" href="#signup">Register</a></div><div class="tld"><div class="tld-name">.org</div><div class="tld-price">$12.99/yr</div><a class="btn sm" href="#signup">Register</a></div><div class="tld"><div class="tld-name">.xyz</div><div class="tld-price">$2.99/yr</div><a class="btn sm" href="#signup">Register</a></div><div class="tld"><div class="tld-name">.dev</div><div class="tld-price">$14.99/yr</div><a class="btn sm" href="#signup">Register</a></div><div class="tld"><div class="tld-name">.co</div><div class="tld-price">$24.99/yr</div><a class="btn sm" href="#signup">Register</a></div><div class="tld"><div class="tld-name">.io</div><div class="tld-price">$39.99/yr</div><a class="btn sm" href="#signup">Register</a></div><div class="tld"><div class="tld-name">.app</div><div class="tld-price">$15.99/yr</div><a class="btn sm" href="#signup">Register</a></div></div></div>
<div class="panel p-servers"><p class="panel-copy">A whole machine, only yours. Built for databases, large apps and heavy traffic.</p><div class="plans"><div class="plan"><div class="plan-top"><h3>Core</h3></div><div><div><span class="amt">$59</span><span class="per">/mo</span><div class="billed">billed monthly</div></div></div><ul class="specs"><li><span>CPU</span><b>8 cores</b></li><li><span>Memory</span><b>32 GB</b></li><li><span>Storage</span><b>2 x 512 GB NVMe</b></li><li><span>Transfer</span><b>10 TB</b></li></ul><a class="btn ghost" href="#signup">Configure Core</a></div><div class="plan feat"><div class="plan-top"><h3>Power</h3><span class="badge">Most popular</span></div><div><div><span class="amt">$109</span><span class="per">/mo</span><div class="billed">billed monthly</div></div></div><ul class="specs"><li><span>CPU</span><b>16 cores</b></li><li><span>Memory</span><b>64 GB</b></li><li><span>Storage</span><b>2 x 1 TB NVMe</b></li><li><span>Transfer</span><b>20 TB</b></li></ul><a class="btn" href="#signup">Configure Power</a></div><div class="plan"><div class="plan-top"><h3>Elite</h3></div><div><div><span class="amt">$199</span><span class="per">/mo</span><div class="billed">billed monthly</div></div></div><ul class="specs"><li><span>CPU</span><b>32 cores</b></li><li><span>Memory</span><b>128 GB</b></li><li><span>Storage</span><b>2 x 2 TB NVMe</b></li><li><span>Transfer</span><b>50 TB</b></li></ul><a class="btn ghost" href="#signup">Configure Elite</a></div></div><p class="swipe">Swipe to see more plans</p></div>
    </div>
  </div>
</section>

<section id="features" class="features">
  <div class="wrap split">
    <div class="sticky">
      <h2>Built for things that stay online.</h2>
      <p class="sub">Every plan ships with the same solid base, backed by a 99.9% uptime guarantee.</p>
    </div>
    <div class="feature-list"><div class="feature"><h3>NVMe on every plan</h3><p>Fast reads and writes for databases, bots and busy sites.</p></div><div class="feature"><h3>DDoS protection</h3><p>Attack traffic is filtered before it reaches your server.</p></div><div class="feature"><h3>Full root access</h3><p>Run Node.js, PHP, Python, Docker, or anything else that runs on Linux.</p></div><div class="feature"><h3>Snapshots and backups</h3><p>Roll back a bad deploy in one click.</p></div><div class="feature"><h3>Free SSL and DNS</h3><p>Certificates renew on their own. Edit DNS records from your dashboard.</p></div><div class="feature"><h3>24/7 live chat</h3><p>A real person answers, day or night.</p></div></div>
  </div>
</section>

<section id="faq" class="faq">
  <div class="wrap split">
    <div><h2>Questions, answered.</h2></div>
    <div><details><summary>How fast is my server ready?</summary><p>Most VPS plans are provisioned within minutes of payment. You get the IP address and root login by email and in your dashboard.</p></details><details><summary>Can I upgrade later?</summary><p>Yes. Move to a bigger plan any time and keep your data.</p></details><details><summary>What can I run on a VPS?</summary><p>Anything that runs on Linux: websites, Node.js and PHP apps, databases, game servers and bots.</p></details><details><summary>Do domains include DNS?</summary><p>Yes. Every domain comes with DNS management, so you can point it at your VPS or hosting plan in a few clicks.</p></details><details><summary>What is your refund policy?</summary><p>Every new plan comes with a 7-day money-back guarantee.</p></details></div>
  </div>
</section>
</main>

<footer class="inv foot">
  <div class="wrap">
    <h2 class="cta-title">Start with a $4 VPS.</h2>
    <p class="sub">Pick a plan, choose an image, and log in. Upgrade any time without moving your data.</p>
    <div class="actions">
      <a class="btn" href="#pricing">Get a VPS from $4/mo</a>
      <a class="btn ghost" href="#signup">Talk to sales</a>
    </div>
    <div class="foot-grid">
      <div><a class="brand" href="#top"><svg width="30" height="30" viewBox="0 0 30 30" aria-hidden="true"><rect width="30" height="30" rx="8" fill="currentColor"/><circle cx="15" cy="15" r="6.5" fill="none" stroke="var(--bg)" stroke-width="2.6"/><circle cx="15" cy="15" r="2" fill="var(--bg)"/></svg><span><b>oxbot</b><span>host</span></span></a><p class="blurb">VPS, web hosting, domains and dedicated servers.</p></div>
      <div><h4>Products</h4><ul><li><a href="#pricing">VPS</a></li><li><a href="#pricing">Web hosting</a></li><li><a href="#domains">Domains</a></li><li><a href="#pricing">Dedicated servers</a></li></ul></div><div><h4>Company</h4><ul><li><a href="#top">About</a></li><li><a href="#top">Contact</a></li><li><a href="#top">Status</a></li></ul></div><div><h4>Legal</h4><ul><li><a href="#top">Terms</a></li><li><a href="#top">Privacy</a></li></ul></div>
    </div>
    <p class="legal">&copy; 2026 oxbothost. All rights reserved.</p>
  </div>
</footer>

<script>
/* optional: domain list follows what you type, and the phone menu closes after a tap. Page works fine without it. */
(function(){var i=document.getElementById('dq');if(!i)return;var n=document.querySelectorAll('.nm');
i.addEventListener('input',function(){var v=i.value.trim().toLowerCase().split('.')[0].replace(/[^a-z0-9-]/g,'')||'yourbrand';
for(var k=0;k<n.length;k++)n[k].textContent=v;});})();
(function(){var t=document.getElementById('nav-toggle');if(!t)return;var l=document.querySelectorAll('.mobile-menu a');
for(var k=0;k<l.length;k++)l[k].addEventListener('click',function(){t.checked=false;});})();
</script>
</body>
</html>
