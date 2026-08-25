<?php ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_samesite', 'Lax');
session_start();
$dev = in_array(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '', array('127.0.0.1','::1'), true);
if(!isset($_SESSION['email']) && !$dev){ header('Location:/login.php?redirect='.urlencode($_SERVER['REQUEST_URI'])); exit; } ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#ffdc00">
  <link rel="icon" type="image/png" href="favicon.png">
  <title>Free Text Motion &mdash; Estudio de Texto Animado | Free Animation Power</title>
  <meta name="description" content="50 animaciones de texto editables con motion graphics. Fuentes de Google, exportacion WebM MP4 y GIF con y sin transparencia.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --yellow:    #ffdc00;
      --yellow2:   #ffe94d;
      --yellow3:   #ffe066;
      --yellow4:   #fff3b3;
      --ink:       #070706;
      --ink2:      #1a1a1a;
      --ink3:      #333;
      --white:     #ffffff;
      --cream:     #fefcf0;
      --warm:      #faf6e8;
      --border:    #ede4c0;
      --border2:   #e8dca0;
      --muted:     #6b6500;
      --muted2:    #938c00;
      --accent:    #ff4200;
      --error:     #cc2200;
      --radius-sm: 10px;
      --radius:    18px;
      --radius-lg: 24px;
      --radius-pill: 50px;
      --ease-out-expo: cubic-bezier(0.16, 1, 0.3, 1);
      --ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
    html { font-size:16px; }
    body {
      font-family:'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      background:var(--yellow);
      color:var(--ink);
      min-height:100vh;
      overflow:hidden;
      line-height:1.5;
      -webkit-font-smoothing:antialiased;
      touch-action:manipulation;
    }
    button { font-family:inherit; cursor:pointer; }
    input, select, textarea { font-family:inherit; }

    nav {
      grid-area:nav;
      display:flex;
      align-items:center;
      gap:0.75rem;
      background:var(--white);
      border-radius:var(--radius-pill);
      padding:8px 10px 8px 18px;
      box-shadow:0 2px 16px rgba(7,7,6,0.08), 0 0 0 1px var(--border);
      z-index:100;
      min-width:0;
    }
    .nav-logo { height:40px; width:auto; }
    .nav-divider { width:1px; height:18px; background:var(--border); flex-shrink:0; }
    .nav-title { font-family:'Outfit',sans-serif; font-weight:700; font-size:0.9rem; letter-spacing:-0.02em; white-space:nowrap; }
    .nav-badge {
      font-family:'Outfit',sans-serif;
      font-size:0.62rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em;
      background:var(--accent); color:var(--white);
      padding:0.25em 0.8em; border-radius:999px; white-space:nowrap;
    }
    .nav-actions { margin-left:auto; display:flex; gap:8px; flex-shrink:0; }
    .nav-btn {
      border:none; border-radius:var(--radius-pill);
      background:var(--warm); color:var(--ink);
      font-size:0.8rem; font-weight:600; letter-spacing:0.02em;
      padding:9px 16px; transition:all .15s ease; white-space:nowrap;
    }
    .nav-btn:hover { background:var(--yellow4); transform:translateY(-1px); }
    .nav-btn.primary { background:var(--ink); color:var(--yellow); }
    .nav-btn.primary:hover { background:var(--ink2); }

    .app {
      display:grid;
      grid-template-rows:auto 1fr auto;
      grid-template-columns:290px 1fr 330px;
      grid-template-areas:"nav nav nav" "left stage right" "foot foot foot";
      gap:12px;
      padding:12px;
      height:100vh;
    }
    .panel {
      background:var(--white);
      border-radius:var(--radius);
      box-shadow:0 2px 16px rgba(7,7,6,0.06), 0 0 0 1px var(--border);
      overflow-y:auto;
      overflow-x:hidden;
      padding:16px;
    }
    .panel::-webkit-scrollbar { width:6px; }
    .panel::-webkit-scrollbar-thumb { background:var(--border2); border-radius:3px; }
    .panel-left { grid-area:left; }
    .panel-right { grid-area:right; }

    .sec-title {
      font-family:'Outfit',sans-serif;
      font-size:0.68rem; font-weight:800; text-transform:uppercase; letter-spacing:0.12em;
      color:var(--muted);
      margin:14px 0 10px;
      display:flex; align-items:center; gap:8px;
    }
    .sec-title:first-child { margin-top:0; }
    .sec-title::after { content:""; flex:1; height:1px; background:var(--border); }

    .field { margin-bottom:12px; }
    .field label {
      display:block;
      font-size:0.74rem; font-weight:700; letter-spacing:0.04em; text-transform:uppercase;
      color:var(--ink3); margin-bottom:6px;
    }
    .field-row { display:flex; gap:8px; align-items:center; }
    .field-row > div { flex:1; min-width:0; }

    input[type=text], input[type=number], select, textarea {
      font-size:0.9rem; width:100%;
      padding:9px 13px;
      border:1px solid var(--border2);
      border-radius:12px;
      background:var(--white); color:var(--ink);
      outline:none; transition:border-color .15s;
    }
    textarea { resize:vertical; min-height:74px; line-height:1.45; }
    input:focus, select:focus, textarea:focus { border-color:var(--ink); }
    select { cursor:pointer; }

    input[type=range] {
      -webkit-appearance:none; appearance:none;
      width:100%; height:4px; border:none; border-radius:2px;
      background:var(--border2); outline:none; padding:0;
    }
    input[type=range]::-webkit-slider-thumb {
      -webkit-appearance:none; width:16px; height:16px; border-radius:50%;
      background:var(--ink); cursor:pointer; box-shadow:0 1px 4px rgba(0,0,0,0.2);
    }
    input[type=range]::-moz-range-thumb { width:16px; height:16px; border:none; border-radius:50%; background:var(--ink); cursor:pointer; }
    .range-val { font-weight:700; min-width:48px; text-align:right; font-variant-numeric:tabular-nums; font-size:0.8rem; }

    input[type=color] {
      -webkit-appearance:none; appearance:none;
      width:100%; height:36px; border:1px solid var(--border2);
      border-radius:12px; cursor:pointer; padding:3px; background:var(--white);
    }
    input[type=color]::-webkit-color-swatch-wrapper { padding:2px; }
    input[type=color]::-webkit-color-swatch { border:none; border-radius:8px; }
    input[type=color]::-moz-color-swatch { border:none; border-radius:8px; }

    .pills { display:flex; background:var(--warm); border-radius:var(--radius-pill); padding:3px; gap:2px; }
    .pills button {
      flex:1; border:none; background:transparent; border-radius:var(--radius-pill);
      padding:7px 8px; font-size:0.74rem; font-weight:600; letter-spacing:0.02em;
      color:var(--muted); transition:all .15s;
    }
    .pills button.active { background:var(--white); color:var(--ink); box-shadow:0 1px 6px rgba(7,7,6,0.12); }

    .switch-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; gap:10px; }
    .switch-row span { font-size:0.82rem; font-weight:600; letter-spacing:0.02em; }
    .switch {
      position:relative; width:42px; height:24px; flex-shrink:0;
      background:var(--border2); border-radius:var(--radius-pill);
      cursor:pointer; transition:background .2s; border:none;
    }
    .switch::after {
      content:""; position:absolute; top:3px; left:3px; width:18px; height:18px;
      background:var(--white); border-radius:50%; box-shadow:0 1px 4px rgba(0,0,0,0.2);
      transition:transform .2s;
    }
    .switch.on { background:var(--ink); }
    .switch.on::after { transform:translateX(18px); background:var(--yellow); }

    .stage { grid-area:stage; display:flex; flex-direction:column; gap:12px; min-width:0; min-height:0; }
    .canvas-wrap {
      flex:1; display:flex; align-items:center; justify-content:center;
      background:var(--white); border-radius:var(--radius);
      box-shadow:0 2px 16px rgba(7,7,6,0.06), 0 0 0 1px var(--border);
      padding:20px; min-height:0; overflow:hidden;
    }
    .canvas-frame {
      position:relative; max-width:100%; max-height:100%;
      border-radius:12px; overflow:hidden;
      box-shadow:0 8px 30px rgba(7,7,6,0.15);
      background-image:
        linear-gradient(45deg,#e9e9e9 25%,transparent 25%),
        linear-gradient(-45deg,#e9e9e9 25%,transparent 25%),
        linear-gradient(45deg,transparent 75%,#e9e9e9 75%),
        linear-gradient(-45deg,transparent 75%,#e9e9e9 75%);
      background-size:16px 16px;
      background-position:0 0, 0 8px, 8px -8px, -8px 0;
      background-color:#f5f5f5;
    }
    #preview { display:block; width:100%; height:auto; }

    .timeline {
      background:var(--white); border-radius:var(--radius);
      box-shadow:0 2px 16px rgba(7,7,6,0.06), 0 0 0 1px var(--border);
      padding:14px 18px; display:flex; align-items:center; gap:14px;
    }
    .play-btn {
      width:44px; height:44px; border-radius:50%; flex-shrink:0;
      background:var(--ink); color:var(--yellow); border:none;
      display:flex; align-items:center; justify-content:center;
      transition:all .15s;
    }
    .play-btn:hover { background:var(--accent); color:var(--white); transform:scale(1.05); }
    .play-btn svg { width:18px; height:18px; }
    .tl-undo {
      width:36px; height:36px; border-radius:50%; flex-shrink:0;
      border:1px solid var(--border2); background:var(--white); color:var(--ink);
      font-size:1rem; line-height:1; transition:all .15s;
    }
    .tl-undo:hover { background:var(--warm); transform:translateY(-1px); }
    .tl-undo:active { transform:scale(0.95); }
    .tl-track {
      flex:1; position:relative; height:44px; min-width:80px;
      background:var(--warm); border-radius:var(--radius-pill); cursor:pointer; overflow:hidden;
    }
    .tl-fill { position:absolute; top:0; left:0; bottom:0; background:var(--yellow); pointer-events:none; opacity:0.5; }
    .tl-head { position:absolute; top:4px; bottom:4px; width:4px; background:var(--ink); border-radius:2px; pointer-events:none; }
    .tl-ticks { position:absolute; inset:0; display:flex; pointer-events:none; }
    .tl-ticks span { flex:1; border-right:1px solid var(--border2); position:relative; }
    .tl-ticks span:last-child { border:none; }
    .tl-ticks span::after {
      content:attr(data-t); position:absolute; top:4px; left:6px;
      font-size:0.6rem; color:var(--muted); font-weight:700; letter-spacing:0.04em;
    }
    .tl-time { font-variant-numeric:tabular-nums; font-weight:700; font-size:0.85rem; min-width:86px; text-align:center; }
    .tl-duration { display:flex; align-items:center; gap:8px; }
    .tl-duration label { font-size:0.66rem; font-weight:800; text-transform:uppercase; color:var(--muted); }
    .tl-duration input { width:64px; text-align:center; padding:8px; }

    details.family { border:1px solid var(--border); border-radius:var(--radius-sm); margin-bottom:8px; overflow:hidden; }
    details.family summary {
      cursor:pointer; list-style:none;
      font-family:'Outfit',sans-serif; font-size:0.76rem; font-weight:700; letter-spacing:0.04em;
      padding:10px 14px; background:var(--warm);
      display:flex; align-items:center; justify-content:space-between;
    }
    details.family summary::-webkit-details-marker { display:none; }
    details.family summary::after { content:"+"; font-weight:800; color:var(--muted); }
    details.family[open] summary::after { content:"â€“"; }
    details.family[open] summary { background:var(--yellow4); }
    .kf-row { border:1px solid var(--border); border-radius:var(--radius-sm); padding:10px; margin-bottom:8px; }
    .kf-head { display:flex; align-items:center; gap:8px; margin-bottom:8px; }
    .kf-head label { flex:1; font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:var(--ink3); }
    .kf-x { width:22px; height:22px; border-radius:50%; border:1px solid var(--border2); background:var(--white); color:var(--muted); font-size:0.7rem; font-weight:700; flex-shrink:0; }
    .kf-strip { position:relative; height:24px; background:var(--warm); border-radius:12px; cursor:crosshair; border:1px solid var(--border); touch-action:none; }
    .kf-dot { position:absolute; top:50%; width:14px; height:14px; border-radius:50%; background:var(--ink); border:2px solid var(--white); transform:translate(-50%,-50%); cursor:grab; box-shadow:0 1px 4px rgba(0,0,0,0.25); touch-action:none; }
    .kf-dot.selected { background:var(--accent); }
    .kf-controls { display:flex; gap:8px; align-items:center; margin-top:8px; }
    .kf-del { border:none; background:var(--warm); border-radius:var(--radius-pill); padding:6px 12px; font-size:0.7rem; font-weight:700; color:var(--error); flex-shrink:0; }
    .kf-on {
      display:inline-block;
      background:var(--accent); color:var(--white);
      font-size:0.6rem; font-weight:700; text-transform:uppercase; letter-spacing:0.04em;
      padding:1px 7px; border-radius:999px; margin-left:6px; cursor:pointer;
      vertical-align:middle;
    }
    label .kf-on { margin-top:2px; }
    .preset-grid { display:grid; grid-template-columns:1fr 1fr; gap:6px; padding:10px; }
    .preset {
      border:1px solid var(--border2); border-radius:var(--radius-pill);
      background:var(--white); color:var(--ink3);
      font-size:0.72rem; font-weight:600; letter-spacing:0.01em;
      padding:8px 6px; text-align:center; transition:all .15s;
    }
    .preset:hover { border-color:var(--ink); }
    .preset.active { background:var(--ink); color:var(--yellow); border-color:var(--ink); }

    .modal-back {
      position:fixed; inset:0; background:rgba(7,7,6,0.5);
      backdrop-filter:blur(4px); -webkit-backdrop-filter:blur(4px);
      display:none; align-items:center; justify-content:center; z-index:200;
    }
    .modal-back.open { display:flex; }
    .modal {
      background:var(--white); border-radius:var(--radius-lg); padding:26px;
      width:min(430px, 92vw); box-shadow:0 20px 60px rgba(0,0,0,0.25);
    }
    .modal h2 { font-family:'Outfit',sans-serif; font-size:1.2rem; font-weight:800; letter-spacing:-0.02em; margin-bottom:18px; }
    .modal-actions { display:flex; gap:8px; margin-top:22px; }
    .modal-actions .nav-btn { flex:1; text-align:center; }
    .progress { height:6px; background:var(--warm); border-radius:3px; overflow:hidden; margin-top:16px; display:none; }
    .progress.active { display:block; }
    .progress-bar { height:100%; background:var(--accent); width:0; transition:width .1s; }

    .hint { font-size:0.7rem; color:var(--muted); line-height:1.5; }
    .footer-note {
      grid-area:foot;
      text-align:center;
      font-size:0.66rem;
      color:var(--muted2);
      font-weight:600;
      padding:2px 10px 10px;
      pointer-events:none;
      white-space:normal;
    }

    #renderCanvas, #fileInput { display:none; }

    @media (max-width:1100px) {
      .app { grid-template-columns:250px 1fr 290px; }
    }
    @media (max-width:920px) {
      body { overflow:auto; }
      .app {
        display:flex; flex-direction:column; height:auto; min-height:100vh; gap:10px; padding:80px 10px 12px;
      }
      nav { position:fixed; top:8px; left:8px; right:8px; border-radius:var(--radius-pill); }
      .stage { order:1; }
      .stage .canvas-wrap { min-height:240px; padding:12px; }
      .panel-left { order:2; }
      .panel-right { order:3; }
      .panel { max-height:none; }
      .timeline { flex-wrap:wrap; gap:10px; }
      .tl-track { min-width:100%; order:-1; }
      .footer-note { order:4; }
    }
    @media (max-width:560px) {
      .nav-title, .nav-badge, .nav-divider { display:none; }
      .nav-actions { gap:6px; }
      .nav-actions .nav-btn { padding:8px 10px; font-size:0.72rem; }
      .app { padding:70px 8px 10px; }
      .panel { padding:12px; }
    }
  </style>
</head>
<body>

<div class="app">

  <nav>
    <a href="/"><img src="logo.png" class="nav-logo" alt="Free Text Motion"></a>
    <div class="nav-divider"></div>
    <span class="nav-title">Free Text Motion</span>
    <span class="nav-badge">Nuevo</span>
    <div class="nav-actions">
      <button class="nav-btn" id="btnNew">Nuevo</button>
      <button class="nav-btn" id="btnOpen">Abrir</button>
      <button class="nav-btn" id="btnSave">Guardar</button>
      <button class="nav-btn primary" id="btnExport">Exportar</button>
    </div>
  </nav>

  <aside class="panel panel-left">

    <div class="sec-title">Texto</div>
    <div class="field">
      <textarea id="txtContent" placeholder="Escribe tu texto...">FREE ANIMATION
POWER</textarea>
    </div>

    <div class="sec-title">Letra seleccionada</div>
    <p class="hint">Toca una letra en el escenario para seleccionarla. Arrastra la letra para moverla y arrastra el tirador naranja para cambiar su tamano. Clic fuera = deseleccionar.</p>
    <div class="field">
      <label id="letterName">Ninguna letra seleccionada</label>
    </div>
    <div class="field">
      <label>Fuente de la letra</label>
      <select id="letterFont"></select>
    </div>
    <div class="switch-row">
      <span>Color propio</span>
      <div class="switch" id="letterFillSwitch"></div>
    </div>
    <div class="field">
      <label>Color de la letra</label>
      <input type="color" id="letterColor" value="#070706">
    </div>
    <div class="field">
      <label>Tamano</label>
      <div class="field-row">
        <input type="range" id="letterSize" min="10" max="500" value="100">
        <span class="range-val" id="letterSizeVal">100%</span>
      </div>
    </div>
    <div class="field">
      <label>Rotacion</label>
      <div class="field-row">
        <input type="range" id="letterRot" min="-180" max="180" value="0">
        <span class="range-val" id="letterRotVal">0Â°</span>
      </div>
    </div>
    <div class="field">
      <label>Desplazamiento X</label>
      <div class="field-row">
        <input type="range" id="letterDx" min="-200" max="200" value="0">
        <span class="range-val" id="letterDxVal">0</span>
      </div>
    </div>
    <div class="field">
      <label>Desplazamiento Y</label>
      <div class="field-row">
        <input type="range" id="letterDy" min="-200" max="200" value="0">
        <span class="range-val" id="letterDyVal">0</span>
      </div>
    </div>
    <div class="field-row" style="gap:8px">
      <button class="nav-btn" id="btnLetterReset" style="flex:1">Restablecer letra</button>
      <button class="nav-btn" id="btnLettersResetAll" style="flex:1">Restablecer todas</button>
    </div>

    <div class="sec-title">Tipografia</div>
    <div class="field">
      <label>Fuente (220 de Google)</label>
      <select id="fontFamily"></select>
    </div>
    <div class="field">
      <label>Peso</label>
      <div class="pills" id="weightGroup">
        <button data-w="400">Regular</button>
        <button data-w="700" class="active">Bold</button>
        <button data-w="900">Black</button>
      </div>
    </div>
    <div class="field">
      <div class="switch-row">
        <span>Cursiva</span>
        <div class="switch" id="italicSwitch"></div>
      </div>
    </div>
    <div class="field">
      <label id="sizeLabel">TamaÃ±o</label>
      <div class="field-row">
        <input type="range" id="fontSize" min="20" max="300" value="150">
        <span class="range-val" id="fontSizeVal">150</span>
      </div>
    </div>
    <div class="field">
      <label id="letterSpaceLabel">Espaciado de letras</label>
      <div class="field-row">
        <input type="range" id="letterSpace" min="-20" max="100" value="0">
        <span class="range-val" id="letterSpaceVal">0</span>
      </div>
    </div>
    <div class="field">
      <label id="lineHLabel">Interlineado</label>
      <div class="field-row">
        <input type="range" id="lineH" min="9" max="20" value="12">
        <span class="range-val" id="lineHVal">1.2</span>
      </div>
    </div>
    <div class="field">
      <label>Alineacion</label>
      <div class="pills" id="alignGroup">
        <button data-a="left">Izq</button>
        <button data-a="center" class="active">Centro</button>
        <button data-a="right">Der</button>
      </div>
    </div>

    <div class="sec-title">Relleno y trazo</div>
    <div class="field">
      <label>Modo</label>
      <div class="pills" id="modeGroup">
        <button data-m="fill" class="active">Relleno</button>
        <button data-m="stroke">Contorno</button>
        <button data-m="both">Ambos</button>
      </div>
    </div>
    <div class="field">
      <div class="field-row">
        <div><label>Relleno</label><input type="color" id="fillColor" value="#070706"></div>
        <div><label>Trazo</label><input type="color" id="strokeColor" value="#ffdc00"></div>
      </div>
    </div>
    <div class="field">
      <label>Grosor del trazo</label>
      <div class="field-row">
        <input type="range" id="strokeW" min="1" max="20" value="3">
        <span class="range-val" id="strokeWVal">3</span>
      </div>
    </div>

    <div class="sec-title">Fondo</div>
    <div class="switch-row">
      <span>Mostrar fondo</span>
      <div class="switch on" id="bgSwitch"></div>
    </div>
    <div class="field">
      <label>Color de fondo</label>
      <input type="color" id="bgColor" value="#ffffff">
    </div>
    <p class="hint">Desactiva el fondo para previsualizar la transparencia (exportable en WebM y GIF con canal alfa).</p>

  </aside>

  <main class="stage">
    <div class="canvas-wrap">
      <div class="canvas-frame">
        <canvas id="preview" width="1280" height="720"></canvas>
      </div>
    </div>
    <div class="timeline">
      <button class="tl-undo" id="btnUndo" title="Deshacer (Ctrl+Z)">&#8630;</button>
      <button class="tl-undo" id="btnRedo" title="Rehacer (Ctrl+Y)">&#8631;</button>
      <button class="play-btn" id="btnPlay">
        <svg id="iconPlay" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
        <svg id="iconPause" viewBox="0 0 24 24" fill="currentColor" style="display:none"><path d="M6 4h4v16H6zM14 4h4v16h-4z"/></svg>
      </button>
      <div class="tl-track" id="tlTrack">
        <div class="tl-ticks" id="tlTicks"></div>
        <div class="tl-fill" id="tlFill"></div>
        <div class="tl-head" id="tlHead"></div>
      </div>
      <div class="tl-time" id="tlTime">0.00 / 3.00</div>
      <div class="tl-duration">
        <label>Dur</label>
        <input type="number" id="duration" min="0.5" max="20" step="0.1" value="3">
      </div>
    </div>
  </main>

  <aside class="panel panel-right">

    <div class="sec-title">Animacion &mdash; 205 presets</div>
    <div class="field">
      <input type="text" id="presetSearch" placeholder="Buscar efecto...">
    </div>
    <div id="presetList"></div>

    <div class="sec-title">Parametros del preset</div>
    <div id="presetParams"><p class="hint">Selecciona un preset para editar sus parametros.</p></div>

    <div class="sec-title">Timing</div>
    <div class="field">
      <label>Easing</label>
      <select id="easing">
        <option value="linear">Linear</option>
        <option value="easeIn">Ease In</option>
        <option value="easeOut" selected>Ease Out</option>
        <option value="easeInOut">Ease In-Out</option>
        <option value="expoOut">Expo Out</option>
        <option value="backOut">Back Out</option>
        <option value="elastic">Elastic</option>
        <option value="bounce">Bounce</option>
      </select>
    </div>
    <div class="field">
      <label>Duracion de entrada</label>
      <div class="field-row">
        <input type="range" id="animIn" min="0.1" max="3" step="0.05" value="1">
        <span class="range-val" id="animInVal">1.0s</span>
      </div>
    </div>
    <div class="field">
      <label>Stagger por letra</label>
      <div class="field-row">
        <input type="range" id="stagger" min="0" max="200" value="40">
        <span class="range-val" id="staggerVal">40ms</span>
      </div>
    </div>
    <div class="switch-row">
      <span>Animar salida</span>
      <div class="switch" id="outSwitch"></div>
    </div>
    <div class="field">
      <label>Efecto de salida</label>
      <select id="outPreset"></select>
    </div>
    <div class="field">
      <label>Duracion de salida</label>
      <div class="field-row">
        <input type="range" id="outDur" min="0.1" max="3" step="0.05" value="1">
        <span class="range-val" id="outDurVal">1.0s</span>
      </div>
    </div>
    <div class="switch-row">
      <span>Repetir en bucle</span>
      <div class="switch on" id="loopSwitch"></div>
    </div>

    <div class="sec-title">Transformacion</div>
    <div class="field">
      <label id="opacityLabel">Opacidad</label>
      <div class="field-row">
        <input type="range" id="opacity" min="0" max="100" value="100">
        <span class="range-val" id="opacityVal">100%</span>
      </div>
    </div>
    <div class="field">
      <label id="rotationLabel">Rotacion</label>
      <div class="field-row">
        <input type="range" id="rotation" min="-180" max="180" value="0">
        <span class="range-val" id="rotationVal">0Â°</span>
      </div>
    </div>
    <div class="field">
      <label id="scaleLabel">Escala</label>
      <div class="field-row">
        <input type="range" id="scale" min="10" max="300" value="100">
        <span class="range-val" id="scaleVal">100%</span>
      </div>
    </div>
    <div class="field">
      <label>Desenfoque</label>
      <div class="field-row">
        <input type="range" id="blur" min="0" max="30" value="0">
        <span class="range-val" id="blurVal">0px</span>
      </div>
    </div>

    <div class="sec-title">Keyframes</div>
    <div id="kfPanel"></div>
    <p class="hint">Activa una propiedad, haz clic en la barra para anadir keyframes en ese instante de la linea de tiempo y arrastra los puntos para moverlos.</p>

    <div class="sec-title">Efectos</div>
    <div class="switch-row">
      <span>Motion blur</span>
      <div class="switch" id="mbSwitch"></div>
    </div>
    <div class="field">
      <label>Fuerza del motion blur</label>
      <div class="field-row">
        <input type="range" id="mbStr" min="1" max="20" value="6">
        <span class="range-val" id="mbStrVal">6</span>
      </div>
    </div>
    <div class="switch-row">
      <span>Sombra</span>
      <div class="switch" id="shSwitch"></div>
    </div>
    <div class="field">
      <div class="field-row">
        <div><label>Color</label><input type="color" id="shColor" value="#000000"></div>
        <div><label>Difuminado</label><input type="range" id="shBlur" min="0" max="60" value="16"><span class="range-val" id="shBlurVal">16</span></div>
      </div>
    </div>

  </aside>

  <div class="footer-note">Free Text Motion &middot; parte del ecosistema Free Animation Power &middot; ESPACIO = reproducir/pausar</div>

</div>

<div class="modal-back" id="exportModal">
  <div class="modal">
    <h2>Exportar animacion</h2>
    <div class="field">
      <label>Formato</label>
      <div class="pills" id="formatGroup">
        <button data-f="webm" class="active">WebM</button>
        <button data-f="mp4">MP4</button>
        <button data-f="mov">MOV</button>
        <button data-f="gif">GIF</button>
      </div>
    </div>
    <div class="field">
      <label>Fotogramas por segundo</label>
      <select id="exportFps">
        <option value="24">24 fps</option>
        <option value="30" selected>30 fps</option>
        <option value="60">60 fps</option>
      </select>
    </div>
    <div class="switch-row">
      <span>Fondo transparente (alfa)</span>
      <div class="switch" id="exportAlphaSwitch"></div>
    </div>
    <p class="hint">WebM y GIF soportan canal alfa real. MOV exporta ProRes 4444 con alfa, compatible con After Effects y Premiere. En MP4 la transparencia se renderiza en negro.</p>
    <div class="progress" id="exportProgress"><div class="progress-bar" id="exportBar"></div></div>
    <p class="hint" id="exportMsg" style="margin-top:8px"></p>
    <div class="modal-actions">
      <button class="nav-btn" id="btnCancelExport">Cancelar</button>
      <button class="nav-btn primary" id="btnDoExport">Renderizar</button>
    </div>
  </div>
</div>

<canvas id="renderCanvas" width="1280" height="720"></canvas>
<input type="file" id="fileInput" accept=".json,.textmotion">

<script>
const $=id=>document.getElementById(id);
const W=1280, H=720;
const FONT_GROUPS={
  'Display':["Anton","Archivo Black","Bebas Neue","Oswald","Barlow Condensed","Roboto Condensed","Abril Fatface","Alfa Slab One","Bangers","Black Ops One","Bowlby One SC","Bungee","Bungee Shade","Chango","Cinzel","Cinzel Decorative","Comfortaa","Courgette","Creepster","DM Serif Display","Exo 2","Fjalla One","Francois One","Fredoka One","Fugaz One","Josefin Sans","Knewave","Lilita One","Luckiest Guy","Monoton","Orbitron","Passion One","Poiret One","Press Start 2P","Righteous","Rubik Mono One","Russo One","Sigmar One","Squada One","Titan One","Ultra","Yeseva One"],
  'Sans Serif':["Inter","Montserrat","Poppins","Roboto","Open Sans","Lato","Raleway","Work Sans","DM Sans","Space Grotesk","Outfit","Plus Jakarta Sans","Nunito","Nunito Sans","Rubik","Manrope","Karla","Mulish","Quicksand","Jost","Urbanist","Sora","Lexend","Albert Sans","Archivo","Public Sans","Figtree","Cabin"],
  'Serif':["Playfair Display","Merriweather","Lora","Roboto Slab","Source Serif 4","PT Serif","Libre Baskerville","Crimson Text","Cormorant Garamond","EB Garamond","Spectral","Zilla Slab","Slabo 27px","Arvo","Literata"],
  'Monoespaciadas':["Space Mono","JetBrains Mono","Fira Code","Source Code Pro","IBM Plex Mono","Roboto Mono","Ubuntu Mono","Cousine","Share Tech Mono","Anonymous Pro","Oxygen Mono"],
  'Script y manuscritas':["Pacifico","Lobster","Dancing Script","Caveat","Satisfy","Great Vibes","Sacramento","Amatic SC","Shadows Into Light","Kalam","Indie Flower","Patrick Hand","Yellowtail","Allura","Cookie","Architects Daughter"],
  'Decorativas':["Rye","Special Elite","Stardos Stencil","Audiowide","New Rocker","Ewert","UnifrakturMaguntia","Frijole"]
};
const FONT_GROUPS_EXTRA={
  'Display extra':["Staatliches","Teko","Paytone One","Ramabhadra","Secular One","Viga","Fredoka","Bungee Inline","Bungee Outline","Bowlby One","Baloo 2","Coiny","Gugi","Hanalei Fill","Jolly Lodger","Kirang Haerang","Kumar One","Megrim","Nosifer","Pirata One","Plaster","Quantico","Rhodium Libre","Sancreek","Jomhuria"],
  'Sans Serif extra':["Heebo","Hind","Assistant","Atkinson Hyperlegible","Barlow Semi Condensed","Signika","Signika Negative","Fira Sans","Fira Sans Condensed","Noto Sans","Source Sans 3","Saira","Saira Condensed","Titillium Web","Chivo","Bricolage Grotesque","Familjen Grotesk","Schibsted Grotesk","Instrument Sans","Hanken Grotesk","Onest","Belleza"],
  'Serif extra':["Noto Serif","Noto Serif Display","Bitter","Bree Serif","DM Serif Text","Gelasio","Libre Caslon Text","Libre Caslon Display","Oranienbaum","Prata","Rozha One","Sahitya","Sumana","Vesper Libre","Vollkorn"],
  'Mono extra':["Fira Mono","Inconsolata","B612 Mono","Cutive Mono","Overpass Mono","Azeret Mono","Red Hat Mono","Spline Sans Mono","Syne Mono","VT323"],
  'Script extra':["Gochi Hand","Marck Script","Pinyon Script","Qwigley","Ruge Boogie","Sevillana","Mr Dafoe","Mrs Saint Delafield","Montez","Norican","Oleo Script","Petit Formal Script","Redressed","Rochester","Sofia"],
  'Decorativas extra':["Astloch","Berkshire Swash","Bonbon","Butcherman","Emblema One","Fascinate","Fascinate Inline","Flamenco","Germania One","Goudy Bookletter 1911","Metal Mania","Modern Antiqua","MedievalSharp"]
};
const FONT_ALL=Object.assign({},FONT_GROUPS,FONT_GROUPS_EXTRA);

function clamp(v,a,b){ return Math.max(a, Math.min(b,v)); }
function hash(n){ const s=Math.sin(n*127.1)*43758.5453; return s-Math.floor(s); }
function sleep(ms){ return new Promise(r=>setTimeout(r,ms)); }

const EASE={
  linear:t=>t,
  easeIn:t=>t*t*t,
  easeOut:t=>1-Math.pow(1-t,3),
  easeInOut:t=>t<0.5?4*t*t*t:1-Math.pow(-2*t+2,3)/2,
  expoOut:t=>t===1?1:1-Math.pow(2,-10*t),
  backOut:t=>{ const c=1.70158+1; return 1+c*Math.pow(t-1,3)+1.70158*Math.pow(t-1,2); },
  elastic:t=>t===0?0:t===1?1:Math.pow(2,-10*t)*Math.sin((t*10-0.75)*(2*Math.PI/3))+1,
  bounce:t=>{ const n=7.5625,d=2.75; if(t<1/d)return n*t*t; if(t<2/d){t-=1.5/d;return n*t*t+0.75;} if(t<2.5/d){t-=2.25/d;return n*t*t+0.9375;} t-=2.625/d; return n*t*t+0.984375; }
};

const KF_PROPS=[
  {key:'size',label:'Tamano',unit:'px',min:20,max:300,step:1,el:'fontSize'},
  {key:'letterSpace',label:'Espaciado de letras',unit:'',min:-20,max:100,step:1,el:'letterSpace'},
  {key:'lineH',label:'Interlineado',unit:'',min:9,max:20,step:1,el:'lineH'},
  {key:'opacity',label:'Opacidad',unit:'%',min:0,max:100,step:1,el:'opacity'},
  {key:'rotation',label:'Rotacion',unit:'Â°',min:-180,max:180,step:1,el:'rotation'},
  {key:'scale',label:'Escala',unit:'%',min:10,max:300,step:1,el:'scale'}
];
function defaultKf(){
  const o={};
  KF_PROPS.forEach(p=>{o[p.key]={on:false,keys:[]};});
  return o;
}
function kfValue(kf,t,fallback){
  if(!kf||!kf.on||!kf.keys||!kf.keys.length)return fallback;
  const k=kf.keys;
  if(k.length===1)return k[0].v;
  if(t<=k[0].t)return k[0].v;
  if(t>=k[k.length-1].t)return k[k.length-1].v;
  for(let i=0;i<k.length-1;i++){
    if(t>=k[i].t&&t<=k[i+1].t){
      const span=k[i+1].t-k[i].t;
      const f=span>0?(t-k[i].t)/span:0;
      return k[i].v+(k[i+1].v-k[i].v)*f;
    }
  }
  return fallback;
}
const PRESETS=[
  { id:'fade', family:'Entradas', name:'Fade', fx:C=>({alpha:C.e}) },
  { id:'slideUp', family:'Entradas', name:'Sube', fx:C=>({dy:(1-C.e)*120, alpha:C.e}) },
  { id:'slideDown', family:'Entradas', name:'Baja', fx:C=>({dy:-(1-C.e)*120, alpha:C.e}) },
  { id:'slideLeft', family:'Entradas', name:'Desde la izquierda', fx:C=>({dx:(1-C.e)*220, alpha:C.e}) },
  { id:'slideRight', family:'Entradas', name:'Desde la derecha', fx:C=>({dx:-(1-C.e)*220, alpha:C.e}) },
  { id:'scalePop', family:'Entradas', name:'Pop de escala', defEasing:'backOut', fx:C=>({scX:C.e, scY:C.e, alpha:C.e}) },
  { id:'rotateIn', family:'Entradas', name:'Giro de entrada', fx:C=>({rot:(1-C.e)*-45, scX:0.3+0.7*C.e, scY:0.3+0.7*C.e, alpha:C.e}) },
  { id:'blurIn', family:'Entradas', name:'Desenfoque', fx:C=>({blur:(1-C.e)*20, alpha:C.e}) },
  { id:'flipX', family:'Entradas', name:'Volteo X', fx:C=>({scX:2*C.e-1, alpha:Math.min(1,C.e*2)}) },
  { id:'zoomIn', family:'Entradas', name:'Zoom in', fx:C=>({scX:0.2+0.8*C.e, scY:0.2+0.8*C.e, alpha:C.e}) },

  { id:'typewriter', family:'Maquina', name:'Maquina de escribir', defStagger:0, defInDur:2, fx:C=>({alpha:(C.p*C.totalChars-C.i)>0?1:0}) },
  { id:'decoder', family:'Maquina', name:'Flash letra a letra', defStagger:60, defInDur:2, fx:C=>({alpha:Math.min(1,C.st*3), scX:0.7+0.3*Math.min(1,C.st*2), scY:0.7+0.3*Math.min(1,C.st*2)}) },
  { id:'glitchWriter', family:'Maquina', name:'Escritura glitch', defStagger:25, params:[{key:'speed',label:'Velocidad',min:2,max:20,step:1,def:10}], fx:(C,P)=>{ const g=C.st>0&&C.st<1; const dx=g?(hash(C.i+C.t*P.speed*2)-0.5)*8:0; const dy=g?(hash(C.i+50+C.t*P.speed*2)-0.5)*6:0; return {dx, dy, alpha:Math.min(1,C.st*4)}; } },
  { id:'scramble', family:'Maquina', name:'Mezcla', defStagger:40, params:[{key:'power',label:'Distancia',min:20,max:150,step:5,def:80}], fx:(C,P)=>{ const d=(1-C.st)*P.power; const a=hash(C.i)*Math.PI*2; return {dx:Math.cos(a)*d, dy:Math.sin(a)*d, rot:(1-C.st)*(hash(C.i+9)-0.5)*120, alpha:Math.min(1,C.st*3)}; } },
  { id:'matrixRain', family:'Maquina', name:'Lluvia', defStagger:40, defInDur:2.5, fx:C=>{ const T={dy:(1-C.st)*-90, alpha:Math.min(1,C.st*3)}; if(C.st<1)T.dupes=[{dy:18,alpha:0.3},{dy:36,alpha:0.12}]; return T; } },

  { id:'kernExpand', family:'Espaciado', name:'Expande espaciado', defStagger:25, fx:C=>({kern:(1-C.e)*60, alpha:C.e}) },
  { id:'kernCollapse', family:'Espaciado', name:'Colapsa espaciado', defStagger:25, fx:C=>({extra:(1-C.e)*60, alpha:Math.min(1,C.e*2)}) },
  { id:'trackingOut', family:'Espaciado', name:'Tracking out', defStagger:0, fx:C=>({extra:C.e*40, alpha:1}) },
  { id:'stretchWide', family:'Espaciado', name:'Estira ancho', defStagger:20, fx:C=>({scX:1+(1-C.e)*0.9, alpha:C.e}) },
  { id:'wordByWord', family:'Espaciado', name:'Palabra a palabra', unit:'word', defStagger:150, fx:C=>({alpha:C.e, dy:(1-C.e)*10}) },

  { id:'wave', family:'Ondas', name:'Onda', defStagger:0, params:[{key:'amp',label:'Amplitud',min:5,max:80,step:1,def:30},{key:'speed',label:'Velocidad',min:1,max:20,step:1,def:6}], fx:(C,P)=>({dy:Math.sin(C.t*P.speed+C.i*0.5)*P.amp*Math.min(1,C.e*2), alpha:Math.min(1,C.e*2)}) },
  { id:'waveCascade', family:'Ondas', name:'Onda cascada', defStagger:30, params:[{key:'amp',label:'Amplitud',min:5,max:80,step:1,def:30},{key:'speed',label:'Velocidad',min:1,max:20,step:1,def:5}], fx:(C,P)=>({dy:Math.sin(C.t*P.speed-C.i*0.6)*P.amp*Math.min(1,C.e*3), alpha:Math.min(1,C.e*3)}) },
  { id:'pendulum', family:'Ondas', name:'Pendulo', defStagger:25, params:[{key:'amp',label:'Amplitud',min:5,max:45,step:1,def:20},{key:'speed',label:'Velocidad',min:1,max:12,step:1,def:4}], fx:(C,P)=>({rot:Math.sin(C.t*P.speed+C.i*0.4)*P.amp*Math.min(1,C.e*2), alpha:Math.min(1,C.e*2)}) },
  { id:'wobble', family:'Ondas', name:'Temblor', defStagger:0, params:[{key:'amp',label:'Amplitud',min:5,max:45,step:1,def:25},{key:'speed',label:'Velocidad',min:1,max:20,step:1,def:8}], fx:(C,P)=>({rot:(hash(C.i*3+Math.floor(C.t*P.speed*2))-0.5)*P.amp*Math.min(1,C.e*2), alpha:Math.min(1,C.e*2)}) },
  { id:'ripple', family:'Ondas', name:'Ripple', defStagger:0, params:[{key:'amp',label:'Amplitud',min:5,max:40,step:1,def:20},{key:'speed',label:'Velocidad',min:1,max:15,step:1,def:5}], fx:(C,P)=>({scX:1+Math.sin(C.t*P.speed-C.i*0.5)*P.amp/100, scY:1-Math.sin(C.t*P.speed-C.i*0.5)*P.amp/100, alpha:Math.min(1,C.e*2)}) },

  { id:'flip3D', family:'3D', name:'Volteo 3D', defStagger:30, fx:C=>({scX:Math.cos((1-C.e)*Math.PI/2), alpha:1}) },
  { id:'spin3D', family:'3D', name:'Giro 3D', defStagger:30, fx:C=>({rot:(1-C.e)*180, scX:0.2+0.8*C.e, alpha:Math.min(1,C.e*2)}) },
  { id:'perspectiveIn', family:'3D', name:'Perspectiva', defStagger:20, fx:C=>({dy:(1-C.e)*60, scX:0.4+0.6*C.e, scY:0.4+0.6*C.e, blur:(1-C.e)*8, alpha:C.e}) },
  { id:'fly3D', family:'3D', name:'Vuelo 3D', defStagger:35, fx:C=>({dx:-(1-C.e)*400, dy:(1-C.e)*-200, scX:0.5+0.5*C.e, scY:0.5+0.5*C.e, alpha:C.e}) },
  { id:'cylinderRoll', family:'3D', name:'Cilindro', defStagger:30, fx:C=>({scX:Math.sin(C.e*Math.PI), dy:(1-C.e)*40, alpha:Math.min(1,C.e*2)}) },

  { id:'rgbSplit', family:'Glitch', name:'RGB split', defStagger:20, params:[{key:'amp',label:'Separacion',min:1,max:30,step:1,def:10}], fx:(C,P)=>({dupes:[{dx:-(1-C.e)*P.amp,color:'#ff2222',alpha:0.85,gco:'screen'},{dx:(1-C.e)*P.amp,color:'#2222ff',alpha:0.85,gco:'screen'}], alpha:C.e}) },
  { id:'ghostEcho', family:'Glitch', name:'Eco fantasma', defStagger:30, params:[{key:'echoes',label:'Ecos',min:1,max:5,step:1,def:3},{key:'spread',label:'Distancia',min:5,max:60,step:1,def:25}], fx:(C,P)=>{ const dupes=[]; for(let k=1;k<=P.echoes;k++)dupes.push({dx:-(1-C.e)*P.spread*k, alpha:0.3/k}); return {dupes, alpha:C.e}; } },
  { id:'flicker', family:'Glitch', name:'Parpadeo', defStagger:10, fx:C=>({alpha:C.e*(0.35+0.65*(Math.sin(C.t*40+C.i*3)>0?1:0))}) },
  { id:'shake', family:'Glitch', name:'Sacudida', defStagger:0, params:[{key:'amp',label:'Fuerza',min:5,max:40,step:1,def:15},{key:'speed',label:'Velocidad',min:1,max:20,step:1,def:10}], fx:(C,P)=>({dx:(hash(C.i*3+Math.floor(C.t*P.speed*3))-0.5)*P.amp*(1-C.e+0.2), dy:(hash(C.i*7+Math.floor(C.t*P.speed*3))-0.5)*P.amp*(1-C.e+0.2), alpha:Math.min(1,C.e*2)}) },
  { id:'pixelate', family:'Glitch', name:'Pixelado', defStagger:15, params:[{key:'amp',label:'Grosor',min:1,max:10,step:1,def:6}], fx:(C,P)=>{ const q=Math.floor((1-C.e)*P.amp)/10; return {scX:1+q, scY:1+q, alpha:Math.min(1,C.e*3)}; } },

  { id:'bounce', family:'Rebote', name:'Rebote', defStagger:40, params:[{key:'amp',label:'Altura',min:20,max:200,step:5,def:90}], fx:(C,P)=>({dy:-Math.abs(Math.sin(C.e*Math.PI*2))*P.amp*(1-C.e*0.6), alpha:Math.min(1,C.e*2)}) },
  { id:'popcorn', family:'Rebote', name:'Palomitas', defStagger:60, fx:C=>({scX:1+Math.sin(C.e*Math.PI*3)*0.3, scY:1-Math.sin(C.e*Math.PI*3)*0.3, alpha:Math.min(1,C.e*3)}) },
  { id:'stomp', family:'Rebote', name:'Pisoton', defStagger:50, fx:C=>({scY:1-Math.sin(C.e*Math.PI)*0.45, scX:1+Math.sin(C.e*Math.PI)*0.45, dy:Math.sin(C.e*Math.PI)*C.state.size*0.25, alpha:1}) },
  { id:'elasticDrop', family:'Rebote', name:'Caida elastica', defStagger:40, defEasing:'elastic', params:[{key:'amp',label:'Altura',min:50,max:250,step:10,def:160}], fx:(C,P)=>({dy:(1-C.e)*-P.amp, alpha:Math.min(1,C.e*2)}) },
  { id:'jelly', family:'Rebote', name:'Gelatina', defStagger:0, params:[{key:'speed',label:'Velocidad',min:2,max:15,step:1,def:6}], fx:(C,P)=>({scX:1+Math.sin(C.t*P.speed+C.i)*0.06*Math.min(1,C.e*2), scY:1-Math.sin(C.t*P.speed+C.i)*0.06*Math.min(1,C.e*2), alpha:Math.min(1,C.e*2)}) },

  { id:'hueCycle', family:'Color', name:'Ciclo de color', defStagger:0, params:[{key:'speed',label:'Velocidad',min:1,max:20,step:1,def:4}], fx:(C,P)=>({fill:'hsl('+((C.t*P.speed*20+C.i*8)%360)+',80%,50%)', alpha:Math.min(1,C.e*2)}) },
  { id:'gradientSweep', family:'Color', name:'Barrido degradado', gradient:true, defStagger:0, params:[{key:'speed',label:'Velocidad',min:50,max:400,step:10,def:150}], fx:C=>({alpha:Math.min(1,C.e*2)}) },
  { id:'rainbowFlow', family:'Color', name:'Flujo arcoiris', defStagger:15, params:[{key:'speed',label:'Velocidad',min:1,max:20,step:1,def:4}], fx:(C,P)=>({fill:'hsl('+((C.t*P.speed*20+C.i*12)%360)+',85%,55%)', alpha:Math.min(1,C.e*3)}) },
  { id:'neonPulse', family:'Color', name:'Pulso neon', defStagger:0, params:[{key:'speed',label:'Velocidad',min:1,max:10,step:1,def:4}], fx:(C,P)=>({fill:C.state.fill, shadow:C.state.stroke, shadowBlur:10+Math.sin(C.t*P.speed)*8, alpha:Math.min(1,C.e*2)}) },
  { id:'invertFlash', family:'Color', name:'Destello invertido', defStagger:0, fx:C=>({fill:(Math.sin(C.t*10)>0)?C.state.fill:C.state.bg, alpha:1}) },

  { id:'strokeDraw', family:'Trazo', name:'Trazo a mano', forceMode:'stroke', defStagger:0, defInDur:2, fx:C=>({clip:clamp(C.st*1.3-0.15,0,1), alpha:Math.min(1,C.e*3)}) },
  { id:'fillReveal', family:'Trazo', name:'Relleno progresivo', forceMode:'fill', defStagger:0, defInDur:2, fx:C=>({clip:clamp(C.st*1.3-0.15,0,1), alpha:1}) },
  { id:'outlineGlow', family:'Trazo', name:'Brillo de contorno', forceMode:'stroke', defStagger:0, params:[{key:'width',label:'Grosor',min:2,max:20,step:1,def:6},{key:'speed',label:'Velocidad',min:1,max:10,step:1,def:4}], fx:(C,P)=>({strokeW:P.width*(0.5+0.5*Math.sin(C.t*P.speed)), shadow:C.state.stroke, shadowBlur:12, alpha:Math.min(1,C.e*2)}) },
  { id:'dualTone', family:'Trazo', name:'Doble tono', forceMode:'both', defStagger:25, fx:C=>({strokeW:2+(1-C.e)*10, alpha:C.e}) },
  { id:'textTrail', family:'Trazo', name:'Estela de texto', forceMode:'stroke', defStagger:30, params:[{key:'len',label:'Longitud',min:1,max:6,step:1,def:3},{key:'spread',label:'Distancia',min:5,max:40,step:1,def:16}], fx:(C,P)=>{ const dupes=[]; for(let k=1;k<=P.len;k++)dupes.push({dx:-k*P.spread*(1-C.e*0.5), alpha:0.25/k}); return {dupes, alpha:C.e}; } },

  { id:'explode', family:'Salida y ambient', name:'Explosion', defStagger:0, params:[{key:'power',label:'Potencia',min:50,max:400,step:10,def:220}], fx:(C,P)=>{ const a=hash(C.i)*Math.PI*2; const d=(1-C.e)*P.power; return {dx:Math.cos(a)*d, dy:Math.sin(a)*d, rot:(1-C.e)*hash(C.i+9)*180, alpha:Math.min(1,C.e*2)}; } },
  { id:'gravityFall', family:'Salida y ambient', name:'Caida libre', defStagger:30, params:[{key:'power',label:'Altura',min:80,max:400,step:10,def:200}], fx:(C,P)=>({dy:(1-C.e)*-P.power+Math.abs(Math.sin(C.e*Math.PI*2))*P.power*0.5, alpha:Math.min(1,C.e*2)}) },
  { id:'scatter', family:'Salida y ambient', name:'Dispersion', defStagger:0, params:[{key:'power',label:'Alcance',min:100,max:400,step:10,def:250}], fx:(C,P)=>({dx:(hash(C.i*5)-0.5)*2*P.power*(1-C.e), dy:(hash(C.i*11)-0.5)*2*P.power*(1-C.e), rot:(hash(C.i*7)-0.5)*90*(1-C.e), alpha:Math.min(1,C.e*2)}) },
  { id:'windBlow', family:'Salida y ambient', name:'Soplo de viento', defStagger:40, params:[{key:'power',label:'Fuerza',min:100,max:400,step:10,def:260}], fx:(C,P)=>({dx:(1-C.e)*P.power, dy:Math.sin(C.i+C.t*10)*(1-C.e)*20, rot:(1-C.e)*10, alpha:C.e}) },
  { id:'marqueeLoop', family:'Salida y ambient', name:'Marquesina', defStagger:0, defInDur:0.5, defEasing:'linear', params:[{key:'speed',label:'Velocidad',min:50,max:300,step:10,def:120}], fx:(C,P)=>{ const span=C.totalW+400; const off=(C.t*P.speed)%span; return {dx:off, dupes:[{dx:off-span, alpha:1}], alpha:Math.min(1,C.e*2)}; } },

  { id:'wipeRight', family:'Revelados', name:'Barrido derecha', defStagger:0, defInDur:2, fx:C=>({clip:C.st, clipDir:'lr', alpha:1}) },
  { id:'wipeLeft', family:'Revelados', name:'Barrido izquierda', defStagger:0, defInDur:2, fx:C=>({clip:C.st, clipDir:'rl', alpha:1}) },
  { id:'wipeDown', family:'Revelados', name:'Barrido hacia abajo', defStagger:0, defInDur:2, fx:C=>({clip:C.st, clipDir:'tb', alpha:1}) },
  { id:'wipeUp', family:'Revelados', name:'Barrido hacia arriba', defStagger:0, defInDur:2, fx:C=>({clip:C.st, clipDir:'bt', alpha:1}) },
  { id:'irisOpen', family:'Revelados', name:'Apertura central', defStagger:0, defInDur:2, fx:C=>({clip:C.st, clipDir:'center', alpha:1}) },

  { id:'rubberBand', family:'Elasticos', name:'Banda elastica', defStagger:35, fx:C=>({scX:1+Math.sin(C.st*Math.PI*2)*0.35*(1-C.st*0.6), scY:1-Math.sin(C.st*Math.PI*2)*0.35*(1-C.st*0.6), alpha:Math.min(1,C.st*3)}) },
  { id:'heartBeat', family:'Elasticos', name:'Latido', defStagger:45, fx:C=>({scX:1+Math.abs(Math.sin(C.st*Math.PI*3))*0.3*(1-C.st*0.4), scY:1+Math.abs(Math.sin(C.st*Math.PI*3))*0.3*(1-C.st*0.4), alpha:Math.min(1,C.st*3)}) },
  { id:'dizzy', family:'Elasticos', name:'Mareo', defStagger:30, fx:C=>({rot:(1-C.st)*220*(hash(C.i)>0.5?1:-1), blur:(1-C.st)*10, alpha:Math.min(1,C.st*3)}) },
  { id:'sneeze', family:'Elasticos', name:'Estornudo', defStagger:50, fx:C=>({scX:1+Math.sin(C.st*Math.PI*2)*0.5, scY:1+Math.sin(C.st*Math.PI*2)*0.5, blur:(1-C.st)*14, alpha:Math.min(1,C.st*4)}) },
  { id:'tickTock', family:'Elasticos', name:'Tic-tac', defStagger:40, fx:C=>({rot:Math.sin(C.st*Math.PI*4)*25*(1-C.st*0.7), alpha:Math.min(1,C.st*3)}) },

  { id:'meltDown', family:'Liquido', name:'Derretido', defStagger:25, fx:C=>({dy:(1-C.st)*-40, scY:1+(1-C.st)*1.2, blur:(1-C.st)*8, alpha:Math.min(1,C.st*2)}) },
  { id:'waveSkew', family:'Liquido', name:'Onda sesgada', defStagger:0, params:[{key:'amp',label:'Amplitud',min:5,max:50,step:5,def:20},{key:'speed',label:'Velocidad',min:1,max:15,step:1,def:5}], fx:(C,P)=>({skew:Math.sin(C.t*P.speed+C.i*0.5)*P.amp/100*Math.min(1,C.e*2), alpha:Math.min(1,C.e*2)}) },
  { id:'splash', family:'Liquido', name:'Salpicadura', defStagger:35, fx:C=>({dy:(1-C.st)*-120+Math.abs(Math.sin(C.st*Math.PI))*40, scX:1+Math.sin(C.st*Math.PI)*0.3, scY:1-Math.sin(C.st*Math.PI)*0.3, alpha:Math.min(1,C.st*2)}) },
  { id:'jellySkew', family:'Liquido', name:'Gelatina sesgada', defStagger:0, params:[{key:'amp',label:'Amplitud',min:5,max:40,step:5,def:20},{key:'speed',label:'Velocidad',min:2,max:12,step:1,def:5}], fx:(C,P)=>({skew:Math.sin(C.t*P.speed+C.i)*P.amp/100*Math.min(1,C.e*2), alpha:Math.min(1,C.e*2)}) },
  { id:'liquidDrop', family:'Liquido', name:'Gota', defStagger:30, params:[{key:'power',label:'Altura',min:40,max:200,step:10,def:100}], fx:(C,P)=>({dy:(1-C.st)*-P.power+Math.abs(Math.sin(C.st*Math.PI))*P.power*0.35, scY:1+(1-C.st)*0.8, alpha:Math.min(1,C.st*2)}) },

  { id:'spiralIn', family:'Caminos', name:'Espiral', defStagger:45, params:[{key:'power',label:'Alcance',min:50,max:250,step:10,def:160}], fx:(C,P)=>{ const ang=C.i*1.2+(1-C.st)*Math.PI*2; const r=(1-C.st)*P.power; return {dx:Math.cos(ang)*r, dy:Math.sin(ang)*r*0.5, rot:(1-C.st)*180, alpha:Math.min(1,C.st*2)}; } },
  { id:'arcIn', family:'Caminos', name:'Arco', defStagger:40, fx:C=>({dy:-Math.sin(C.st*Math.PI)*100, rot:(1-C.st)*-60, alpha:Math.min(1,C.st*2)}) },
  { id:'zigzag', family:'Caminos', name:'Zigzag', defStagger:30, params:[{key:'power',label:'Salto',min:40,max:200,step:10,def:120}], fx:(C,P)=>({dx:(1-C.st)*P.power*((C.i%2)?-1:1), dy:(1-C.st)*P.power*0.4*((Math.floor(C.i/2)%2)?-1:1), alpha:C.st}) },
  { id:'loopLoop', family:'Caminos', name:'Rizo', defStagger:45, params:[{key:'power',label:'Tamano',min:20,max:120,step:10,def:70}], fx:(C,P)=>({dy:-Math.sin(C.st*Math.PI*2)*P.power, dx:-Math.cos(C.st*Math.PI*2)*P.power*0.3+P.power*0.3, alpha:Math.min(1,C.st*2)}) },
  { id:'stairs', family:'Caminos', name:'Escaleras', defStagger:20, params:[{key:'power',label:'Peldano',min:20,max:100,step:5,def:60}], fx:(C,P)=>({dy:(1-C.st)*P.power*Math.floor(hash(C.i)*4), dx:(1-C.st)*P.power*0.6, alpha:Math.min(1,C.st*2)}) },

  { id:'pingPong', family:'Fisica', name:'Ping-pong', defStagger:0, defEasing:'linear', params:[{key:'amp',label:'Recorrido',min:20,max:120,step:10,def:80},{key:'speed',label:'Velocidad',min:1,max:12,step:1,def:3}], fx:(C,P)=>({dx:Math.abs(((C.t*P.speed*2+C.i*0.8)%2)-1)*P.amp-P.amp/2, alpha:Math.min(1,C.e*2)}) },
  { id:'springWobble', family:'Fisica', name:'Muelle', defStagger:0, params:[{key:'amp',label:'Amplitud',min:5,max:40,step:1,def:18},{key:'speed',label:'Velocidad',min:2,max:15,step:1,def:5}], fx:(C,P)=>({rot:Math.sin(C.t*P.speed+C.i*0.7)*P.amp*Math.min(1,C.e*2), alpha:Math.min(1,C.e*2)}) },
  { id:'ricochet', family:'Fisica', name:'Ricochet', defStagger:30, params:[{key:'power',label:'Potencia',min:40,max:220,step:10,def:140}], fx:(C,P)=>{ const dir=hash(C.i)>0.5?1:-1; return {dx:dir*(1-C.st)*P.power*0.5, dy:(1-C.st)*-P.power+Math.abs(Math.sin(C.st*Math.PI*3))*P.power*0.7, alpha:Math.min(1,C.st*2)}; } },
  { id:'pendulumSwing', family:'Fisica', name:'Pendulo de cuerda', defStagger:0, params:[{key:'amp',label:'Amplitud',min:10,max:80,step:5,def:40},{key:'speed',label:'Velocidad',min:1,max:10,step:1,def:3}], fx:(C,P)=>{ const a=Math.sin(C.t*P.speed+C.i*0.5)*P.amp; return {dx:a, dy:-(1-Math.cos(C.t*P.speed+C.i*0.5))*P.amp*0.5, alpha:Math.min(1,C.e*2)}; } },
  { id:'floatAmbient', family:'Fisica', name:'Flotacion', defStagger:0, defInDur:0.8, params:[{key:'speed',label:'Velocidad',min:1,max:10,step:1,def:3}], fx:(C,P)=>({dy:Math.sin(C.t*P.speed+C.i*0.8)*12, rot:Math.sin(C.t*P.speed*0.7+C.i)*2, alpha:Math.min(1,C.e*2)}) },

  { id:'extrudeIn', family:'Profundidad', name:'Extrusion', defStagger:0, params:[{key:'depth',label:'Profundidad',min:2,max:10,step:1,def:5}], fx:(C,P)=>{ const dupes=[]; const shades=['#d9d9d9','#b3b3b3','#8c8c8c','#666666','#404040']; for(let k=1;k<=P.depth;k++)dupes.push({dx:-k*7*(1-C.e), color:shades[(k-1)%5], alpha:0.85}); return {dupes, alpha:C.e}; } },
  { id:'parallaxIn', family:'Profundidad', name:'Paralaje', defStagger:20, fx:C=>({scX:1-(1-C.st)*0.5*hash(C.i), scY:1-(1-C.st)*0.5*hash(C.i), blur:(1-C.st)*6*hash(C.i), alpha:Math.min(1,C.st*2)}) },
  { id:'foldUp', family:'Profundidad', name:'Pliegue', defStagger:30, fx:C=>({scY:Math.cos((1-C.st)*Math.PI/2), dy:(1-C.st)*-20, alpha:1}) },
  { id:'deepZoom', family:'Profundidad', name:'Zoom profundo', defStagger:0, defInDur:0.8, defEasing:'linear', params:[{key:'speed',label:'Velocidad',min:1,max:10,step:1,def:3}], fx:(C,P)=>{ const z=Math.sin(C.t*P.speed); return {scX:1+z*0.5, scY:1+z*0.5, blur:Math.abs(z)*5, alpha:1}; } },
  { id:'tunnelIn', family:'Profundidad', name:'Tunel', defStagger:20, fx:C=>({scX:0.2+0.8*C.st, scY:0.2+0.8*C.st, blur:(1-C.st)*15, dy:(1-C.st)*20, alpha:Math.min(1,C.st*2)}) },

  { id:'lightSweep', family:'Luces', name:'Barrido de luz', defStagger:0, defInDur:0.8, params:[{key:'speed',label:'Velocidad',min:50,max:400,step:10,def:200}], fx:(C,P)=>{ const span=C.totalW+200; const bx=((C.t*P.speed)%span)-span/2; return {dupes:[{dx:bx,color:'#ffffff',alpha:0.9,gco:'screen'}], alpha:1}; } },
  { id:'strobe', family:'Luces', name:'Estroboscopio', defStagger:0, defInDur:0.5, params:[{key:'speed',label:'Velocidad',min:2,max:20,step:1,def:8}], fx:(C,P)=>({alpha:(Math.floor(C.t*P.speed)%2)?1:0.2}) },
  { id:'sparkleTwinkle', family:'Luces', name:'Destellos', defStagger:0, defInDur:0.8, params:[{key:'speed',label:'Velocidad',min:1,max:10,step:1,def:4}], fx:(C,P)=>{ const s=Math.sin(C.t*P.speed*3+C.i*2); return {dupes:s>0.6?[{dx:(hash(C.i)-0.5)*24, dy:(hash(C.i+4)-0.5)*24, color:'#ffffff', alpha:s, gco:'screen'}]:null, alpha:1}; } },
  { id:'glowBreathe', family:'Luces', name:'Resplandor', defStagger:0, defInDur:0.8, params:[{key:'speed',label:'Velocidad',min:1,max:8,step:1,def:3}], fx:(C,P)=>({shadow:C.state.stroke, shadowBlur:8+Math.sin(C.t*P.speed+C.i*0.5)*6, alpha:1}) },
  { id:'shineAcross', family:'Luces', name:'Brillo cruzado', defStagger:0, defInDur:0.8, params:[{key:'speed',label:'Velocidad',min:50,max:400,step:10,def:220}], fx:(C,P)=>{ const span=C.totalW+400; const bx=((C.t*P.speed)%span)-span/2; return {dupes:[{dx:bx,color:'#ffffff',alpha:0.55,gco:'screen'},{dx:bx*1.15,color:'#ffffff',alpha:0.25,gco:'screen'}], alpha:1}; } },

  { id:'baselineBounce', family:'Tipograficos', name:'Saltos de linea base', defStagger:0, defInDur:0.8, params:[{key:'speed',label:'Velocidad',min:2,max:15,step:1,def:6}], fx:(C,P)=>({dy:-Math.abs(Math.sin(C.t*P.speed+C.i*0.6))*14, rot:Math.sin(C.t*P.speed+C.i*0.6)*6, alpha:Math.min(1,C.e*2)}) },
  { id:'swashIn', family:'Tipograficos', name:'Trazo caligrafico', defStagger:35, fx:C=>({rot:(1-C.st)*120*(C.i%2?-1:1), blur:(1-C.st)*8, alpha:Math.min(1,C.st*2)}) },
  { id:'kernDance', family:'Tipograficos', name:'Baile de kerning', defStagger:0, defInDur:0.8, params:[{key:'speed',label:'Velocidad',min:2,max:15,step:1,def:5}], fx:(C,P)=>({kern:Math.sin(C.t*P.speed+C.i*0.4)*24, alpha:Math.min(1,C.e*2)}) },
  { id:'tallIn', family:'Tipograficos', name:'Crecimiento alto', defStagger:30, fx:C=>({scY:1.8-0.8*C.st, scX:0.8+0.2*C.st, alpha:C.st}) },
  { id:'squishIn', family:'Tipograficos', name:'Aplastamiento', defStagger:30, fx:C=>({scY:0.4+0.6*C.st, scX:1.4-0.4*C.st, dy:(1-C.st)*30, alpha:Math.min(1,C.st*2)}) },

  { id:'orbitLoop', family:'Ambientales', name:'Orbita', defStagger:0, defInDur:0.8, params:[{key:'speed',label:'Velocidad',min:1,max:10,step:1,def:3}], fx:(C,P)=>({dx:Math.cos(C.t*P.speed+C.i*0.7)*30, dy:Math.sin(C.t*P.speed+C.i*0.7)*12, alpha:Math.min(1,C.e*2)}) },
  { id:'breathing', family:'Ambientales', name:'Respiracion', defStagger:0, defInDur:0.8, params:[{key:'speed',label:'Velocidad',min:1,max:8,step:1,def:2}], fx:(C,P)=>({scX:1+Math.sin(C.t*P.speed+C.i*0.3)*0.08, scY:1+Math.sin(C.t*P.speed+C.i*0.3)*0.08, alpha:1}) },
  { id:'hoverFloat', family:'Ambientales', name:'Flotar', defStagger:0, defInDur:0.8, params:[{key:'speed',label:'Velocidad',min:1,max:10,step:1,def:3}], fx:(C,P)=>({dy:Math.sin(C.t*P.speed+C.i*0.6)*10, alpha:Math.min(1,C.e*2)}) },
  { id:'windLoop', family:'Ambientales', name:'Viento', defStagger:0, defInDur:0.8, params:[{key:'speed',label:'Velocidad',min:1,max:12,step:1,def:4}], fx:(C,P)=>({skew:Math.sin(C.t*P.speed+C.i*0.5)*0.2*Math.min(1,C.e*2), alpha:Math.min(1,C.e*2)}) },
  { id:'colorShift', family:'Ambientales', name:'Cambio de color', defStagger:0, defInDur:0.8, params:[{key:'speed',label:'Velocidad',min:1,max:15,step:1,def:4}], fx:(C,P)=>({fill:'hsl('+((C.t*P.speed*10)%360)+',75%,50%)', alpha:1}) },

  { id:'stampIn', family:'Aterrizajes', name:'Sello', defStagger:25, fx:C=>({scX:2.5-1.5*C.st, scY:2.5-1.5*C.st, blur:(1-C.st)*10, alpha:Math.min(1,C.st*2.5)}) },
  { id:'helicopterLand', family:'Aterrizajes', name:'Helicoptero', defStagger:30, fx:C=>({dy:(1-C.st)*-160, rot:Math.sin(C.st*Math.PI*4)*8*(1-C.st), alpha:Math.min(1,C.st*3)}) },
  { id:'magnetSnap', family:'Aterrizajes', name:'Imantado', defStagger:25, defEasing:'elastic', params:[{key:'power',label:'Distancia',min:100,max:400,step:10,def:200}], fx:(C,P)=>({dx:(1-C.st)*-P.power, alpha:Math.min(1,C.st*2)}) },
  { id:'parachute', family:'Aterrizajes', name:'Paracaidas', defStagger:35, fx:C=>({dy:(1-C.st)*-120, scX:1+(1-C.st)*0.5, scY:1+(1-C.st)*0.5, rot:Math.sin(C.t*3+C.i)*(1-C.st)*6, alpha:Math.min(1,C.st*2)}) },
  { id:'crashLand', family:'Aterrizajes', name:'Aterrizaje brusco', defStagger:30, params:[{key:'power',label:'Altura',min:40,max:260,step:10,def:200}], fx:(C,P)=>({dy:(1-C.st)*-P.power+Math.abs(Math.sin(C.st*Math.PI*2))*P.power*0.4, scY:1-Math.sin(C.st*Math.PI)*0.25, alpha:Math.min(1,C.st*2)}) },

  { id:'cineFade', family:'Cinematicos', name:'Fundido cinematografico', defStagger:25, defEasing:'expoOut', fx:C=>({alpha:C.e, dy:(1-C.e)*30, blur:(1-C.e)*4}) },
  { id:'cineTrack', family:'Cinematicos', name:'Tracking cinematografico', defStagger:20, defEasing:'expoOut', fx:C=>({kern:(1-C.e)*70, alpha:C.e, blur:(1-C.e)*6}) },
  { id:'cineZoom', family:'Cinematicos', name:'Zoom cinematografico', defStagger:30, defEasing:'expoOut', fx:C=>({scX:0.85+0.15*C.e, scY:0.85+0.15*C.e, alpha:C.e, blur:(1-C.e)*8}) },
  { id:'whipPan', family:'Cinematicos', name:'Whip pan', defStagger:15, defEasing:'expoOut', fx:C=>({dx:(1-C.e)*600, rot:(1-C.e)*6, alpha:C.e, blur:(1-C.e)*5}) },
  { id:'glideIn', family:'Cinematicos', name:'Deslizamiento suave', defStagger:30, fx:C=>({dx:(1-C.e)*-150, alpha:Math.min(1,C.e*1.5)}) },
  { id:'focusPull', family:'Cinematicos', name:'Tiro de foco', defStagger:20, fx:C=>({blur:(1-C.e)*24, alpha:Math.min(1,C.e*1.6)}) },
  { id:'driftUp', family:'Cinematicos', name:'Deriva ascendente', defStagger:35, fx:C=>({dy:(1-C.e)*60, alpha:C.e, rot:(1-C.e)*2}) },
  { id:'chapterTitle', family:'Cinematicos', name:'Titulo de capitulo', defStagger:25, fx:C=>({scX:0.94+0.06*C.e, scY:0.94+0.06*C.e, dy:(1-C.e)*20, blur:(1-C.e)*3, alpha:C.e}) },
  { id:'microReveal', family:'Cinematicos', name:'Micro revelado', defStagger:30, fx:C=>({scX:0.98+0.02*C.e, scY:0.98+0.02*C.e, dy:(1-C.e)*8, alpha:C.e}) },
  { id:'softPop', family:'Cinematicos', name:'Pop suave', defStagger:40, defEasing:'backOut', fx:C=>({scX:0.9+0.1*C.e, scY:0.9+0.1*C.e, alpha:C.e}) },

  { id:'kinFlip', family:'Kinetic Type', name:'Volteo kinetic', defStagger:35, fx:C=>({scX:Math.cos((1-C.st)*Math.PI), alpha:1}) },
  { id:'kinJump', family:'Kinetic Type', name:'Salto kinetic', defStagger:45, fx:C=>({dy:-Math.abs(Math.sin(C.st*Math.PI))*60, rot:Math.sin(C.st*Math.PI)*14, alpha:1}) },
  { id:'kinSpin', family:'Kinetic Type', name:'Giro kinetic', defStagger:30, fx:C=>({rot:(1-C.st)*360, scX:0.4+0.6*C.st, scY:0.4+0.6*C.st, alpha:Math.min(1,C.st*2)}) },
  { id:'kinSlide', family:'Kinetic Type', name:'Deslizamiento alternado', defStagger:30, fx:C=>({dx:(1-C.st)*180*(C.i%2?-1:1), alpha:Math.min(1,C.st*2)}) },
  { id:'kinPop', family:'Kinetic Type', name:'Pop kinetic', defStagger:50, fx:C=>({scX:1+Math.sin(C.st*Math.PI)*0.4, scY:1+Math.sin(C.st*Math.PI)*0.4, alpha:Math.min(1,C.st*2)}) },
  { id:'kinWave', family:'Kinetic Type', name:'Onda kinetic', defStagger:25, fx:C=>({dy:Math.sin(C.st*Math.PI*2+C.i*0.8)*30*(1-C.st*0.5), alpha:Math.min(1,C.st*2)}) },
  { id:'kinPunch', family:'Kinetic Type', name:'Golpe kinetic', defStagger:35, fx:C=>({dx:(1-C.st)*(hash(C.i)>0.5?1:-1)*90, scX:1.3-0.3*C.st, scY:1.3-0.3*C.st, alpha:Math.min(1,C.st*2)}) },
  { id:'kinRoll', family:'Kinetic Type', name:'Rodado kinetic', defStagger:30, fx:C=>({rot:(1-C.st)*180, dy:(1-C.st)*40, alpha:Math.min(1,C.st*2)}) },
  { id:'kinStretch', family:'Kinetic Type', name:'Estiramiento kinetic', defStagger:30, fx:C=>({scX:1.6-0.6*C.st, scY:0.5+0.5*C.st, alpha:Math.min(1,C.st*2)}) },
  { id:'kinZoom', family:'Kinetic Type', name:'Zoom kinetic', defStagger:30, fx:C=>({scX:0.3+0.7*C.st, scY:0.3+0.7*C.st, rot:(1-C.st)*30, alpha:Math.min(1,C.st*1.5)}) },

  { id:'edSerif', family:'Editorial Elegante', name:'Serif elegante', defStagger:28, fx:C=>({kern:(1-C.e)*30, dy:(1-C.e)*14, alpha:C.e}) },
  { id:'edMinimal', family:'Editorial Elegante', name:'Minimal', defStagger:30, fx:C=>({dx:(1-C.e)*-80, alpha:C.e}) },
  { id:'edRefined', family:'Editorial Elegante', name:'Refinado', defStagger:25, fx:C=>({alpha:C.e, blur:(1-C.e)*3, dy:(1-C.e)*10}) },
  { id:'edGold', family:'Editorial Elegante', name:'Oro', defStagger:20, fx:C=>({fill:'hsl('+(48-((1-C.e)*8))+',85%,55%)', alpha:C.e, dy:(1-C.e)*12}) },
  { id:'edEditorial', family:'Editorial Elegante', name:'Editorial', defStagger:22, fx:C=>({kern:(1-C.e)*26, dy:(1-C.e)*18, alpha:C.e}) },
  { id:'edSwiss', family:'Editorial Elegante', name:'Suizo limpio', defStagger:35, fx:C=>({dx:(1-C.e)*60, alpha:C.e}) },
  { id:'edBaseline', family:'Editorial Elegante', name:'Ascenso de linea base', defStagger:30, fx:C=>({dy:(1-C.e)*24, alpha:C.e, blur:(1-C.e)*2}) },
  { id:'edOptical', family:'Editorial Elegante', name:'Ajuste optico', defStagger:25, fx:C=>({scX:1+(1-C.e)*0.08, scY:1-(1-C.e)*0.05, alpha:C.e}) },
  { id:'edOvershoot', family:'Editorial Elegante', name:'Sobreimpulso sutil', defStagger:35, defEasing:'backOut', fx:C=>({dx:(1-C.e)*-120, alpha:C.e}) },
  { id:'edFine', family:'Editorial Elegante', name:'Fundido fino', defStagger:30, fx:C=>({alpha:C.e, blur:(1-C.e)*1.5}) },

  { id:'whipLeft', family:'Whip y Overshoot', name:'Whip izquierda', defStagger:12, defEasing:'expoOut', fx:C=>({dx:(1-C.e)*-500, rot:(1-C.e)*-8, blur:(1-C.e)*6, alpha:C.e}) },
  { id:'whipRight', family:'Whip y Overshoot', name:'Whip derecha', defStagger:12, defEasing:'expoOut', fx:C=>({dx:(1-C.e)*500, rot:(1-C.e)*8, blur:(1-C.e)*6, alpha:C.e}) },
  { id:'whipUp', family:'Whip y Overshoot', name:'Whip arriba', defStagger:12, defEasing:'expoOut', fx:C=>({dy:(1-C.e)*-320, rot:(1-C.e)*-8, blur:(1-C.e)*6, alpha:C.e}) },
  { id:'whipDown', family:'Whip y Overshoot', name:'Whip abajo', defStagger:12, defEasing:'expoOut', fx:C=>({dy:(1-C.e)*320, rot:(1-C.e)*8, blur:(1-C.e)*6, alpha:C.e}) },
  { id:'overScale', family:'Whip y Overshoot', name:'Sobreimpulso de escala', defStagger:35, defEasing:'backOut', fx:C=>({scX:0.2+0.8*C.e, scY:0.2+0.8*C.e, alpha:C.e}) },
  { id:'overRotate', family:'Whip y Overshoot', name:'Sobreimpulso de giro', defStagger:30, defEasing:'backOut', fx:C=>({rot:(1-C.e)*-45, alpha:C.e}) },
  { id:'overSlide', family:'Whip y Overshoot', name:'Sobreimpulso de deslizamiento', defStagger:30, defEasing:'backOut', fx:C=>({dx:(1-C.e)*200, alpha:Math.min(1,C.e*2)}) },
  { id:'snapIn', family:'Whip y Overshoot', name:'Ajuste elastico', defStagger:25, defEasing:'elastic', fx:C=>({dx:(1-C.e)*-240, alpha:Math.min(1,C.e*2)}) },
  { id:'punchScale', family:'Whip y Overshoot', name:'Escala con puno', defStagger:40, fx:C=>({scX:1+Math.sin(C.e*Math.PI)*0.25, scY:1+Math.sin(C.e*Math.PI)*0.25, alpha:Math.min(1,C.e*2)}) },
  { id:'slamIn', family:'Whip y Overshoot', name:'Golpe de entrada', defStagger:30, defEasing:'bounce', fx:C=>({dy:(1-C.e)*-260, alpha:Math.min(1,C.e*3)}) },

  { id:'grainIn', family:'Texturas y Grano', name:'Grano', defStagger:15, fx:C=>({alpha:C.e*(0.85+0.15*Math.sin(C.t*70+C.i))}) },
  { id:'stencilIn', family:'Texturas y Grano', name:'Estencil', forceMode:'stroke', defStagger:25, fx:C=>({strokeW:(1-C.e)*14+2, alpha:C.e}) },
  { id:'grunge', family:'Texturas y Grano', name:'Grunge', defStagger:20, fx:C=>({dx:(hash(C.i*3+Math.floor(C.t*8))-0.5)*10*(1-C.e), dy:(hash(C.i*7+Math.floor(C.t*8))-0.5)*10*(1-C.e), alpha:Math.min(1,C.e*2)}) },
  { id:'vhsIn', family:'Texturas y Grano', name:'VHS', defStagger:20, fx:C=>({dupes:[{dx:-(1-C.e)*6,color:'#ff2222',alpha:0.6,gco:'screen'},{dx:(1-C.e)*6,color:'#2222ff',alpha:0.6,gco:'screen'}], dy:(hash(C.i+Math.floor(C.t*10))-0.5)*4*(1-C.e), alpha:C.e}) },
  { id:'blurBlend', family:'Texturas y Grano', name:'Fundido con blur', defStagger:25, fx:C=>({blur:(1-C.e)*16, alpha:C.e, scX:1.02-0.02*C.e, scY:1.02-0.02*C.e}) },
  { id:'inkReveal', family:'Texturas y Grano', name:'Tinta', defStagger:20, fx:C=>({clip:C.st, clipDir:'center', blur:(1-C.st)*10, alpha:1}) },
  { id:'paperSlide', family:'Texturas y Grano', name:'Papel', defStagger:30, fx:C=>({dx:(1-C.e)*90, rot:(1-C.e)*2, alpha:C.e}) },
  { id:'tapePeel', family:'Texturas y Grano', name:'Cinta adhesiva', defStagger:20, fx:C=>({clip:C.st, clipDir:'tb', rot:(1-C.e)*-6, dy:(1-C.e)*-30, alpha:1}) },
  { id:'photocopy', family:'Texturas y Grano', name:'Fotocopia', defStagger:18, fx:C=>({blur:(1-C.st)*10, alpha:Math.min(1,C.st*2), dupes:[{dx:2,dy:2,color:'#999999',alpha:0.35}]}) },
  { id:'stampInk', family:'Texturas y Grano', name:'Sello de tinta', defStagger:22, fx:C=>({scX:2.4-1.4*C.st, scY:2.4-1.4*C.st, rot:(hash(C.i)-0.5)*6*(1-C.st), alpha:Math.min(1,C.st*2)}) },

  { id:'fluidWave', family:'Flujo y Liquido', name:'Onda fluida', defStagger:0, params:[{key:'amp',label:'Amplitud',min:5,max:80,step:1,def:30},{key:'speed',label:'Velocidad',min:1,max:15,step:1,def:5}], fx:(C,P)=>({dy:Math.sin(C.t*P.speed+C.i*0.4)*P.amp*Math.min(1,C.e*2), skew:Math.cos(C.t*P.speed+C.i*0.4)*0.15*Math.min(1,C.e*2), alpha:Math.min(1,C.e*2)}) },
  { id:'ripple2', family:'Flujo y Liquido', name:'Ripple suave', defStagger:0, params:[{key:'amp',label:'Amplitud',min:5,max:40,step:1,def:20},{key:'speed',label:'Velocidad',min:1,max:12,step:1,def:4}], fx:(C,P)=>({scX:1+Math.sin(C.t*P.speed-C.i*0.6)*P.amp/100, scY:1-Math.sin(C.t*P.speed-C.i*0.6)*P.amp/100, alpha:Math.min(1,C.e*2)}) },
  { id:'droplet', family:'Flujo y Liquido', name:'Gota pequena', defStagger:45, fx:C=>({dy:(1-C.st)*-70+Math.abs(Math.sin(C.st*Math.PI*2))*30, alpha:Math.min(1,C.st*2)}) },
  { id:'jellyWave2', family:'Flujo y Liquido', name:'Gelatina ondulada', defStagger:0, params:[{key:'speed',label:'Velocidad',min:2,max:12,step:1,def:5}], fx:(C,P)=>({scX:1+Math.sin(C.t*P.speed+C.i*0.6)*0.09, scY:1-Math.sin(C.t*P.speed+C.i*0.6)*0.09, alpha:Math.min(1,C.e*2)}) },
  { id:'cascade', family:'Flujo y Liquido', name:'Cascada', defStagger:30, fx:C=>({dy:(1-C.st)*-(40+(C.i%5)*16), alpha:Math.min(1,C.st*2)}) },
  { id:'surf', family:'Flujo y Liquido', name:'Surf', defStagger:0, params:[{key:'speed',label:'Velocidad',min:2,max:12,step:1,def:5}], fx:(C,P)=>({dy:Math.sin(C.t*P.speed+C.i)*14, rot:Math.sin(C.t*P.speed+C.i)*8, alpha:Math.min(1,C.e*2)}) },
  { id:'undulate', family:'Flujo y Liquido', name:'Ondulacion', defStagger:0, params:[{key:'speed',label:'Velocidad',min:1,max:12,step:1,def:4}], fx:(C,P)=>({skew:Math.sin(C.t*P.speed+C.i*0.5)*0.3, dy:Math.sin(C.t*P.speed*0.8+C.i)*10, alpha:Math.min(1,C.e*2)}) },
  { id:'bubbleIn', family:'Flujo y Liquido', name:'Burbujas', defStagger:40, defEasing:'bounce', fx:C=>({scX:0.2+0.8*C.st, scY:0.2+0.8*C.st, dy:(1-C.st)*-60, alpha:Math.min(1,C.st*2)}) },
  { id:'splash2', family:'Flujo y Liquido', name:'Salpicadura doble', defStagger:35, fx:C=>({dy:-Math.abs(Math.sin(C.st*Math.PI*2))*90, scX:1+Math.sin(C.st*Math.PI)*0.35, scY:1-Math.sin(C.st*Math.PI)*0.35, alpha:Math.min(1,C.st*2)}) },
  { id:'current', family:'Flujo y Liquido', name:'Corriente', defStagger:30, fx:C=>({dx:(1-C.st)*140, dy:Math.sin(C.t*6+C.i)*8*(1-C.st), alpha:Math.min(1,C.st*2)}) },

  { id:'maskLeft', family:'Minimal Moderno', name:'Mascara izquierda', defStagger:0, defInDur:1.6, fx:C=>({clip:C.st, clipDir:'lr', alpha:1}) },
  { id:'maskRight', family:'Minimal Moderno', name:'Mascara derecha', defStagger:0, defInDur:1.6, fx:C=>({clip:C.st, clipDir:'rl', alpha:1}) },
  { id:'maskTop', family:'Minimal Moderno', name:'Mascara superior', defStagger:0, defInDur:1.6, fx:C=>({clip:C.st, clipDir:'tb', alpha:1}) },
  { id:'maskBottom', family:'Minimal Moderno', name:'Mascara inferior', defStagger:0, defInDur:1.6, fx:C=>({clip:C.st, clipDir:'bt', alpha:1}) },
  { id:'splitReveal', family:'Minimal Moderno', name:'Revelado dividido', defStagger:0, defInDur:1.6, fx:C=>({clip:C.st, clipDir:'center', alpha:1}) },
  { id:'fadeSlide', family:'Minimal Moderno', name:'Fundido deslizante', defStagger:30, fx:C=>({dx:(1-C.e)*-40, alpha:C.e}) },
  { id:'scaleSoft', family:'Minimal Moderno', name:'Escala suave', defStagger:35, fx:C=>({scX:0.96+0.04*C.e, scY:0.96+0.04*C.e, alpha:C.e}) },
  { id:'trackingIn', family:'Minimal Moderno', name:'Tracking de entrada', defStagger:25, fx:C=>({extra:(1-C.e)*40, alpha:C.e}) },
  { id:'blurReveal2', family:'Minimal Moderno', name:'Revelado con blur', defStagger:25, fx:C=>({blur:(1-C.e)*12, alpha:C.e}) },
  { id:'riseFade', family:'Minimal Moderno', name:'Ascenso y fundido', defStagger:30, fx:C=>({dy:(1-C.e)*36, alpha:C.e}) },

  { id:'tiltIn', family:'3D Profundo', name:'Inclinacion 3D', defStagger:25, fx:C=>({rot:(1-C.e)*-35, scY:0.8+0.2*C.e, blur:(1-C.e)*5, alpha:C.e}) },
  { id:'rotateY3D', family:'3D Profundo', name:'Rotacion Y', defStagger:30, fx:C=>({scX:Math.cos((1-C.e)*Math.PI), alpha:1}) },
  { id:'depthField', family:'3D Profundo', name:'Campo de profundidad', defStagger:20, fx:C=>({scX:0.6+0.4*C.e*hash(C.i), scY:0.6+0.4*C.e*hash(C.i), blur:(1-C.e)*10*hash(C.i), alpha:Math.min(1,C.e*2)}) },
  { id:'perspScale', family:'3D Profundo', name:'Escala en perspectiva', defStagger:30, fx:C=>({scX:1.4-0.4*C.e, scY:1.4-0.4*C.e, dy:(1-C.e)*40, blur:(1-C.e)*6, alpha:C.e}) },
  { id:'orbit3D', family:'3D Profundo', name:'Orbita 3D', defStagger:0, params:[{key:'speed',label:'Velocidad',min:1,max:10,step:1,def:3}], fx:(C,P)=>({scX:Math.cos(C.t*P.speed+C.i*0.5), rot:Math.sin(C.t*P.speed+C.i*0.5)*10, alpha:Math.min(1,C.e*2)}) },
  { id:'flyThrough', family:'3D Profundo', name:'Vuelo a traves', defStagger:25, fx:C=>({scX:0.1+0.9*C.st, scY:0.1+0.9*C.st, blur:(1-C.st)*20, alpha:Math.min(1,C.st*2)}) },
  { id:'carousel', family:'3D Profundo', name:'Carrusel', defStagger:0, params:[{key:'speed',label:'Velocidad',min:1,max:10,step:1,def:3}], fx:(C,P)=>({dx:Math.sin(C.t*P.speed+C.i*0.6)*220, scX:Math.cos(C.t*P.speed+C.i*0.6), alpha:Math.min(1,C.e*2)}) },
  { id:'zoomBounce', family:'3D Profundo', name:'Zoom con rebote', defStagger:35, defEasing:'elastic', fx:C=>({scX:0.4+0.6*C.e, scY:0.4+0.6*C.e, alpha:Math.min(1,C.e*2)}) },
  { id:'parallaxLoop', family:'3D Profundo', name:'Paralaje continuo', defStagger:0, params:[{key:'speed',label:'Velocidad',min:1,max:10,step:1,def:3}], fx:(C,P)=>({dx:Math.sin(C.t*P.speed+C.i)*12, scX:1+Math.sin(C.t*P.speed+C.i)*0.05, scY:1+Math.sin(C.t*P.speed+C.i)*0.05, alpha:1}) },
  { id:'cubeRoll', family:'3D Profundo', name:'Rueda de cubo', defStagger:30, fx:C=>({scY:Math.sin(C.st*Math.PI), dy:(1-C.st)*30, alpha:Math.min(1,C.st*2)}) },

  { id:'letterFall', family:'Letras Objeto', name:'Caida de letras', defStagger:35, fx:C=>({dy:(1-C.st)*-90, alpha:Math.min(1,C.st*2)}) },
  { id:'letterRise', family:'Letras Objeto', name:'Ascenso de letras', defStagger:35, fx:C=>({dy:(1-C.st)*40, alpha:C.st}) },
  { id:'letterShuffle', family:'Letras Objeto', name:'Barajado', defStagger:40, params:[{key:'power',label:'Dispersion',min:20,max:120,step:10,def:60}], fx:(C,P)=>({dx:(hash(C.i)-0.5)*2*P.power*(1-C.st), dy:(hash(C.i+4)-0.5)*2*P.power*(1-C.st), alpha:Math.min(1,C.st*2)}) },
  { id:'letterWobbleIn', family:'Letras Objeto', name:'Vaiven de entrada', defStagger:30, fx:C=>({rot:(1-C.st)*30*Math.sin(C.i), alpha:Math.min(1,C.st*2)}) },
  { id:'letterScaleCascade', family:'Letras Objeto', name:'Cascada de escala', defStagger:45, fx:C=>({scX:1.4-0.4*C.st, scY:1.4-0.4*C.st, dy:(1-C.st)*10, alpha:Math.min(1,C.st*2)}) },
  { id:'letterBlurIn', family:'Letras Objeto', name:'Blur por letra', defStagger:30, fx:C=>({blur:(1-C.st)*14, alpha:Math.min(1,C.st*2)}) },
  { id:'letterFlip', family:'Letras Objeto', name:'Volteo por letra', defStagger:30, fx:C=>({scX:Math.cos((1-C.st)*Math.PI/2), alpha:1}) },
  { id:'letterSwing', family:'Letras Objeto', name:'Balanceo por letra', defStagger:40, fx:C=>({rot:Math.sin(C.st*Math.PI)*40*(1-C.st*0.5), alpha:Math.min(1,C.st*2)}) },
  { id:'letterPulse', family:'Letras Objeto', name:'Pulso por letra', defStagger:0, params:[{key:'speed',label:'Velocidad',min:1,max:10,step:1,def:4}], fx:(C,P)=>({scX:1+Math.sin(C.t*P.speed+C.i*0.5)*0.08, scY:1+Math.sin(C.t*P.speed+C.i*0.5)*0.08, alpha:1}) },
  { id:'letterHop', family:'Letras Objeto', name:'Brinco por letra', defStagger:45, fx:C=>({dy:-Math.abs(Math.sin(C.st*Math.PI))*30, alpha:Math.min(1,C.st*2)}) },

  { id:'explosion2', family:'Espectaculares', name:'Explosion doble', defStagger:0, params:[{key:'power',label:'Potencia',min:50,max:400,step:10,def:240}], fx:(C,P)=>{ const a=hash(C.i)*Math.PI*2; const d=(1-C.e)*P.power; return {dx:Math.cos(a)*d, dy:Math.sin(a)*d, rot:(1-C.e)*hash(C.i+9)*180, dupes:[{dx:Math.cos(a)*d*0.6,dy:Math.sin(a)*d*0.6,color:'#ffffff',alpha:0.4,gco:'screen'}], alpha:Math.min(1,C.e*2)}; } },
  { id:'shockwave', family:'Espectaculares', name:'Onda expansiva', defStagger:0, fx:C=>({scX:2.2-1.2*C.e, scY:2.2-1.2*C.e, blur:(1-C.e)*12, alpha:Math.min(1,C.e*1.5)}) },
  { id:'trailBlur', family:'Espectaculares', name:'Estela con blur', defStagger:25, params:[{key:'len',label:'Longitud',min:1,max:6,step:1,def:3},{key:'spread',label:'Distancia',min:5,max:40,step:1,def:18}], fx:(C,P)=>{ const dupes=[]; for(let k=1;k<=P.len;k++)dupes.push({dx:-k*P.spread*(1-C.e*0.4), alpha:0.3/k}); return {dupes, alpha:C.e}; } },
  { id:'neonFlicker', family:'Espectaculares', name:'Neon parpadeante', defStagger:0, params:[{key:'speed',label:'Velocidad',min:2,max:20,step:1,def:10}], fx:(C,P)=>({shadow:C.state.stroke, shadowBlur:20*(Math.sin(C.t*P.speed+C.i)>0?1:0.3), alpha:1}) },
  { id:'hologram', family:'Espectaculares', name:'Holograma', defStagger:0, params:[{key:'speed',label:'Velocidad',min:2,max:12,step:1,def:6}], fx:(C,P)=>({dupes:[{dx:-3,color:'#00ffff',alpha:0.5,gco:'screen'},{dx:3,color:'#ff00ff',alpha:0.5,gco:'screen'}], skew:Math.sin(C.t*P.speed+C.i*0.5)*0.08, alpha:0.9}) },
  { id:'fireRise', family:'Espectaculares', name:'Ascenso de fuego', defStagger:30, fx:C=>({dy:(1-C.st)*-120, fill:'hsl('+(15+Math.sin(C.t*9+C.i)*10)+',90%,55%)', blur:(1-C.st)*8, dupes:[{dx:0,dy:10,color:'#ff6600',alpha:0.35,gco:'screen'}], alpha:Math.min(1,C.st*2)}) },
  { id:'electric', family:'Espectaculares', name:'Electrico', defStagger:0, params:[{key:'speed',label:'Velocidad',min:5,max:30,step:1,def:18}], fx:(C,P)=>({dx:(hash(C.i+Math.floor(C.t*P.speed))-0.5)*10*(1-C.e+0.3), dupes:[{dx:-4,color:'#00e5ff',alpha:0.5,gco:'screen'}], alpha:1}) },
  { id:'glitch2', family:'Espectaculares', name:'Glitch de bloques', defStagger:0, params:[{key:'speed',label:'Velocidad',min:5,max:25,step:1,def:12}], fx:(C,P)=>({dx:Math.floor(hash(C.i+Math.floor(C.t*P.speed))*5-2)*8*(1-C.e+0.3), alpha:1}) },
  { id:'confetti2', family:'Espectaculares', name:'Confeti', defStagger:0, params:[{key:'speed',label:'Velocidad',min:1,max:10,step:1,def:4}], fx:(C,P)=>{ const dupes=[]; const cols=['#ff4200','#00b4ff','#2ecc40']; for(let k=0;k<3;k++){ const a=hash(C.i+k*7)*Math.PI*2; const r=20+hash(C.i+k*3)*60; dupes.push({dx:Math.cos(a)*r+Math.sin(C.t*P.speed+k)*8, dy:Math.sin(a)*r+Math.cos(C.t*P.speed+k)*8, color:cols[k], alpha:0.7, gco:'screen'}); } return {dupes, alpha:1}; } },
  { id:'laserIn', family:'Espectaculares', name:'Laser', defStagger:25, fx:C=>({dx:(1-C.e)*300, blur:(1-C.e)*6, dupes:[{dx:-(1-C.e)*40,color:C.state.stroke,alpha:0.6,gco:'screen'}], alpha:C.e}) }
];
const PRESET_BY_ID={};
PRESETS.forEach(p=>PRESET_BY_ID[p.id]=p);

const DEFAULT_STATE={
  text:"FREE ANIMATION\nPOWER",
  font:"Archivo Black",
  weight:700,
  italic:false,
  size:150,
  letterSpace:0,
  lineH:1.2,
  align:"center",
  mode:"fill",
  restoreMode:null,
  fill:"#070706",
  stroke:"#ffdc00",
  strokeW:3,
  bgOn:true,
  bg:"#ffffff",
  preset:"fade",
  presetParams:{},
  easing:"easeOut",
  inDur:1.0,
  stagger:40,
  outOn:false,
  outDur:1.0,
  outPreset:'mirror',
  loop:true,
  duration:3,
  opacity:100,
  rotation:0,
  scale:100,
  blur:0,
  mbOn:false,
  mb:6,
  shOn:false,
  shColor:"#000000",
  shBlur:16,
  time:0,
  playing:false,
  kf:defaultKf(),
  letters:{},
  v:3
};
let state=Object.assign({},DEFAULT_STATE,{presetParams:{},kf:defaultKf(),letters:{}});

const loadedFonts=new Set();
function preloadAllFonts(){
  const all=[];
  Object.keys(FONT_ALL).forEach(g=>{
    FONT_ALL[g].forEach(f=>{ all.push(f); loadedFonts.add(f); });
  });
  for(let i=0;i<all.length;i+=10){
    const chunk=all.slice(i,i+10);
    const q=chunk.map(f=>'family='+encodeURIComponent(f).replace(/%20/g,'+')+':wght@400;700;900').join('&');
    const link=document.createElement('link');
    link.rel='stylesheet';
    link.href='https://fonts.googleapis.com/css2?'+q+'&display=swap';
    document.head.appendChild(link);
  }
}
function loadFont(name){
  if(!name||loadedFonts.has(name))return Promise.resolve();
  loadedFonts.add(name);
  const link=document.createElement('link');
  link.rel='stylesheet';
  link.href='https://fonts.googleapis.com/css2?family='+encodeURIComponent(name).replace(/%20/g,'+')+':ital,wght@0,400;0,700;0,900;1,400;1,700&display=swap';
  document.head.appendChild(link);
  return document.fonts.load('700 100px "'+name+'"').then(()=>document.fonts.load('400 100px "'+name+'"')).catch(()=>{});
}

function paramDefaults(preset){
  const o={};
  (preset.params||[]).forEach(p=>o[p.key]=p.def);
  return o;
}

let lastLayout=[];
function render(ctx,t,forceBg){
  const S=state;
  lastLayout=[];
  const size=kfValue(S.kf.size,t,S.size);
  const letterSpace=kfValue(S.kf.letterSpace,t,S.letterSpace);
  const lineH=(kfValue(S.kf.lineH,t,S.lineH*10))/10;
  const opacity=kfValue(S.kf.opacity,t,S.opacity);
  const rotation=kfValue(S.kf.rotation,t,S.rotation);
  const scale=kfValue(S.kf.scale,t,S.scale);
  ctx.clearRect(0,0,W,H);
  const showBg=forceBg!==undefined?forceBg:S.bgOn;
  if(showBg){ ctx.fillStyle=S.bg; ctx.fillRect(0,0,W,H); }
  const preset=PRESET_BY_ID[S.preset]||PRESETS[0];
  const P=Object.assign({},paramDefaults(preset),S.presetParams[S.preset]||{});
  const outPresetId=S.outPreset||'mirror';
  const presetOut=outPresetId==='mirror'?preset:(PRESET_BY_ID[outPresetId]||preset);
  const POut=outPresetId==='mirror'?P:Object.assign({},paramDefaults(presetOut),S.presetParams[outPresetId]||{});
  const inDur=S.inDur, outDur=S.outOn?S.outDur:0;
  const holdStart=inDur, holdEnd=Math.max(inDur,S.duration-outDur);
  let phase='hold', p=1;
  if(t<holdStart){ phase='in'; p=t/inDur; }
  else if(t>holdEnd&&S.outOn){ phase='out'; p=(t-holdEnd)/outDur; }
  p=clamp(p,0,1);
  const pr=phase==='out'?presetOut:preset;
  const Pp=phase==='out'?POut:P;
  const durPhase=phase==='out'?outDur:inDur;
  ctx.font=(S.italic?'italic ':'')+S.weight+' '+size+'px "'+S.font+'", sans-serif';
  ctx.textBaseline='middle';
  const lines=S.text.split('\n');
  let maxLineW=0;
  lines.forEach(line=>{
    const w=line.split('').reduce((a,c)=>a+ctx.measureText(c).width,0)+Math.max(0,line.length-1)*letterSpace;
    if(w>maxLineW)maxLineW=w;
  });
  const fit=Math.min(1,(W-160)/Math.max(1,maxLineW),(H-120)/Math.max(1,lines.length*size*lineH));
  const sizeF=Math.max(10,size*fit);
  ctx.font=(S.italic?'italic ':'')+S.weight+' '+sizeF+'px "'+S.font+'", sans-serif';
  const lineHeight=sizeF*lineH;
  const totalH=lines.length*lineHeight;
  const startY=H/2-totalH/2+lineHeight/2;
  const charsFlat=S.text.replace(/\n/g,'').split('');
  const totalChars=charsFlat.length;
  let wordIdx=-1, prevSpace=true;
  const charWord=[];
  charsFlat.forEach(ch=>{
    if(ch===' '){ prevSpace=true; charWord.push(wordIdx); }
    else { if(prevSpace){ wordIdx++; prevSpace=false; } charWord.push(wordIdx); }
  });
  const wordTotal=wordIdx+1;
  ctx.save();
  ctx.translate(W/2,H/2);
  ctx.rotate(rotation*Math.PI/180);
  ctx.scale(scale/100,scale/100);
  ctx.translate(-W/2,-H/2);
  ctx.globalAlpha=opacity/100;
  let charIdx=0;
  const positions=[];
  let charIdxBase=0;
  lines.forEach((line,li)=>{
    const chars=line.split('');
    const widths=chars.map((c,ci2)=>{
      const Lf=S.letters[charIdxBase+ci2];
      if(Lf&&Lf.font){
        ctx.save();
        ctx.font=(S.italic?'italic ':'')+(Lf.weight||S.weight)+' '+sizeF+'px "'+Lf.font+'", sans-serif';
        const w=ctx.measureText(c).width;
        ctx.restore();
        return w;
      }
      return ctx.measureText(c).width;
    });
    const totalW=widths.reduce((a,b)=>a+b,0)+Math.max(0,chars.length-1)*letterSpace;
    let lineX=S.align==='left'?80:(S.align==='right'?W-80-totalW:W/2-totalW/2);
    const y=startY+li*lineHeight;
    let x=lineX;
    let grad=null;
    if(pr.gradient){
      const span=totalW+800;
      const off=(t*Pp.speed)%span-400;
      grad=ctx.createLinearGradient(lineX+off,0,lineX+off+span,0);
      grad.addColorStop(0,S.fill);
      grad.addColorStop(0.5,S.stroke);
      grad.addColorStop(1,S.fill);
    }
    chars.forEach((ch,ci)=>{
      positions.push({x,y});
      const li={idx:charIdx,x,y,w:widths[ci],h:sizeF};
      lastLayout.push(li);
      const wIdx=charWord[charIdx];
      const unit=pr.unit==='word'?'word':'char';
      const idx=unit==='word'?Math.max(0,wIdx):charIdx;
      const total=unit==='word'?Math.max(1,wordTotal):totalChars;
      const delay=idx*S.stagger/1000;
      let st=(p*durPhase-delay)/Math.max(0.05,durPhase-(total-1)*S.stagger/1000);
      st=clamp(st,0,1);
      const e=(EASE[S.easing]||EASE.easeOut)(st);
      const C={ch,i:charIdx,word:Math.max(0,wIdx),charW:widths[ci],totalW,lineIdx:li,W,H,t,e,st,p:(phase==='out'&&outPresetId==='mirror')?(1-p):p,totalChars,state:S};
      const T=pr.fx(C,Pp)||{};
      const L=S.letters[charIdx];
      if(L){
        if(L.fill)T.fill=L.fill;
        if(L.size){ T.scX=(T.scX||1)*L.size; T.scY=(T.scY||1)*L.size; }
        if(L.rot)T.rot=(T.rot||0)+L.rot;
        if(L.dx)T.dx=(T.dx||0)+L.dx;
        if(L.dy)T.dy=(T.dy||0)+L.dy;
      }
      ctx.save();
      const cx=x+widths[ci]/2+(T.dx||0)+(T.kern||0)*(ci-chars.length/2);
      const cy=y+(T.dy||0);
      li.mx=cx; li.my=cy; li.rot=T.rot||0; li.sx=T.scX||1; li.sy=T.scY||1;
      ctx.translate(cx,cy);
      ctx.rotate((T.rot||0)*Math.PI/180);
      ctx.scale(T.scX||1,T.scY||1);
      if(T.skew)ctx.transform(1,0,T.skew,1,0,0);
      ctx.globalAlpha*=T.alpha!=null?T.alpha:1;
      let bl=S.blur+(T.blur||0);
      if(S.mbOn&&phase!=='hold'&&st>0&&st<1)bl+=(1-e)*S.mb;
      if(bl>0)ctx.filter='blur('+bl+'px)';
      if(S.shOn){ ctx.shadowColor=S.shColor; ctx.shadowBlur=S.shBlur; ctx.shadowOffsetX=0; ctx.shadowOffsetY=4; }
      if(T.shadow!=null){ ctx.shadowColor=T.shadow; ctx.shadowBlur=T.shadowBlur||12; }
      const fill=T.fill||grad||S.fill;
      const stroke=T.stroke||S.stroke;
      const strokeW=T.strokeW!=null?T.strokeW:S.strokeW;
      if(T.clip!=null){
        const fw=widths[ci];
        const cl=clamp(T.clip,0,1);
        ctx.beginPath();
        if(T.clipDir==='rl'){ ctx.rect(fw/2-fw*cl,-sizeF,fw*cl,sizeF*2); }
        else if(T.clipDir==='tb'){ ctx.rect(-fw/2,-sizeF,fw,sizeF*2*cl); }
        else if(T.clipDir==='bt'){ ctx.rect(-fw/2,sizeF-sizeF*2*cl,fw,sizeF*2*cl); }
        else if(T.clipDir==='center'){ ctx.rect(-fw*cl/2,-sizeF*cl,fw*cl,sizeF*2*cl); }
        else { ctx.rect(-fw/2,-sizeF,fw*cl,sizeF*2); }
        ctx.clip();
      }
      const gx=-widths[ci]/2, gy=0;
      const dc=T.char!=null?T.char:ch;
      if(L&&L.font){
        ctx.font=(S.italic?'italic ':'')+(L.weight||S.weight)+' '+sizeF+'px "'+L.font+'", sans-serif';
      }
      if(S.mode==='fill'||S.mode==='both'){ ctx.fillStyle=fill; ctx.fillText(dc,gx,gy); }
      if(S.mode==='stroke'||S.mode==='both'){ ctx.strokeStyle=stroke; ctx.lineWidth=strokeW; ctx.lineJoin='round'; ctx.strokeText(dc,gx,gy); }
      if(T.dupes){
        T.dupes.forEach(d=>{
          ctx.save();
          if(d.gco)ctx.globalCompositeOperation=d.gco;
          ctx.translate(d.dx||0,d.dy||0);
          ctx.globalAlpha*=d.alpha!=null?d.alpha:1;
          const df=d.color||fill;
          if(S.mode==='fill'||S.mode==='both'){ ctx.fillStyle=df; ctx.fillText(dc,gx,gy); }
          if(S.mode==='stroke'||S.mode==='both'){ ctx.strokeStyle=df; ctx.lineWidth=strokeW; ctx.strokeText(dc,gx,gy); }
          ctx.restore();
        });
      }
      ctx.restore();
      x+=widths[ci]+letterSpace+(T.extra||0);
      charIdx++;
    });
    charIdxBase+=chars.length;
  });
  if(pr.id==='typewriter'&&phase==='in'&&totalChars>0){
    const vis=Math.min(totalChars-1,Math.ceil(p*totalChars));
    const cur=positions[vis];
    if(cur&&Math.floor(t*2)%2===0){
      ctx.fillStyle=S.fill;
      ctx.fillRect(cur.x-2,cur.y-sizeF*0.4,4,sizeF*0.8);
    }
  }
  ctx.restore();
}

function drawSelection(ctx){
  if(selLetter==null)return;
  const it=lastLayout.find(v=>v.idx===selLetter);
  if(!it)return;
  const pad=6;
  ctx.save();
  ctx.translate(it.mx,it.my);
  ctx.rotate((it.rot||0)*Math.PI/180);
  ctx.scale(it.sx||1,it.sy||1);
  ctx.lineWidth=2;
  ctx.strokeStyle='#ff4200';
  ctx.setLineDash([6,4]);
  ctx.strokeRect(-it.w/2-pad,-it.h/2-pad,it.w+pad*2,it.h+pad*2);
  ctx.restore();
  const a=(it.rot||0)*Math.PI/180;
  const c=Math.cos(a), s=Math.sin(a);
  const ex=it.w/2+pad+12, ey=it.h/2+pad+12;
  const hx=it.mx+(ex*c-ey*s)*(it.sx||1);
  const hy=it.my+(ex*s+ey*c)*(it.sy||1);
  ctx.lineWidth=2;
  ctx.strokeStyle='#ff4200';
  ctx.fillStyle='#ffffff';
  ctx.setLineDash([]);
  ctx.beginPath();
  ctx.arc(hx,hy,7,0,Math.PI*2);
  ctx.fill();
  ctx.stroke();
  lastHandle={x:hx,y:hy};
}

const preview=$('preview');
const pctx=preview.getContext('2d');
let lastTime=0;
function loop(now){
  if(state.playing){
    const dt=(now-lastTime)/1000;
    state.time+=dt;
    if(state.time>=state.duration){
      state.time=state.loop?0:state.duration;
      state.playing=state.loop;
      syncPlayIcon();
    }
  }
  lastTime=now;
  render(pctx,state.time);
  drawSelection(pctx);
  updateTimeline();
  requestAnimationFrame(loop);
}

function updateTimeline(){
  const pct=clamp(state.time/state.duration,0,1)*100;
  $('tlHead').style.left='calc('+pct+'% - 2px)';
  $('tlFill').style.width=pct+'%';
  $('tlTime').textContent=state.time.toFixed(2)+' / '+state.duration.toFixed(2);
}
function syncPlayIcon(){
  $('iconPlay').style.display=state.playing?'none':'block';
  $('iconPause').style.display=state.playing?'block':'none';
}
function buildTicks(){
  const el=$('tlTicks');
  const d=state.duration;
  el.innerHTML='';
  let step=1;
  if(d>16)step=5;
  else if(d>8)step=2;
  else if(d<2)step=0.5;
  const n=Math.floor(d/step);
  for(let i=0;i<=n;i++){
    const s=document.createElement('span');
    s.dataset.t=(i*step)+'s';
    s.style.flex='0 0 '+((step/d)*100)+'%';
    s.style.overflow='hidden';
    el.appendChild(s);
  }
}

function wirePills(id,key,attr,parse){
  $(id).querySelectorAll('button').forEach(b=>{
    b.addEventListener('click',()=>{
      $(id).querySelectorAll('button').forEach(x=>x.classList.remove('active'));
      b.classList.add('active');
      state[key]=parse?parse(b.dataset[attr]):b.dataset[attr];
      saveLS();
    });
  });
}
function wireRange(id,key,suffix,scale,onDone){
  const el=$(id), val=$(id+'Val');
  const kfProp=KF_PROPS.find(p=>p.el===id);
  el.addEventListener('input',()=>{
    const raw=parseFloat(el.value);
    if(kfProp){
      const o=state.kf[kfProp.key];
      if(o&&o.on&&o.keys.length){
        let best=0, bd=1e9;
        o.keys.forEach((k,i)=>{ const d=Math.abs(k.t-state.time); if(d<bd){ bd=d; best=i; } });
        o.keys[best].v=raw;
        buildKfUI();
        saveLS();
        if(val)val.textContent=el.value+(suffix||'');
        return;
      }
    }
    state[key]=raw*(scale||1);
    if(val)val.textContent=el.value+(suffix||'');
    saveLS();
    if(onDone)onDone();
  });
}
function wireSwitch(id,key){
  const el=$(id);
  el.addEventListener('click',()=>{
    state[key]=!state[key];
    el.classList.toggle('on',state[key]);
    saveLS();
  });
}
function setSwitch(id,on){ $(id).classList.toggle('on',on); }
function setPills(id,attr,val){
  $(id).querySelectorAll('button').forEach(b=>b.classList.toggle('active',b.dataset[attr]===String(val)));
}

function buildParamsUI(){
  const wrap=$('presetParams');
  wrap.innerHTML='';
  const preset=PRESET_BY_ID[state.preset];
  if(!preset||!preset.params||!preset.params.length){
    wrap.innerHTML='<p class="hint">Este preset no tiene parametros extra. Usa Timing, Transformacion y Efectos para personalizarlo.</p>';
    return;
  }
  const vals=state.presetParams[state.preset]||{};
  preset.params.forEach(pm=>{
    const field=document.createElement('div');
    field.className='field';
    const lab=document.createElement('label');
    lab.textContent=pm.label;
    const row=document.createElement('div');
    row.className='field-row';
    const rng=document.createElement('input');
    rng.type='range';
    rng.min=pm.min; rng.max=pm.max; rng.step=pm.step;
    rng.value=vals[pm.key]!=null?vals[pm.key]:pm.def;
    const val=document.createElement('span');
    val.className='range-val';
    val.textContent=rng.value;
    rng.addEventListener('input',()=>{
      state.presetParams[state.preset][pm.key]=parseFloat(rng.value);
      val.textContent=rng.value;
      saveLS();
    });
    row.appendChild(rng);
    row.appendChild(val);
    field.appendChild(lab);
    field.appendChild(row);
    wrap.appendChild(field);
  });
}

function selectPreset(id){
  state.preset=id;
  const pr=PRESET_BY_ID[id];
  if(pr.defStagger!=null)state.stagger=pr.defStagger;
  if(pr.defInDur!=null)state.inDur=pr.defInDur;
  if(pr.defEasing)state.easing=pr.defEasing;
  if(pr.forceMode){
    if(state.restoreMode==null)state.restoreMode=state.mode;
    state.mode=pr.forceMode;
  }else if(state.restoreMode!=null){
    state.mode=state.restoreMode;
    state.restoreMode=null;
  }
  if(!state.presetParams[id])state.presetParams[id]={};
  (pr.params||[]).forEach(pm=>{ if(state.presetParams[id][pm.key]===undefined)state.presetParams[id][pm.key]=pm.def; });
  state.time=0;
  syncUI();
  buildParamsUI();
  saveLS();
}

function syncUI(){
  $('txtContent').value=state.text;
  $('fontFamily').value=state.font;
  $('fontSize').value=state.size; $('fontSizeVal').textContent=state.size;
  $('letterSpace').value=state.letterSpace; $('letterSpaceVal').textContent=state.letterSpace;
  $('lineH').value=Math.round(state.lineH*10); $('lineHVal').textContent=state.lineH.toFixed(1);
  $('strokeW').value=state.strokeW; $('strokeWVal').textContent=state.strokeW;
  $('opacity').value=state.opacity; $('opacityVal').textContent=state.opacity+'%';
  $('rotation').value=state.rotation; $('rotationVal').textContent=state.rotation+'Â°';
  $('scale').value=state.scale; $('scaleVal').textContent=state.scale+'%';
  $('blur').value=state.blur; $('blurVal').textContent=state.blur+'px';
  $('stagger').value=state.stagger; $('staggerVal').textContent=state.stagger+'ms';
  $('animIn').value=state.inDur; $('animInVal').textContent=state.inDur.toFixed(1)+'s';
  $('outDur').value=state.outDur; $('outDurVal').textContent=state.outDur.toFixed(1)+'s';
  $('mbStr').value=state.mb; $('mbStrVal').textContent=state.mb;
  $('shBlur').value=state.shBlur; $('shBlurVal').textContent=state.shBlur;
  $('fillColor').value=state.fill;
  $('strokeColor').value=state.stroke;
  $('bgColor').value=state.bg;
  $('shColor').value=state.shColor;
  $('easing').value=state.easing;
  $('outPreset').value=state.outPreset||'mirror';
  $('duration').value=state.duration;
  setPills('weightGroup','w',state.weight);
  setPills('alignGroup','a',state.align);
  setPills('modeGroup','m',state.mode);
  setSwitch('italicSwitch',state.italic);
  setSwitch('bgSwitch',state.bgOn);
  setSwitch('outSwitch',state.outOn);
  setSwitch('loopSwitch',state.loop);
  setSwitch('mbSwitch',state.mbOn);
  setSwitch('shSwitch',state.shOn);
  document.querySelectorAll('.preset').forEach(b=>b.classList.toggle('active',b.dataset.p===state.preset));
  buildTicks();
  syncStaticSliders();
  buildKfUI();
  updateLetterCtrls();
}

function buildPresetList(){
  const wrap=$('presetList');
  wrap.innerHTML='';
  const families={};
  PRESETS.forEach(p=>{
    if(!families[p.family])families[p.family]=[];
    families[p.family].push(p);
  });
  let first=true;
  Object.keys(families).forEach(fam=>{
    const det=document.createElement('details');
    det.className='family';
    if(first){ det.open=true; det.classList.add('first-family'); first=false; }
    const sum=document.createElement('summary');
    sum.textContent=fam+' ('+families[fam].length+')';
    det.appendChild(sum);
    const grid=document.createElement('div');
    grid.className='preset-grid';
    families[fam].forEach(p=>{
      const b=document.createElement('button');
      b.className='preset';
      b.dataset.p=p.id;
      b.textContent=p.name;
      b.addEventListener('click',()=>selectPreset(p.id));
      grid.appendChild(b);
    });
    det.appendChild(grid);
    wrap.appendChild(det);
  });
}

$('presetSearch').addEventListener('input',e=>{
  const q=e.target.value.trim().toLowerCase();
  document.querySelectorAll('details.family').forEach(d=>{
    if(!q){
      d.style.display='';
      d.open=d.classList.contains('first-family');
    }else{
      const hit=[].slice.call(d.querySelectorAll('.preset')).some(b=>b.textContent.toLowerCase().includes(q));
      d.style.display=hit?'':'none';
      if(hit)d.open=true;
    }
  });
});

let kfSel=null;
function buildKfUI(){
  const wrap=$('kfPanel');
  if(!wrap)return;
  wrap.innerHTML='';
  const dur=state.duration||3;
  KF_PROPS.forEach(p=>{
    const o=state.kf[p.key]||(state.kf[p.key]={on:false,keys:[]});
    const row=document.createElement('div');
    row.className='kf-row';
    const head=document.createElement('div');
    head.className='kf-head';
    const lab=document.createElement('label');
    lab.textContent=p.label;
    const sw=document.createElement('div');
    sw.className='switch'+(o.on?' on':'');
    sw.addEventListener('click',()=>{
      o.on=!o.on;
      if(o.on&&!o.keys.length){
        o.keys.push({t:0,v:state[p.key]});
        kfSel={key:p.key,idx:0};
      }
      saveLS();
      syncStaticSliders();
      buildKfUI();
    });
    const x=document.createElement('button');
    x.className='kf-x';
    x.textContent='x';
    x.title='Quitar todos los keyframes de esta propiedad';
    x.addEventListener('click',()=>{
      o.keys=[];
      if(kfSel&&kfSel.key===p.key)kfSel=null;
      saveLS();
      buildKfUI();
    });
    head.appendChild(lab);
    head.appendChild(sw);
    head.appendChild(x);
    const strip=document.createElement('div');
    strip.className='kf-strip';
    strip.addEventListener('click',e=>{
      const r=strip.getBoundingClientRect();
      const t=clamp((e.clientX-r.left)/r.width,0,1)*dur;
      const v=kfValue(o,t,state[p.key]);
      const kf={t,v};
      o.keys.push(kf);
      o.keys.sort((a,b)=>a.t-b.t);
      kfSel={key:p.key,idx:o.keys.indexOf(kf)};
      if(!o.on)o.on=true;
      saveLS();
      syncStaticSliders();
      buildKfUI();
    });
    o.keys.forEach((k,idx)=>{
      const d=document.createElement('div');
      d.className='kf-dot'+(kfSel&&kfSel.key===p.key&&kfSel.idx===idx?' selected':'');
      d.style.left=((k.t/dur)*100)+'%';
      d.addEventListener('pointerdown',ev=>{
        ev.preventDefault();
        ev.stopPropagation();
        kfSel={key:p.key,idx};
        strip.querySelectorAll('.kf-dot').forEach(dd=>dd.classList.remove('selected'));
        d.classList.add('selected');
        try{ d.setPointerCapture(ev.pointerId); }catch(err){}
        const move=me=>{
          const r=strip.getBoundingClientRect();
          k.t=clamp((me.clientX-r.left)/r.width,0,1)*dur;
          o.keys.sort((a,b)=>a.t-b.t);
          d.style.left=((k.t/dur)*100)+'%';
          buildControls();
        };
        const up=()=>{
          d.removeEventListener('pointermove',move);
          d.removeEventListener('pointerup',up);
          saveLS();
        };
        d.addEventListener('pointermove',move);
        d.addEventListener('pointerup',up);
        buildControls();
      });
      strip.appendChild(d);
    });
    const ctrl=document.createElement('div');
    ctrl.className='kf-controls';
    ctrl.style.display='none';
    const buildControls=()=>{
      const sel=(kfSel&&kfSel.key===p.key)?kfSel:null;
      if(!sel||!o.keys[sel.idx]){
        ctrl.style.display='none';
        return;
      }
      ctrl.style.display='flex';
      ctrl.innerHTML='';
      const k=o.keys[sel.idx];
      const rng=document.createElement('input');
      rng.type='range';
      rng.min=p.min; rng.max=p.max; rng.step=p.step;
      rng.value=k.v;
      const val=document.createElement('span');
      val.className='range-val';
      const fmt=v=>(p.key==='lineH'?(Math.round(v)/10).toFixed(1):v)+(p.unit||'');
      val.textContent=fmt(k.v);
      rng.addEventListener('input',()=>{
        k.v=parseFloat(rng.value);
        val.textContent=fmt(k.v);
        saveLS();
      });
      const del=document.createElement('button');
      del.className='kf-del';
      del.textContent='Eliminar';
      del.addEventListener('click',()=>{
        o.keys.splice(sel.idx,1);
        kfSel=null;
        saveLS();
        buildKfUI();
      });
      ctrl.appendChild(rng);
      ctrl.appendChild(val);
      ctrl.appendChild(del);
    };
    row.appendChild(head);
    row.appendChild(strip);
    row.appendChild(ctrl);
    wrap.appendChild(row);
    buildControls();
  });
}
function syncStaticSliders(){
  KF_PROPS.forEach(p=>{
    const lab=$(p.el+'Label');
    if(lab){
      const on=state.kf[p.key]&&state.kf[p.key].on&&state.kf[p.key].keys.length>0;
      lab.innerHTML=on?p.label+' <span class="kf-on" title="Keyframes activos: este slider edita el keyframe mas cercano al cursor. Haz clic aqui para desactivar los keyframes.">keyframes</span>':p.label;
    }
  });
}
document.addEventListener('click',e=>{
  if(e.target&&e.target.classList&&e.target.classList.contains('kf-on')){
    const lab=e.target.parentElement;
    const prop=KF_PROPS.find(p=>lab&&lab.id===p.el+'Label');
    if(prop){
      state.kf[prop.key].on=false;
      saveLS();
      buildKfUI();
      syncStaticSliders();
    }
  }
});

const HISTORY_MAX=50;
let history=[], hIndex=0, hLast=0;
function snapshot(){ return JSON.stringify(state); }
function pushHistory(){
  const now=Date.now();
  const s=snapshot();
  if(hIndex>=0&&history[hIndex]===s)return;
  if(now-hLast<400&&hIndex>0){
    history[hIndex]=s;
    hLast=now;
    return;
  }
  history=history.slice(0,hIndex+1);
  history.push(s);
  if(history.length>HISTORY_MAX)history.shift();
  hIndex=history.length-1;
  hLast=now;
}
function applySnapshot(s){
  try{
    const o=JSON.parse(s);
    Object.assign(state,sanitizeState(o),{playing:false,time:0});
    kfSel=null;
    selLetter=null;
    syncUI();
    buildParamsUI();
    saveLS(true);
  }catch(err){}
}
function undo(){
  if(hIndex>0){
    hIndex--;
    applySnapshot(history[hIndex]);
  }
}
function redo(){
  if(hIndex<history.length-1){
    hIndex++;
    applySnapshot(history[hIndex]);
  }
}
function resetHistory(){
  history=[snapshot()];
  hIndex=0;
  hLast=0;
}

let selLetter=null;
let lastHandle=null;
let dragMode=null;
let dragStart=null;
function updateLetterCtrls(){
  const chars=state.text.replace(/\n/g,'').split('');
  const L=(selLetter!=null&&state.letters[selLetter])||{};
  const ch=selLetter!=null?(chars[selLetter]!=null?chars[selLetter]:''):'';
  $('letterName').textContent=selLetter!=null?('Letra '+(selLetter+1)+' ('+(ch===' '?'espacio':ch)+')'):'Ninguna letra seleccionada';
  $('letterFont').value=L.font||'';
  setSwitch('letterFillSwitch',!!L.fill);
  $('letterColor').value=L.fill||state.fill;
  $('letterSize').value=Math.round((L.size||1)*100);
  $('letterSizeVal').textContent=Math.round((L.size||1)*100)+'%';
  $('letterRot').value=L.rot||0;
  $('letterRotVal').textContent=(L.rot||0)+'Â°';
  $('letterDx').value=L.dx||0;
  $('letterDxVal').textContent=L.dx||0;
  $('letterDy').value=L.dy||0;
  $('letterDyVal').textContent=L.dy||0;
}
function letterSet(key,val){
  if(selLetter==null)return;
  if(!state.letters[selLetter])state.letters[selLetter]={};
  state.letters[selLetter][key]=val;
  saveLS();
  updateLetterCtrls();
}
$('letterFillSwitch').addEventListener('click',()=>{
  if(selLetter==null)return;
  const L=state.letters[selLetter]||(state.letters[selLetter]={});
  if(L.fill){ L.fill=null; } else { L.fill=state.fill; }
  saveLS();
  updateLetterCtrls();
});
$('letterFont').addEventListener('change',e=>{
  if(selLetter==null)return;
  if(!e.target.value){
    if(state.letters[selLetter]){
      delete state.letters[selLetter].font;
      if(!Object.keys(state.letters[selLetter]).length)delete state.letters[selLetter];
    }
  }else{
    letterSet('font',e.target.value);
    return;
  }
  saveLS();
  updateLetterCtrls();
});
$('letterColor').addEventListener('input',e=>{
  if(selLetter==null)return;
  const L=state.letters[selLetter]||(state.letters[selLetter]={});
  L.fill=e.target.value;
  saveLS();
});
$('letterSize').addEventListener('input',e=>{ letterSet('size',parseFloat(e.target.value)/100); });
$('letterRot').addEventListener('input',e=>{ letterSet('rot',parseFloat(e.target.value)); });
$('letterDx').addEventListener('input',e=>{ letterSet('dx',parseFloat(e.target.value)); });
$('letterDy').addEventListener('input',e=>{ letterSet('dy',parseFloat(e.target.value)); });
$('btnLetterReset').addEventListener('click',()=>{
  if(selLetter==null)return;
  delete state.letters[selLetter];
  saveLS();
  updateLetterCtrls();
});
$('btnLettersResetAll').addEventListener('click',()=>{
  state.letters={};
  selLetter=null;
  lastHandle=null;
  saveLS();
  updateLetterCtrls();
});
function canvasPoint(e){
  const rect=preview.getBoundingClientRect();
  return {
    x:(e.clientX-rect.left)*(W/rect.width),
    y:(e.clientY-rect.top)*(H/rect.height)
  };
}
preview.addEventListener('pointerdown',e=>{
  const p=canvasPoint(e);
  if(selLetter!=null&&lastHandle&&Math.hypot(p.x-lastHandle.x,p.y-lastHandle.y)<=16){
    dragMode='resize';
    const it=lastLayout.find(v=>v.idx===selLetter);
    dragStart={p,size:(state.letters[selLetter]&&state.letters[selLetter].size)||1,cx:it?it.mx:p.x,cy:it?it.my:p.y};
    try{ preview.setPointerCapture(e.pointerId); }catch(err){}
    e.preventDefault();
    return;
  }
  let hit=null, bd=1e9;
  lastLayout.forEach(it=>{
    if(p.x>=it.x-8&&p.x<=it.x+it.w+8&&Math.abs(p.y-it.y)<=it.h/2+12){
      const d=Math.hypot(p.x-(it.x+it.w/2),p.y-it.y);
      if(d<bd){ bd=d; hit=it.idx; }
    }
  });
  if(hit!=null){
    selLetter=hit;
    dragMode='move';
    const L=state.letters[hit]||{};
    dragStart={p,dx:L.dx||0,dy:L.dy||0};
    try{ preview.setPointerCapture(e.pointerId); }catch(err){}
  }else{
    selLetter=null;
    lastHandle=null;
  }
  updateLetterCtrls();
});
preview.addEventListener('pointermove',e=>{
  if(!dragMode||selLetter==null)return;
  const p=canvasPoint(e);
  const L=state.letters[selLetter]||(state.letters[selLetter]={});
  if(dragMode==='move'){
    L.dx=Math.round(dragStart.dx+(p.x-dragStart.p.x));
    L.dy=Math.round(dragStart.dy+(p.y-dragStart.p.y));
  }else{
    const c0=Math.max(1,Math.hypot(dragStart.p.x-dragStart.cx,dragStart.p.y-dragStart.cy));
    const c1=Math.hypot(p.x-dragStart.cx,p.y-dragStart.cy);
    L.size=clamp(dragStart.size*c1/c0,0.1,5);
  }
  updateLetterCtrls();
});
preview.addEventListener('pointerup',()=>{
  if(dragMode){ saveLS(); }
  dragMode=null;
});

function saveLS(noHist){
  if(!noHist)pushHistory();
  const o=Object.assign({},state,{playing:false,time:0});
  try{ localStorage.setItem('fap-textmotion',JSON.stringify(o)); }catch(err){}
}
const SAVE_VERSION=3;
function sanitizeState(o){
  o=o||{};
  const out=Object.assign({},DEFAULT_STATE,o);
  out.presetParams=(o.presetParams&&typeof o.presetParams==='object'&&!Array.isArray(o.presetParams))?o.presetParams:{};
  out.kf=defaultKf();
  KF_PROPS.forEach(p=>{
    const src=o.kf&&o.kf[p.key];
    out.kf[p.key]={on:!!(src&&src.on),keys:(src&&Array.isArray(src.keys))?src.keys.slice():[]};
  });
  out.letters=(o.letters&&typeof o.letters==='object'&&!Array.isArray(o.letters))?o.letters:{};
  if(!PRESET_BY_ID[out.preset])out.preset='fade';
  if(out.outPreset!=='mirror'&&!PRESET_BY_ID[out.outPreset])out.outPreset='mirror';
  out.size=clamp(parseFloat(out.size)||150,20,300);
  out.letterSpace=clamp(parseFloat(out.letterSpace)||0,-20,100);
  out.lineH=clamp(parseFloat(out.lineH)||1.2,0.9,2);
  out.opacity=clamp(parseFloat(out.opacity)||100,0,100);
  out.rotation=clamp(parseFloat(out.rotation)||0,-180,180);
  out.scale=clamp(parseFloat(out.scale)||100,10,300);
  out.duration=clamp(parseFloat(out.duration)||3,0.5,20);
  out.inDur=clamp(parseFloat(out.inDur)||1,0.1,3);
  out.outDur=clamp(parseFloat(out.outDur)||1,0.1,3);
  out.stagger=clamp(parseFloat(out.stagger)||40,0,200);
  out.strokeW=clamp(parseFloat(out.strokeW)||3,1,20);
  out.blur=clamp(parseFloat(out.blur)||0,0,30);
  out.mb=clamp(parseFloat(out.mb)||6,1,20);
  out.shBlur=clamp(parseFloat(out.shBlur)||16,0,60);
  out.weight=[400,700,900].indexOf(out.weight)>-1?out.weight:700;
  out.mode=['fill','stroke','both'].indexOf(out.mode)>-1?out.mode:'fill';
  out.align=['left','center','right'].indexOf(out.align)>-1?out.align:'center';
  out.easing=EASE[out.easing]?out.easing:'easeOut';
  if(typeof out.text!=='string')out.text='FREE ANIMATION\nPOWER';
  if(typeof out.font!=='string'||!out.font)out.font='Archivo Black';
  out.playing=false;
  out.time=0;
  return out;
}
function restoreLS(){
  try{
    const raw=localStorage.getItem('fap-textmotion');
    if(!raw)return;
    const o=JSON.parse(raw);
    if(o.v!==SAVE_VERSION){
      localStorage.removeItem('fap-textmotion');
      return;
    }
    Object.assign(state,sanitizeState(o),{playing:false,time:0});
  }catch(err){}
}

$('txtContent').addEventListener('input',e=>{
  state.text=e.target.value;
  saveLS();
  updateLetterCtrls();
});
$('fontFamily').addEventListener('change',e=>{
  state.font=e.target.value;
  loadFont(state.font);
  saveLS();
});
wirePills('weightGroup','weight','w',parseInt);
wirePills('alignGroup','align','a');
wirePills('modeGroup','mode','m');
wireRange('fontSize','size');
wireRange('letterSpace','letterSpace');
wireRange('lineH','lineH','',0.1);
wireRange('strokeW','strokeW');
wireRange('opacity','opacity','%');
wireRange('rotation','rotation','Â°');
wireRange('scale','scale','%');
wireRange('blur','blur','px');
wireRange('stagger','stagger','ms');
wireRange('outDur','outDur');
wireRange('mbStr','mb');
wireRange('shBlur','shBlur');
$('animIn').addEventListener('input',e=>{
  state.inDur=parseFloat(e.target.value);
  $('animInVal').textContent=state.inDur.toFixed(1)+'s';
  saveLS();
});
wireSwitch('italicSwitch','italic');
wireSwitch('bgSwitch','bgOn');
wireSwitch('outSwitch','outOn');
wireSwitch('loopSwitch','loop');
wireSwitch('mbSwitch','mbOn');
wireSwitch('shSwitch','shOn');
$('fillColor').addEventListener('input',e=>{ state.fill=e.target.value; saveLS(); });
$('strokeColor').addEventListener('input',e=>{ state.stroke=e.target.value; saveLS(); });
$('bgColor').addEventListener('input',e=>{ state.bg=e.target.value; saveLS(); });
$('shColor').addEventListener('input',e=>{ state.shColor=e.target.value; saveLS(); });
$('easing').addEventListener('change',e=>{ state.easing=e.target.value; saveLS(); });
$('outPreset').addEventListener('change',e=>{
  state.outPreset=e.target.value;
  if(state.outPreset!=='mirror'){
    if(!state.presetParams[state.outPreset])state.presetParams[state.outPreset]={};
    const pr=PRESET_BY_ID[state.outPreset];
    if(pr)(pr.params||[]).forEach(pm=>{ if(state.presetParams[state.outPreset][pm.key]===undefined)state.presetParams[state.outPreset][pm.key]=pm.def; });
  }
  saveLS();
});
$('duration').addEventListener('input',e=>{
  let v=parseFloat(e.target.value)||3;
  v=Math.max(0.5,Math.min(20,v));
  state.duration=v;
  e.target.value=v;
  buildTicks();
  buildKfUI();
  saveLS();
});
$('btnPlay').addEventListener('click',()=>{
  state.playing=!state.playing;
  syncPlayIcon();
});
$('btnUndo').addEventListener('click',undo);
$('btnRedo').addEventListener('click',redo);
document.addEventListener('keydown',e=>{
  const tag=document.activeElement&&document.activeElement.tagName;
  if((e.ctrlKey||e.metaKey)&&e.key.toLowerCase()==='z'&&tag!=='TEXTAREA'&&tag!=='INPUT'){
    e.preventDefault();
    if(e.shiftKey){ redo(); } else { undo(); }
    return;
  }
  if((e.ctrlKey||e.metaKey)&&e.key.toLowerCase()==='y'&&tag!=='TEXTAREA'&&tag!=='INPUT'){
    e.preventDefault();
    redo();
    return;
  }
  if(e.code==='Space'&&tag!=='TEXTAREA'&&tag!=='INPUT'){
    e.preventDefault();
    state.playing=!state.playing;
    syncPlayIcon();
  }
});
const track=$('tlTrack');
let scrubbing=false;
function scrub(e){
  const r=track.getBoundingClientRect();
  const clientX=e.clientX!=null?e.clientX:(e.touches?e.touches[0].clientX:0);
  const x=clientX-r.left;
  state.time=clamp(x/r.width,0,1)*state.duration;
}
track.addEventListener('mousedown',e=>{ scrubbing=true; scrub(e); });
window.addEventListener('mousemove',e=>{ if(scrubbing)scrub(e); });
window.addEventListener('mouseup',()=>scrubbing=false);
track.addEventListener('touchstart',e=>{ scrubbing=true; scrub(e); });
window.addEventListener('touchmove',e=>{ if(scrubbing)scrub(e); });
window.addEventListener('touchend',()=>scrubbing=false);

$('btnNew').addEventListener('click',()=>{
  if(!confirm('Â¿Crear un proyecto nuevo? Se perderan los cambios no guardados.'))return;
  state=Object.assign({},DEFAULT_STATE,{presetParams:{},kf:defaultKf(),letters:{}});
  localStorage.removeItem('fap-textmotion');
  kfSel=null;
  selLetter=null;
  resetHistory();
  syncUI();
  buildParamsUI();
  loadFont(state.font);
});
$('btnSave').addEventListener('click',()=>{
  const save=Object.assign({},state,{playing:false,time:0});
  const blob=new Blob([JSON.stringify(save,null,2)],{type:'application/json'});
  const a=document.createElement('a');
  a.href=URL.createObjectURL(blob);
  a.download='proyecto.textmotion';
  a.click();
  setTimeout(()=>URL.revokeObjectURL(a.href),1000);
});
$('btnOpen').addEventListener('click',()=>$('fileInput').click());
$('fileInput').addEventListener('change',e=>{
  const f=e.target.files[0];
  if(!f)return;
  const r=new FileReader();
  r.onload=ev=>{
    try{
      const data=JSON.parse(ev.target.result);
      Object.assign(state,sanitizeState(data),{playing:false,time:0});
      syncUI();
      buildParamsUI();
      loadFont(state.font);
      resetHistory();
      saveLS(true);
    }catch(err){ alert('Archivo de proyecto invalido'); }
  };
  r.readAsText(f);
  e.target.value='';
});

let exportFormat='webm';
let exportAlpha=false;
$('btnExport').addEventListener('click',()=>$('exportModal').classList.add('open'));
$('btnCancelExport').addEventListener('click',()=>$('exportModal').classList.remove('open'));
$('formatGroup').querySelectorAll('button').forEach(b=>{
  b.addEventListener('click',()=>{
    $('formatGroup').querySelectorAll('button').forEach(x=>x.classList.remove('active'));
    b.classList.add('active');
    exportFormat=b.dataset.f;
  });
});
$('exportAlphaSwitch').addEventListener('click',function(){
  exportAlpha=!exportAlpha;
  this.classList.toggle('on',exportAlpha);
});
function setBar(v){ $('exportBar').style.width=(v*100)+'%'; }
function download(blob,name){
  const a=document.createElement('a');
  a.href=URL.createObjectURL(blob);
  a.download=name;
  a.click();
  setTimeout(()=>URL.revokeObjectURL(a.href),1000);
}
$('btnDoExport').addEventListener('click',async ()=>{
  const fps=parseInt($('exportFps').value);
  const prog=$('exportProgress');
  prog.classList.add('active');
  setBar(0);
  $('exportMsg').textContent='';
  $('btnDoExport').disabled=true;
  const cv=$('renderCanvas');
  const ctx=cv.getContext('2d');
  const showBg=!exportAlpha;
  try{
    if(exportFormat==='gif'){
      await exportGIF(ctx,fps,showBg);
    }else if(exportFormat==='mov'){
      await exportMOV(ctx,fps,showBg);
    }else{
      await exportVideo(ctx,fps,showBg,exportFormat==='webm'&&exportAlpha);
    }
  }catch(err){
    alert('Fallo la exportacion: '+err.message);
    $('exportMsg').textContent='';
  }
  prog.classList.remove('active');
  $('btnDoExport').disabled=false;
  $('exportModal').classList.remove('open');
});

async function exportVideo(ctx,fps,showBg,wantAlpha){
  const mimes=wantAlpha?['video/webm;codecs=vp9','video/webm']:['video/mp4;codecs=avc1','video/mp4','video/webm;codecs=vp9','video/webm'];
  const mime=mimes.find(m=>MediaRecorder.isTypeSupported(m))||'video/webm';
  const stream=$('renderCanvas').captureStream(fps);
  const rec=new MediaRecorder(stream,{mimeType:mime,videoBitsPerSecond:8000000});
  const chunks=[];
  rec.ondataavailable=e=>chunks.push(e.data);
  const done=new Promise(res=>rec.onstop=res);
  rec.start();
  const frames=Math.max(1,Math.round(state.duration*fps));
  for(let i=0;i<=frames;i++){
    render(ctx,(i/frames)*state.duration,showBg);
    setBar(i/frames);
    await sleep(1000/fps);
  }
  rec.stop();
  await done;
  const ext=mime.indexOf('mp4')>-1?'mp4':'webm';
  download(new Blob(chunks,{type:mime}),'textmotion.'+ext);
}

let ffmpegPromise=null;
let lastMovFrames=0;
function loadScriptWithFallback(paths){
  return new Promise((res,rej)=>{
    let i=0;
    const tryNext=()=>{
      if(i>=paths.length){
        rej(new Error('No se pudo cargar el codificador FFmpeg (revisa que exista la carpeta ffmpeg/ junto al index.php)'));
        return;
      }
      const s=document.createElement('script');
      s.src=paths[i];
      s.onload=res;
      s.onerror=()=>{
        i++;
        s.remove();
        tryNext();
      };
      document.head.appendChild(s);
    };
    tryNext();
  });
}
function ensureFfmpeg(){
  if(!ffmpegPromise){
    ffmpegPromise=(async()=>{
      let base='ffmpeg/';
      try{ base=new URL('ffmpeg/',location.href).href; }catch(err){}
      await loadScriptWithFallback([
        base+'ffmpeg.js',
        'https://cdn.jsdelivr.net/npm/@ffmpeg/ffmpeg@0.12.10/dist/umd/ffmpeg.js',
        'https://unpkg.com/@ffmpeg/ffmpeg@0.12.10/dist/umd/ffmpeg.js'
      ]);
      await loadScriptWithFallback([
        base+'util.js',
        'https://cdn.jsdelivr.net/npm/@ffmpeg/util@0.12.1/dist/umd/index.js',
        'https://unpkg.com/@ffmpeg/util@0.12.1/dist/umd/index.js'
      ]);
      const FF=FFmpegWASM.FFmpeg;
      const ff=new FF();
      const cores=[
        {coreURL:base+'ffmpeg-core.js',wasmURL:base+'ffmpeg-core.wasm'},
        {coreURL:'https://cdn.jsdelivr.net/npm/@ffmpeg/core@0.12.6/dist/umd/ffmpeg-core.js',wasmURL:'https://cdn.jsdelivr.net/npm/@ffmpeg/core@0.12.6/dist/umd/ffmpeg-core.wasm'},
        {coreURL:'https://unpkg.com/@ffmpeg/core@0.12.6/dist/umd/ffmpeg-core.js',wasmURL:'https://unpkg.com/@ffmpeg/core@0.12.6/dist/umd/ffmpeg-core.wasm'}
      ];
      let lastErr=null;
      for(let i=0;i<cores.length;i++){
        try{ await ff.load(cores[i]); lastErr=null; break; }
        catch(err){ lastErr=err; }
      }
      if(lastErr)throw lastErr;
      return ff;
    })();
    ffmpegPromise.catch(()=>{ ffmpegPromise=null; });
  }
  return ffmpegPromise;
}
async function exportMOV(ctx,fps,showBg){
  $('exportMsg').textContent='Cargando codificador MOV (la primera vez descarga ~30 MB)...';
  const ff=await ensureFfmpeg();
  const total=Math.round(state.duration*fps);
  const frames=Math.min(300,total);
  if(total>300)$('exportMsg').textContent='Limitado a 300 fotogramas. Reduce duracion o fps para clips mas largos.';
  for(let i=1;i<=lastMovFrames;i++){
    try{ await ff.deleteFile('frame'+String(i).padStart(4,'0')+'.png'); }catch(err){}
  }
  lastMovFrames=frames;
  $('exportMsg').textContent='Generando '+frames+' fotogramas PNG...';
  for(let i=1;i<=frames;i++){
    render(ctx,(i-1)/fps,showBg);
    const blob=await new Promise(res=>$('renderCanvas').toBlob(res,'image/png'));
    const buf=new Uint8Array(await blob.arrayBuffer());
    await ff.writeFile('frame'+String(i).padStart(4,'0')+'.png',buf);
    setBar(i/frames);
  }
  $('exportMsg').textContent='Codificando MOV (ProRes 4444 con alfa)...';
  try{
    await ff.exec(['-y','-framerate',String(fps),'-i','frame%04d.png','-c:v','prores_ks','-profile:v','4444','-pix_fmt','yuva444p10le','out.mov']);
  }catch(err){
    $('exportMsg').textContent='ProRes no disponible, usando QuickTime Animation (qtrle)...';
    await ff.exec(['-y','-framerate',String(fps),'-i','frame%04d.png','-c:v','qtrle','-pix_fmt','argb','out.mov']);
  }
  const data=await ff.readFile('out.mov');
  $('exportMsg').textContent='';
  download(new Blob([data],{type:'video/quicktime'}),'textmotion.mov');
}

async function exportGIF(ctx,fps,showBg){  const gif=new GifEnc(W,H);
  gif.setDelay(Math.round(1000/fps));
  gif.setRepeat(0);
  gif.setAlpha(!showBg);
  gif.start();
  const frames=Math.max(1,Math.round(state.duration*fps));
  for(let i=0;i<=frames;i++){
    render(ctx,(i/frames)*state.duration,showBg);
    gif.add(ctx);
    setBar(i/frames);
    await sleep(1);
  }
  gif.finish();
  download(new Blob([new Uint8Array(gif.out)],{type:'image/gif'}),'textmotion.gif');
}

function GifEnc(w,h){
  this.w=w; this.h=h; this.out=[]; this.delay=10; this.repeat=0; this.alpha=false;
}
GifEnc.prototype.setDelay=function(ms){ this.delay=Math.round(ms/10); };
GifEnc.prototype.setRepeat=function(r){ this.repeat=r; };
GifEnc.prototype.setAlpha=function(a){ this.alpha=a; };
GifEnc.prototype.ws=function(s){ for(let i=0;i<s.length;i++)this.out.push(s.charCodeAt(i)); };
GifEnc.prototype.wsh=function(v){ this.out.push(v&255,(v>>8)&255); };
GifEnc.prototype.start=function(){
  this.ws("GIF89a");
  this.wsh(this.w); this.wsh(this.h);
  this.out.push(0xF0|7,0,0);
  for(let i=0;i<256;i++)this.out.push(i,i,i);
  this.out.push(0x21,0xFF,11);
  this.ws("NETSCAPE2.0");
  this.out.push(3,1);
  this.wsh(this.repeat);
  this.out.push(0);
};
GifEnc.prototype.add=function(ctx){
  const img=ctx.getImageData(0,0,this.w,this.h).data;
  const n=this.w*this.h;
  const pixels=new Uint8Array(n);
  const palette=[];
  const map=new Map();
  const TR=255;
  for(let i=0;i<n;i++){
    const a=img[i*4+3];
    if(this.alpha&&a<128){ pixels[i]=TR; continue; }
    const r=img[i*4]&0xF8, g=img[i*4+1]&0xFC, b=img[i*4+2]&0xF8;
    const key=(r<<16)|(g<<8)|b;
    let idx=map.get(key);
    if(idx===undefined){
      if(palette.length<255){ idx=palette.length; palette.push([r,g,b]); map.set(key,idx); }
      else{
        let best=0, bd=1e9;
        for(let j=0;j<255;j++){
          const p=palette[j];
          const d=(p[0]-r)*(p[0]-r)+(p[1]-g)*(p[1]-g)+(p[2]-b)*(p[2]-b);
          if(d<bd){ bd=d; best=j; }
        }
        idx=best; map.set(key,idx);
      }
    }
    pixels[i]=idx;
  }
  this.out.push(0x21,0xF9,4);
  this.out.push(this.alpha?9:8);
  this.wsh(this.delay);
  this.out.push(this.alpha?TR:0);
  this.out.push(0);
  this.out.push(0x2C);
  this.wsh(0); this.wsh(0);
  this.wsh(this.w); this.wsh(this.h);
  this.out.push(0x87);
  for(let i=0;i<256;i++){
    const c=palette[i]||[0,0,0];
    this.out.push(c[0],c[1],c[2]);
  }
  this.lzw(pixels);
};
GifEnc.prototype.lzw=function(pixels){
  const minCode=8;
  this.out.push(minCode);
  const clear=1<<minCode, eoi=clear+1;
  let codeSize=minCode+1, dict=new Map(), next=eoi+1;
  let buf=0, bits=0;
  const bytes=[];
  const emit=c=>{
    buf|=c<<bits; bits+=codeSize;
    while(bits>=8){ bytes.push(buf&0xFF); buf>>=8; bits-=8; }
  };
  emit(clear);
  let prev=pixels[0];
  for(let i=1;i<pixels.length;i++){
    const c=pixels[i];
    const key=(prev<<12)|c;
    if(dict.has(key)){ prev=dict.get(key); }
    else{
      emit(prev);
      dict.set(key,next++);
      if(next>(1<<codeSize)&&codeSize<12)codeSize++;
      if(next>=4096){ emit(clear); dict.clear(); next=eoi+1; codeSize=minCode+1; }
      prev=c;
    }
  }
  emit(prev); emit(eoi);
  if(bits>0)bytes.push(buf&0xFF);
  let p=0;
  while(p<bytes.length){
    const len=Math.min(255,bytes.length-p);
    this.out.push(len);
    for(let i=0;i<len;i++)this.out.push(bytes[p+i]);
    p+=len;
  }
  this.out.push(0);
};
GifEnc.prototype.finish=function(){ this.out.push(0x3B); };

function fitCanvas(){
  const wrap=document.querySelector('.canvas-wrap');
  const frame=document.querySelector('.canvas-frame');
  const pad=40;
  const availW=wrap.clientWidth-pad;
  const availH=wrap.clientHeight-pad;
  const scale=Math.min(availW/W,availH/H,1);
  frame.style.width=(W*scale)+'px';
}
window.addEventListener('resize',fitCanvas);

function populateFontSelect(selEl,placeholder){
  if(placeholder){
    const o=document.createElement('option');
    o.value='';
    o.textContent=placeholder;
    selEl.appendChild(o);
  }
  Object.keys(FONT_ALL).forEach(g=>{
    const og=document.createElement('optgroup');
    og.label=g;
    FONT_ALL[g].forEach(f=>{
      const o=document.createElement('option');
      o.value=f;
      o.textContent=f;
      o.style.fontFamily='"'+f+'", sans-serif';
      og.appendChild(o);
    });
    selEl.appendChild(og);
  });
}
(function init(){
  populateFontSelect($('fontFamily'));
  populateFontSelect($('letterFont'),'Fuente global (la del texto)');
  const osel=$('outPreset');
  const om=document.createElement('option');
  om.value='mirror';
  om.textContent='Espejo (invertir la entrada)';
  osel.appendChild(om);
  const fams={};
  PRESETS.forEach(p=>{
    if(!fams[p.family])fams[p.family]=[];
    fams[p.family].push(p);
  });
  Object.keys(fams).forEach(fam=>{
    const og=document.createElement('optgroup');
    og.label=fam;
    fams[fam].forEach(p=>{
      const o=document.createElement('option');
      o.value=p.id;
      o.textContent=p.name;
      og.appendChild(o);
    });
    osel.appendChild(og);
  });
  buildPresetList();
  restoreLS();
  resetHistory();
  buildParamsUI();
  syncUI();
  preloadAllFonts();
  loadFont(state.font);
  setTimeout(fitCanvas,50);
  requestAnimationFrame(loop);
})();
</script>
</body>
</html>
