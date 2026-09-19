<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="color-scheme" content="light dark">
<title>Dashboard | oxbothost</title>
<meta name="robots" content="noindex">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,300..800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<!--
  oxbothost dashboard (client area): one file, plain HTML + CSS, no build step.
  Save it as dashboard.html next to index.html, login.html and register.html.

  Sections: Home, Domains, Hosting, VPS, Servers, Support, in a sidebar. On a phone the sidebar slides
  in from the left when you tap the menu button. Sections switch with the radio buttons at the top
  of <body>, so it works even with JavaScript off.

  ALL DATA HERE IS SAMPLE DATA (Ada Obi, adaobi.com, starter-01, 203.0.113.x, prices, dates).
  Replace it with rows from your database. Each domain, hosting plan, VPS, server and ticket is one
  repeatable block, so it maps straight onto a PHP foreach loop or a template loop.

  BUTTONS AND LINKS
  Every action link has data-backend and a URL like /vps/starter-01/restart. Point those at your
  routes. While DEMO is true (script at the bottom) they only show a preview message.
  Copy buttons work for real. Set  var DEMO = false;  when your backend is ready.
  Log the person in before serving this page, and check on the server that they own the service.
-->
<style>
:root{
  color-scheme:light dark;
  --bg:#fff; --fg:#000; --muted:#4d4d4d; --line:#000; --soft:#d9d9d9; --surface:#f5f5f5;
  --ibg:#000; --ifg:#fff; --imuted:#d0d0d0; --iline:#fff; --isoft:#4d4d4d;
  --pad:clamp(16px,3vw,40px);
}
@media (prefers-color-scheme: dark){
  :root:not([data-theme="light"]){
    --bg:#000; --fg:#fff; --muted:#d0d0d0; --line:#fff; --soft:#4d4d4d; --surface:#0e0e0e;
    --ibg:#fff; --ifg:#000; --imuted:#4d4d4d; --iline:#000; --isoft:#d9d9d9;
  }
}
:root[data-theme="dark"]{
  color-scheme:dark;
  --bg:#000; --fg:#fff; --muted:#d0d0d0; --line:#fff; --soft:#4d4d4d; --surface:#0e0e0e;
  --ibg:#fff; --ifg:#000; --imuted:#4d4d4d; --iline:#000; --isoft:#d9d9d9;
}
:root[data-theme="light"]{color-scheme:light}

*{box-sizing:border-box;margin:0;padding:0}
html{-webkit-text-size-adjust:100%}
body{
  background:var(--bg);color:var(--fg);
  font-family:"Bricolage Grotesque",ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;
  font-size:15px;line-height:1.5;-webkit-font-smoothing:antialiased;
}
a{color:inherit;-webkit-tap-highlight-color:transparent}
button,input,select,textarea{font:inherit;color:inherit}
ul,ol{list-style:none}
svg{display:block;flex:none}
:focus-visible{outline:2px solid var(--fg);outline-offset:3px}
.sr{position:absolute;opacity:0;pointer-events:none;width:1px;height:1px}
.mono{font-family:"JetBrains Mono",ui-monospace,SFMono-Regular,Menlo,Consolas,monospace}
summary{list-style:none;cursor:pointer}
summary::-webkit-details-marker{display:none}

