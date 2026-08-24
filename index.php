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
  <link rel="icon" type="image/png" href="/favicon.png">
  <title>Text Motion &mdash; Estudio de Texto Animado | Free Animation Power</title>
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
    .nav-logo { height:28px; width:auto; }
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
      grid-template-rows:auto 1fr;
      grid-template-columns:290px 1fr 330px;
      grid-template-areas:"nav nav nav" "left stage right";
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
    details.family[open] summary::after { content:"–"; }
    details.family[open] summary { background:var(--yellow4); }
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
      position:fixed; bottom:4px; left:50%; transform:translateX(-50%);
      font-size:0.66rem; color:var(--muted2); font-weight:600; z-index:50;
      pointer-events:none; text-align:center;
    }

    #renderCanvas, #fileInput { display:none; }

    @media (max-width:1100px) {
      body { overflow:auto; }
      .app { grid-template-columns:250px 1fr 290px; height:auto; min-height:100vh; }
    }
    @media (max-width:920px) {
      body { overflow:auto; }
      .app {
        display:flex; flex-direction:column; height:auto; min-height:100vh; gap:10px; padding:80px 10px 10px;
      }
      nav { position:fixed; top:10px; left:10px; right:10px; border-radius:var(--radius-pill); }
      .nav-actions .nav-btn { padding:8px 10px; font-size:0.72rem; }
      .stage { order:1; }
      .stage .canvas-wrap { min-height:260px; }
      .panel-left { order:2; }
      .panel-right { order:3; }
      .panel { max-height:none; }
      .footer-note { display:none; }
    }
  </style>
</head>
<body>

<div class="app">

  <nav>
    <a href="/"><img src="/favicon.png" class="nav-logo" alt="FAP"></a>
    <div class="nav-divider"></div>
    <span class="nav-title">Text Motion</span>
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

    <div class="sec-title">Tipografia</div>
    <div class="field">
      <label>Fuente</label>
      <select id="fontFamily"></select>
    </div>
    <div class="field">
      <label>Fuente personalizada de Google</label>
      <input type="text" id="customFont" placeholder="ej. Rubik Mono One">
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
      <label>Tamaño</label>
      <div class="field-row">
        <input type="range" id="fontSize" min="20" max="300" value="150">
        <span class="range-val" id="fontSizeVal">150</span>
      </div>
    </div>
    <div class="field">
      <label>Espaciado de letras</label>
      <div class="field-row">
        <input type="range" id="letterSpace" min="-20" max="100" value="0">
        <span class="range-val" id="letterSpaceVal">0</span>
      </div>
    </div>
    <div class="field">
      <label>Interlineado</label>
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

    <div class="sec-title">Animacion &mdash; 50 presets</div>
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
      <span>Animar salida (espejo)</span>
      <div class="switch" id="outSwitch"></div>
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
      <label>Opacidad</label>
      <div class="field-row">
        <input type="range" id="opacity" min="0" max="100" value="100">
        <span class="range-val" id="opacityVal">100%</span>
      </div>
    </div>
    <div class="field">
      <label>Rotacion</label>
      <div class="field-row">
        <input type="range" id="rotation" min="-180" max="180" value="0">
        <span class="range-val" id="rotationVal">0°</span>
      </div>
    </div>
    <div class="field">
      <label>Escala</label>
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

</div>

<div class="modal-back" id="exportModal">
  <div class="modal">
    <h2>Exportar animacion</h2>
    <div class="field">
      <label>Formato</label>
      <div class="pills" id="formatGroup">
        <button data-f="webm" class="active">WebM</button>
        <button data-f="mp4">MP4</button>
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
    <p class="hint">WebM y GIF soportan canal alfa real. En MP4 la transparencia se renderiza en negro.</p>
    <div class="progress" id="exportProgress"><div class="progress-bar" id="exportBar"></div></div>
    <div class="modal-actions">
      <button class="nav-btn" id="btnCancelExport">Cancelar</button>
      <button class="nav-btn primary" id="btnDoExport">Renderizar</button>
    </div>
  </div>
</div>

<canvas id="renderCanvas" width="1280" height="720"></canvas>
<input type="file" id="fileInput" accept=".json,.textmotion">
<div class="footer-note">Text Motion &middot; parte del ecosistema Free Animation Power &middot; ESPACIO = reproducir/pausar</div>

<script>
const $=id=>document.getElementById(id);
const W=1280, H=720;
const FONTS=["Archivo Black","Anton","Bebas Neue","Barlow Condensed","Oswald","Montserrat","Poppins","Inter","Space Grotesk","Space Mono","Playfair Display","DM Sans","Work Sans","Abril Fatface","Pacifico","Rubik Mono One"];
const DECODER_CHARS="ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
const MATRIX_CHARS="01アカサタナハマヤラワABCDEF";

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
  { id:'decoder', family:'Maquina', name:'Decodificador', defStagger:30, params:[{key:'speed',label:'Velocidad',min:5,max:40,step:1,def:20}], fx:(C,P)=>{ let ch=C.ch; if(C.st<0.85&&C.st>0&&C.ch!==' '){ ch=DECODER_CHARS[Math.floor(hash(C.i+Math.floor(C.t*P.speed)))%44]; } return {char:ch, alpha:Math.min(1,C.st*3)}; } },
  { id:'glitchWriter', family:'Maquina', name:'Escritura glitch', defStagger:20, params:[{key:'speed',label:'Velocidad',min:5,max:40,step:1,def:20}], fx:(C,P)=>{ let ch=C.ch; const g=C.st<1&&C.st>0&&C.ch!==' '; if(g)ch=DECODER_CHARS[Math.floor(hash(C.i+Math.floor(C.t*P.speed)))%44]; const dx=g?(hash(C.i+C.t*30)-0.5)*8:0; return {char:ch, dx, alpha:Math.min(1,C.st*4)}; } },
  { id:'scramble', family:'Maquina', name:'Mezcla', defStagger:25, fx:C=>{ if(C.ch===' '||C.st>=1)return {alpha:Math.min(1,C.st*3)}; const flat=C.state.text.replace(/\n/g,'').split(''); const j=(C.i+Math.floor((1-C.st)*(C.totalChars-1)*hash(C.i+3)))%C.totalChars; return {char:flat[j]||C.ch, alpha:1}; } },
  { id:'matrixRain', family:'Maquina', name:'Lluvia matrix', defStagger:0, defInDur:2.5, params:[{key:'speed',label:'Velocidad',min:5,max:30,step:1,def:12}], fx:(C,P)=>{ const done=C.st>=1; const ch=done?C.ch:MATRIX_CHARS[Math.floor(hash(C.i*7+Math.floor(C.t*P.speed)))%16]; return {char:ch, dy:(1-C.e)*-60, alpha:Math.min(1,C.e*2)}; } },

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
  { id:'marqueeLoop', family:'Salida y ambient', name:'Marquesina', defStagger:0, defInDur:0.5, defEasing:'linear', params:[{key:'speed',label:'Velocidad',min:50,max:300,step:10,def:120}], fx:(C,P)=>{ const span=C.totalW+400; const off=(C.t*P.speed)%span; return {dx:off, dupes:[{dx:off-span, alpha:1}], alpha:Math.min(1,C.e*2)}; } }
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
  playing:false
};
let state=Object.assign({},DEFAULT_STATE,{presetParams:{}});

const loadedFonts=new Set();
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