/* the black sidebar swaps the tokens, so everything inside just works */
.inv{--bg:var(--ibg);--fg:var(--ifg);--muted:var(--imuted);--line:var(--iline);--soft:var(--isoft);--surface:#1c1c1c;background:var(--bg);color:var(--fg)}
@media (prefers-color-scheme: dark){:root:not([data-theme="light"]) .inv{--surface:#e9e9e9}}
:root[data-theme="dark"] .inv{--surface:#e9e9e9}

/* ---------- layout ---------- */
.rail{position:fixed;inset:0 auto 0 0;width:248px;display:flex;flex-direction:column;gap:28px;padding:22px 16px;z-index:30}
.content{margin-left:248px;min-width:0}
.brand{display:inline-flex;align-items:center;gap:10px;font-size:1.35rem;letter-spacing:-.04em;text-decoration:none;width:max-content}
.brand b{font-weight:800}
.brand span span{font-weight:400}
.rail .brand{padding:0 6px}
.rail-nav{display:grid;gap:4px}
.rl{display:flex;align-items:center;gap:12px;height:46px;padding:0 14px;border-radius:12px;font-weight:600;color:var(--muted);cursor:pointer;touch-action:manipulation}
.rl:hover{background:var(--surface);color:var(--fg)}
.rail-help{margin-top:auto;border:1px solid var(--line);border-radius:16px;padding:16px;display:grid;gap:10px;font-size:.92rem}
.rail-help p{color:var(--muted)}
.rail-help p b{color:var(--fg)}

.topbar{position:sticky;top:0;z-index:20;height:68px;display:flex;align-items:center;justify-content:space-between;gap:12px;padding:0 var(--pad);background:var(--bg);border-bottom:1px solid var(--soft)}
.tb-left{display:flex;align-items:center;gap:12px;min-width:0}
.topbar .brand{display:none}
.crumb{color:var(--muted);font-weight:500}
.hamb,.rail-close{display:none;place-items:center;width:42px;height:42px;border-radius:50%;border:1px solid var(--line);cursor:pointer;flex:none;touch-action:manipulation}
.hamb:hover,.rail-close:hover{background:var(--surface)}
.rail-top{display:flex;align-items:center;justify-content:space-between;gap:12px}
.scrim{display:none}
#nav-toggle:focus-visible ~ .app .hamb{outline:2px solid var(--fg);outline-offset:3px}
.actions{display:flex;align-items:center;gap:10px}
main{padding:28px var(--pad) 72px;max-width:1160px;margin:0 auto}

/* ---------- buttons, badges, bits ---------- */
.btn{
  display:inline-flex;align-items:center;justify-content:center;gap:8px;height:48px;padding:0 22px;
  border-radius:999px;border:1.5px solid var(--fg);background:var(--fg);color:var(--bg);
  font-weight:600;font-size:.98rem;text-decoration:none;white-space:nowrap;cursor:pointer;touch-action:manipulation;
  transition:background .15s,color .15s;
}
.btn:hover{background:transparent;color:var(--fg)}
.btn.ghost{background:transparent;color:var(--fg)}
.btn.ghost:hover{background:var(--fg);color:var(--bg)}
.btn.sm{height:40px;padding:0 16px;font-size:.9rem}
.btn.off{opacity:.45;pointer-events:none}
.iconbtn{position:relative;display:grid;place-items:center;width:42px;height:42px;border-radius:50%;border:1px solid var(--line);cursor:pointer}
.pip{position:absolute;top:8px;right:9px;width:10px;height:10px;border-radius:50%;background:var(--fg);border:2px solid var(--bg)}
.avatar{display:grid;place-items:center;width:42px;height:42px;border-radius:50%;background:var(--fg);color:var(--bg);font-weight:700;font-size:.92rem;cursor:pointer}

.badge{display:inline-flex;align-items:center;height:26px;padding:0 12px;border-radius:999px;border:1.5px solid var(--fg);font-size:.8rem;font-weight:700;white-space:nowrap}
.badge.solid{background:var(--fg);color:var(--bg)}
.badge.warn{border-style:dashed}
.badge.mute{border-color:var(--soft);color:var(--muted);font-weight:600}
.st{display:inline-flex;align-items:center;gap:8px;font-weight:600;font-size:.9rem;white-space:nowrap}
.st::before{content:"";width:10px;height:10px;border-radius:50%;border:2px solid var(--fg);background:var(--fg)}
.st.off::before{background:transparent}

.meter{height:10px;border:1px solid var(--fg);border-radius:999px;overflow:hidden;background:var(--bg)}
.meter span{display:block;height:100%;background:var(--fg)}
.meter.hi span{background:repeating-linear-gradient(45deg,var(--fg) 0 4px,var(--bg) 4px 8px)}
.m-top{display:flex;justify-content:space-between;gap:10px;font-size:.85rem;margin-bottom:6px}
.m-top span{color:var(--muted)}
.m-top b{font-weight:600}
.meters{display:grid;grid-template-columns:1fr 1fr;gap:14px 20px}

.switch{display:flex;align-items:center;gap:12px;cursor:pointer;font-weight:600;font-size:.95rem}
.switch input{appearance:none;-webkit-appearance:none;flex:none;position:relative;width:46px;height:28px;border:1.5px solid var(--fg);border-radius:999px;background:var(--bg);cursor:pointer}
.switch input::before{content:"";position:absolute;top:3px;left:3px;width:18px;height:18px;border-radius:50%;background:var(--fg);transition:transform .15s,background .15s}
.switch input:checked{background:var(--fg)}
.switch input:checked::before{background:var(--bg);transform:translateX(18px)}

.pop-wrap{position:relative}
.menu{position:relative}
.pop{position:absolute;right:0;top:calc(100% + 8px);min-width:230px;padding:6px;background:var(--bg);border:1px solid var(--line);border-radius:14px;z-index:60}
.pop a,.pop label.pi{display:flex;align-items:center;gap:10px;padding:11px 12px;border-radius:10px;text-decoration:none;font-weight:500;cursor:pointer}
.pop a:hover,.pop label.pi:hover{background:var(--surface)}
.pop .who{padding:10px 12px 12px;border-bottom:1px solid var(--soft);margin-bottom:6px}
.pop .who small{display:block;color:var(--muted)}
.pop .note{display:block;padding:11px 12px;border-radius:10px;font-size:.92rem}
.pop .note small{display:block;color:var(--muted)}
.pop.wide{min-width:min(320px,86vw)}

/* ---------- views (switched by the radio buttons at the top of <body>) ---------- */
.view{display:none}
#v-home:checked ~ .app .view-home{display:block}
#v-home:checked ~ .app .rl[data-v="home"]{background:var(--fg);color:var(--bg)}
#v-home:focus-visible ~ .app [data-v="home"]{outline:2px solid var(--fg);outline-offset:-3px}
#v-domains:checked ~ .app .view-domains{display:block}
#v-domains:checked ~ .app .rl[data-v="domains"]{background:var(--fg);color:var(--bg)}
#v-domains:focus-visible ~ .app [data-v="domains"]{outline:2px solid var(--fg);outline-offset:-3px}
#v-hosting:checked ~ .app .view-hosting{display:block}
#v-hosting:checked ~ .app .rl[data-v="hosting"]{background:var(--fg);color:var(--bg)}
#v-hosting:focus-visible ~ .app [data-v="hosting"]{outline:2px solid var(--fg);outline-offset:-3px}
#v-vps:checked ~ .app .view-vps{display:block}
#v-vps:checked ~ .app .rl[data-v="vps"]{background:var(--fg);color:var(--bg)}
#v-vps:focus-visible ~ .app [data-v="vps"]{outline:2px solid var(--fg);outline-offset:-3px}
#v-servers:checked ~ .app .view-servers{display:block}
#v-servers:checked ~ .app .rl[data-v="servers"]{background:var(--fg);color:var(--bg)}
#v-servers:focus-visible ~ .app [data-v="servers"]{outline:2px solid var(--fg);outline-offset:-3px}
#v-support:checked ~ .app .view-support{display:block}
#v-support:checked ~ .app .rl[data-v="support"]{background:var(--fg);color:var(--bg)}
#v-support:focus-visible ~ .app [data-v="support"]{outline:2px solid var(--fg);outline-offset:-3px}


.head{display:flex;justify-content:space-between;align-items:flex-end;gap:16px;flex-wrap:wrap}
.head h1{font-size:clamp(1.9rem,3.6vw,2.6rem);font-weight:800;letter-spacing:-.045em;line-height:1}
.sub{color:var(--muted);margin-top:8px}
.card{border:1px solid var(--line);border-radius:16px;padding:20px;min-width:0}
.card>h2,.card-h{font-size:1.05rem;font-weight:700;letter-spacing:-.02em;margin-bottom:14px;display:flex;justify-content:space-between;align-items:center;gap:12px}
.card>h2 a,.card>h2 label{font-size:.88rem;font-weight:600;color:var(--muted);cursor:pointer;text-decoration:underline}
.list>*{padding:14px 0}
.list>*+*{border-top:1px solid var(--soft)}
.list>:first-child{padding-top:0}
.list>:last-child{padding-bottom:0}

/* home */
.tiles{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-top:24px}
.tile{position:relative;display:flex;flex-direction:column;gap:2px;padding:18px;border:1px solid var(--line);border-radius:16px;cursor:pointer;touch-action:manipulation;transition:background .15s,color .15s}
.tile:hover{background:var(--fg);color:var(--bg);--muted:var(--bg)}
.tile .ic{position:absolute;top:18px;right:18px}
.t-n{font-size:2.6rem;font-weight:800;letter-spacing:-.05em;line-height:1;margin-top:18px}
.t-l{font-weight:700}
.t-s{color:var(--muted);font-size:.86rem}
.grid2{display:grid;grid-template-columns:1.15fr .85fr;gap:16px;margin-top:16px}
.stack{display:grid;gap:16px;align-content:start}
.att{display:flex;align-items:center;gap:14px}
.att .txt{flex:1;min-width:0}
.att .txt b{display:block;font-weight:600}
.att .txt small{color:var(--muted)}
.ibox{display:grid;place-items:center;width:42px;height:42px;border-radius:50%;border:1px solid var(--line);flex:none}
.srv-row{display:grid;gap:12px}
.srv-top{display:flex;justify-content:space-between;align-items:center;gap:12px}
.srv-top b{display:block;font-weight:700}
.srv-top small{color:var(--muted)}
.feed>li{display:flex;justify-content:space-between;gap:16px;font-size:.95rem}
.feed small{color:var(--muted);white-space:nowrap}
.quick{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}
.quick .btn{height:auto;flex-direction:column;align-items:flex-start;justify-content:flex-start;gap:14px;padding:16px;border-radius:16px;white-space:normal;text-align:left;line-height:1.25}

/* domains */
.dsearch{display:flex;gap:10px;margin-top:22px;max-width:640px}
.dsearch input{flex:1;min-width:0}
input[type="text"],input[type="search"],select,textarea{
  width:100%;height:50px;padding:0 16px;border:1.5px solid var(--fg);border-radius:12px;background:var(--bg);color:var(--fg);font-size:1rem;
}
textarea{height:auto;min-height:140px;padding:12px 16px;resize:vertical;line-height:1.5}
input::placeholder,textarea::placeholder{color:var(--muted);opacity:1}
.row{border:1px solid var(--line);border-radius:16px;margin-top:12px}
.row:first-of-type{margin-top:22px}
.row>summary{display:grid;grid-template-columns:1fr auto auto 24px;gap:6px 20px;align-items:center;padding:18px 20px}
.d-name{font-size:1.15rem;font-weight:700;letter-spacing:-.02em;overflow-wrap:anywhere}
.d-exp{color:var(--muted);font-size:.92rem;white-space:nowrap}
.chev{transition:transform .2s}
.row[open] .chev{transform:rotate(180deg)}
.row-body{display:grid;grid-template-columns:1.5fr 1fr;gap:28px;padding:18px 20px 22px;border-top:1px solid var(--soft)}
.row-body h3{font-size:.85rem;font-weight:700;color:var(--muted);margin-bottom:8px}
.recs{font-size:.92rem}
.rec{display:grid;grid-template-columns:64px 64px 1fr 64px;gap:12px;align-items:center;padding:10px 0;border-top:1px solid var(--soft)}
.rec.h{border-top:0;padding-top:0;font-size:.78rem;font-weight:700;color:var(--muted)}
.rec .v{word-break:break-all;font-size:.85rem}
.rec .t{font-weight:700}
.ns{display:grid;gap:6px;font-size:.92rem;margin-bottom:16px}
.ctl{display:grid;gap:14px}

/* service cards (hosting, vps, servers) */
.svcs{display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,440px),1fr));gap:16px;margin-top:24px}
.svc{display:flex;flex-direction:column;gap:18px}
.svc-h{display:flex;justify-content:space-between;align-items:flex-start;gap:12px}
.svc-h h2{font-size:1.3rem;font-weight:800;letter-spacing:-.03em;line-height:1.15;overflow-wrap:anywhere}
.svc-h small{display:block;color:var(--muted);margin-top:2px}
.kv{display:grid;grid-template-columns:auto 1fr;gap:8px 20px;font-size:.92rem}
.kv dt{color:var(--muted)}
.kv dd{font-weight:600;text-align:right;overflow-wrap:anywhere}
.ipbox{display:flex;align-items:center;justify-content:space-between;gap:10px;border:1px solid var(--soft);border-radius:12px;padding:8px 8px 8px 14px;font-size:.9rem;min-width:0}
.ipbox span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.copy{display:inline-flex;align-items:center;gap:6px;height:34px;padding:0 12px;border-radius:999px;border:1px solid var(--line);background:transparent;font-weight:600;font-size:.82rem;cursor:pointer;flex:none}
.copy:hover{background:var(--fg);color:var(--bg)}
.acts{display:flex;flex-wrap:wrap;gap:8px;margin-top:auto}
.chips{display:flex;flex-wrap:wrap;gap:8px}
.chip{display:inline-flex;align-items:center;gap:8px;height:38px;padding:0 14px;border:1px solid var(--line);border-radius:999px;text-decoration:none;font-weight:600;font-size:.88rem}
.chip:hover{background:var(--fg);color:var(--bg)}
.note-line{display:flex;align-items:center;gap:10px;font-size:.92rem;padding:12px 14px;border:1.5px dashed var(--fg);border-radius:12px}
.stopped-msg{display:flex;align-items:center;gap:10px;padding:14px;border:1px solid var(--soft);border-radius:12px;color:var(--muted);font-size:.92rem}
.cta-card{border:1.5px dashed var(--line);border-radius:16px;padding:24px;display:flex;flex-direction:column;justify-content:center;align-items:flex-start;gap:12px;min-height:220px}
.cta-card h2{font-size:1.3rem;font-weight:800;letter-spacing:-.03em}
.cta-card p{color:var(--muted);max-width:34ch}

/* support */
.support{display:grid;grid-template-columns:1.15fr .85fr;gap:16px;margin-top:24px;align-items:start}
.f{margin-bottom:14px}
.f>label,.f>.l{display:block;font-weight:600;font-size:.92rem;margin-bottom:6px}
.f2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.sel{position:relative}
.sel::after{content:"";position:absolute;right:18px;top:50%;width:8px;height:8px;border:solid var(--fg);border-width:0 2px 2px 0;transform:translateY(-70%) rotate(45deg);pointer-events:none}
select{appearance:none;-webkit-appearance:none;padding-right:44px;cursor:pointer;text-overflow:ellipsis}
option{background:var(--bg);color:var(--fg)}
.seg{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
.seg label{position:relative}
.seg input{position:absolute;opacity:0;inset:0;cursor:pointer}
.seg span{display:flex;justify-content:center;align-items:center;height:46px;border:1.5px solid var(--fg);border-radius:999px;font-weight:600;cursor:pointer}
.seg input:checked+span{background:var(--fg);color:var(--bg)}
.seg input:focus-visible+span{outline:2px solid var(--fg);outline-offset:3px}
.contact{display:flex;align-items:center;gap:14px}
.contact .txt{flex:1;min-width:0}
.contact .txt b{display:block}
.contact .txt small{color:var(--muted);overflow-wrap:anywhere}
.tickets{margin-top:16px}
.ticket{display:grid;grid-template-columns:72px 1fr auto 110px;gap:12px;align-items:center;text-decoration:none}
.ticket:hover .subj b{text-decoration:underline}
.subj b{display:block;font-weight:600}
.subj small{color:var(--muted)}
.when{color:var(--muted);font-size:.88rem;text-align:right}
.tid{color:var(--muted);font-weight:600}

/* toast */
.toast{position:fixed;left:50%;bottom:24px;transform:translate(-50%,16px);width:max-content;max-width:min(460px,calc(100% - 32px));padding:12px 20px;border-radius:18px;background:var(--fg);color:var(--bg);font-weight:600;font-size:.92rem;text-align:center;opacity:0;pointer-events:none;transition:opacity .2s,transform .2s;z-index:100}
.toast.show{opacity:1;transform:translate(-50%,0)}

/* ---------- tablet and phone ---------- */
@media (max-width:1000px){
  .tiles{grid-template-columns:1fr 1fr}
  .grid2,.support{grid-template-columns:1fr}
}
@media (max-width:900px){
  .content{margin-left:0}
  .rail{width:min(300px,86vw);transform:translateX(-102%);visibility:hidden;border-right:1px solid var(--line);transition:transform .25s ease,visibility 0s linear .25s;overflow-y:auto}
  #nav-toggle:checked ~ .app .rail{transform:none;visibility:visible;transition:transform .25s ease,visibility 0s}
  .scrim{display:block;position:fixed;inset:0;z-index:28;background:rgba(0,0,0,.55);opacity:0;pointer-events:none;transition:opacity .25s}
  #nav-toggle:checked ~ .app .scrim{opacity:1;pointer-events:auto}
  body:has(#nav-toggle:checked){overflow:hidden}
  .hamb,.rail-close{display:grid}
  .rl{height:52px;font-size:1.05rem}
  .topbar{height:60px}
  .topbar .brand{display:inline-flex;font-size:1.2rem}
  .crumb{display:none}
  .btn.order span{display:none}
  .btn.order{width:42px;height:42px;padding:0}
  main{padding-top:22px}
  .toast{bottom:calc(20px + env(safe-area-inset-bottom))}
  .pop{position:fixed;left:16px;right:16px;top:68px;min-width:0}
}
@media (max-width:700px){
  .head h1{font-size:2rem}
  .t-n{font-size:2.2rem;margin-top:14px}
  .meters{grid-template-columns:1fr}
  .row>summary{grid-template-columns:1fr 24px;grid-template-areas:"n c" "b c" "e c"}
  .row>summary .d-name{grid-area:n}
  .row>summary .badge{grid-area:b;justify-self:start}
  .row>summary .d-exp{grid-area:e}
  .row>summary .chev{grid-area:c}
  .row-body{grid-template-columns:1fr;gap:22px;padding:16px 16px 20px}
  .rec{grid-template-columns:56px 1fr;grid-template-areas:"t n" "v v";gap:2px 12px}
  .rec .t{grid-area:t}.rec .n{grid-area:n}.rec .v{grid-area:v}.rec .ttl,.rec.h{display:none}
  .card{padding:16px}
  .f2{grid-template-columns:1fr}
  .dsearch{flex-direction:column}
  .dsearch input{flex:none}
  .ticket{grid-template-columns:1fr auto;grid-template-areas:"s b" "i w";gap:4px 12px}
  .ticket .subj{grid-area:s}.ticket .badge{grid-area:b}.ticket .tid{grid-area:i}.ticket .when{grid-area:w}
  .att{align-items:flex-start;flex-wrap:wrap}
  .att .txt{flex:1 1 calc(100% - 56px)}
  .att .btn{margin-left:56px}
  .acts .btn{flex:1 1 calc(50% - 8px)}
}
@media (max-width:400px){.topbar .brand span{display:none}}
@media (prefers-reduced-motion:reduce){.btn,.tile,.chev,.toast,.switch input::before,.rail,.scrim{transition:none!important}}

</style>
</head>
<body>
<input class="sr" type="checkbox" id="nav-toggle" aria-label="Open or close the menu"><input class="sr" type="radio" name="view" id="v-home" checked aria-label="Home"><input class="sr" type="radio" name="view" id="v-domains" aria-label="Domains"><input class="sr" type="radio" name="view" id="v-hosting" aria-label="Hosting"><input class="sr" type="radio" name="view" id="v-vps" aria-label="VPS"><input class="sr" type="radio" name="view" id="v-servers" aria-label="Servers"><input class="sr" type="radio" name="view" id="v-support" aria-label="Support">
<div class="app">

  <aside class="rail inv" aria-label="Sidebar">
    <div class="rail-top">
      <a class="brand" href="index.html" data-backend aria-label="oxbothost home"><svg width="30" height="30" viewBox="0 0 30 30" aria-hidden="true"><rect width="30" height="30" rx="8" fill="currentColor"/><circle cx="15" cy="15" r="6.5" fill="none" stroke="var(--bg)" stroke-width="2.6"/><circle cx="15" cy="15" r="2" fill="var(--bg)"/></svg><span><b>oxbot</b><span>host</span></span></a>
      <label class="rail-close" for="nav-toggle" aria-label="Close menu"><svg class="ic" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg></label>
    </div>
    <nav class="rail-nav" aria-label="Sections"><label class="rl" for="v-home" data-v="home"><svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11.5 12 4l9 7.5"/><path d="M5.5 10v9.5h13V10"/></svg><span>Home</span></label><label class="rl" for="v-domains" data-v="domains"><svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c3 3.2 3 14.8 0 18"/><path d="M12 3c-3 3.2-3 14.8 0 18"/></svg><span>Domains</span></label><label class="rl" for="v-hosting" data-v="hosting"><svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="2.5"/><path d="M3 9h18"/><path d="M6.5 6.5h.01M9.5 6.5h.01"/></svg><span>Hosting</span></label><label class="rl" for="v-vps" data-v="vps"><svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3 20 7.5v9L12 21l-8-4.5v-9L12 3z"/><path d="M12 12l8-4.5M12 12v9M12 12 4 7.5"/></svg><span>VPS</span></label><label class="rl" for="v-servers" data-v="servers"><svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3.5" width="18" height="7" rx="2"/><rect x="3" y="13.5" width="18" height="7" rx="2"/><path d="M7 7h.01M7 17h.01M11 7h6M11 17h6"/></svg><span>Servers</span></label><label class="rl" for="v-support" data-v="support"><svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a8 8 0 0 1-11.6 7.1L4 20.5l1.4-4.9A8 8 0 1 1 21 12z"/></svg><span>Support</span></label></nav>
    <div class="rail-help">
      <p><b>Need a hand?</b></p>
      <p>Our team answers 24/7 on live chat.</p>
      <label class="btn sm" for="v-support">Contact support</label>
    </div>
  </aside>

  <div class="content">
    <header class="topbar">
      <div class="tb-left">
        <label class="hamb" for="nav-toggle" aria-label="Open menu"><svg class="ic" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg></label>
        <a class="brand" href="index.html" data-backend aria-label="oxbothost home"><svg width="30" height="30" viewBox="0 0 30 30" aria-hidden="true"><rect width="30" height="30" rx="8" fill="currentColor"/><circle cx="15" cy="15" r="6.5" fill="none" stroke="var(--bg)" stroke-width="2.6"/><circle cx="15" cy="15" r="2" fill="var(--bg)"/></svg><span><b>oxbot</b><span>host</span></span></a>
        <span class="crumb">Client area</span>
      </div>
      <div class="actions">
        <details class="menu">
          <summary class="btn sm order" aria-label="New order"><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg><span>New order</span></summary>
          <div class="pop">
            <a href="/order/vps" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3 20 7.5v9L12 21l-8-4.5v-9L12 3z"/><path d="M12 12l8-4.5M12 12v9M12 12 4 7.5"/></svg>VPS</a>
            <a href="/order/hosting" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="2.5"/><path d="M3 9h18"/><path d="M6.5 6.5h.01M9.5 6.5h.01"/></svg>Web hosting</a>
            <a href="/domains/search" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c3 3.2 3 14.8 0 18"/><path d="M12 3c-3 3.2-3 14.8 0 18"/></svg>Domain</a>
            <a href="/order/servers" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3.5" width="18" height="7" rx="2"/><rect x="3" y="13.5" width="18" height="7" rx="2"/><path d="M7 7h.01M7 17h.01M11 7h6M11 17h6"/></svg>Dedicated server</a>
          </div>
        </details>
        <details class="menu">
          <summary class="iconbtn" aria-label="Notifications, 2 new"><svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 16v-5a6 6 0 1 1 12 0v5l1.5 2h-15L6 16z"/><path d="M10 21h4"/></svg><i class="pip"></i></summary>
          <div class="pop wide">
            <a class="note" href="/domains/adaobi.dev" data-backend>adaobi.dev expires in 12 days<small>Today</small></a>
            <a class="note" href="/support/tickets/2291" data-backend>New reply on ticket #2291<small>2 hours ago</small></a>
            <a class="note" href="/vps/starter-01" data-backend>Snapshot finished on starter-01<small>2 hours ago</small></a>
          </div>
        </details>
        <details class="menu">
          <summary class="avatar" aria-label="Account menu">AO</summary>
          <div class="pop">
            <div class="who"><b>Ada Obi</b><small>ada@example.com</small></div>
            <a href="/account" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 20c1-4 4-6 8-6s7 2 8 6"/></svg>Profile</a>
            <a href="/billing" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="M3 10h18"/></svg>Billing</a>
            <a href="login.html" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 4H5v16h5"/><path d="M15 8l4 4-4 4M19 12H9"/></svg>Log out</a>
          </div>
        </details>
      </div>
    </header>
    <main>
<section class="view view-home" aria-label="Home">
  <div class="head"><div>
    <h1 id="greet">Welcome back, Ada</h1>
    <p class="sub">Here is what is happening with your services.</p>
  </div></div>

  <div class="tiles">
    <label class="tile" for="v-domains"><svg class="ic" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c3 3.2 3 14.8 0 18"/><path d="M12 3c-3 3.2-3 14.8 0 18"/></svg><span class="t-n">3</span><span class="t-l">Domains</span><span class="t-s">1 expires in 12 days</span></label>
    <label class="tile" for="v-hosting"><svg class="ic" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="2.5"/><path d="M3 9h18"/><path d="M6.5 6.5h.01M9.5 6.5h.01"/></svg><span class="t-n">2</span><span class="t-l">Web hosting</span><span class="t-s">1 almost out of disk</span></label>
    <label class="tile" for="v-vps"><svg class="ic" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3 20 7.5v9L12 21l-8-4.5v-9L12 3z"/><path d="M12 12l8-4.5M12 12v9M12 12 4 7.5"/></svg><span class="t-n">2</span><span class="t-l">VPS</span><span class="t-s">1 stopped</span></label>
    <label class="tile" for="v-servers"><svg class="ic" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3.5" width="18" height="7" rx="2"/><rect x="3" y="13.5" width="18" height="7" rx="2"/><path d="M7 7h.01M7 17h.01M11 7h6M11 17h6"/></svg><span class="t-n">1</span><span class="t-l">Servers</span><span class="t-s">Online</span></label>
  </div>

  <div class="grid2">
    <div class="stack">
      <section class="card">
        <h2>Needs attention</h2>
        <div class="list">
          <div class="att"><span class="ibox"><svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7.5V13M12 16.5h.01"/></svg></span><div class="txt"><b>adaobi.dev expires in 12 days</b><small>Auto-renew is off</small></div><a class="btn sm ghost" href="/domains/adaobi.dev/renew" data-backend>Renew</a></div>
          <div class="att"><span class="ibox"><svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="M3 10h18"/></svg></span><div class="txt"><b>Invoice #1043 is due Oct 3</b><small>$12.00 for starter-01 and hosting</small></div><a class="btn sm ghost" href="/billing/invoices/1043" data-backend>Pay now</a></div>
          <div class="att"><span class="ibox"><svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a8 8 0 0 1-11.6 7.1L4 20.5l1.4-4.9A8 8 0 1 1 21 12z"/></svg></span><div class="txt"><b>Ticket #2291 has a reply</b><small>Cannot connect via SSH</small></div><label class="btn sm ghost" for="v-support">View</label></div>
        </div>
      </section>

      <section class="card">
        <h2>Servers <label for="v-vps">View all</label></h2>
        <div class="list">
          <div class="srv-row"><div class="srv-top"><div><b>starter-01</b><small class="mono">203.0.113.24</small></div><span class="st on">Running</span></div>
            <div class="meters"><div class="m"><div class="m-top"><span>CPU</span><b>18%</b></div><div class="meter" role="meter" aria-label="CPU" aria-valuemin="0" aria-valuemax="100" aria-valuenow="18"><span style="width:18%"></span></div></div><div class="m"><div class="m-top"><span>Memory</span><b>41%</b></div><div class="meter" role="meter" aria-label="Memory" aria-valuemin="0" aria-valuemax="100" aria-valuenow="41"><span style="width:41%"></span></div></div></div></div>
          <div class="srv-row"><div class="srv-top"><div><b>dev-box</b><small class="mono">198.51.100.42</small></div><span class="st off">Stopped</span></div></div>
          <div class="srv-row"><div class="srv-top"><div><b>core-01</b><small class="mono">203.0.113.80</small></div><span class="st on">Online</span></div>
            <div class="meters"><div class="m"><div class="m-top"><span>CPU</span><b>6%</b></div><div class="meter" role="meter" aria-label="CPU" aria-valuemin="0" aria-valuemax="100" aria-valuenow="6"><span style="width:6%"></span></div></div><div class="m"><div class="m-top"><span>Memory</span><b>22%</b></div><div class="meter" role="meter" aria-label="Memory" aria-valuemin="0" aria-valuemax="100" aria-valuenow="22"><span style="width:22%"></span></div></div></div></div>
        </div>
      </section>
    </div>

    <div class="stack">
      <section class="card">
        <h2>Quick actions</h2>
        <div class="quick">
          <a class="btn ghost" href="/order/vps" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>Order a VPS</a>
          <a class="btn ghost" href="/domains/search" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c3 3.2 3 14.8 0 18"/><path d="M12 3c-3 3.2-3 14.8 0 18"/></svg>Register a domain</a>
          <label class="btn ghost" for="v-support"><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a8 8 0 0 1-11.6 7.1L4 20.5l1.4-4.9A8 8 0 1 1 21 12z"/></svg>Open a ticket</label>
          <a class="btn ghost" href="/billing/invoices" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="M3 10h18"/></svg>View invoices</a>
        </div>
      </section>

      <section class="card">
        <h2>Recent activity</h2>
        <ul class="feed list">
          <li><span>Snapshot created on starter-01</span><small>2 hours ago</small></li>
          <li><span>DNS record added to adaobi.com</span><small>Yesterday</small></li>
          <li><span>Invoice #1042 paid</span><small>Sep 3</small></li>
          <li><span>Ticket #2290 closed</span><small>Sep 1</small></li>
        </ul>
      </section>
    </div>
  </div>
</section>
<section class="view view-domains" aria-label="Domains">
  <div class="head"><div><h1>Domains</h1><p class="sub">3 domains. Tap one to see its DNS records and settings.</p></div></div>
  <form class="dsearch" action="/domains/search" method="get" data-backend>
    <input type="search" name="q" placeholder="Find a new domain, like yourbrand.com" aria-label="Search for a domain" autocomplete="off" autocapitalize="none" spellcheck="false">
    <button class="btn" type="submit"><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c3 3.2 3 14.8 0 18"/><path d="M12 3c-3 3.2-3 14.8 0 18"/></svg>Search</button>
  </form>
  <details class="row">
    <summary><span class="d-name">adaobi.com</span><span class="badge solid">Active</span><span class="d-exp">Expires Mar 14, 2027</span><span class="chev"><svg class="ic" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg></span></summary>
    <div class="row-body">
      <div>
        <h3>DNS records</h3>
        <div class="recs" role="table" aria-label="DNS records for adaobi.com">
          <div class="rec h" role="row"><span role="columnheader">Type</span><span role="columnheader">Name</span><span role="columnheader">Value</span><span role="columnheader">TTL</span></div>
          <div class="rec" role="row"><span class="t" role="cell">A</span><span class="n" role="cell">@</span><span class="v mono" role="cell">203.0.113.24</span><span class="ttl" role="cell">3600</span></div><div class="rec" role="row"><span class="t" role="cell">CNAME</span><span class="n" role="cell">www</span><span class="v mono" role="cell">adaobi.com</span><span class="ttl" role="cell">3600</span></div><div class="rec" role="row"><span class="t" role="cell">MX</span><span class="n" role="cell">@</span><span class="v mono" role="cell">mail.adaobi.com (10)</span><span class="ttl" role="cell">3600</span></div><div class="rec" role="row"><span class="t" role="cell">TXT</span><span class="n" role="cell">@</span><span class="v mono" role="cell">v=spf1 include:oxbothost.com ~all</span><span class="ttl" role="cell">3600</span></div>
        </div>
      </div>
      <div>
        <h3>Nameservers</h3>
        <div class="ns mono"><span>ns1.oxbothost.com</span><span>ns2.oxbothost.com</span></div>
        <div class="ctl">
          <label class="switch"><input type="checkbox" data-toggle="Auto-renew for adaobi.com" checked>Auto-renew</label>
          <label class="switch"><input type="checkbox" data-toggle="Transfer lock for adaobi.com" checked>Transfer lock</label>
          <div class="acts"><a class="btn sm ghost" href="/domains/adaobi.com/dns" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c3 3.2 3 14.8 0 18"/><path d="M12 3c-3 3.2-3 14.8 0 18"/></svg>Manage DNS</a><a class="btn sm ghost" href="/domains/adaobi.com/renew" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 12a8 8 0 1 1-2.3-5.7"/><path d="M20 4v5h-5"/></svg>Renew 1 year</a></div>
        </div>
      </div>
    </div>
  </details>
  <details class="row">
    <summary><span class="d-name">shopbyada.ng</span><span class="badge solid">Active</span><span class="d-exp">Expires Jun 2, 2027</span><span class="chev"><svg class="ic" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg></span></summary>
    <div class="row-body">
      <div>
        <h3>DNS records</h3>
        <div class="recs" role="table" aria-label="DNS records for shopbyada.ng">
          <div class="rec h" role="row"><span role="columnheader">Type</span><span role="columnheader">Name</span><span role="columnheader">Value</span><span role="columnheader">TTL</span></div>
          <div class="rec" role="row"><span class="t" role="cell">A</span><span class="n" role="cell">@</span><span class="v mono" role="cell">198.51.100.17</span><span class="ttl" role="cell">3600</span></div><div class="rec" role="row"><span class="t" role="cell">CNAME</span><span class="n" role="cell">www</span><span class="v mono" role="cell">shopbyada.ng</span><span class="ttl" role="cell">3600</span></div>
        </div>
      </div>
      <div>
        <h3>Nameservers</h3>
        <div class="ns mono"><span>ns1.oxbothost.com</span><span>ns2.oxbothost.com</span></div>
        <div class="ctl">
          <label class="switch"><input type="checkbox" data-toggle="Auto-renew for shopbyada.ng" checked>Auto-renew</label>
          <label class="switch"><input type="checkbox" data-toggle="Transfer lock for shopbyada.ng" checked>Transfer lock</label>
          <div class="acts"><a class="btn sm ghost" href="/domains/shopbyada.ng/dns" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c3 3.2 3 14.8 0 18"/><path d="M12 3c-3 3.2-3 14.8 0 18"/></svg>Manage DNS</a><a class="btn sm ghost" href="/domains/shopbyada.ng/renew" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 12a8 8 0 1 1-2.3-5.7"/><path d="M20 4v5h-5"/></svg>Renew 1 year</a></div>
        </div>
      </div>
    </div>
  </details>
  <details class="row">
    <summary><span class="d-name">adaobi.dev</span><span class="badge warn">Expiring soon</span><span class="d-exp">Expires Oct 1, 2026</span><span class="chev"><svg class="ic" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg></span></summary>
    <div class="row-body">
      <div>
        <h3>DNS records</h3>
        <div class="recs" role="table" aria-label="DNS records for adaobi.dev">
          <div class="rec h" role="row"><span role="columnheader">Type</span><span role="columnheader">Name</span><span role="columnheader">Value</span><span role="columnheader">TTL</span></div>
          <div class="rec" role="row"><span class="t" role="cell">A</span><span class="n" role="cell">@</span><span class="v mono" role="cell">203.0.113.24</span><span class="ttl" role="cell">3600</span></div><div class="rec" role="row"><span class="t" role="cell">CNAME</span><span class="n" role="cell">www</span><span class="v mono" role="cell">adaobi.dev</span><span class="ttl" role="cell">3600</span></div>
        </div>
      </div>
      <div>
        <h3>Nameservers</h3>
        <div class="ns mono"><span>ns1.oxbothost.com</span><span>ns2.oxbothost.com</span></div>
        <div class="ctl">
          <label class="switch"><input type="checkbox" data-toggle="Auto-renew for adaobi.dev">Auto-renew</label>
          <label class="switch"><input type="checkbox" data-toggle="Transfer lock for adaobi.dev" checked>Transfer lock</label>
          <div class="acts"><a class="btn sm ghost" href="/domains/adaobi.dev/dns" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c3 3.2 3 14.8 0 18"/><path d="M12 3c-3 3.2-3 14.8 0 18"/></svg>Manage DNS</a><a class="btn sm" href="/domains/adaobi.dev/renew" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 12a8 8 0 1 1-2.3-5.7"/><path d="M20 4v5h-5"/></svg>Renew for $14.99</a></div>
        </div>
      </div>
    </div>
  </details>
</section>
<section class="view view-hosting" aria-label="Web hosting">
  <div class="head"><div><h1>Web hosting</h1><p class="sub">2 hosting plans.</p></div><a class="btn" href="/order/hosting" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>New hosting plan</a></div>
  <div class="svcs">
    <article class="card svc">
      <div class="svc-h"><div><h2>adaobi.com</h2><small>Premium plan, $5/mo, renews Nov 12</small></div><span class="badge solid">Active</span></div>
      <div class="meters"><div class="m"><div class="m-top"><span>Disk</span><b>12.4 of 50 GB</b></div><div class="meter" role="meter" aria-label="Disk" aria-valuemin="0" aria-valuemax="100" aria-valuenow="25"><span style="width:25%"></span></div></div><div class="m"><div class="m-top"><span>Websites</span><b>3 of 25</b></div><div class="meter" role="meter" aria-label="Websites" aria-valuemin="0" aria-valuemax="100" aria-valuenow="12"><span style="width:12%"></span></div></div><div class="m"><div class="m-top"><span>Email accounts</span><b>4 of 25</b></div><div class="meter" role="meter" aria-label="Email accounts" aria-valuemin="0" aria-valuemax="100" aria-valuenow="16"><span style="width:16%"></span></div></div><div class="m"><div class="m-top"><span>Databases</span><b>2 of 20</b></div><div class="meter" role="meter" aria-label="Databases" aria-valuemin="0" aria-valuemax="100" aria-valuenow="10"><span style="width:10%"></span></div></div></div>
      
      <div class="chips">
        <a class="chip" href="/hosting/adaobi.com/panel" data-backend><svg class="ic" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 4h6v6"/><path d="M20 4l-9 9"/><path d="M18 14v5H5V6h5"/></svg>Control panel</a>
        <a class="chip" href="/hosting/adaobi.com/files" data-backend>File manager</a>
        <a class="chip" href="/hosting/adaobi.com/email" data-backend>Email</a>
        <a class="chip" href="/hosting/adaobi.com/databases" data-backend>Databases</a>
      </div>
      <div class="acts"><a class="btn sm ghost" href="/hosting/adaobi.com/upgrade" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>Upgrade plan</a><a class="btn sm ghost" href="/hosting/adaobi.com/ssl" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12.5l4.5 4.5 10-10.5"/></svg>SSL: active</a></div>
    </article>
    <article class="card svc">
      <div class="svc-h"><div><h2>shopbyada.ng</h2><small>Single plan, $2/mo, renews Jan 9</small></div><span class="badge solid">Active</span></div>
      <div class="meters"><div class="m"><div class="m-top"><span>Disk</span><b>8.8 of 10 GB</b></div><div class="meter hi" role="meter" aria-label="Disk" aria-valuemin="0" aria-valuemax="100" aria-valuenow="88"><span style="width:88%"></span></div></div><div class="m"><div class="m-top"><span>Websites</span><b>1 of 1</b></div><div class="meter hi" role="meter" aria-label="Websites" aria-valuemin="0" aria-valuemax="100" aria-valuenow="100"><span style="width:100%"></span></div></div><div class="m"><div class="m-top"><span>Email accounts</span><b>1 of 1</b></div><div class="meter hi" role="meter" aria-label="Email accounts" aria-valuemin="0" aria-valuemax="100" aria-valuenow="100"><span style="width:100%"></span></div></div><div class="m"><div class="m-top"><span>Databases</span><b>1 of 10</b></div><div class="meter" role="meter" aria-label="Databases" aria-valuemin="0" aria-valuemax="100" aria-valuenow="10"><span style="width:10%"></span></div></div></div>
      <div class="note-line"><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7.5V13M12 16.5h.01"/></svg><span>Disk is almost full. Upgrade to keep the site online.</span></div>
      <div class="chips">
        <a class="chip" href="/hosting/shopbyada.ng/panel" data-backend><svg class="ic" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 4h6v6"/><path d="M20 4l-9 9"/><path d="M18 14v5H5V6h5"/></svg>Control panel</a>
        <a class="chip" href="/hosting/shopbyada.ng/files" data-backend>File manager</a>
        <a class="chip" href="/hosting/shopbyada.ng/email" data-backend>Email</a>
        <a class="chip" href="/hosting/shopbyada.ng/databases" data-backend>Databases</a>
      </div>
      <div class="acts"><a class="btn sm ghost" href="/hosting/shopbyada.ng/upgrade" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>Upgrade plan</a><a class="btn sm ghost" href="/hosting/shopbyada.ng/ssl" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12.5l4.5 4.5 10-10.5"/></svg>SSL: active</a></div>
    </article>
  </div>
</section>
<section class="view view-vps" aria-label="VPS">
  <div class="head"><div><h1>VPS</h1><p class="sub">2 virtual servers. Full root access on every one.</p></div><a class="btn" href="/order/vps" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>New VPS</a></div>
  <div class="svcs">
    <article class="card svc">
      <div class="svc-h"><div><h2>starter-01</h2><small>Starter plan, $4/mo, renews Oct 3</small></div><span class="st on">Running</span></div>
      <dl class="kv"><dt>Resources</dt><dd>1 vCPU, 1 GB RAM, 20 GB NVMe</dd><dt>System</dt><dd>Ubuntu 24.04 LTS</dd><dt>Location</dt><dd>Frankfurt</dd><dt>Uptime</dt><dd>41 days</dd></dl>
      <div class="ipbox mono"><span>203.0.113.24</span><button class="copy" type="button" data-copy="203.0.113.24" aria-label="Copy 203.0.113.24"><svg class="ic" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="11" height="11" rx="2"/><path d="M5 15V6a2 2 0 0 1 2-2h9"/></svg>Copy</button></div>
      <div class="ipbox mono"><span>ssh root@203.0.113.24</span><button class="copy" type="button" data-copy="ssh root@203.0.113.24" aria-label="Copy ssh root@203.0.113.24"><svg class="ic" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="11" height="11" rx="2"/><path d="M5 15V6a2 2 0 0 1 2-2h9"/></svg>Copy</button></div>
      <div class="meters"><div class="m"><div class="m-top"><span>CPU</span><b>18%</b></div><div class="meter" role="meter" aria-label="CPU" aria-valuemin="0" aria-valuemax="100" aria-valuenow="18"><span style="width:18%"></span></div></div><div class="m"><div class="m-top"><span>Memory</span><b>410 MB of 1 GB</b></div><div class="meter" role="meter" aria-label="Memory" aria-valuemin="0" aria-valuemax="100" aria-valuenow="41"><span style="width:41%"></span></div></div><div class="m"><div class="m-top"><span>Disk</span><b>9.1 of 20 GB</b></div><div class="meter" role="meter" aria-label="Disk" aria-valuemin="0" aria-valuemax="100" aria-valuenow="46"><span style="width:46%"></span></div></div><div class="m"><div class="m-top"><span>Transfer</span><b>120 GB of 1 TB</b></div><div class="meter" role="meter" aria-label="Transfer" aria-valuemin="0" aria-valuemax="100" aria-valuenow="12"><span style="width:12%"></span></div></div></div>
      <div class="acts"><a class="btn sm ghost" href="/vps/starter-01/console" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 6l6 6-6 6"/><path d="M12 18h8"/></svg>Console</a><a class="btn sm ghost" href="/vps/starter-01/restart" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 12a8 8 0 1 1-2.3-5.7"/><path d="M20 4v5h-5"/></svg>Restart</a><a class="btn sm ghost" href="/vps/starter-01/stop" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="6" y="6" width="12" height="12" rx="2"/></svg>Stop</a><a class="btn sm ghost" href="/vps/starter-01/snapshot" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 8h3l1.5-2h7L17 8h3v11H4V8z"/><circle cx="12" cy="13" r="3.2"/></svg>Snapshot</a><a class="btn sm ghost" href="/vps/starter-01/reinstall" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12a8 8 0 0 1 14-5.3"/><path d="M18 3v4h-4"/><path d="M20 12a8 8 0 0 1-14 5.3"/><path d="M6 21v-4h4"/></svg>Reinstall</a></div>
    </article>
    <article class="card svc">
      <div class="svc-h"><div><h2>dev-box</h2><small>Plus plan, $8/mo, renews Oct 21</small></div><span class="st off">Stopped</span></div>
      <dl class="kv"><dt>Resources</dt><dd>2 vCPU, 4 GB RAM, 60 GB NVMe</dd><dt>System</dt><dd>Debian 12</dd><dt>Location</dt><dd>Frankfurt</dd><dt>Uptime</dt><dd>Stopped</dd></dl>
      <div class="ipbox mono"><span>198.51.100.42</span><button class="copy" type="button" data-copy="198.51.100.42" aria-label="Copy 198.51.100.42"><svg class="ic" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="11" height="11" rx="2"/><path d="M5 15V6a2 2 0 0 1 2-2h9"/></svg>Copy</button></div>
      
      <div class="stopped-msg"><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="6" y="6" width="12" height="12" rx="2"/></svg><span>This server is stopped. Start it to see live usage.</span></div>
      <div class="acts"><a class="btn sm" href="/vps/dev-box/start" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 5l12 7-12 7V5z"/></svg>Start</a><a class="btn sm ghost" href="/vps/dev-box/snapshot" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 8h3l1.5-2h7L17 8h3v11H4V8z"/><circle cx="12" cy="13" r="3.2"/></svg>Snapshot</a><a class="btn sm ghost" href="/vps/dev-box/reinstall" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12a8 8 0 0 1 14-5.3"/><path d="M18 3v4h-4"/><path d="M20 12a8 8 0 0 1-14 5.3"/><path d="M6 21v-4h4"/></svg>Reinstall</a></div>
    </article>
    <div class="cta-card"><h2>Need another server?</h2><p>Deploy a new VPS in minutes. Plans start at $4 a month.</p><a class="btn" href="/order/vps" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>Order a VPS</a></div>
  </div>
</section>
<section class="view view-servers" aria-label="Dedicated servers">
  <div class="head"><div><h1>Dedicated servers</h1><p class="sub">1 dedicated server.</p></div><a class="btn" href="/order/servers" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>New server</a></div>
  <div class="svcs">
    <article class="card svc">
      <div class="svc-h"><div><h2>core-01</h2><small>Core plan, $59/mo, renews Oct 12</small></div><span class="st on">Online</span></div>
      <dl class="kv"><dt>Resources</dt><dd>8 cores, 32 GB RAM, 2 x 512 GB NVMe</dd><dt>System</dt><dd>Ubuntu 24.04 LTS</dd><dt>Location</dt><dd>Frankfurt</dd><dt>Uptime</dt><dd>96 days</dd></dl>
      <div class="ipbox mono"><span>203.0.113.80</span><button class="copy" type="button" data-copy="203.0.113.80" aria-label="Copy 203.0.113.80"><svg class="ic" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="11" height="11" rx="2"/><path d="M5 15V6a2 2 0 0 1 2-2h9"/></svg>Copy</button></div>
      <div class="ipbox mono"><span>ssh root@203.0.113.80</span><button class="copy" type="button" data-copy="ssh root@203.0.113.80" aria-label="Copy ssh root@203.0.113.80"><svg class="ic" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="11" height="11" rx="2"/><path d="M5 15V6a2 2 0 0 1 2-2h9"/></svg>Copy</button></div>
      <div class="meters"><div class="m"><div class="m-top"><span>CPU</span><b>6%</b></div><div class="meter" role="meter" aria-label="CPU" aria-valuemin="0" aria-valuemax="100" aria-valuenow="6"><span style="width:6%"></span></div></div><div class="m"><div class="m-top"><span>Memory</span><b>7 GB of 32 GB</b></div><div class="meter" role="meter" aria-label="Memory" aria-valuemin="0" aria-valuemax="100" aria-valuenow="22"><span style="width:22%"></span></div></div><div class="m"><div class="m-top"><span>Disk</span><b>318 GB of 1 TB</b></div><div class="meter" role="meter" aria-label="Disk" aria-valuemin="0" aria-valuemax="100" aria-valuenow="31"><span style="width:31%"></span></div></div><div class="m"><div class="m-top"><span>Transfer</span><b>0.8 TB of 10 TB</b></div><div class="meter" role="meter" aria-label="Transfer" aria-valuemin="0" aria-valuemax="100" aria-valuenow="8"><span style="width:8%"></span></div></div></div>
      <div class="acts"><a class="btn sm ghost" href="/servers/core-01/console" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 6l6 6-6 6"/><path d="M12 18h8"/></svg>Remote console</a><a class="btn sm ghost" href="/servers/core-01/reboot" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 12a8 8 0 1 1-2.3-5.7"/><path d="M20 4v5h-5"/></svg>Reboot</a><a class="btn sm ghost" href="/servers/core-01/rescue" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="3.5"/><path d="M5.6 5.6l3.9 3.9M14.5 14.5l3.9 3.9M18.4 5.6l-3.9 3.9M9.5 14.5l-3.9 3.9"/></svg>Rescue mode</a><a class="btn sm ghost" href="/servers/core-01/reinstall" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12a8 8 0 0 1 14-5.3"/><path d="M18 3v4h-4"/><path d="M20 12a8 8 0 0 1-14 5.3"/><path d="M6 21v-4h4"/></svg>Reinstall OS</a></div>
    </article>
    <div class="cta-card"><h2>Need more power?</h2><p>Dedicated servers from $59 a month. The whole machine, only yours.</p><a class="btn" href="/order/servers" data-backend><svg class="ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>Order a server</a></div>
  </div>
</section>
<section class="view view-support" aria-label="Support">
  <div class="head"><div><h1>Support</h1><p class="sub">We answer every ticket. For anything urgent, use live chat.</p></div></div>
  <div class="support">
    <section class="card">
      <h2>Open a ticket</h2>
      <form action="/support/tickets" method="post" data-backend>
        <!-- add a hidden CSRF token input here if your backend uses one -->
        <div class="f2">
          <div class="f"><label for="dept">Department</label><div class="sel"><select id="dept" name="department"><option>Technical support</option><option>Billing</option><option>Sales</option><option>Domains</option></select></div></div>
          <div class="f"><label for="svc">Related service</label><div class="sel"><select id="svc" name="service"><option value="">General question</option><option>starter-01 (VPS)</option><option>dev-box (VPS)</option><option>core-01 (Server)</option><option>adaobi.com (Domain)</option><option>shopbyada.ng (Hosting)</option></select></div></div>
        </div>
        <div class="f"><span class="l" id="prio-l">Priority</span>
          <div class="seg" role="radiogroup" aria-labelledby="prio-l">
            <label><input type="radio" name="priority" value="low"><span>Low</span></label>
            <label><input type="radio" name="priority" value="normal" checked><span>Normal</span></label>
            <label><input type="radio" name="priority" value="high"><span>High</span></label>
          </div>
        </div>
        <div class="f"><label for="subject">Subject</label><input id="subject" name="subject" type="text" placeholder="What do you need help with?" required></div>
        <div class="f"><label for="message">Message</label><textarea id="message" name="message" placeholder="Give us the details. Include error messages and what you already tried." required></textarea></div>
        <button class="btn" type="submit">Send ticket</button>
      </form>
    </section>

    <div class="stack">
      <section class="card">
        <h2>Talk to us</h2>
        <div class="list">
          <div class="contact"><span class="ibox"><svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a8 8 0 0 1-11.6 7.1L4 20.5l1.4-4.9A8 8 0 1 1 21 12z"/></svg></span><div class="txt"><b>Live chat</b><small>24/7, talk to a person</small></div><a class="btn sm ghost" href="/support/chat" data-backend>Start chat</a></div>
          <div class="contact"><span class="ibox"><svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="M3.5 7l8.5 6 8.5-6"/></svg></span><div class="txt"><b>Email</b><small>support@oxbothost.com</small></div><a class="btn sm ghost" href="mailto:support@oxbothost.com" data-backend>Write</a></div>
          <div class="contact"><span class="ibox"><svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 4h11a3 3 0 0 1 3 3v13H8a3 3 0 0 1-3-3V4z"/><path d="M5 17a3 3 0 0 1 3-3h11"/></svg></span><div class="txt"><b>Knowledge base</b><small>Guides for VPS, DNS and email</small></div><a class="btn sm ghost" href="/help" data-backend>Browse</a></div>
        </div>
      </section>
      <section class="card">
        <h2>System status</h2>
        <p><span class="st on">All systems operational</span></p>
        <p class="sub" style="margin-top:8px"><a href="/status" data-backend>See status page</a></p>
      </section>
    </div>
  </div>

  <section class="card tickets">
    <h2>Your tickets</h2>
    <div class="list">
      <a class="ticket" href="/support/tickets/2291" data-backend><span class="tid">#2291</span><span class="subj"><b>Cannot connect via SSH</b><small>starter-01, Technical support</small></span><span class="badge solid">Answered</span><span class="when">2 hours ago</span></a>
      <a class="ticket" href="/support/tickets/2290" data-backend><span class="tid">#2290</span><span class="subj"><b>Move domain to oxbothost</b><small>adaobi.dev, Domains</small></span><span class="badge mute">Closed</span><span class="when">Sep 1</span></a>
      <a class="ticket" href="/support/tickets/2287" data-backend><span class="tid">#2287</span><span class="subj"><b>Question about my invoice</b><small>Billing</small></span><span class="badge mute">Closed</span><span class="when">Aug 19</span></a>
    </div>
  </section>
</section>
    </main>
  </div>

  <label class="scrim" for="nav-toggle" aria-hidden="true"></label>
</div>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script>
(function () {
  // Set to false once your backend routes exist. While true, buttons only show a preview message.
  var DEMO = true;

  var toast = document.getElementById('toast');
  var timer;
  function say(msg) {
    toast.textContent = msg;
    toast.classList.add('show');
    clearTimeout(timer);
    timer = setTimeout(function () { toast.classList.remove('show'); }, 2800);
  }

  // greeting by time of day (replace "Ada" with the logged-in person's first name)
  var g = document.getElementById('greet');
  if (g) {
    var hr = new Date().getHours();
    g.textContent = (hr < 12 ? 'Good morning' : hr < 18 ? 'Good afternoon' : 'Good evening') + ', Ada';
  }

  // the sidebar is a slide-in drawer on phones: close it after choosing a section, or on Escape
  var navToggle = document.getElementById('nav-toggle');
  function closeSidebar() { if (navToggle) navToggle.checked = false; }

  // menus (new order, notifications, account) close on outside tap or Escape
  function closeMenus(except) {
    var m = document.querySelectorAll('details.menu[open]');
    for (var i = 0; i < m.length; i++) if (m[i] !== except) m[i].removeAttribute('open');
  }
  document.addEventListener('click', function (e) {
    closeMenus(e.target.closest ? e.target.closest('details.menu') : null);
  });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { closeMenus(); closeSidebar(); } });

  // the open section lives in the address bar, e.g. dashboard.html#vps
  var radios = document.querySelectorAll('input[name="view"]');
  function fromHash() {
    var id = (location.hash || '').replace('#', '');
    var r = id ? document.getElementById('v-' + id) : null;
    if (r) r.checked = true;
  }
  fromHash();
  window.addEventListener('hashchange', fromHash);
  for (var i = 0; i < radios.length; i++) {
    radios[i].addEventListener('change', function () {
      try { history.replaceState(null, '', '#' + this.id.slice(2)); } catch (e) {}
      window.scrollTo(0, 0);
      closeMenus();
      closeSidebar();
    });
  }

  // copy buttons (IP addresses, SSH commands)
  document.addEventListener('click', function (e) {
    var b = e.target.closest ? e.target.closest('[data-copy]') : null;
    if (!b) return;
    var text = b.getAttribute('data-copy');
    function ok() { say('Copied ' + text); }
    function fallback() {
      var t = document.createElement('textarea');
      t.value = text; t.style.position = 'fixed'; t.style.opacity = '0';
      document.body.appendChild(t); t.select();
      try { document.execCommand('copy'); ok(); } catch (err) { say('Could not copy. Select the text and copy it.'); }
      document.body.removeChild(t);
    }
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(text).then(ok, fallback);
    } else {
      fallback();
    }
  });

  if (DEMO) {
    document.addEventListener('click', function (e) {
      var a = e.target.closest ? e.target.closest('a[data-backend]') : null;
      if (!a) return;
      e.preventDefault();
      var label = (a.textContent || '').replace(/\s+/g, ' ').trim();
      say('Preview only: ' + (label ? label + ' goes to ' : '') + a.getAttribute('href'));
    });
    var forms = document.querySelectorAll('form[data-backend]');
    for (var f = 0; f < forms.length; f++) {
      forms[f].addEventListener('submit', function (e) {
        e.preventDefault();
        if (!this.checkValidity()) { this.reportValidity(); return; }
        say('Preview only: this form posts to ' + this.getAttribute('action'));
      });
    }
    var sw = document.querySelectorAll('input[data-toggle]');
    for (var s = 0; s < sw.length; s++) {
      sw[s].addEventListener('change', function () {
        say(this.getAttribute('data-toggle') + (this.checked ? ' is on' : ' is off') + ' (preview)');
      });
    }
  }
})();

</script>
</body>
</html>