function render(ctx,t,forceBg){
  const S=state;
  ctx.clearRect(0,0,W,H);
  const showBg=forceBg!==undefined?forceBg:S.bgOn;
  if(showBg){ ctx.fillStyle=S.bg; ctx.fillRect(0,0,W,H); }
  const preset=PRESET_BY_ID[S.preset]||PRESETS[0];
  const P=Object.assign({},paramDefaults(preset),S.presetParams[S.preset]||{});
  const inDur=S.inDur, outDur=S.outOn?S.outDur:0;
  const holdStart=inDur, holdEnd=Math.max(inDur,S.duration-outDur);
  let phase='hold', p=1;
  if(t<holdStart){ phase='in'; p=t/inDur; }
  else if(t>holdEnd&&S.outOn){ phase='out'; p=1-(t-holdEnd)/outDur; }
  p=clamp(p,0,1);
  ctx.font=(S.italic?'italic ':'')+S.weight+' '+S.size+'px "'+S.font+'", sans-serif';
  ctx.textBaseline='middle';
  const lines=S.text.split('\n');
  const lineH=S.size*S.lineH;
  const totalH=lines.length*lineH;
  const startY=H/2-totalH/2+lineH/2;
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
  ctx.rotate(S.rotation*Math.PI/180);
  ctx.scale(S.scale/100,S.scale/100);
  ctx.translate(-W/2,-H/2);
  ctx.globalAlpha=S.opacity/100;
  let charIdx=0;
  const positions=[];
  lines.forEach((line,li)=>{
    const chars=line.split('');
    const widths=chars.map(c=>ctx.measureText(c).width);
    const totalW=widths.reduce((a,b)=>a+b,0)+Math.max(0,chars.length-1)*S.letterSpace;
    let lineX=S.align==='left'?80:(S.align==='right'?W-80-totalW:W/2-totalW/2);
    const y=startY+li*lineH;
    let x=lineX;
    let grad=null;
    if(preset.gradient){
      const span=totalW+800;
      const off=(t*P.speed)%span-400;
      grad=ctx.createLinearGradient(lineX+off,0,lineX+off+span,0);
      grad.addColorStop(0,S.fill);
      grad.addColorStop(0.5,S.stroke);
      grad.addColorStop(1,S.fill);
    }
    chars.forEach((ch,ci)=>{
      positions.push({x,y});
      const wIdx=charWord[charIdx];
      const unit=preset.unit==='word'?'word':'char';
      const idx=unit==='word'?Math.max(0,wIdx):charIdx;
      const total=unit==='word'?Math.max(1,wordTotal):totalChars;
      const delay=idx*S.stagger/1000;
      let st=(p*inDur-delay)/Math.max(0.05,inDur-(total-1)*S.stagger/1000);
      st=clamp(st,0,1);
      const e=(EASE[S.easing]||EASE.easeOut)(st);
      const C={ch,i:charIdx,word:Math.max(0,wIdx),charW:widths[ci],totalW,lineIdx:li,W,H,t,e,st,p,totalChars,state:S};
      const T=preset.fx(C,P)||{};
      ctx.save();
      const cx=x+(T.dx||0)+(T.kern||0)*(ci-chars.length/2);
      const cy=y+(T.dy||0);
      ctx.translate(cx,cy);
      ctx.rotate((T.rot||0)*Math.PI/180);
      ctx.scale(T.scX||1,T.scY||1);
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
        ctx.beginPath();
        ctx.rect(-widths[ci]/2,-S.size,widths[ci]*clamp(T.clip,0,1),S.size*2);
        ctx.clip();
      }
      const gx=-widths[ci]/2, gy=0;
      const dc=T.char!=null?T.char:ch;
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
      x+=widths[ci]+S.letterSpace+(T.extra||0);
      charIdx++;
    });
  });
  if(preset.id==='typewriter'&&phase==='in'&&totalChars>0){
    const vis=Math.min(totalChars-1,Math.ceil(p*totalChars));
    const cur=positions[vis];
    if(cur&&Math.floor(t*2)%2===0){
      ctx.fillStyle=S.fill;
      ctx.fillRect(cur.x-2,cur.y-S.size*0.4,4,S.size*0.8);
    }
  }
  ctx.restore();
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
  const n=Math.min(20,Math.ceil(state.duration));
  el.innerHTML='';
  for(let i=0;i<n;i++){
    const s=document.createElement('span');
    s.dataset.t=i+'s';
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
  el.addEventListener('input',()=>{
    state[key]=parseFloat(el.value)*(scale||1);
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
  if(pr.forceMode)state.mode=pr.forceMode;
  if(!state.presetParams[id])state.presetParams[id]={};
  pr.params.forEach(pm=>{ if(state.presetParams[id][pm.key]===undefined)state.presetParams[id][pm.key]=pm.def; });
  state.time=0;
  syncUI();
  buildParamsUI();
  saveLS();
}

function syncUI(){
  $('txtContent').value=state.text;
  $('fontFamily').value=state.font;
  $('customFont').value=state.font;
  $('fontSize').value=state.size; $('fontSizeVal').textContent=state.size;
  $('letterSpace').value=state.letterSpace; $('letterSpaceVal').textContent=state.letterSpace;
  $('lineH').value=Math.round(state.lineH*10); $('lineHVal').textContent=state.lineH.toFixed(1);
  $('strokeW').value=state.strokeW; $('strokeWVal').textContent=state.strokeW;
  $('opacity').value=state.opacity; $('opacityVal').textContent=state.opacity+'%';
  $('rotation').value=state.rotation; $('rotationVal').textContent=state.rotation+'°';
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
    if(first){ det.open=true; first=false; }
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

function saveLS(){
  const o=Object.assign({},state,{playing:false,time:0});
  try{ localStorage.setItem('fap-textmotion',JSON.stringify(o)); }catch(err){}
}
function restoreLS(){
  try{
    const raw=localStorage.getItem('fap-textmotion');
    if(!raw)return;
    const o=JSON.parse(raw);
    Object.assign(state,o,{playing:false,time:0});
    if(!state.presetParams)state.presetParams={};
  }catch(err){}
}

$('txtContent').addEventListener('input',e=>{ state.text=e.target.value; saveLS(); });
$('customFont').addEventListener('change',e=>{
  const f=e.target.value.trim();
  if(f){ state.font=f; loadFont(f); saveLS(); }
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
wireRange('rotation','rotation','°');
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
$('duration').addEventListener('input',e=>{
  let v=parseFloat(e.target.value)||3;
  v=Math.max(0.5,Math.min(20,v));
  state.duration=v;
  e.target.value=v;
  buildTicks();
  saveLS();
});
$('btnPlay').addEventListener('click',()=>{
  state.playing=!state.playing;
  syncPlayIcon();
});
document.addEventListener('keydown',e=>{
  if(e.code==='Space'&&document.activeElement.tagName!=='TEXTAREA'&&document.activeElement.tagName!=='INPUT'){
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
  if(!confirm('¿Crear un proyecto nuevo? Se perderan los cambios no guardados.'))return;
  state=Object.assign({},DEFAULT_STATE,{presetParams:{}});
  localStorage.removeItem('fap-textmotion');
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
      Object.assign(state,data,{playing:false,time:0});
      if(!state.presetParams)state.presetParams={};
      syncUI();
      buildParamsUI();
      loadFont(state.font);
      saveLS();
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
  $('btnDoExport').disabled=true;
  const cv=$('renderCanvas');
  const ctx=cv.getContext('2d');
  const showBg=!exportAlpha;
  try{
    if(exportFormat==='gif'){
      await exportGIF(ctx,fps,showBg);
    }else{
      await exportVideo(ctx,fps,showBg,exportFormat==='webm'&&exportAlpha);
    }
  }catch(err){
    alert('Fallo la exportacion: '+err.message);
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

async function exportGIF(ctx,fps,showBg){
  const gif=new GifEnc(W,H);
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

(function init(){
  const sel=$('fontFamily');
  FONTS.forEach(f=>{
    const o=document.createElement('option');
    o.value=f;
    o.textContent=f;
    o.style.fontFamily='"'+f+'", sans-serif';
    sel.appendChild(o);
  });
  buildPresetList();
  restoreLS();
  buildParamsUI();
  syncUI();
  loadFont(state.font);
  setTimeout(fitCanvas,50);
  requestAnimationFrame(loop);
})();
</script>
</body>
</html>
