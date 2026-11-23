<?php
session_start();
require_once 'data_patterns.php';
require_once 'data_symptoms.php';

if (isset($_POST['ajax_match'])) {
    header('Content-Type: application/json');
    $sel    = array_filter((array)($_POST['symptoms'] ?? []));
    $age    = intval($_POST['age'] ?? 0);
    $gender = strtolower(trim($_POST['gender'] ?? ''));
    $results = findDiagnosesBySymptoms(array_values($sel), $age, $gender);
    echo json_encode(['results' => $results, 'count' => count($results)]);
    exit;
}
if (isset($_GET['detail'])) {
    header('Content-Type: application/json');
    $p = getPatternById($_GET['detail']);
    echo $p ? json_encode($p) : json_encode(['error' => 'Not found']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EndoFlow v5.0 — Clinical Decision Support</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=IBM+Plex+Sans:wght@300;400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
/* ═══════════════════════════════════════════════════════
   ENDOFLOW v3.0 — TWO-SCREEN LAYOUT
   Screen 1: Input  (Demographics + Symptoms)
   Screen 2: Results (Full page, results only)
   Design: Medical Editorial — Deep Teal + Amber Gold
═══════════════════════════════════════════════════════ */
:root {
  --teal:        #0d5c63;
  --teal-mid:    #117a83;
  --teal-light:  #1a9faa;
  --teal-pale:   #e8f7f8;
  --gold:        #c9922a;
  --gold-light:  #f0b840;
  --gold-pale:   #fdf6e3;
  --rose:        #c0392b;
  --rose-pale:   #fdf0ee;
  --orange:      #d35400;
  --emerald:     #1a7a4a;
  --emerald-pale:#e8f5ee;
  --slate:       #4a5568;
  --slate-lt:    #8896a7;
  --bg:          #f5f4f0;
  --surface:     #ffffff;
  --surface2:    #f9f8f5;
  --border:      #e2ddd5;
  --text:        #1a1a2e;
  --text-muted:  #5a6070;
  --shadow-sm:   0 1px 4px rgba(0,0,0,.06);
  --shadow-md:   0 4px 20px rgba(0,0,0,.10);
  --shadow-lg:   0 12px 48px rgba(0,0,0,.14);
  --r-sm: 8px; --r-md: 14px; --r-lg: 22px;
  --font-head: 'Playfair Display', Georgia, serif;
  --font-body: 'IBM Plex Sans', system-ui, sans-serif;
  --font-mono: 'IBM Plex Mono', monospace;
  --transition: all .2s cubic-bezier(.4,0,.2,1);
}
[data-theme="dark"] {
  --bg:#0e1117; --surface:#161b24; --surface2:#1e2533;
  --border:#2a3244; --text:#e8eaf0; --text-muted:#8896a7;
  --teal-pale:#0d2d32; --gold-pale:#2a2010;
  --rose-pale:#2a1010; --emerald-pale:#0a1f14;
}
*,*::before,*::after { box-sizing:border-box; margin:0; padding:0; }
body {
  font-family: var(--font-body);
  background: var(--bg); color: var(--text);
  min-height: 100vh; font-size: 14.5px; line-height: 1.6;
  overflow-x: hidden; transition: background .3s, color .3s;
}

/* ── HEADER ── */
.app-header {
  background: var(--teal); color: #fff; height: 64px;
  padding: 0 28px; display: flex; align-items: center;
  justify-content: space-between; position: sticky; top: 0;
  z-index: 200; box-shadow: 0 2px 24px rgba(0,0,0,.2);
}
.header-left { display:flex; align-items:center; gap:14px; }
.brand-icon {
  width:40px; height:40px; background:var(--gold); border-radius:10px;
  display:flex; align-items:center; justify-content:center;
  font-size:18px; color:var(--teal); flex-shrink:0;
}
.brand-name  { font-family:var(--font-head); font-size:1.65rem; letter-spacing:-.3px; line-height:1; }
.brand-sub   { font-size:.68rem; color:rgba(255,255,255,.5); letter-spacing:1.8px; text-transform:uppercase; margin-top:2px; }
.header-right { display:flex; align-items:center; gap:12px; }
.hdr-badge {
  background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15);
  padding:4px 12px; border-radius:20px; font-size:.75rem; color:rgba(255,255,255,.7);
}
.hdr-badge b { color:var(--gold-light); }
.btn-theme {
  background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.2);
  color:#fff; width:36px; height:36px; border-radius:50%; cursor:pointer;
  display:flex; align-items:center; justify-content:center;
  font-size:.9rem; transition:var(--transition);
}
.btn-theme:hover { background:rgba(255,255,255,.2); }

/* ── SCREEN SYSTEM ── */
.screen { display:none; }
.screen.active { display:block; }

/* ═══════════════════════════════════════
   SCREEN 1 — INPUT
═══════════════════════════════════════ */
#screen-input.active {
  display:flex; flex-direction:column; align-items:center;
  padding: 40px 20px 70px; min-height:calc(100vh - 64px);
}

.input-card {
  background: var(--surface); border-radius: var(--r-lg);
  box-shadow: var(--shadow-md); width:100%; max-width:900px;
  overflow:hidden;
}

/* Hero banner */
.inp-hero {
  background: var(--teal); padding:30px 38px; color:#fff;
  position:relative; overflow:hidden;
}
.inp-hero::before {
  content:''; position:absolute; right:-50px; top:-50px;
  width:220px; height:220px; background:rgba(201,146,42,.14); border-radius:50%;
}
.inp-hero::after {
  content:''; position:absolute; right:90px; bottom:-70px;
  width:180px; height:180px; background:rgba(201,146,42,.07); border-radius:50%;
}
.inp-hero-inner { position:relative; z-index:1; display:flex; align-items:center; gap:22px; }
.inp-hero-icon  { font-size:3rem; }
.inp-hero-text h2 { font-family:var(--font-head); font-size:1.75rem; margin-bottom:5px; }
.inp-hero-text p  { color:rgba(255,255,255,.65); font-size:.87rem; max-width:480px; line-height:1.65; }

/* Step indicator */
.steps-bar {
  display:flex; align-items:center; gap:8px;
  padding:14px 38px; background:var(--surface2);
  border-bottom:1px solid var(--border);
}
.stp { display:flex; align-items:center; gap:7px; font-size:.78rem; font-weight:600; color:var(--slate-lt); }
.stp.active { color:var(--teal); }
.stp.done   { color:var(--emerald); }
.stp-num {
  width:22px; height:22px; border-radius:50%;
  background:var(--border); color:var(--slate-lt);
  font-size:.72rem; font-weight:700;
  display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.stp.active .stp-num { background:var(--teal); color:#fff; }
.stp.done   .stp-num { background:var(--emerald); color:#fff; }
.stp-line { flex:1; height:1.5px; background:var(--border); }
.stp-line.done { background:var(--emerald); }

/* Input body */
.inp-body { padding:28px 38px 34px; }
.inp-sec-label {
  font-size:.67rem; letter-spacing:1.8px; text-transform:uppercase;
  color:var(--gold); font-weight:700; margin-bottom:13px;
  display:flex; align-items:center; gap:7px;
  padding-bottom:8px; border-bottom:1px solid var(--border);
}

/* Demographics row */
.demo-row { display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px; margin-bottom:28px; }
.demo-field label { display:block; font-size:.75rem; color:var(--text-muted); font-weight:600; margin-bottom:5px; }
.demo-field input, .demo-field select {
  width:100%; padding:9px 11px; border:1.5px solid var(--border);
  border-radius:var(--r-sm); font-family:var(--font-body); font-size:.88rem;
  color:var(--text); background:var(--surface2); outline:none; transition:border-color .2s, box-shadow .2s;
}
.demo-field input:focus, .demo-field select:focus {
  border-color:var(--teal-light); box-shadow:0 0 0 3px rgba(17,122,131,.1); background:var(--surface);
}

/* Symptom search */
.sym-search { position:relative; margin-bottom:13px; }
.sym-search input {
  width:100%; padding:9px 14px 9px 37px; border:1.5px solid var(--border);
  border-radius:var(--r-sm); font-family:var(--font-body); font-size:.88rem;
  color:var(--text); background:var(--surface2); outline:none; transition:border-color .2s, box-shadow .2s;
}
.sym-search input:focus {
  border-color:var(--teal-light); box-shadow:0 0 0 3px rgba(17,122,131,.1); background:var(--surface);
}
.sym-search .si { position:absolute; left:11px; top:50%; transform:translateY(-50%); color:var(--slate-lt); font-size:.83rem; }

/* Category tabs */
.cat-tabs { display:flex; flex-wrap:wrap; gap:5px; margin-bottom:13px; }
.cat-tab {
  padding:4px 11px; border-radius:20px; border:1.5px solid var(--border);
  background:transparent; font-family:var(--font-body); font-size:.72rem;
  font-weight:500; color:var(--text-muted); cursor:pointer; transition:var(--transition);
}
.cat-tab:hover  { border-color:var(--teal); color:var(--teal); }
.cat-tab.active { background:var(--teal); border-color:var(--teal); color:#fff; }

/* Symptom chip area */
.sym-area { max-height:300px; overflow-y:auto; margin-bottom:4px; }
.cat-group { display:none; }
.cat-group.active { display:block; }
.cat-group-label {
  font-size:.67rem; letter-spacing:1.5px; text-transform:uppercase;
  color:var(--gold); font-weight:700; margin:13px 0 7px;
  display:flex; align-items:center; gap:6px;
}
.chips-wrap { display:flex; flex-wrap:wrap; gap:6px; }
.sym-chip {
  padding:5px 12px; border-radius:20px; border:1.5px solid var(--border);
  background:var(--surface2); font-family:var(--font-body); font-size:.78rem;
  color:var(--text-muted); cursor:pointer; transition:var(--transition); user-select:none;
}
.sym-chip:hover  { border-color:var(--teal); color:var(--teal); background:var(--teal-pale); }
.sym-chip.selected { background:var(--teal); border-color:var(--teal); color:#fff; font-weight:500; }
.sym-chip.hidden   { display:none; }

/* Selected summary + CTA */
.sel-summary {
  margin-top:18px; padding:14px 16px;
  background:var(--teal-pale); border:1.5px solid var(--teal-light);
  border-radius:var(--r-sm); display:flex;
  align-items:flex-start; justify-content:space-between; gap:14px;
}
.sel-left { flex:1; }
.sel-top  { display:flex; align-items:center; gap:9px; margin-bottom:7px; }
.sel-lbl  { font-size:.76rem; font-weight:600; color:var(--teal); }
.count-pill { background:var(--teal); color:#fff; font-size:.72rem; font-weight:700; padding:2px 10px; border-radius:20px; }
.sel-chips  { display:flex; flex-wrap:wrap; gap:4px; min-height:22px; }
.sel-chip {
  background:#fff; border:1px solid var(--teal-light); color:var(--teal);
  font-size:.72rem; padding:3px 10px; border-radius:20px;
  display:flex; align-items:center; gap:4px;
}
.sel-chip button { background:none; border:none; color:var(--teal); cursor:pointer; font-size:.75rem; padding:0; }
.sel-chip button:hover { color:var(--rose); }
.sel-right { display:flex; flex-direction:column; gap:7px; flex-shrink:0; }
.btn-diagnose {
  padding:12px 28px; background:var(--gold); color:var(--teal);
  border:none; border-radius:var(--r-sm); font-family:var(--font-body);
  font-size:.95rem; font-weight:700; cursor:pointer;
  display:flex; align-items:center; gap:8px; transition:var(--transition); white-space:nowrap;
}
.btn-diagnose:hover    { background:var(--gold-light); transform:translateY(-1px); box-shadow:0 4px 16px rgba(201,146,42,.3); }
.btn-diagnose:active   { transform:scale(.98); }
.btn-diagnose:disabled { opacity:.45; cursor:not-allowed; transform:none; box-shadow:none; }
.btn-clear {
  padding:9px 20px; background:transparent; color:var(--text-muted);
  border:1.5px solid var(--border); border-radius:var(--r-sm);
  font-family:var(--font-body); font-size:.82rem; cursor:pointer;
  transition:var(--transition); white-space:nowrap;
}
.btn-clear:hover { border-color:var(--rose); color:var(--rose); }

/* ═══════════════════════════════════════
   SCREEN 2 — RESULTS
═══════════════════════════════════════ */
#screen-results { min-height:calc(100vh - 64px); background:var(--bg); }
#screen-results.active { display:block; animation:fadeInUp .3s ease; }
@keyframes fadeInUp { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }

/* Results top bar */
.res-topbar {
  background:var(--surface); border-bottom:1px solid var(--border);
  padding:13px 36px; display:flex; align-items:center;
  justify-content:space-between; gap:16px;
  position:sticky; top:64px; z-index:100; box-shadow:var(--shadow-sm);
}
.rtb-left  { display:flex; align-items:center; gap:14px; }
.rtb-right { display:flex; align-items:center; gap:10px; flex-shrink:0; }
.btn-back {
  padding:7px 16px; background:transparent; color:var(--text-muted);
  border:1.5px solid var(--border); border-radius:var(--r-sm);
  font-family:var(--font-body); font-size:.82rem; font-weight:600;
  cursor:pointer; display:flex; align-items:center; gap:6px; transition:var(--transition);
}
.btn-back:hover { border-color:var(--teal); color:var(--teal); }
.rtb-title { font-family:var(--font-head); font-size:1.3rem; color:var(--text); }
.rtb-sub   { font-size:.8rem; color:var(--text-muted); margin-top:1px; }
.res-pill  {
  background:var(--gold-pale); color:var(--text); font-size:.8rem; font-weight:700;
  padding:4px 14px; border-radius:20px; border:1px solid var(--gold);
}
.patient-chip {
  background:var(--teal-pale); border:1px solid var(--teal-light);
  color:var(--teal); font-size:.78rem; font-weight:600;
  padding:4px 12px; border-radius:20px;
  display:flex; align-items:center; gap:5px;
}

/* Results main */
.res-main { padding:28px 36px 60px; }

/* Emergency banner */
.emg-banner {
  background:var(--rose-pale); border:2px solid var(--rose);
  border-radius:var(--r-sm); padding:14px 18px;
  display:none; align-items:center; gap:14px; margin-bottom:20px;
  animation:pulse-border 1.5s ease infinite;
}
.emg-banner.show { display:flex; }
@keyframes pulse-border {
  0%,100% { border-color:var(--rose); box-shadow:0 0 0 0 rgba(192,57,43,.2); }
  50%      { border-color:#e74c3c; box-shadow:0 0 0 6px rgba(192,57,43,0); }
}
.emg-icon-sm { font-size:2rem; animation:shake .5s ease infinite; }
@keyframes shake { 0%,100%{transform:rotate(0)} 25%{transform:rotate(-8deg)} 75%{transform:rotate(8deg)} }
.emg-text-sm h4 { color:var(--rose); font-size:.95rem; font-weight:700; margin-bottom:2px; }
.emg-text-sm p  { color:var(--rose); font-size:.82rem; opacity:.85; }

/* Cards grid */
.cards-grid { display:grid; gap:18px; }

/* ── RESULT CARDS (identical to v3.0 working version) ── */
.diag-card {
  background:var(--surface); border:1px solid var(--border);
  border-radius:var(--r-md); overflow:hidden;
  transition:var(--transition); position:relative;
  animation:fadeUp .35s ease both;
}
.diag-card:nth-child(1){animation-delay:.05s}
.diag-card:nth-child(2){animation-delay:.10s}
.diag-card:nth-child(3){animation-delay:.15s}
.diag-card:nth-child(4){animation-delay:.20s}
.diag-card:nth-child(5){animation-delay:.25s}
@keyframes fadeUp { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }
.diag-card:hover { box-shadow:var(--shadow-md); transform:translateY(-2px); }
.diag-card::before { content:''; position:absolute; left:0; top:0; bottom:0; width:4px; }
.diag-card.priority-emergency::before { background:var(--rose); }
.diag-card.priority-high::before      { background:var(--orange); }
.diag-card.priority-medium::before,
.diag-card.priority-moderate::before  { background:#f0a830; }
.diag-card.priority-low::before       { background:var(--emerald); }

.card-head { padding:18px 22px 14px 26px; display:flex; align-items:flex-start; justify-content:space-between; gap:14px; border-bottom:1px solid var(--border); }
.card-title-area { flex:1; }
.card-organ  { font-size:.65rem; letter-spacing:1.5px; text-transform:uppercase; color:var(--gold); font-weight:700; margin-bottom:3px; }
.card-name   { font-family:var(--font-head); font-size:1.2rem; color:var(--text); line-height:1.2; margin-bottom:4px; }
.card-pattern { font-size:.8rem; color:var(--text-muted); display:flex; align-items:center; gap:5px; }
.card-right  { display:flex; flex-direction:column; align-items:flex-end; gap:8px; flex-shrink:0; }

.pri-badge { font-size:.65rem; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; padding:3px 10px; border-radius:20px; }
.pri-emergency { background:#fdecea; color:#c0392b; border:1.5px solid #f4a9a3; }
.pri-high      { background:#fff3ec; color:var(--orange); border:1.5px solid #fdd0b0; }
.pri-medium,
.pri-moderate  { background:#fff4e0; color:#a05c00; border:1.5px solid #f0a830; }
.pri-low       { background:var(--emerald-pale); color:var(--emerald); border:1.5px solid #7ecfa0; }

.ring-wrap  { display:flex; flex-direction:column; align-items:center; gap:2px; }
.ring-svg   { transform:rotate(-90deg); }
.ring-track { fill:none; stroke:var(--border); stroke-width:4; }
.ring-fill  { fill:none; stroke-width:4; stroke-linecap:round; transition:stroke-dashoffset .8s ease; }
.ring-fill.high    { stroke:#1a7a4a; }
.ring-fill.medium  { stroke:var(--gold); }
.ring-fill.low-pct { stroke:var(--slate-lt); }
.ring-label { font-size:.78rem; font-weight:700; color:var(--text); text-align:center; }
.ring-sub   { font-size:.62rem; color:var(--text-muted); text-align:center; }

.conf-badge    { font-size:.68rem; font-weight:700; padding:3px 10px; border-radius:20px; letter-spacing:.5px; }
.conf-High     { background:#fdecea; color:#c0392b; border:1.5px solid #f4a9a3; }
.conf-Moderate { background:#fff4e0; color:#a05c00; border:1.5px solid #f0a830; }
.conf-Low      { background:var(--emerald-pale); color:var(--emerald); border:1.5px solid #7ecfa0; }

.card-body { padding:16px 26px; display:grid; grid-template-columns:1fr 1fr; }
.card-col  { padding:4px 12px 4px 0; }
.card-col:last-child { border-left:1px solid var(--border); padding-left:14px; padding-right:0; }
.col-label { font-size:.67rem; letter-spacing:1.3px; text-transform:uppercase; color:var(--slate-lt); font-weight:600; margin-bottom:9px; display:flex; align-items:center; gap:6px; }
.feat-list { list-style:none; }
.feat-list li { font-size:.83rem; color:var(--text-muted); padding:2px 0 2px 13px; position:relative; line-height:1.45; }
.feat-list li::before { content:'\25B8'; position:absolute; left:0; color:var(--gold); font-size:.72rem; top:4px; }

.lab-pills { display:flex; flex-direction:column; gap:4px; }
.lab-pill  { display:flex; align-items:center; justify-content:space-between; background:var(--surface2); padding:5px 10px; border-radius:6px; font-size:.8rem; }
.lab-test  { color:var(--text-muted); }
.lab-val   { display:flex; align-items:center; gap:5px; }
.lab-num   { font-weight:600; color:var(--text); font-size:.78rem; }
.dir-tag   { font-size:.6rem; font-weight:700; letter-spacing:.5px; padding:1px 5px; border-radius:3px; }
.dir-high     { background:var(--rose-pale); color:var(--rose); }
.dir-low      { background:#eff5ff; color:#1d4ed8; }
.dir-positive { background:var(--rose-pale); color:var(--rose); }
.dir-normal   { background:var(--emerald-pale); color:var(--emerald); }
.dir-negative { background:var(--emerald-pale); color:var(--emerald); }

.card-foot { padding:12px 26px; border-top:1px solid var(--border); background:var(--surface2); display:flex; align-items:flex-start; justify-content:space-between; gap:14px; }
.foot-left { flex:1; }
.foot-sec-label { font-size:.65rem; letter-spacing:1.2px; text-transform:uppercase; color:var(--slate-lt); font-weight:600; margin-bottom:5px; }
.matched-chips { display:flex; flex-wrap:wrap; gap:4px; margin-bottom:8px; }
.mchip { font-size:.7rem; background:rgba(13,92,99,.07); color:var(--text); padding:2px 8px; border-radius:10px; }
.mchip.cardinal { background:var(--gold-pale); color:#7a5200; border:1px solid #f5d98a; font-weight:600; }
.missing-section { margin-top:6px; padding:8px 12px; background:rgba(13,92,99,.05); border-radius:6px; border-left:3px solid var(--teal-light); }
.missing-label { font-size:.65rem; letter-spacing:1px; text-transform:uppercase; color:var(--teal); font-weight:700; margin-bottom:4px; }
.missing-chips { display:flex; flex-wrap:wrap; gap:4px; }
.mschip { font-size:.7rem; background:var(--teal-pale); color:var(--teal); padding:2px 8px; border-radius:10px; border:1px dashed var(--teal-light); }
.ddx-strip { display:flex; flex-wrap:wrap; gap:4px; }
.ddx-tag   { font-size:.72rem; background:var(--surface2); border:1px solid var(--border); color:var(--text-muted); padding:2px 9px; border-radius:20px; }
.foot-btns { display:flex; flex-direction:column; gap:6px; flex-shrink:0; }
.btn-detail { padding:7px 16px; background:var(--teal); color:#fff; border:none; border-radius:7px; font-family:var(--font-body); font-size:.8rem; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:6px; transition:var(--transition); white-space:nowrap; }
.btn-detail:hover { background:var(--teal-mid); }

.empty-state { text-align:center; padding:70px 20px; }
.empty-icon  { font-size:3.5rem; opacity:.2; margin-bottom:14px; }
.empty-state h3 { font-family:var(--font-head); font-size:1.4rem; margin-bottom:6px; }
.empty-state p  { color:var(--text-muted); font-size:.88rem; }

/* ── MODAL (unchanged from v3.0) ── */
.modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,.6); z-index:400; display:none; align-items:center; justify-content:center; padding:20px; backdrop-filter:blur(4px); }
.modal-overlay.open { display:flex; }
.modal-box  { background:var(--surface); border-radius:var(--r-lg); width:100%; max-width:880px; max-height:90vh; overflow-y:auto; box-shadow:var(--shadow-lg); animation:slideUp .25s ease; }
@keyframes slideUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
.modal-head  { background:var(--teal); color:#fff; padding:22px 30px; display:flex; justify-content:space-between; align-items:flex-start; position:sticky; top:0; z-index:1; border-radius:var(--r-lg) var(--r-lg) 0 0; }
.modal-title { font-family:var(--font-head); font-size:1.45rem; margin-bottom:3px; }
.modal-sub   { font-size:.78rem; color:rgba(255,255,255,.6); }
.modal-close { background:rgba(255,255,255,.12); border:none; color:#fff; width:34px; height:34px; border-radius:50%; font-size:1rem; cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0; transition:var(--transition); }
.modal-close:hover { background:rgba(255,255,255,.22); }
.guideline-badge { display:inline-flex; align-items:center; gap:6px; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.2); padding:4px 12px; border-radius:20px; font-size:.72rem; color:rgba(255,255,255,.8); margin-top:6px; text-decoration:none; }
.guideline-badge:hover { background:rgba(255,255,255,.18); }
.modal-body  { padding:26px 30px; }
.modal-sec   { margin-bottom:22px; }
.modal-sec-title { font-size:.67rem; letter-spacing:1.8px; text-transform:uppercase; color:var(--gold); font-weight:700; margin-bottom:10px; display:flex; align-items:center; gap:7px; padding-bottom:7px; border-bottom:1px solid var(--border); }
.pathophys-box { font-size:.88rem; color:var(--text-muted); line-height:1.75; background:var(--surface2); padding:14px 16px; border-radius:var(--r-sm); border-left:3px solid var(--teal-light); }
.epi-grid  { display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:8px; }
.epi-item  { background:var(--surface2); border-radius:var(--r-sm); padding:10px 12px; }
.epi-key   { font-size:.67rem; letter-spacing:1px; text-transform:uppercase; color:var(--slate-lt); font-weight:600; margin-bottom:2px; }
.epi-val   { font-size:.85rem; color:var(--text); font-weight:500; }
.algo-steps { display:flex; flex-direction:column; gap:7px; }
.algo-step  { display:flex; gap:10px; align-items:flex-start; }
.step-num   { background:var(--teal); color:#fff; width:24px; height:24px; border-radius:50%; font-size:.72rem; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:1px; }
.step-txt   { font-size:.85rem; color:var(--text-muted); line-height:1.5; padding-top:3px; }
.mgmt-list  { display:flex; flex-direction:column; gap:5px; }
.mgmt-item  { background:var(--surface2); border-left:3px solid var(--gold); padding:8px 12px; border-radius:0 6px 6px 0; font-size:.85rem; color:var(--text-muted); line-height:1.5; }
.ddx-grid   { display:grid; grid-template-columns:1fr 1fr; gap:7px; }
.ddx-item   { background:var(--surface2); border-radius:6px; padding:9px 11px; }
.ddx-name   { font-size:.83rem; font-weight:600; color:var(--text); margin-bottom:2px; }
.ddx-note   { font-size:.76rem; color:var(--text-muted); }
.modal-foot { padding:14px 30px; border-top:1px solid var(--border); display:flex; gap:8px; background:var(--surface2); border-radius:0 0 var(--r-lg) var(--r-lg); }
.btn-print  { padding:8px 18px; background:var(--surface); color:var(--text); border:1.5px solid var(--border); border-radius:7px; font-family:var(--font-body); font-size:.82rem; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:6px; transition:var(--transition); }
.btn-print:hover { border-color:var(--teal); color:var(--teal); }

/* ── LOADING ── */
.loading-overlay { position:fixed; inset:0; background:rgba(255,255,255,.82); z-index:500; display:none; align-items:center; justify-content:center; flex-direction:column; gap:14px; backdrop-filter:blur(3px); }
[data-theme="dark"] .loading-overlay { background:rgba(14,17,23,.82); }
.loading-overlay.show { display:flex; }
.spinner { width:38px; height:38px; border:4px solid var(--border); border-top-color:var(--teal); border-radius:50%; animation:spin .7s linear infinite; }
@keyframes spin { to{transform:rotate(360deg)} }
.load-txt { font-size:.84rem; color:var(--text-muted); font-weight:500; }

/* Scrollbar */
::-webkit-scrollbar { width:5px; }
::-webkit-scrollbar-track { background:transparent; }
::-webkit-scrollbar-thumb { background:var(--border); border-radius:3px; }
::-webkit-scrollbar-thumb:hover { background:var(--slate-lt); }

/* Print */
@media print {
  .app-header,.res-topbar,.btn-detail,.modal-close,.modal-foot { display:none !important; }
  .modal-box { box-shadow:none; max-height:none; }
  .modal-overlay { position:static; backdrop-filter:none; background:none; padding:0; display:block; }
}

/* Responsive */
@media(max-width:860px) {
  #screen-input.active { padding:20px 12px 50px; }
  .inp-hero { padding:22px 22px; }
  .inp-body { padding:20px 22px 24px; }
  .demo-row { grid-template-columns:1fr 1fr; }
  .res-topbar { padding:11px 18px; flex-wrap:wrap; }
  .res-main   { padding:18px 18px 40px; }
  .card-body  { grid-template-columns:1fr; }
  .card-col:last-child { border-left:none; padding-left:0; border-top:1px solid var(--border); padding-top:12px; margin-top:8px; }
  .ddx-grid { grid-template-columns:1fr; }
  .hdr-badge { display:none; }
}
@media(max-width:560px) {
  .demo-row { grid-template-columns:1fr; }
  .sel-summary { flex-direction:column; }
  .sel-right { flex-direction:row; }
  .btn-diagnose, .btn-clear { flex:1; justify-content:center; }
}

/* ── LAB SCREEN ── */
#screen-labs { min-height:calc(100vh - 64px); background:var(--bg); }
#screen-labs.active { display:block; animation:fadeInUp .3s ease; }
.lab-field-wrap input:focus {
  outline:none;
  border-color:var(--teal) !important;
  box-shadow:0 0 0 3px rgba(13,115,119,.12);
}
.lab-field-wrap input.abnormal-high {
  border-color:#e74c3c !important;
  background:rgba(231,76,60,.04);
}
.lab-field-wrap input.abnormal-low {
  border-color:#e74c3c !important;
  background:rgba(231,76,60,.04);
}
.lab-field-wrap input.normal-val {
  border-color:#27ae60 !important;
  background:rgba(39,174,96,.04);
}
.lab-flag.flag-high { background:#fdecea; color:#c0392b; }
.lab-flag.flag-low  { background:#fdecea; color:#c0392b; }
.lab-flag.flag-ok   { background:#eafaf1; color:#27ae60; }

/* combined score badge */
.combined-badge {
  display:inline-flex; align-items:center; gap:5px;
  background:var(--teal); color:#fff;
  border-radius:6px; padding:3px 10px;
  font-size:.78rem; font-weight:700; margin-left:6px;
}
.lab-matched-chips { display:flex; flex-wrap:wrap; gap:4px; margin-top:6px; }
.lab-chip {
  background:rgba(13,115,119,.1); color:var(--teal);
  border:1px solid var(--teal); border-radius:20px;
  padding:2px 10px; font-size:.78rem; font-weight:600;
}
.lab-chip.abnormal { background:rgba(192,57,43,.08); color:#c0392b; border-color:#c0392b; }
</style>
</head>
<body>

<!-- ── HEADER ── -->
<header class="app-header">
  <div class="header-left">
    <div class="brand-icon"><i class="fa-solid fa-dna"></i></div>
    <div>
      <div class="brand-name">EndoFlow <span style="font-size:.65rem;background:var(--teal);color:#fff;padding:2px 7px;border-radius:4px;vertical-align:middle;margin-left:4px;">v5.0</span></div>
      <div class="brand-sub">Clinical Decision Support &mdash; Endocrinology</div>
    </div>
  </div>
  <div class="header-right">
    <div class="hdr-badge"><b><?php echo count($patterns); ?></b> Disorders</div>
    <div class="hdr-badge">Endocrine Society <b>Guidelines</b></div>
    <div class="hdr-badge" style="background:rgba(13,115,119,.15);border-color:var(--teal);"><i class="fa-solid fa-vial" style="color:var(--teal);margin-right:4px;"></i><b style="color:var(--teal);">Lab Validated</b></div>
    <button class="btn-theme" onclick="toggleTheme()" title="Toggle dark mode">
      <i class="fa-solid fa-moon" id="themeIcon"></i>
    </button>
  </div>
</header>

<!-- ══════════════════════════════
     SCREEN 1 — INPUT
══════════════════════════════ -->
<div class="screen active" id="screen-input">

  <div class="input-card">

    <!-- Hero -->
    <div class="inp-hero">
      <div class="inp-hero-inner">
        <div class="inp-hero-icon">&#x1F9EC;</div>
        <div class="inp-hero-text">
          <h2>Endocrine Disorder Diagnosis</h2>
          <p>Enter patient details and select presenting symptoms below. The weighted diagnostic engine will rank the endocrine disorder patterns by clinical relevance.</p>
        </div>
      </div>
    </div>

    <!-- Step indicator -->
    <div class="steps-bar">
      <div class="stp active" id="stp1"><div class="stp-num">1</div><span>Patient Details</span></div>
      <div class="stp-line" id="sline1"></div>
      <div class="stp active" id="stp2"><div class="stp-num">2</div><span>Select Symptoms</span></div>
      <div class="stp-line" id="sline2"></div>
      <div class="stp" id="stp3"><div class="stp-num">3</div><span>Order Tests</span></div>
      <div class="stp-line" id="sline3a"></div>
      <div class="stp" id="stp4"><div class="stp-num">4</div><span>Enter Results</span></div>
      <div class="stp" id="stp4b"><div class="stp-num" style="font-size:.65rem;">4B</div><span>Confirm</span></div>
      <div class="stp-line" id="sline3"></div>
      <div class="stp" id="stp5"><div class="stp-num">5</div><span>View Results</span></div>
    </div>

    <!-- Body -->
    <div class="inp-body">

      <!-- Demographics -->
      <div class="inp-sec-label">
        <i class="fa-solid fa-user-doctor"></i> Patient Demographics
        <span style="margin-left:auto;font-size:.67rem;color:var(--slate-lt);font-weight:400;text-transform:none;letter-spacing:0;">All fields optional — improves match accuracy</span>
      </div>
      <div class="demo-row">
        <div class="demo-field">
          <label>Age (years)</label>
          <input type="number" id="patientAge" placeholder="e.g. 35" min="1" max="120" oninput="validateAgeInput(this)">
          <div id="ageError" style="display:none;color:var(--rose);font-size:.72rem;margin-top:4px;font-weight:600;">
            <i class="fa-solid fa-triangle-exclamation"></i> Age must be between 1 and 120
          </div>
        </div>
        <div class="demo-field">
          <label>Gender</label>
          <select id="patientGender">
            <option value="">Select gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>
      </div>

      <!-- Symptom search -->
      <div class="inp-sec-label"><i class="fa-solid fa-list-check"></i> Select Presenting Symptoms</div>
      <div class="sym-search">
        <i class="fa-solid fa-search si"></i>
        <input type="text" id="symSearch" placeholder="Search symptoms by name..." oninput="filterSymptoms(this.value)">
      </div>

      <!-- Category tabs -->
      <div class="cat-tabs" id="catTabs">
        <button class="cat-tab active" onclick="switchCat('all',this)">All</button>
        <?php foreach ($symptomCategories as $catKey => $catData): ?>
        <button class="cat-tab" onclick="switchCat('<?php echo $catKey; ?>',this)">
          <i class="fa-solid <?php echo $catData['icon']; ?>" style="font-size:.7rem;margin-right:2px;"></i>
          <?php echo explode(' ', $catData['label'])[0]; ?>
        </button>
        <?php endforeach; ?>
      </div>

      <!-- Symptom chips area -->
      <div class="sym-area" id="symListArea">

        <!-- ALL group -->
        <div class="cat-group active" id="cat-all">
          <?php foreach ($symptomCategories as $catKey => $catData): ?>
          <div class="cat-group-label"><i class="fa-solid <?php echo $catData['icon']; ?>"></i> <?php echo $catData['label']; ?></div>
          <div class="chips-wrap">
            <?php foreach ($catData['symptoms'] as $symId):
                  $label = $allSymptoms[$symId] ?? $symId;
                  $short = trim(explode('(', $label)[0]); ?>
            <span class="sym-chip" id="chip-all-<?php echo $symId; ?>" data-sym="<?php echo $symId; ?>" onclick="toggleChip(this)"><?php echo htmlspecialchars($short); ?></span>
            <?php endforeach; ?>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Per-category groups -->
        <?php foreach ($symptomCategories as $catKey => $catData): ?>
        <div class="cat-group" id="cat-<?php echo $catKey; ?>">
          <div class="cat-group-label"><i class="fa-solid <?php echo $catData['icon']; ?>"></i> <?php echo $catData['label']; ?></div>
          <div class="chips-wrap">
            <?php foreach ($catData['symptoms'] as $symId):
                  $label = $allSymptoms[$symId] ?? $symId;
                  $short = trim(explode('(', $label)[0]); ?>
            <span class="sym-chip" id="chip-<?php echo $catKey; ?>-<?php echo $symId; ?>" data-sym="<?php echo $symId; ?>" onclick="toggleChip(this)"><?php echo htmlspecialchars($short); ?></span>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endforeach; ?>

      </div><!-- /sym-area -->

      <!-- Selected summary + CTA -->
      <div class="sel-summary">
        <div class="sel-left">
          <div class="sel-top">
            <span class="sel-lbl">Selected Symptoms</span>
            <span class="count-pill" id="selCount">0</span>
          </div>
          <div class="sel-chips" id="selChips">
            <span style="font-size:.75rem;color:var(--slate-lt);font-style:italic;">No symptoms selected &mdash; click chips above to add</span>
          </div>
        </div>
        <div class="sel-right">
          <button class="btn-diagnose" id="btnDiagnose" onclick="goToOrderLabsScreen()" disabled>
            <i class="fa-solid fa-flask"></i> Next: Enter Lab Values
          </button>
          <button class="btn-clear" onclick="clearAll()">
            <i class="fa-solid fa-rotate-left"></i> Clear All
          </button>
        </div>
      </div>

    </div><!-- /inp-body -->
  </div><!-- /input-card -->

</div><!-- /screen-input -->


<!-- ══════════════════════════════
     SCREEN 3 — LAB PARAMETERS
══════════════════════════════ -->
<!-- ══════════════════════════════════════════════
   SCREEN 2.5 — RECOMMENDED LAB TESTS TO ORDER
   Shows test NAMES so the doctor/patient knows what to order
   BEFORE entering any values
══════════════════════════════════════════════ -->
<div class="screen" id="screen-order-labs">
  <div class="res-topbar">
    <div class="rtb-left">
      <button class="btn-back" onclick="showScreen('screen-input')">
        <i class="fa-solid fa-arrow-left"></i> Back to Symptoms
      </button>
      <div>
        <div class="rtb-title">Recommended Lab Tests</div>
        <div class="rtb-sub" id="orderLabsSub">Tests to order based on your symptoms</div>
      </div>
    </div>
    <div class="rtb-right">
      <span class="res-pill" style="background:var(--teal-pale);color:var(--teal);border-color:var(--teal);">Step 3</span>
    </div>
  </div>

  <div style="max-width:900px;margin:0 auto;padding:24px 16px 110px;">

    <!-- Header guidance banner -->
    <div style="background:var(--teal-pale);border:1.5px solid var(--teal);border-radius:14px;padding:16px 20px;margin-bottom:24px;display:flex;gap:14px;align-items:flex-start;">
      <i class="fa-solid fa-flask-vial" style="color:var(--teal);margin-top:3px;flex-shrink:0;font-size:1.2rem;"></i>
      <div>
        <strong style="color:var(--teal);font-size:.95rem;">Lab Tests to Order — Based on Your Symptoms</strong>
        <p style="margin-top:6px;font-size:.85rem;color:var(--slate);line-height:1.65;">
          Based on the symptoms selected, these are the <strong>priority lab investigations</strong> to order. 
          Send the patient for these tests first. Once results are available, return here and click 
          <strong>"I Have the Results → Enter Lab Values"</strong> to complete the diagnosis.
        </p>
        <p style="margin-top:5px;font-size:.78rem;color:var(--slate-lt);">
          <i class="fa-solid fa-circle-info" style="color:var(--teal);"></i>
          Initial (first-line) tests are shown first. Confirmatory tests may be needed depending on initial findings.
        </p>
      </div>
    </div>

    <!-- Top suspected disorders summary -->
    <div id="orderLabsDisorderSummary" style="margin-bottom:22px;"></div>

    <!-- Lab tests to order — grouped by specimen type -->
    <div id="orderLabsContainer"></div>

    <!-- Print / share hint -->
    <div style="margin-top:12px;text-align:center;">
      <button onclick="window.print()" style="padding:8px 18px;border-radius:8px;border:1.5px solid var(--border);background:transparent;color:var(--slate);font-size:.82rem;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
        <i class="fa-solid fa-print"></i> Print Lab Order List
      </button>
    </div>

    <!-- Bottom action bar -->
    <div style="position:sticky;bottom:0;background:var(--bg);padding:16px 0;border-top:1px solid var(--border);display:flex;gap:12px;justify-content:space-between;margin-top:20px;align-items:center;">
      <div style="font-size:.8rem;color:var(--slate-lt);">
        <i class="fa-solid fa-clock" style="color:var(--gold);"></i>
        Order these tests → collect results → return here to enter values
      </div>
      <div style="display:flex;gap:10px;">
        <button onclick="showScreen('screen-input')" style="padding:11px 22px;border-radius:10px;border:1.5px solid var(--border);background:transparent;color:var(--slate);font-size:.9rem;cursor:pointer;">
          <i class="fa-solid fa-arrow-left"></i> Back
        </button>
        <button onclick="goToLabScreen()" style="padding:12px 28px;border-radius:10px;border:none;background:var(--teal);color:#fff;font-size:.95rem;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:8px;box-shadow:0 3px 14px rgba(13,115,119,.3);">
          <i class="fa-solid fa-vial-circle-check"></i> I Have the Results → Enter Lab Values
        </button>
      </div>
    </div>

  </div>
</div><!-- /screen-order-labs -->

<!-- ══════════════════════════════════════════════
   SCREEN 3A — INITIAL PRIORITY LABS (Smart, Real-World)
   Shows only the 1-2 first-line tests per top disorder
══════════════════════════════════════════════ -->
<div class="screen" id="screen-labs">
  <div class="res-topbar">
    <div class="rtb-left">
      <button class="btn-back" onclick="showScreen('screen-order-labs')">
        <i class="fa-solid fa-arrow-left"></i> Back to Test List
      </button>
      <div>
        <div class="rtb-title">Initial Lab Tests</div>
        <div class="rtb-sub" id="labScreenSub">Priority tests recommended for your top suspected diagnoses</div>
      </div>
    </div>
    <div class="rtb-right">
      <span class="res-pill" id="labCount">0 entered</span>
    </div>
  </div>

  <div style="max-width:900px;margin:0 auto;padding:24px 16px 100px;">

    <!-- Clinical rationale banner -->
    <div style="background:var(--teal-pale);border:1.5px solid var(--teal);border-radius:14px;padding:16px 20px;margin-bottom:24px;display:flex;gap:14px;align-items:flex-start;">
      <i class="fa-solid fa-stethoscope" style="color:var(--teal);margin-top:3px;flex-shrink:0;font-size:1.1rem;"></i>
      <div style="font-size:.87rem;color:var(--slate);">
        <strong style="color:var(--teal);font-size:.95rem;">Clinical Approach — Real-World Lab Ordering</strong>
        <p style="margin-top:5px;line-height:1.65;">Based on your symptoms, only the <strong>first-line priority tests</strong> are shown — exactly what a physician would order initially. Enter the values available. <strong>You can skip tests not yet done</strong> — the system will still generate a diagnosis based on what is available.</p>
        <p style="margin-top:5px;font-size:.8rem;color:var(--slate-lt);">Abnormal values are flagged HIGH/LOW automatically. If initial results are borderline, you will be prompted for one confirmatory test.</p>
      </div>
    </div>

    <!-- Dynamic priority lab fields rendered by JS -->
    <div id="labFieldsContainer"></div>

    <!-- "Skip labs" option -->
    <div style="text-align:center;margin-top:14px;padding:14px;background:var(--surface2);border-radius:10px;border:1px dashed var(--border);">
      <p style="font-size:.83rem;color:var(--text-muted);margin-bottom:8px;"><i class="fa-solid fa-clock" style="color:var(--gold);"></i> Lab results not yet available? You can proceed with symptom-based assessment only.</p>
      <button onclick="runDiagnosis(true)" style="padding:9px 22px;border-radius:8px;border:1.5px solid var(--teal);background:transparent;color:var(--teal);font-size:.87rem;font-weight:600;cursor:pointer;">
        <i class="fa-solid fa-forward"></i> Skip — Use Symptoms Only
      </button>
    </div>

    <!-- Submit bar -->
    <div style="position:sticky;bottom:0;background:var(--bg);padding:16px 0;border-top:1px solid var(--border);display:flex;gap:12px;justify-content:flex-end;margin-top:16px;">
      <button onclick="showScreen('screen-order-labs')" style="padding:12px 24px;border-radius:10px;border:1.5px solid var(--border);background:transparent;color:var(--slate);font-size:.95rem;cursor:pointer;">
        <i class="fa-solid fa-arrow-left"></i> Back
      </button>
      <button id="btnRunDiagnosis" onclick="runDiagnosis(false)"
        style="padding:12px 30px;border-radius:10px;border:none;background:var(--teal);color:#fff;font-size:.95rem;font-weight:700;cursor:pointer;transition:opacity .2s;">
        <i class="fa-solid fa-stethoscope"></i> Analyse &amp; Diagnose
      </button>
    </div>

  </div>
</div><!-- /screen-labs -->

<!-- ══════════════════════════════════════════════
   SCREEN 3B — CONFIRMATORY LAB (shown if initial is borderline)
══════════════════════════════════════════════ -->
<div class="screen" id="screen-confirmatory">
  <div class="res-topbar">
    <div class="rtb-left">
      <button class="btn-back" onclick="showScreen('screen-labs')">
        <i class="fa-solid fa-arrow-left"></i> Back to Initial Labs
      </button>
      <div>
        <div class="rtb-title">Confirmatory Test</div>
        <div class="rtb-sub" id="confScreenSub">One additional test recommended to confirm your top diagnosis</div>
      </div>
    </div>
    <div class="rtb-right">
      <span class="res-pill" style="background:var(--gold-pale);color:var(--gold);border-color:var(--gold);">Step 3B</span>
    </div>
  </div>

  <div style="max-width:780px;margin:0 auto;padding:24px 16px 100px;">

    <!-- Reasoning banner -->
    <div id="confReasonBanner" style="background:var(--gold-pale);border:1.5px solid var(--gold);border-radius:14px;padding:16px 20px;margin-bottom:24px;">
      <div style="display:flex;gap:12px;align-items:flex-start;">
        <i class="fa-solid fa-magnifying-glass-chart" style="color:var(--gold);margin-top:3px;font-size:1.1rem;flex-shrink:0;"></i>
        <div>
          <strong style="color:var(--gold);font-size:.95rem;">Borderline Initial Result — Confirmatory Test Needed</strong>
          <p id="confReasonText" style="font-size:.86rem;color:var(--slate);margin-top:5px;line-height:1.6;"></p>
        </div>
      </div>
    </div>

    <!-- Top suspected diagnosis summary -->
    <div id="confTopDxSummary" style="background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:16px 20px;margin-bottom:22px;"></div>

    <!-- Confirmatory lab fields -->
    <div id="confLabFields"></div>

    <!-- Submit bar -->
    <div style="position:sticky;bottom:0;background:var(--bg);padding:16px 0;border-top:1px solid var(--border);display:flex;gap:12px;justify-content:flex-end;margin-top:16px;">
      <button onclick="runDiagnosis(false)" style="padding:12px 24px;border-radius:10px;border:1.5px solid var(--border);background:transparent;color:var(--slate);font-size:.95rem;cursor:pointer;">
        <i class="fa-solid fa-forward"></i> Skip — Use Current Data
      </button>
      <button id="btnRunConfirmatory" onclick="runDiagnosisWithConfirmatory()"
        style="padding:12px 30px;border-radius:10px;border:none;background:var(--gold);color:#fff;font-size:.95rem;font-weight:700;cursor:pointer;">
        <i class="fa-solid fa-check-circle"></i> Confirm &amp; Diagnose
      </button>
    </div>
  </div>
</div><!-- /screen-confirmatory -->


══════════════════════════════ -->
<div class="screen" id="screen-results">

  <!-- Sticky top bar -->
  <div class="res-topbar">
    <div class="rtb-left">
      <button class="btn-back" onclick="goBack()">
        <i class="fa-solid fa-arrow-left"></i> New Search
      </button>
      <div>
        <div class="rtb-title">Matching Diagnoses</div>
        <div class="rtb-sub" id="rtbSub">&mdash;</div>
      </div>
    </div>
    <div class="rtb-right">
      <div class="patient-chip" id="patientChip" style="display:none;">
        <i class="fa-solid fa-user"></i>
        <span id="patientChipText"></span>
      </div>
      <span class="res-pill" id="resCount">0 found</span>
    </div>
  </div>

  <!-- Main results area -->
  <div class="res-main">

    <!-- Emergency banner -->
    <div class="emg-banner" id="emgBanner">
      <div class="emg-icon-sm">&#x1F6A8;</div>
      <div class="emg-text-sm">
        <h4><i class="fa-solid fa-triangle-exclamation"></i> EMERGENCY Diagnosis Detected</h4>
        <p id="emgBannerMsg">One or more conditions require immediate clinical assessment.</p>
      </div>
    </div>

    <!-- Cards -->
    <div class="cards-grid" id="cardsGrid"></div>

  </div>
</div><!-- /screen-results -->


<!-- ── DETAIL MODAL (unchanged from v3.0) ── -->
<div class="modal-overlay" id="detailModal" onclick="closeModalOnBg(event)">
  <div class="modal-box">
    <div class="modal-head">
      <div>
        <div class="modal-title" id="modalTitle">Loading...</div>
        <div class="modal-sub"   id="modalSub"></div>
        <a href="#" id="modalGuidelineLink" class="guideline-badge" target="_blank">
          <i class="fa-solid fa-book-open"></i>
          <span id="modalGuidelineText">View Guideline</span>
        </a>
      </div>
      <button class="modal-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="modal-body" id="modalBody"></div>
    <div class="modal-foot">
      <button class="btn-print" onclick="window.print()"><i class="fa-solid fa-print"></i> Print</button>
      <button class="btn-print" onclick="closeModal()"><i class="fa-solid fa-arrow-left"></i> Close</button>
    </div>
  </div>
</div>

<!-- ── LOADING ── -->
<div class="loading-overlay" id="loadingOverlay">
  <div class="spinner"></div>
  <div class="load-txt">Analysing symptoms&hellip;</div>
</div>

<!-- ── DATA & SCRIPTS ── -->
<script>
const SYMPTOM_LABELS = <?php echo json_encode($allSymptoms); ?>;
const PATTERNS       = <?php echo json_encode($patterns); ?>;

// State
let selectedSymptoms     = new Set();
let matchResults         = [];
let currentPatientAge    = 0;
let currentPatientGender = '';
let enteredLabValues     = {}; // v4.0 lab values

// Lab reference ranges (must match data_lab_parameters.php)
const LAB_REFS = {
  cortisol_morning:       { low:5,     high:25,    dir_abnormal:'low'  },
  cortisol_24h_urine:     { low:0,     high:50,    dir_abnormal:'high' },
  cortisol_salivary:      { low:0,     high:0.13,  dir_abnormal:'high' },
  acth:                   { low:10,    high:65,    dir_abnormal:'high' },
  tsh:                    { low:0.4,   high:4.5,   dir_abnormal:null   },
  free_t4:                { low:0.8,   high:1.8,   dir_abnormal:null   },
  free_t3:                { low:2.3,   high:4.2,   dir_abnormal:null   },
  trab:                   { low:0,     high:1.75,  dir_abnormal:'high' },
  anti_tpo:               { low:0,     high:35,    dir_abnormal:'high' },
  serum_na:               { low:135,   high:145,   dir_abnormal:null   },
  serum_k:                { low:3.5,   high:5.0,   dir_abnormal:null   },
  serum_aldosterone:      { low:2,     high:15,    dir_abnormal:'high' },
  plasma_renin:           { low:0.5,   high:4.0,   dir_abnormal:'low'  },
  aldo_renin_ratio:       { low:0,     high:20,    dir_abnormal:'high' },
  plasma_metanephrines:   { low:0,     high:0.5,   dir_abnormal:'high' },
  urine_metanephrines:    { low:0,     high:400,   dir_abnormal:'high' },
  igf1:                   { low:75,    high:250,   dir_abnormal:'high' },
  gh_ogtt:                { low:0,     high:1.0,   dir_abnormal:'high' },
  serum_osmolality:       { low:280,   high:295,   dir_abnormal:null   },
  urine_osmolality:       { low:300,   high:900,   dir_abnormal:null   },
  urine_sodium:           { low:20,    high:40,    dir_abnormal:'high' },
  serum_prolactin:        { low:2,     high:29,    dir_abnormal:'high' },
  serum_glucose:          { low:70,    high:100,   dir_abnormal:'high' },
  urine_specific_gravity: { low:1.005, high:1.030, dir_abnormal:'low'  },

  // ── v5.0 NEW LAB PARAMETERS ──────────────────────────────────
  hba1c:                  { low:4.0,   high:5.6,   dir_abnormal:'high' },
  fasting_insulin:        { low:2,     high:25,    dir_abnormal:'high' },
  c_peptide:              { low:0.6,   high:3.1,   dir_abnormal:null   },
  serum_calcium:          { low:8.5,   high:10.5,  dir_abnormal:null   },
  intact_pth:             { low:10,    high:65,    dir_abnormal:null   },
  serum_phosphate:        { low:2.5,   high:4.5,   dir_abnormal:null   },
  vitamin_d_25oh:         { low:30,    high:100,   dir_abnormal:'low'  },
  serum_testosterone:     { low:264,   high:916,   dir_abnormal:'low'  },
  serum_testosterone_free:{ low:65,    high:225,   dir_abnormal:'low'  },
  lh:                     { low:1.7,   high:8.6,   dir_abnormal:null   },
  fsh:                    { low:1.5,   high:12.4,  dir_abnormal:null   },
  serum_17ohp:            { low:0,     high:200,   dir_abnormal:'high' },
  serum_calcitonin:       { low:0,     high:10,    dir_abnormal:'high' },
  chromogranin_a:         { low:0,     high:100,   dir_abnormal:'high' },
  urine_5hiaa:            { low:0,     high:8,     dir_abnormal:'high' },
  serum_gastrin:          { low:0,     high:115,   dir_abnormal:'high' },
  esr:                    { low:0,     high:20,    dir_abnormal:'high' },
  amh:                    { low:1.0,   high:3.4,   dir_abnormal:'high' },
  dheas:                  { low:65,    high:380,   dir_abnormal:'high' },
};

// ── AGE VALIDATION ─────────────────────────────────────
function validateAgeInput(input) {
  const val = parseInt(input.value) || 0;
  const err = document.getElementById('ageError');
  if (input.value !== '' && (val < 1 || val > 120)) {
    input.style.borderColor = 'var(--rose)';
    input.style.boxShadow   = '0 0 0 3px rgba(192,57,43,.15)';
    if (err) err.style.display = 'block';
  } else {
    input.style.borderColor = '';
    input.style.boxShadow   = '';
    if (err) err.style.display = 'none';
  }
}


// ── THEME ──────────────────────────────────────────────
function toggleTheme() {
  const html   = document.documentElement;
  const isDark = html.getAttribute('data-theme') === 'dark';
  const newTheme = isDark ? 'light' : 'dark';
  html.setAttribute('data-theme', newTheme);
  document.getElementById('themeIcon').className = isDark ? 'fa-solid fa-moon' : 'fa-solid fa-sun';
  try { localStorage.setItem('endoflow_theme', newTheme); } catch(e) {}
}

// Restore saved theme on load
(function() {
  try {
    const saved = localStorage.getItem('endoflow_theme');
    if (saved === 'dark') {
      document.documentElement.setAttribute('data-theme', 'dark');
      document.addEventListener('DOMContentLoaded', () => {
        const icon = document.getElementById('themeIcon');
        if (icon) icon.className = 'fa-solid fa-sun';
      });
    }
  } catch(e) {}
})();

// ── SCREEN SWITCH ──────────────────────────────────────
function showScreen(id) {
  document.querySelectorAll('.screen').forEach(s => s.classList.remove('active'));
  document.getElementById(id).classList.add('active');
  window.scrollTo({ top: 0, behavior: 'smooth' });
  // Update step indicators
  const steps = { 'screen-input': 2, 'screen-order-labs': 3, 'screen-labs': 4, 'screen-confirmatory': 4, 'screen-results': 5 };
  const activeStep = steps[id] || 2;
  for (let i = 1; i <= 5; i++) {
    const el = document.getElementById('stp'+i);
    if (el) el.classList.toggle('active', i <= activeStep);
  }
  const el4b = document.getElementById('stp4b');
  if (el4b) el4b.classList.toggle('active', id === 'screen-confirmatory');
  const el3b = document.getElementById('stp3b');
  if (el3b) el3b.classList.toggle('active', id === 'screen-confirmatory');
}

function goBack() {
  const srch = document.getElementById('symSearch');
  if (srch && srch.value) { srch.value=''; filterSymptoms(''); }
  showScreen('screen-input');
}

// v4.0 — Full lab meta: id, label, unit, normal range, hint, relevant disorders
const LAB_META = {
  cortisol_morning:       { label:'Morning Serum Cortisol',           unit:'mcg/dL',    ref:'5–25',       hint:'Draw at 8 AM. Low = Addison\'s' },
  cortisol_24h_urine:     { label:'24h Urinary Free Cortisol',        unit:'mcg/day',   ref:'< 50',       hint:'Elevated in Cushing\'s' },
  cortisol_salivary:      { label:'Late Night Salivary Cortisol',     unit:'mcg/dL',    ref:'< 0.13',     hint:'Elevated in Cushing\'s' },
  acth:                   { label:'Plasma ACTH',                      unit:'pg/mL',     ref:'10–65',      hint:'> 100 in Addison\'s' },
  tsh:                    { label:'TSH',                              unit:'mIU/L',     ref:'0.4–4.5',    hint:'↑ Hypothyroid · ↓ Graves\'' },
  free_t4:                { label:'Free T4',                          unit:'ng/dL',     ref:'0.8–1.8',    hint:'↓ Hypothyroid · ↑ Graves\'' },
  free_t3:                { label:'Free T3',                          unit:'pg/mL',     ref:'2.3–4.2',    hint:'↑ in Graves\'' },
  trab:                   { label:'TRAb (TSH Receptor Antibodies)',   unit:'IU/L',      ref:'< 1.75',     hint:'Elevated in Graves\'' },
  anti_tpo:               { label:'Anti-TPO Antibodies',              unit:'IU/mL',     ref:'< 35',       hint:'Elevated in Hashimoto\'s / Graves\'' },
  serum_na:               { label:'Serum Sodium (Na+)',               unit:'mEq/L',     ref:'135–145',    hint:'↓ Addison\'s / SIADH · ↑ DI' },
  serum_k:                { label:'Serum Potassium (K+)',             unit:'mEq/L',     ref:'3.5–5.0',    hint:'↓ Conn\'s · ↑ Addison\'s' },
  serum_aldosterone:      { label:'Serum Aldosterone',                unit:'ng/dL',     ref:'2–15',       hint:'Elevated in Conn\'s' },
  plasma_renin:           { label:'Plasma Renin Activity',            unit:'ng/mL/hr',  ref:'0.5–4.0',    hint:'Low in Conn\'s' },
  aldo_renin_ratio:       { label:'Aldosterone:Renin Ratio (ARR)',    unit:'',          ref:'< 20',       hint:'> 30 = Conn\'s Syndrome' },
  plasma_metanephrines:   { label:'Plasma Metanephrines',             unit:'nmol/L',    ref:'< 0.5',      hint:'Elevated in Pheochromocytoma' },
  urine_metanephrines:    { label:'24h Urine Metanephrines',          unit:'mcg/day',   ref:'< 400',      hint:'Elevated in Pheochromocytoma' },
  igf1:                   { label:'IGF-1',                            unit:'ng/mL',     ref:'75–250',     hint:'Elevated in Acromegaly' },
  gh_ogtt:                { label:'GH after Oral Glucose Tolerance',  unit:'ng/mL',     ref:'< 1.0',      hint:'Fails to suppress in Acromegaly' },
  serum_osmolality:       { label:'Serum Osmolality',                 unit:'mOsm/kg',   ref:'280–295',    hint:'↓ SIADH · ↑ Diabetes Insipidus' },
  urine_osmolality:       { label:'Urine Osmolality',                 unit:'mOsm/kg',   ref:'300–900',    hint:'↓ in DI · ↑ in SIADH' },
  urine_sodium:           { label:'Urine Sodium',                     unit:'mEq/L',     ref:'20–40',      hint:'Elevated in SIADH' },
  serum_prolactin:        { label:'Serum Prolactin',                  unit:'ng/mL',     ref:'2–29',       hint:'> 200 = Prolactinoma' },
  serum_glucose:          { label:'Fasting Serum Glucose',            unit:'mg/dL',     ref:'70–100',     hint:'Elevated in Cushing\'s / Acromegaly · Low in Insulinoma' },
  urine_specific_gravity: { label:'Urine Specific Gravity',           unit:'',          ref:'1.005–1.030',hint:'Low in Diabetes Insipidus' },

  // ── v5.0 NEW LAB META ─────────────────────────────────────────
  hba1c:                   { label:'HbA1c (Glycated Haemoglobin)',         unit:'%',         ref:'< 5.7%',      hint:'≥ 6.5% = Diabetes. 5.7–6.4% = Prediabetes (ADA/ES)' },
  fasting_insulin:         { label:'Fasting Serum Insulin',                unit:'µIU/mL',    ref:'2–25',        hint:'↑ T2DM / Insulin resistance · ↓ T1DM · ↑↑ Insulinoma' },
  c_peptide:               { label:'C-Peptide',                            unit:'ng/mL',     ref:'0.6–3.1',     hint:'Low/absent in T1DM (< 0.6) · Normal-high in T2DM · ↑↑ Insulinoma' },
  serum_calcium:           { label:'Serum Calcium (Total, Corrected)',     unit:'mg/dL',     ref:'8.5–10.5',    hint:'↑ Hyperparathyroidism / Malignancy · ↓ Hypoparathyroidism / VitD def. Correct: Ca + 0.8×(4−albumin)' },
  intact_pth:              { label:'Intact PTH (Parathyroid Hormone)',     unit:'pg/mL',     ref:'10–65',       hint:'↑ PHPT / VitD deficiency · ↓ Hypoparathyroidism (< 10 = low)' },
  serum_phosphate:         { label:'Serum Phosphate',                      unit:'mg/dL',     ref:'2.5–4.5',     hint:'↓ PHPT (PTH promotes phosphaturia) · ↑ Hypoparathyroidism / CKD' },
  vitamin_d_25oh:          { label:'25-OH Vitamin D',                      unit:'ng/mL',     ref:'30–100',      hint:'< 20 = Deficient · 20–29 = Insufficient · > 100 = Toxicity risk (ES Guidelines 2011)' },
  serum_testosterone:      { label:'Total Serum Testosterone (8 AM)',      unit:'ng/dL',     ref:'264–916',     hint:'< 264 ng/dL = Hypogonadal (ES 2018). Draw fasting at 8 AM. Repeat to confirm' },
  serum_testosterone_free: { label:'Free Testosterone',                    unit:'pg/mL',     ref:'65–225',      hint:'< 65 pg/mL = Low. Preferred when SHBG is abnormal (obesity, elderly)' },
  lh:                      { label:'LH (Luteinising Hormone)',              unit:'IU/L',      ref:'1.7–8.6',     hint:'↑ Primary hypogonadism (testicular failure) · ↓ Secondary (pituitary/hypothalamic) · ↑ PCOS' },
  fsh:                     { label:'FSH (Follicle Stimulating Hormone)',    unit:'IU/L',      ref:'1.5–12.4',    hint:'↑ Primary hypogonadism / ovarian failure · ↓ Secondary hypogonadism · ↑ PCOS' },
  serum_17ohp:             { label:'17-Hydroxyprogesterone (17-OHP)',       unit:'ng/dL',     ref:'< 200',       hint:'> 200 ng/dL basal = Classic CAH. 200–1000 = equivocal → ACTH stim test. > 1000 post-stim = NC-CAH (ES 2018)' },
  serum_calcitonin:        { label:'Serum Calcitonin',                      unit:'pg/mL',     ref:'< 10',        hint:'> 100 pg/mL strongly suggests Medullary Thyroid Carcinoma. Key MEN2 marker (ATA/ES)' },
  chromogranin_a:          { label:'Plasma Chromogranin A (CgA)',           unit:'U/L',       ref:'< 100',       hint:'↑ NETs / Carcinoid / Insulinoma / MEN1. Note: PPI use falsely elevates CgA (ES NET CPG 2015)' },
  urine_5hiaa:             { label:'24h Urine 5-HIAA',                      unit:'mg/day',    ref:'< 8',         hint:'> 15 mg/day = Carcinoid syndrome. Avoid serotonin-rich foods 3 days prior (bananas, walnuts, avocado)' },
  serum_gastrin:           { label:'Fasting Serum Gastrin',                 unit:'pg/mL',     ref:'< 115',       hint:'> 1000 pg/mL = ZES/Gastrinoma (MEN1). Stop PPI 2 weeks before test. Secretin test if borderline' },
  esr:                     { label:'ESR (Erythrocyte Sedimentation Rate)',   unit:'mm/hr',     ref:'< 20',        hint:'> 50 mm/hr in subacute (De Quervain\'s) thyroiditis. Often > 100. Key differentiator from Graves\'' },
  amh:                     { label:'Anti-Müllerian Hormone (AMH)',           unit:'ng/mL',     ref:'1.0–3.4',     hint:'> 3.4 ng/mL = Elevated in PCOS. Also used for ovarian reserve. Unaffected by OCP (ES PCOS CPG 2013)' },
  dheas:                   { label:'DHEAS (Dehydroepiandrosterone Sulfate)', unit:'mcg/dL',    ref:'65–380',      hint:'↑ CAH / Adrenal tumor · ↓ Cushing\'s (adrenal adenoma). Adrenal-specific androgen marker' },
};

// Which labs are relevant for each disorder
// Per-disorder lab lists (used to compute relevantLabIds from matched symptoms)
const DISORDER_LABS = {
  primary_hyperaldosteronism: ['serum_k','serum_aldosterone','plasma_renin','aldo_renin_ratio','serum_na'],
  addisons_disease:           ['cortisol_morning','acth','serum_na','serum_k','serum_glucose'],
  pheochromocytoma:           ['plasma_metanephrines','urine_metanephrines'],
  siadh:                      ['serum_na','serum_osmolality','urine_osmolality','urine_sodium'],
  acromegaly:                 ['igf1','gh_ogtt','serum_glucose'],
  graves_disease:             ['tsh','free_t4','free_t3','trab','anti_tpo'],
  hypothyroidism:             ['tsh','free_t4','free_t3','anti_tpo'],
  cushings_syndrome:          ['cortisol_24h_urine','cortisol_salivary','acth','serum_k','serum_glucose'],
  cushing_syndrome:           ['cortisol_24h_urine','cortisol_salivary','acth','serum_k','serum_glucose'],
  diabetes_insipidus:         ['serum_na','serum_osmolality','urine_osmolality','urine_specific_gravity'],
  prolactinoma:               ['serum_prolactin'],

  // ── v5.0 NEW DISORDERS ────────────────────────────────────────
  type2_diabetes:             ['serum_glucose','hba1c','fasting_insulin','c_peptide'],
  type1_diabetes:             ['serum_glucose','hba1c','c_peptide','fasting_insulin'],
  hyperparathyroidism:        ['serum_calcium','intact_pth','serum_phosphate','vitamin_d_25oh'],
  hypoparathyroidism:         ['serum_calcium','intact_pth','serum_phosphate','vitamin_d_25oh'],
  congenital_adrenal_hyperplasia: ['serum_17ohp','acth','serum_na','serum_k','dheas','cortisol_morning'],
  polycystic_ovary_syndrome:  ['serum_testosterone_free','lh','fsh','amh','dheas','fasting_insulin'],
  male_hypogonadism:          ['serum_testosterone','serum_testosterone_free','lh','fsh','serum_prolactin'],
  osteoporosis:               ['serum_calcium','vitamin_d_25oh','intact_pth','serum_phosphate'],
  vitamin_d_deficiency:       ['vitamin_d_25oh','intact_pth','serum_calcium','serum_phosphate'],
  thyroid_nodule_cancer:      ['tsh','serum_calcitonin','chromogranin_a'],
  subclinical_hypothyroidism: ['tsh','free_t4','anti_tpo'],
  multiple_endocrine_neoplasia_type1: ['serum_calcium','intact_pth','serum_gastrin','serum_prolactin','igf1','serum_glucose','chromogranin_a'],
  carcinoid_syndrome:         ['urine_5hiaa','chromogranin_a'],
  insulinoma:                 ['serum_glucose','fasting_insulin','c_peptide','chromogranin_a'],
  thyroiditis_subacute:       ['tsh','free_t4','esr'],
  central_hypothyroidism:     ['free_t4','tsh','cortisol_morning','igf1','serum_prolactin'],
};

// Specimen-type groups — defines display order, icon, colours, and which labs belong
const SPECIMEN_GROUPS = [
  {
    id:    'hormones',
    label: 'Hormonal Blood Tests',
    icon:  'fa-droplet',
    color: '#0d7377',
    pale:  'rgba(13,115,119,.07)',
    labs:  ['cortisol_morning','acth','tsh','free_t4','free_t3','serum_aldosterone','plasma_renin','aldo_renin_ratio','igf1','serum_prolactin',
            'intact_pth','serum_calcitonin','serum_testosterone','serum_testosterone_free','lh','fsh','amh','dheas','serum_17ohp','esr'],
  },
  {
    id:    'metabolic',
    label: 'Metabolic, Electrolyte & Bone Panel',
    icon:  'fa-bolt',
    color: '#0d7377',
    pale:  'rgba(13,115,119,.07)',
    labs:  ['serum_na','serum_k','serum_glucose','serum_osmolality','hba1c','fasting_insulin','c_peptide',
            'serum_calcium','serum_phosphate','vitamin_d_25oh'],
  },
  {
    id:    'autoimmune',
    label: 'Autoimmune & Antibody Tests',
    icon:  'fa-shield-virus',
    color: '#0d7377',
    pale:  'rgba(13,115,119,.07)',
    labs:  ['trab','anti_tpo'],
  },
  {
    id:    'urine',
    label: 'Urine & 24h Collection Tests',
    icon:  'fa-vial',
    color: '#0d7377',
    pale:  'rgba(13,115,119,.07)',
    labs:  ['cortisol_24h_urine','cortisol_salivary','urine_metanephrines','urine_osmolality','urine_sodium','urine_specific_gravity','urine_5hiaa'],
  },
  {
    id:    'neuroendocrine',
    label: 'Neuroendocrine & Tumour Markers',
    icon:  'fa-atom',
    color: '#0d7377',
    pale:  'rgba(13,115,119,.07)',
    labs:  ['chromogranin_a','serum_gastrin','gh_ogtt','plasma_metanephrines'],
  },
];

// ── PRIORITY LAB DATA (mirrors data_lab_parameters.php $disorderPriorityLabs) ──
const PRIORITY_LABS = {
  primary_hyperaldosteronism: { initial:['serum_k','aldo_renin_ratio'], confirmatory:['serum_aldosterone','plasma_renin'], rationale:'ARR is the recommended screening test (ES 2016). Serum K+ confirms hypokalemia.', canDiagnoseWithInitial:true },
  addisons_disease:           { initial:['cortisol_morning','acth'], confirmatory:['serum_na','serum_k'], rationale:'8 AM cortisol < 5 mcg/dL is highly suggestive. ACTH distinguishes primary vs secondary.', canDiagnoseWithInitial:true },
  pheochromocytoma:           { initial:['plasma_metanephrines'], confirmatory:['urine_metanephrines'], rationale:'Plasma metanephrines are first-line (99% sensitivity). Urine confirms.', canDiagnoseWithInitial:true },
  siadh:                      { initial:['serum_na','serum_osmolality'], confirmatory:['urine_osmolality','urine_sodium'], rationale:'Hyponatremia + low serum osmolality is the diagnostic entry point.', canDiagnoseWithInitial:false },
  acromegaly:                 { initial:['igf1'], confirmatory:['gh_ogtt'], rationale:'IGF-1 is the best single screening test (stable, no fasting required).', canDiagnoseWithInitial:false },
  graves_disease:             { initial:['tsh','free_t4'], confirmatory:['trab'], rationale:'TSH + Free T4 establish hyperthyroidism. TRAb confirms Graves autoimmunity.', canDiagnoseWithInitial:false },
  hypothyroidism:             { initial:['tsh'], confirmatory:['free_t4','anti_tpo'], rationale:'TSH alone is first-line. If elevated, Free T4 confirms overt hypothyroidism.', canDiagnoseWithInitial:false },
  cushing_syndrome:           { initial:['cortisol_24h_urine'], confirmatory:['cortisol_salivary','acth'], rationale:'24h urinary free cortisol is a standard first-line screening test.', canDiagnoseWithInitial:false },
  diabetes_insipidus:         { initial:['serum_na','serum_osmolality'], confirmatory:['urine_osmolality','urine_specific_gravity'], rationale:'Hypernatremia + high serum osmolality establishes the entry point.', canDiagnoseWithInitial:false },
  prolactinoma:               { initial:['serum_prolactin'], confirmatory:['free_t4','igf1'], rationale:'A single serum prolactin > 250 ng/mL is almost always diagnostic.', canDiagnoseWithInitial:true },
  type2_diabetes:             { initial:['serum_glucose','hba1c'], confirmatory:['fasting_insulin'], rationale:'Fasting glucose + HbA1c together establish diagnosis per ADA criteria.', canDiagnoseWithInitial:true },
  type1_diabetes:             { initial:['serum_glucose','hba1c'], confirmatory:['c_peptide','fasting_insulin'], rationale:'Glucose + HbA1c establish DM. Low C-peptide differentiates T1DM from T2DM.', canDiagnoseWithInitial:false },
  hyperparathyroidism:        { initial:['serum_calcium','intact_pth'], confirmatory:['serum_phosphate','vitamin_d_25oh'], rationale:'Hypercalcemia + elevated PTH is the classic diagnostic pair.', canDiagnoseWithInitial:true },
  hypoparathyroidism:         { initial:['serum_calcium','intact_pth'], confirmatory:['serum_phosphate'], rationale:'Low calcium + inappropriately low PTH is diagnostic.', canDiagnoseWithInitial:true },
  congenital_adrenal_hyperplasia: { initial:['serum_17ohp','acth'], confirmatory:['dheas','cortisol_morning'], rationale:'Elevated 17-OHP (especially post-ACTH stimulation) is the hallmark.', canDiagnoseWithInitial:true },
  polycystic_ovary_syndrome:  { initial:['serum_testosterone_free','lh'], confirmatory:['amh','fasting_insulin'], rationale:'Free testosterone + LH:FSH ratio are first-line tests.', canDiagnoseWithInitial:false },
  male_hypogonadism:          { initial:['serum_testosterone'], confirmatory:['lh','fsh'], rationale:'Total testosterone (drawn 8–10 AM) is the mandatory first test.', canDiagnoseWithInitial:false },
  osteoporosis:               { initial:['vitamin_d_25oh','serum_calcium'], confirmatory:['intact_pth','serum_phosphate'], rationale:'Vitamin D + calcium are the foundational metabolic bone labs.', canDiagnoseWithInitial:false },
  vitamin_d_deficiency:       { initial:['vitamin_d_25oh'], confirmatory:['intact_pth','serum_calcium'], rationale:'25-OH Vitamin D is the single definitive test. < 20 ng/mL = deficiency (ES).', canDiagnoseWithInitial:true },
  thyroid_nodule_cancer:      { initial:['tsh','serum_calcitonin'], confirmatory:['chromogranin_a'], rationale:'TSH + calcitonin is the initial panel. Elevated calcitonin suggests medullary cancer.', canDiagnoseWithInitial:false },
  subclinical_hypothyroidism: { initial:['tsh','free_t4'], confirmatory:['anti_tpo'], rationale:'High TSH + normal Free T4 defines subclinical hypothyroidism.', canDiagnoseWithInitial:true },
  multiple_endocrine_neoplasia_type1: { initial:['serum_calcium','intact_pth','serum_prolactin'], confirmatory:['serum_gastrin','igf1','chromogranin_a'], rationale:'MEN1 triad: screen parathyroid (Ca/PTH), pituitary (prolactin), and pancreas (gastrin).', canDiagnoseWithInitial:false },
  carcinoid_syndrome:         { initial:['urine_5hiaa','chromogranin_a'], confirmatory:[], rationale:'24h urine 5-HIAA + plasma chromogranin A are the diagnostic pair.', canDiagnoseWithInitial:true },
  insulinoma:                 { initial:['serum_glucose','fasting_insulin'], confirmatory:['c_peptide'], rationale:"Whipple's triad: fasting hypoglycemia + high insulin + symptom relief with glucose.", canDiagnoseWithInitial:false },
  thyroiditis_subacute:       { initial:['tsh','free_t4'], confirmatory:['esr'], rationale:'Transient hyperthyroidism (low TSH/high T4). Very high ESR is characteristic.', canDiagnoseWithInitial:false },
  central_hypothyroidism:     { initial:['free_t4','tsh'], confirmatory:['cortisol_morning','igf1'], rationale:'Low Free T4 with low/normal TSH (pituitary failure). Evaluate other axes.', canDiagnoseWithInitial:false },
};

// v6.0 — Smart priority lab screen: shows only 1-2 initial tests per top disorder
// ── SCREEN 2.5: Show recommended lab TEST NAMES to order ──────────────────
function goToOrderLabsScreen() {
  const selectedArr = [...selectedSymptoms];
  if (!selectedArr.length) return;

  const age    = parseInt(document.getElementById('patientAge').value) || 0;
  const gender = document.getElementById('patientGender').value;
  const symMatches = weightedMatch(selectedArr, age, gender);
  const top5 = symMatches.slice(0, 5);

  // Collect initial + confirmatory labs per disorder
  const allLabIds     = new Set();
  const initialLabIds = new Set();
  const confLabIds    = new Set();
  const labToDisorders = {};
  const labIsInitial   = {};

  const disOrderShort = {
    primary_hyperaldosteronism:"Conn's", addisons_disease:"Addison's",
    pheochromocytoma:"Pheo", siadh:"SIADH", acromegaly:"Acromegaly",
    graves_disease:"Graves'", hypothyroidism:"Hypothyroid", cushing_syndrome:"Cushing's",
    diabetes_insipidus:"Diab. Insipidus", prolactinoma:"Prolactinoma",
    type2_diabetes:"T2DM", type1_diabetes:"T1DM",
    hyperparathyroidism:"Hyperparathyroid", hypoparathyroidism:"Hypoparathyroid",
    congenital_adrenal_hyperplasia:"CAH", polycystic_ovary_syndrome:"PCOS",
    male_hypogonadism:"Hypogonadism", osteoporosis:"Osteoporosis",
    vitamin_d_deficiency:"Vit D Def", thyroid_nodule_cancer:"Thyroid Ca",
    subclinical_hypothyroidism:"Sub-Hypothyroid", multiple_endocrine_neoplasia_type1:"MEN1",
    carcinoid_syndrome:"Carcinoid", insulinoma:"Insulinoma",
    thyroiditis_subacute:"Thyroiditis", central_hypothyroidism:"Central Hypothyroid"
  };

  top5.forEach(r => {
    const pl = PRIORITY_LABS[r.id];
    if (!pl) return;
    (pl.initial || []).forEach(labId => {
      allLabIds.add(labId); initialLabIds.add(labId);
      labIsInitial[labId] = true;
      if (!labToDisorders[labId]) labToDisorders[labId] = [];
      if (!labToDisorders[labId].includes(r.id)) labToDisorders[labId].push(r.id);
    });
    (pl.confirmatory || []).forEach(labId => {
      if (!initialLabIds.has(labId)) {
        allLabIds.add(labId); confLabIds.add(labId);
        if (!labIsInitial[labId]) labIsInitial[labId] = false;
      }
      if (!labToDisorders[labId]) labToDisorders[labId] = [];
      if (!labToDisorders[labId].includes(r.id)) labToDisorders[labId].push(r.id);
    });
  });

  // ── Render disorder summary ──
  const summaryDiv = document.getElementById('orderLabsDisorderSummary');
  summaryDiv.innerHTML = `
    <div style="font-size:.72rem;letter-spacing:1.4px;text-transform:uppercase;color:var(--gold);font-weight:700;margin-bottom:10px;">
      <i class="fa-solid fa-ranking-star"></i> Top Suspected Disorders (by symptom match)
    </div>
    <div style="display:flex;flex-wrap:wrap;gap:8px;">
      ${top5.map((r,i) => `
        <div style="background:var(--surface);border:1.5px solid ${i===0?'var(--teal)':'var(--border)'};border-radius:10px;padding:8px 14px;display:flex;align-items:center;gap:8px;">
          <span style="width:22px;height:22px;border-radius:50%;background:${i===0?'var(--teal)':'var(--surface2)'};color:${i===0?'#fff':'var(--slate)'};display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:700;flex-shrink:0;">${i+1}</span>
          <div>
            <div style="font-size:.82rem;font-weight:600;color:var(--text);line-height:1.2;">${r.name}</div>
            <div style="font-size:.7rem;color:var(--slate-lt);">Symptom match: ${r.match_percentage}%</div>
          </div>
        </div>`).join('')}
    </div>`;

  // ── Render lab order list grouped by specimen type ──
  const container = document.getElementById('orderLabsContainer');
  container.innerHTML = '';

  if (allLabIds.size === 0) {
    container.innerHTML = '<div style="text-align:center;padding:40px;color:var(--slate-lt);"><i class="fa-solid fa-flask" style="font-size:2rem;display:block;margin-bottom:12px;"></i><p>No specific labs found. Proceed to symptom-based assessment.</p></div>';
  } else {
    // Section: Initial (First-line) Tests
    const initialInGroups = [];
    const confInGroups    = [];

    SPECIMEN_GROUPS.forEach(grp => {
      const initLabs = grp.labs.filter(id => initialLabIds.has(id) && LAB_META[id]);
      const confLabs = grp.labs.filter(id => confLabIds.has(id) && LAB_META[id]);
      if (initLabs.length) initialInGroups.push({ grp, labs: initLabs });
      if (confLabs.length) confInGroups.push({ grp, labs: confLabs });
    });

    // Helper: build a test-order card
    function buildOrderCard(grpData, tier) {
      const { grp, labs } = grpData;
      const isInitial = tier === 'initial';
      const card = document.createElement('div');
      card.style.cssText = 'background:var(--surface);border:1px solid var(--border);border-radius:16px;margin-bottom:16px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.07);';
      card.innerHTML = `
        <div style="background:${grp.color};padding:13px 20px;display:flex;align-items:center;gap:12px;">
          <div style="width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fa-solid ${grp.icon}" style="color:#fff;font-size:1rem;"></i>
          </div>
          <div style="flex:1;">
            <div style="font-size:.9rem;font-weight:700;color:#fff;">${grp.label}</div>
            <div style="font-size:.72rem;color:rgba(255,255,255,.7);margin-top:2px;">${labs.length} test${labs.length>1?'s':''}</div>
          </div>
        </div>
        <div style="padding:14px 18px;display:flex;flex-direction:column;gap:10px;">
          ${labs.map((labId, idx) => {
            const m = LAB_META[labId] || {};
            const disorders = (labToDisorders[labId]||[]).map(d => {
              const match = top5.find(r => r.id === d);
              return match ? match.name : d;
            });
            return `
            <div style="display:flex;align-items:flex-start;gap:14px;padding:12px 14px;background:var(--surface2);border-radius:10px;border:1px solid var(--border);">
              <div style="width:28px;height:28px;border-radius:50%;background:${isInitial?grp.color:'var(--gold)'};color:#fff;display:flex;align-items:center;justify-content:center;font-size:.78rem;font-weight:700;flex-shrink:0;margin-top:1px;">${idx+1}</div>
              <div style="flex:1;">
                <div style="font-size:.92rem;font-weight:700;color:var(--text);line-height:1.3;">
                  ${m.label || labId}
                  ${m.unit ? `<span style="font-weight:400;color:var(--slate-lt);font-size:.78rem;"> — ${m.unit}</span>` : ''}
                </div>
                <div style="font-size:.78rem;color:var(--slate-lt);margin-top:4px;line-height:1.5;">
                  <i class="fa-solid fa-circle-info" style="color:${grp.color};font-size:.65rem;"></i>
                  <strong>Normal range:</strong> ${m.ref || '—'} &nbsp;·&nbsp; ${m.hint || ''}
                </div>
                ${disorders.length ? `
                <div style="margin-top:6px;display:flex;flex-wrap:wrap;gap:4px;">
                  <span style="font-size:.65rem;color:var(--slate-lt);font-weight:600;letter-spacing:.5px;text-transform:uppercase;align-self:center;">Screens for:</span>
                  ${disorders.map(d => `<span style="font-size:.68rem;background:${grp.pale};color:${grp.color};border:1px solid ${grp.color}44;padding:2px 9px;border-radius:10px;font-weight:600;">${d}</span>`).join('')}
                </div>` : ''}
              </div>
            </div>`;
          }).join('')}
        </div>`;
      container.appendChild(card);
    }

    // Section header: First-line
    if (initialInGroups.length) {
      const h = document.createElement('div');
      h.innerHTML = `
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;margin-top:4px;">
          <div style="width:36px;height:36px;border-radius:50%;background:var(--teal);display:flex;align-items:center;justify-content:center;">
            <i class="fa-solid fa-1" style="color:#fff;font-size:.9rem;"></i>
          </div>
          <div>
            <div style="font-size:1rem;font-weight:700;color:var(--text);">First-Line Investigations — Initial Workup</div>
            <div style="font-size:.78rem;color:var(--slate-lt);">These are the mandatory initial investigations based on the presenting symptoms</div>
          </div>
        </div>`;
      container.appendChild(h);
      initialInGroups.forEach(g => buildOrderCard(g, 'initial'));
    }

    // Section header: Confirmatory
    if (confInGroups.length) {
      const h2 = document.createElement('div');
      h2.innerHTML = `
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;margin-top:20px;">
          <div style="width:36px;height:36px;border-radius:50%;background:var(--gold);display:flex;align-items:center;justify-content:center;">
            <i class="fa-solid fa-2" style="color:#fff;font-size:.9rem;"></i>
          </div>
          <div>
            <div style="font-size:1rem;font-weight:700;color:var(--text);">Confirmatory Tests — Order If Initial Results Are Borderline</div>
            <div style="font-size:.78rem;color:var(--slate-lt);">These may be needed to confirm the suspected diagnosis — order based on clinical judgement</div>
          </div>
        </div>`;
      container.appendChild(h2);
      confInGroups.forEach(g => buildOrderCard(g, 'confirmatory'));
    }
  }

  const sub = document.getElementById('orderLabsSub');
  if (sub) sub.textContent = `${allLabIds.size} tests recommended · ${initialLabIds.size} first-line, ${confLabIds.size} confirmatory`;

  showScreen('screen-order-labs');
}

function goToLabScreen() {
  const selectedArr = [...selectedSymptoms];
  if (!selectedArr.length) return;

  // Quick symptom match to find top disorders
  const age    = parseInt(document.getElementById('patientAge').value) || 0;
  const gender = document.getElementById('patientGender').value;
  const symMatches = weightedMatch(selectedArr, age, gender);
  const top5 = symMatches.slice(0, 5);

  // Collect unique initial lab IDs across top 5 disorders (de-duplicated)
  const priorityLabIds   = new Set();
  const labToDisorders   = {};
  const disorderRationale = {};

  top5.forEach(r => {
    const pl = PRIORITY_LABS[r.id];
    if (!pl) return;
    disorderRationale[r.id] = { name: r.name, rationale: pl.rationale, pct: r.match_percentage };
    pl.initial.forEach(labId => {
      priorityLabIds.add(labId);
      if (!labToDisorders[labId]) labToDisorders[labId] = [];
      if (!labToDisorders[labId].includes(r.id)) labToDisorders[labId].push(r.id);
    });
  });

  const container = document.getElementById('labFieldsContainer');
  container.innerHTML = '';

  // Render suspected disorders summary at top
  if (top5.length) {
    const summaryDiv = document.createElement('div');
    summaryDiv.style.cssText = 'margin-bottom:22px;';
    summaryDiv.innerHTML = `
      <div style="font-size:.72rem;letter-spacing:1.4px;text-transform:uppercase;color:var(--gold);font-weight:700;margin-bottom:10px;">
        <i class="fa-solid fa-ranking-star"></i> Top Suspected Disorders (by symptom match)
      </div>
      <div style="display:flex;flex-wrap:wrap;gap:8px;">
        ${top5.map((r,i) => `
          <div style="background:var(--surface);border:1.5px solid ${i===0?'var(--teal)':'var(--border)'};border-radius:10px;padding:8px 14px;display:flex;align-items:center;gap:8px;${i===0?'box-shadow:0 2px 10px rgba(13,92,99,.12);':''}">
            <span style="width:22px;height:22px;border-radius:50%;background:${i===0?'var(--teal)':'var(--surface2)'};color:${i===0?'#fff':'var(--slate)'};display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:700;flex-shrink:0;">${i+1}</span>
            <div>
              <div style="font-size:.82rem;font-weight:600;color:var(--text);line-height:1.2;">${r.name}</div>
              <div style="font-size:.7rem;color:var(--slate-lt);">Symptom match: ${r.match_percentage}%</div>
            </div>
          </div>`).join('')}
      </div>`;
    container.appendChild(summaryDiv);
  }

  if (priorityLabIds.size === 0) {
    container.innerHTML += '<div style="text-align:center;padding:40px;color:var(--slate-lt);"><i class="fa-solid fa-flask" style="font-size:2rem;display:block;margin-bottom:12px;"></i><p>No priority labs available. Use "Skip" to proceed with symptom-based assessment.</p></div>';
  } else {
    // ── Group by SPECIMEN TYPE (test-wise grouping, not disorder-wise) ──
    SPECIMEN_GROUPS.forEach(grp => {
      // Find which labs in this specimen group are in our priorityLabIds
      const labsInGroup = grp.labs.filter(labId => priorityLabIds.has(labId) && LAB_META[labId]);
      if (!labsInGroup.length) return;

      const card = document.createElement('div');
      card.style.cssText = 'background:var(--surface);border:1px solid var(--border);border-radius:16px;margin-bottom:20px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.07);';

      // Build "relevant for disorders" tags for the header
      const disorderTags = top5
        .filter(r => {
          const pl = PRIORITY_LABS[r.id];
          return pl && pl.initial.some(l => labsInGroup.includes(l));
        })
        .map(r => `<span style="font-size:.68rem;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);color:rgba(255,255,255,.85);padding:2px 9px;border-radius:20px;white-space:nowrap;">${r.name}</span>`)
        .join('');

      card.innerHTML = `
        <div style="background:${grp.color};padding:13px 20px;display:flex;align-items:center;gap:12px;">
          <div style="width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fa-solid ${grp.icon}" style="color:#fff;font-size:1rem;"></i>
          </div>
          <div style="flex:1;">
            <div style="font-size:.9rem;font-weight:700;color:#fff;">${grp.label}</div>
            <div style="font-size:.72rem;color:rgba(255,255,255,.65);margin-top:3px;">${labsInGroup.length} test${labsInGroup.length>1?'s':''} required</div>
          </div>
        </div>
        ${disorderTags ? `
        <div style="padding:8px 18px;background:${grp.pale};border-bottom:1px solid var(--border);display:flex;flex-wrap:wrap;gap:6px;align-items:center;">
          <span style="font-size:.7rem;color:var(--slate-lt);font-weight:600;letter-spacing:.8px;text-transform:uppercase;margin-right:4px;">Relevant for:</span>
          ${top5
            .filter(r => { const pl = PRIORITY_LABS[r.id]; return pl && pl.initial.some(l => labsInGroup.includes(l)); })
            .map(r => `<span style="font-size:.72rem;background:var(--surface);border:1.5px solid ${grp.color};color:${grp.color};padding:2px 10px;border-radius:20px;font-weight:600;">${r.name}</span>`)
            .join('')}
        </div>` : ''}
        <div style="padding:16px 18px;display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:12px;">
          ${labsInGroup.map(labId => {
            const m = LAB_META[labId] || {};
            // Which disorders need this specific lab?
            const neededBy = top5.filter(r => {
              const pl = PRIORITY_LABS[r.id];
              return pl && pl.initial.includes(labId);
            }).map(r => r.name);
            return `
            <div class="lab-field-wrap" data-lab-id="${labId}" style="background:var(--surface2);border:1px solid var(--border);border-radius:10px;padding:12px 14px;">
              <label style="font-size:.82rem;font-weight:600;color:var(--text);display:block;margin-bottom:6px;line-height:1.3;">
                ${m.label || labId}
                ${m.unit ? `<span style="font-weight:400;color:var(--slate-lt);font-size:.75rem;"> (${m.unit})</span>` : ''}
              </label>
              <div style="position:relative;">
                <input type="number" step="any" id="lab_${labId}" placeholder="Enter the value"
                  oninput="onLabInput(this,'${labId}')"
                  style="width:100%;padding:9px 44px 9px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:.92rem;background:var(--surface);color:var(--text);transition:border-color .2s;box-sizing:border-box;font-family:var(--font-mono);">
                <span class="lab-flag" id="flag_${labId}" style="display:none;position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:.72rem;font-weight:700;border-radius:4px;padding:2px 7px;letter-spacing:.5px;"></span>
              </div>
              <div style="font-size:.73rem;color:var(--slate-lt);margin-top:5px;">
                <i class="fa-solid fa-circle-info" style="font-size:.62rem;color:${grp.color};"></i>
                Ref: <strong style="color:var(--text-muted);">${m.ref || '—'}</strong> &nbsp;·&nbsp; ${m.hint || ''}
              </div>
              ${neededBy.length ? `<div style="margin-top:6px;display:flex;flex-wrap:wrap;gap:4px;">
                ${neededBy.map(d => `<span style="font-size:.65rem;background:${grp.pale};color:${grp.color};border:1px solid ${grp.color}33;padding:1px 7px;border-radius:10px;font-weight:600;">${d}</span>`).join('')}
              </div>` : ''}
            </div>`;
          }).join('')}
        </div>`;
      container.appendChild(card);
    });
  }

  const sub = document.getElementById('labScreenSub');
  if (sub) sub.textContent = `${priorityLabIds.size} priority tests for ${top5.length} suspected disorders`;

  enteredLabValues = {};
  updateLabCount();
  showScreen('screen-labs');
}

function goBackToSymptoms() {
  showScreen('screen-input');
}

// Check if confirmatory test is needed based on initial lab results
function needsConfirmatory(topResult) {
  if (!topResult) return false;
  const pl = PRIORITY_LABS[topResult.id];
  if (!pl || pl.canDiagnoseWithInitial) return false;
  if (!pl.confirmatory || !pl.confirmatory.length) return false;
  // Check if any initial labs were entered and are borderline
  const initialEntered = pl.initial.filter(l => enteredLabValues[l] !== undefined);
  if (!initialEntered.length) return false;
  // Borderline = lab is entered but NOT in matched labs
  const topMatchedLabs = topResult.matched_labs_ids || [];
  const initialHit = initialEntered.some(l => topMatchedLabs.includes(l));
  // If we have initial labs but none confirm the top disorder, suggest confirmatory
  return initialEntered.length > 0 && !initialHit;
}

// Build and show confirmatory lab screen
function showConfirmatoryScreen(topResult, currentResults) {
  const pl = PRIORITY_LABS[topResult.id];
  const confLabs = (pl.confirmatory || []).filter(l => LAB_META[l] && !(l in enteredLabValues));

  document.getElementById('confScreenSub').textContent = `Confirm: ${topResult.name}`;
  document.getElementById('confReasonText').textContent =
    `Your initial labs for ${topResult.name} are available but the result is borderline. Ordering ${confLabs.length === 1 ? 'this test' : 'these tests'} will help confirm or rule out the diagnosis before a final recommendation is made.`;

  // Top suspected summary
  const topDiv = document.getElementById('confTopDxSummary');
  topDiv.innerHTML = `
    <div style="display:flex;gap:14px;align-items:center;flex-wrap:wrap;">
      <div style="flex:1;">
        <div style="font-size:.7rem;color:var(--gold);font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:4px;">Top Suspected Diagnosis</div>
        <div style="font-size:1.05rem;font-weight:700;color:var(--text);">${topResult.name}</div>
        <div style="font-size:.78rem;color:var(--slate-lt);margin-top:2px;">Symptom match: ${topResult.match_percentage}% &nbsp;·&nbsp; Lab match: ${topResult.lab_pct || 0}%</div>
        <div style="margin-top:6px;font-size:.8rem;color:var(--slate);">${pl.rationale}</div>
      </div>
      <div style="text-align:center;">
        <div style="font-size:2rem;font-weight:700;color:var(--teal);">${topResult.combined_pct || topResult.match_percentage}%</div>
        <div style="font-size:.72rem;color:var(--slate-lt);">Combined score</div>
      </div>
    </div>`;

  // Render confirmatory lab fields
  const confContainer = document.getElementById('confLabFields');
  confContainer.innerHTML = '';
  if (!confLabs.length) {
    confContainer.innerHTML = '<div style="text-align:center;padding:30px;color:var(--slate-lt);">All confirmatory tests already entered. Proceed to diagnosis.</div>';
  } else {
    confContainer.innerHTML = `
      <div style="font-size:.72rem;letter-spacing:1.3px;text-transform:uppercase;color:var(--teal);font-weight:700;margin-bottom:12px;">
        <i class="fa-solid fa-vial"></i> Confirmatory Test${confLabs.length>1?'s':''}
      </div>
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:12px;">
        ${confLabs.map(labId => {
          const m = LAB_META[labId] || {};
          return `
          <div class="lab-field-wrap" data-lab-id="${labId}" style="background:var(--gold-pale);border:1.5px solid var(--gold);border-radius:10px;padding:14px;">
            <label style="font-size:.82rem;font-weight:600;color:var(--text);display:block;margin-bottom:6px;">
              ${m.label || labId}
              ${m.unit ? `<span style="font-weight:400;color:var(--slate-lt);font-size:.75rem;"> (${m.unit})</span>` : ''}
            </label>
            <div style="position:relative;">
              <input type="number" step="any" id="lab_${labId}" placeholder="Enter the value"
                oninput="onLabInput(this,'${labId}')"
                style="width:100%;padding:9px 44px 9px 12px;border:1.5px solid var(--gold);border-radius:8px;font-size:.92rem;background:var(--surface);color:var(--text);transition:border-color .2s;box-sizing:border-box;font-family:var(--font-mono);">
              <span class="lab-flag" id="flag_${labId}" style="display:none;position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:.72rem;font-weight:700;border-radius:4px;padding:2px 7px;"></span>
            </div>
            <div style="font-size:.73rem;color:var(--slate-lt);margin-top:5px;">
              <i class="fa-solid fa-circle-info" style="font-size:.62rem;color:var(--gold);"></i>
              Ref: <strong>${m.ref||'—'}</strong> &nbsp;·&nbsp; ${m.hint||''}
            </div>
          </div>`;
        }).join('')}
      </div>`;
  }
  showScreen('screen-confirmatory');
}

function runDiagnosisWithConfirmatory() {
  runDiagnosis(false);
}

// v4.0 — lab input handler
function onLabInput(input, labId) {
  const val = input.value.trim();
  const ref = LAB_REFS[labId];
  const flag = document.getElementById('flag_' + labId);

  input.classList.remove('abnormal-high','abnormal-low','normal-val');
  if (flag) { flag.style.display='none'; flag.className='lab-flag'; }

  if (val === '' || !ref) {
    delete enteredLabValues[labId];
  } else {
    const num = parseFloat(val);
    enteredLabValues[labId] = num;
    if (num > ref.high) {
      input.classList.add('abnormal-high');
      if (flag) { flag.textContent='HIGH'; flag.className='lab-flag flag-high'; flag.style.display='inline-block'; }
    } else if (num < ref.low && ref.low > 0) {
      input.classList.add('abnormal-low');
      if (flag) { flag.textContent='LOW'; flag.className='lab-flag flag-low'; flag.style.display='inline-block'; }
    } else {
      input.classList.add('normal-val');
      if (flag) { flag.textContent='OK'; flag.className='lab-flag flag-ok'; flag.style.display='inline-block'; }
    }
  }
  updateLabCount();
}

function updateLabCount() {
  const count = Object.keys(enteredLabValues).length;
  const el = document.getElementById('labCount');
  if (el) el.textContent = count > 0 ? count + ' entered' : 'None yet — optional';
  // Lab submission is always enabled in v6 (labs are optional)
  const btn = document.getElementById('btnRunDiagnosis');
  if (btn) { btn.disabled = false; btn.style.opacity = '1'; }
}

// ── CHIP TOGGLE ────────────────────────────────────────
function toggleChip(chip) {
  const sym        = chip.dataset.sym;
  const isSelected = chip.classList.contains('selected');
  document.querySelectorAll(`.sym-chip[data-sym="${sym}"]`).forEach(c => {
    c.classList.toggle('selected', !isSelected);
  });
  if (!isSelected) selectedSymptoms.add(sym);
  else             selectedSymptoms.delete(sym);
  renderSelChips();
}

function renderSelChips() {
  const wrap  = document.getElementById('selChips');
  const count = document.getElementById('selCount');
  const btn   = document.getElementById('btnDiagnose');
  count.textContent = selectedSymptoms.size;
  btn.disabled = selectedSymptoms.size === 0;
  if (selectedSymptoms.size === 0) {
    wrap.innerHTML = '<span style="font-size:.75rem;color:var(--slate-lt);font-style:italic;">No symptoms selected &mdash; click chips above to add</span>';
    return;
  }
  wrap.innerHTML = Array.from(selectedSymptoms).map(s => {
    const label = (SYMPTOM_LABELS[s] || s).split('(')[0].trim();
    return `<span class="sel-chip">${label}<button onclick="removeSymptom('${s}')">&#215;</button></span>`;
  }).join('');
}

function removeSymptom(sym) {
  selectedSymptoms.delete(sym);
  document.querySelectorAll(`.sym-chip[data-sym="${sym}"]`).forEach(c => c.classList.remove('selected'));
  renderSelChips();
}

function clearAll() {
  selectedSymptoms.clear();
  document.querySelectorAll('.sym-chip').forEach(c => c.classList.remove('selected'));
  renderSelChips();
  // Reset age error state
  const ageInp = document.getElementById('patientAge');
  if (ageInp) { ageInp.style.borderColor=''; ageInp.style.boxShadow=''; }
  const ageErr = document.getElementById('ageError');
  if (ageErr) ageErr.style.display='none';
  showScreen('screen-input');
}

function filterSymptoms(q) {
  q = q.toLowerCase();
  document.querySelectorAll('.sym-chip').forEach(chip => {
    chip.classList.toggle('hidden', !!q && !chip.textContent.toLowerCase().includes(q));
  });
}

function switchCat(cat, btn) {
  document.querySelectorAll('.cat-tab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('.cat-group').forEach(g => g.classList.remove('active'));
  document.getElementById(`cat-${cat}`)?.classList.add('active');
}

// ── WEIGHTED MATCH ENGINE (identical to v3.0) ──────────
function weightedMatch(selectedArr, age, gender) {
  const results = [];
  for (const [pid, pattern] of Object.entries(PATTERNS)) {
    const weights    = pattern.symptom_weights || {};
    const symptomMap = pattern.symptom_map || [];
    if (!symptomMap.length) continue;
    const maxScore = Object.values(weights).reduce((a, b) => a + b, 0);
    if (!maxScore) continue;
    let scored = 0;
    const matched = [], missing = [];
    for (const sym of symptomMap) {
      const w = weights[sym] || 1;
      if (selectedArr.includes(sym)) { scored += w; matched.push({ sym, weight: w }); }
      else missing.push({ sym, weight: w });
    }
    if (scored === 0) continue;
    let matchPct  = Math.round((scored / maxScore) * 100);
    let demoBoost = 0;
    if (age > 0) {
      const ar = pattern.age_range || [0, 100];
      if (age >= ar[0] && age <= ar[1]) demoBoost += 5;
    }
    if (gender && pattern.gender_bias) {
      if (pattern.gender_bias === gender || pattern.gender_bias === 'none') demoBoost += 5;
    }
    const adjustedPct  = Math.min(100, matchPct + demoBoost);
    const cardinalHits = matched.filter(m => m.weight >= 3).length;
    let confidence = 'Low';
    if (adjustedPct >= 75) confidence = 'High';
    else if (adjustedPct >= 50) confidence = 'Moderate';
    results.push({
      ...pattern,
      match_score: scored, max_score: maxScore,
      match_percentage: adjustedPct, base_percentage: matchPct, demo_boost: demoBoost,
      confidence, cardinal_hits: cardinalHits,
      matching_symptoms: matched.map(m => m.sym),
      missing_symptoms:  missing.map(m => m.sym),
    });
  }
  results.sort((a, b) =>
    b.match_percentage !== a.match_percentage
      ? b.match_percentage - a.match_percentage
      : b.cardinal_hits - a.cardinal_hits
  );
  return results;
}

// ── RUN DIAGNOSIS ──────────────────────────────────────
function runDiagnosis(skipLabs) {
  if (selectedSymptoms.size === 0) return;

  document.getElementById('loadingOverlay').classList.add('show');

  setTimeout(() => {
    const selectedArr = Array.from(selectedSymptoms);
    const ageInput    = document.getElementById('patientAge');
    let rawAge        = parseInt(ageInput.value) || 0;

    // Validate age: must be 1–120
    if (rawAge < 0 || rawAge > 120) {
      ageInput.style.borderColor = 'var(--rose)';
      ageInput.style.boxShadow   = '0 0 0 3px rgba(192,57,43,.15)';
      ageInput.focus();
      document.getElementById('ageError').style.display = 'block';
      document.getElementById('loadingOverlay').classList.remove('show');
      return;
    }
    // Clear any previous error
    ageInput.style.borderColor = '';
    ageInput.style.boxShadow   = '';
    document.getElementById('ageError').style.display = 'none';

    currentPatientAge    = rawAge;
    currentPatientGender = document.getElementById('patientGender').value;

    matchResults = weightedMatch(selectedArr, currentPatientAge, currentPatientGender);

    // v4.0 — add lab scoring to each result
    const hasLabs = Object.keys(enteredLabValues).length > 0;
    const labWeightRules = {
      primary_hyperaldosteronism: [
        {lab:'serum_k',dir:'low',w:3},{lab:'serum_aldosterone',dir:'high',w:3},
        {lab:'plasma_renin',dir:'low',w:3},{lab:'aldo_renin_ratio',dir:'high',w:3},
        {lab:'serum_na',dir:'high',w:1},{lab:'serum_glucose',dir:'high',w:1}],
      addisons_disease: [
        {lab:'cortisol_morning',dir:'low',w:3},{lab:'acth',dir:'high',w:3},
        {lab:'serum_na',dir:'low',w:2},{lab:'serum_k',dir:'high',w:2},
        {lab:'serum_glucose',dir:'low',w:2}],
      pheochromocytoma: [
        {lab:'plasma_metanephrines',dir:'high',w:3},{lab:'urine_metanephrines',dir:'high',w:3},
        {lab:'serum_glucose',dir:'high',w:1}],
      siadh: [
        {lab:'serum_na',dir:'low',w:3},{lab:'serum_osmolality',dir:'low',w:3},
        {lab:'urine_osmolality',dir:'high',w:3},{lab:'urine_sodium',dir:'high',w:2}],
      acromegaly: [
        {lab:'igf1',dir:'high',w:3},{lab:'gh_ogtt',dir:'high',w:3},
        {lab:'serum_glucose',dir:'high',w:1}],
      graves_disease: [
        {lab:'tsh',dir:'low',w:3},{lab:'free_t4',dir:'high',w:3},
        {lab:'free_t3',dir:'high',w:2},{lab:'trab',dir:'high',w:3},
        {lab:'anti_tpo',dir:'high',w:1}],
      hypothyroidism: [
        {lab:'tsh',dir:'high',w:3},{lab:'free_t4',dir:'low',w:3},
        {lab:'free_t3',dir:'low',w:2},{lab:'anti_tpo',dir:'high',w:2},
        {lab:'serum_na',dir:'low',w:1}],
      cushings_syndrome: [
        {lab:'cortisol_24h_urine',dir:'high',w:3},{lab:'cortisol_salivary',dir:'high',w:3},
        {lab:'acth',dir:'high',w:2},{lab:'serum_k',dir:'low',w:2},
        {lab:'serum_glucose',dir:'high',w:1}],
      // alias for data_patterns.php key
      cushing_syndrome: [
        {lab:'cortisol_24h_urine',dir:'high',w:3},{lab:'cortisol_salivary',dir:'high',w:3},
        {lab:'acth',dir:'high',w:2},{lab:'serum_k',dir:'low',w:2},
        {lab:'serum_glucose',dir:'high',w:1}],
      diabetes_insipidus: [
        {lab:'serum_na',dir:'high',w:3},{lab:'serum_osmolality',dir:'high',w:3},
        {lab:'urine_osmolality',dir:'low',w:3},{lab:'urine_specific_gravity',dir:'low',w:2}],
      prolactinoma: [
        {lab:'serum_prolactin',dir:'high',w:3},{lab:'igf1',dir:'high',w:1},
        {lab:'free_t4',dir:'low',w:1}],

      // ── v5.0 NEW DISORDERS ──────────────────────────────────────
      type2_diabetes: [
        {lab:'serum_glucose',dir:'high',w:3},{lab:'hba1c',dir:'high',w:3},
        {lab:'fasting_insulin',dir:'high',w:2},{lab:'c_peptide',dir:'high',w:1}],
      type1_diabetes: [
        {lab:'serum_glucose',dir:'high',w:3},{lab:'hba1c',dir:'high',w:3},
        {lab:'c_peptide',dir:'low',w:3},{lab:'fasting_insulin',dir:'low',w:2}],
      hyperparathyroidism: [
        {lab:'serum_calcium',dir:'high',w:3},{lab:'intact_pth',dir:'high',w:3},
        {lab:'serum_phosphate',dir:'low',w:2},{lab:'vitamin_d_25oh',dir:'low',w:1}],
      hypoparathyroidism: [
        {lab:'serum_calcium',dir:'low',w:3},{lab:'intact_pth',dir:'low',w:3},
        {lab:'serum_phosphate',dir:'high',w:2},{lab:'vitamin_d_25oh',dir:'low',w:1}],
      congenital_adrenal_hyperplasia: [
        {lab:'serum_17ohp',dir:'high',w:3},{lab:'acth',dir:'high',w:3},
        {lab:'serum_na',dir:'low',w:2},{lab:'serum_k',dir:'high',w:2},
        {lab:'dheas',dir:'high',w:2},{lab:'cortisol_morning',dir:'low',w:2}],
      polycystic_ovary_syndrome: [
        {lab:'serum_testosterone_free',dir:'high',w:3},{lab:'lh',dir:'high',w:2},
        {lab:'amh',dir:'high',w:2},{lab:'dheas',dir:'high',w:1},
        {lab:'fasting_insulin',dir:'high',w:2}],
      male_hypogonadism: [
        {lab:'serum_testosterone',dir:'low',w:3},{lab:'serum_testosterone_free',dir:'low',w:3},
        {lab:'lh',dir:'low',w:2},{lab:'fsh',dir:'low',w:2},
        {lab:'serum_prolactin',dir:'high',w:1}],
      osteoporosis: [
        {lab:'serum_calcium',dir:'low',w:2},{lab:'vitamin_d_25oh',dir:'low',w:3},
        {lab:'intact_pth',dir:'high',w:2},{lab:'serum_phosphate',dir:'low',w:1}],
      vitamin_d_deficiency: [
        {lab:'vitamin_d_25oh',dir:'low',w:3},{lab:'intact_pth',dir:'high',w:2},
        {lab:'serum_calcium',dir:'low',w:2},{lab:'serum_phosphate',dir:'low',w:1}],
      thyroid_nodule_cancer: [
        {lab:'serum_calcitonin',dir:'high',w:3},{lab:'chromogranin_a',dir:'high',w:1},
        {lab:'tsh',dir:'low',w:1}],
      subclinical_hypothyroidism: [
        {lab:'tsh',dir:'high',w:3},{lab:'free_t4',dir:'low',w:1},
        {lab:'anti_tpo',dir:'high',w:2}],
      multiple_endocrine_neoplasia_type1: [
        {lab:'serum_calcium',dir:'high',w:3},{lab:'intact_pth',dir:'high',w:3},
        {lab:'serum_gastrin',dir:'high',w:3},{lab:'serum_prolactin',dir:'high',w:2},
        {lab:'igf1',dir:'high',w:2},{lab:'serum_glucose',dir:'low',w:2},
        {lab:'chromogranin_a',dir:'high',w:2}],
      carcinoid_syndrome: [
        {lab:'urine_5hiaa',dir:'high',w:3},{lab:'chromogranin_a',dir:'high',w:3},
        {lab:'serum_glucose',dir:'high',w:1}],
      insulinoma: [
        {lab:'serum_glucose',dir:'low',w:3},{lab:'fasting_insulin',dir:'high',w:3},
        {lab:'c_peptide',dir:'high',w:3},{lab:'chromogranin_a',dir:'high',w:1}],
      thyroiditis_subacute: [
        {lab:'tsh',dir:'low',w:3},{lab:'free_t4',dir:'high',w:2},
        {lab:'esr',dir:'high',w:3}],
      central_hypothyroidism: [
        {lab:'free_t4',dir:'low',w:3},{lab:'tsh',dir:'low',w:2},
        {lab:'cortisol_morning',dir:'low',w:2},{lab:'igf1',dir:'low',w:1},
        {lab:'serum_prolactin',dir:'high',w:1}],
    };

    matchResults.forEach(r => {
      const rules = labWeightRules[r.id] || [];
      let labScore = 0, labMax = 0;
      const matchedLabs = [], missingLabs = [];

      rules.forEach(rule => {
        labMax += rule.w;
        const ref = LAB_REFS[rule.lab];
        const val = enteredLabValues[rule.lab];
        if (val !== undefined && ref) {
          let abnormal = false;
          if (rule.dir === 'high' && val > ref.high) abnormal = true;
          if (rule.dir === 'low'  && val < ref.low)  abnormal = true;
          if (abnormal) { labScore += rule.w; matchedLabs.push(rule.lab); }
          else missingLabs.push(rule.lab);
        } else {
          missingLabs.push(rule.lab);
        }
      });

      r.lab_score = labScore;
      r.lab_max   = labMax;
      r.matched_labs_ids = matchedLabs;
      r.missing_labs_ids = missingLabs;

      if (hasLabs && labMax > 0) {
        const labPct = Math.round((labScore / labMax) * 100);
        const combined = Math.min(100, Math.round((r.match_percentage * 0.60) + (labPct * 0.40)));
        r.lab_pct      = labPct;
        r.combined_pct = combined;
        r.combined_confidence = combined >= 75 ? 'High' : combined >= 50 ? 'Moderate' : 'Low';
      } else {
        r.lab_pct      = 0;
        r.combined_pct = r.match_percentage;
        r.combined_confidence = r.confidence;
      }
    });

    // Re-sort by combined
    matchResults.sort((a,b) =>
      b.combined_pct !== a.combined_pct
        ? b.combined_pct - a.combined_pct
        : b.cardinal_hits - a.cardinal_hits
    );

    // Update results topbar
    document.getElementById('resCount').textContent = `${matchResults.length} found`;
    const parts = [`${selectedArr.length} symptom${selectedArr.length !== 1 ? 's' : ''} analysed`];
    if (hasLabs) parts.push(`${Object.keys(enteredLabValues).length} lab values`);
    document.getElementById('rtbSub').textContent = parts.join(' · ');

    // Patient chip
    const pcParts = [];
    if (currentPatientAge)    pcParts.push(`Age ${currentPatientAge}`);
    if (currentPatientGender) pcParts.push(currentPatientGender.charAt(0).toUpperCase() + currentPatientGender.slice(1));
    const pchip = document.getElementById('patientChip');
    if (pcParts.length) {
      document.getElementById('patientChipText').textContent = pcParts.join(', ');
      pchip.style.display = 'flex';
    } else {
      pchip.style.display = 'none';
    }

    // Emergency check
    const emg = matchResults.filter(r => r.priority === 'emergency' && (r.combined_pct || r.match_percentage) >= 40);
    const banner = document.getElementById('emgBanner');
    if (emg.length) {
      document.getElementById('emgBannerMsg').textContent =
        emg.map(e => e.name).join(', ') + ' \u2014 Immediate clinical assessment required.';
      banner.classList.add('show');
    } else {
      banner.classList.remove('show');
    }

    // Render cards
    renderCards(matchResults);

    // ── v6.0 CONFIRMATORY CHECK: if top disorder is borderline, offer one more test ──
    if (!skipLabs && matchResults.length > 0) {
      const top = matchResults[0];
      if (needsConfirmatory(top)) {
        document.getElementById('loadingOverlay').classList.remove('show');
        showConfirmatoryScreen(top, matchResults);
        return;
      }
    }

    // Hide loading, show results screen
    document.getElementById('loadingOverlay').classList.remove('show');
    showScreen('screen-results');
  }, 550);
}

// ── RENDER CARDS (v6.0 — with 3-tier verdict) ──────────────────
function renderCards(results) {
  const grid = document.getElementById('cardsGrid');
  const wts  = {};
  for (const [pid, p] of Object.entries(PATTERNS)) wts[pid] = p.symptom_weights || {};

  if (!results.length) {
    grid.innerHTML = `
      <div class="empty-state">
        <div class="empty-icon">&#x1F50D;</div>
        <h3>No Matches Found</h3>
        <p>No patterns matched your selected symptoms.<br>Try selecting more or different symptoms.</p>
      </div>`;
    return;
  }

  // ── 3-Tier Verdict Banner ──
  const top       = results[0];
  const hasLabs   = Object.keys(enteredLabValues).length > 0;
  const topScore  = top.combined_pct || top.match_percentage;
  const labPct    = top.lab_pct || 0;

  let verdictHtml = '';
  if (topScore >= 75 && hasLabs && labPct >= 60) {
    verdictHtml = `
      <div style="background:var(--emerald-pale);border:2px solid var(--emerald);border-radius:14px;padding:18px 22px;margin-bottom:22px;display:flex;gap:14px;align-items:flex-start;">
        <i class="fa-solid fa-circle-check" style="color:var(--emerald);font-size:1.4rem;flex-shrink:0;margin-top:2px;"></i>
        <div>
          <div style="font-size:1rem;font-weight:700;color:var(--emerald);">&#x2714; CONFIRMED — High Clinical Confidence</div>
          <div style="font-size:.85rem;color:var(--slate);margin-top:4px;">Symptom pattern <strong>and</strong> laboratory results both strongly support <strong>${escHtml(top.name)}</strong>. Proceed with guideline-directed management.</div>
          <div style="font-size:.75rem;color:var(--slate-lt);margin-top:4px;">Symptom: ${top.match_percentage}% &nbsp;·&nbsp; Lab: ${labPct}% &nbsp;·&nbsp; Combined: ${topScore}%</div>
        </div>
      </div>`;
  } else if (topScore >= 50) {
    const labNote = hasLabs ? ` Lab confirmation: ${labPct}%.` : ' Labs not yet entered.';
    verdictHtml = `
      <div style="background:#fff4e0;border:2px solid #f0a830;border-radius:14px;padding:18px 22px;margin-bottom:22px;display:flex;gap:14px;align-items:flex-start;">
        <i class="fa-solid fa-triangle-exclamation" style="color:#a05c00;font-size:1.4rem;flex-shrink:0;margin-top:2px;"></i>
        <div>
          <div style="font-size:1rem;font-weight:700;color:#a05c00;">&#x26A0; PROBABLE — Moderate Confidence</div>
          <div style="font-size:.85rem;color:var(--slate);margin-top:4px;"><strong>${escHtml(top.name)}</strong> is the most likely diagnosis based on symptom pattern (${top.match_percentage}%).${labNote} Order confirmatory labs or refer for specialist evaluation.</div>
        </div>
      </div>`;
  } else {
    verdictHtml = `
      <div style="background:var(--rose-pale);border:2px solid var(--rose);border-radius:14px;padding:18px 22px;margin-bottom:22px;display:flex;gap:14px;align-items:flex-start;">
        <i class="fa-solid fa-user-doctor" style="color:var(--rose);font-size:1.4rem;flex-shrink:0;margin-top:2px;"></i>
        <div>
          <div style="font-size:1rem;font-weight:700;color:var(--rose);">&#x1F4CB; REFER — Low Confidence / Further Workup Needed</div>
          <div style="font-size:.85rem;color:var(--slate);margin-top:4px;">Symptom overlap is insufficient for a confident diagnosis. The results below show possible matches. <strong>Refer to an endocrinologist</strong> and order the labs shown in each card.</div>
        </div>
      </div>`;
  }

  grid.innerHTML = verdictHtml + results.map(r => {
    const hasLabs2  = Object.keys(enteredLabValues).length > 0;
    const pct       = r.combined_pct || r.match_percentage;
    const symPct    = r.match_percentage;
    const labPct2   = r.lab_pct || 0;
    const ringClass = pct >= 70 ? 'high' : pct <= 40 ? 'low-pct' : 'medium';
    const circum    = 2 * Math.PI * 20;
    const dash      = (pct / 100) * circum;
    const gap       = circum - dash;
    const weights   = wts[r.id] || {};

    const matchedHtml = r.matching_symptoms.map(s => {
      const isCard = (weights[s] || 1) >= 3;
      return `<span class="mchip${isCard ? ' cardinal' : ''}" title="${isCard ? 'Cardinal \u2605' : 'Supporting'}">${(SYMPTOM_LABELS[s]||s).split('(')[0].trim()}${isCard ? ' \u2605' : ''}</span>`;
    }).join('');

    const topMissing = r.missing_symptoms.filter(s => (weights[s] || 1) >= 2).slice(0, 4);
    const missingHtml = topMissing.length ? `
      <div class="missing-section">
        <div class="missing-label"><i class="fa-solid fa-lightbulb"></i> Confirm by checking these missing symptoms</div>
        <div class="missing-chips">${topMissing.map(s => `<span class="mschip">${(SYMPTOM_LABELS[s]||s).split('(')[0].trim()}</span>`).join('')}</div>
      </div>` : '';

    const labMatchedHtml = (r.matched_labs_ids||[]).length ? `
      <div class="missing-section" style="margin-top:8px;">
        <div class="missing-label" style="color:var(--teal);"><i class="fa-solid fa-vial"></i> Lab values supporting this diagnosis</div>
        <div class="lab-matched-chips">${(r.matched_labs_ids||[]).map(l => `<span class="lab-chip abnormal">${l.replace(/_/g,' ')}</span>`).join('')}</div>
      </div>` : '';

    // ── v6.0: Priority labs recommendation strip ──
    const pl = PRIORITY_LABS[r.id];
    const recLabsHtml = pl && !hasLabs2 ? `
      <div class="missing-section" style="margin-top:8px;background:var(--teal-pale);border-radius:8px;padding:8px 10px;">
        <div class="missing-label" style="color:var(--teal);"><i class="fa-solid fa-flask-vial"></i> Order these tests first</div>
        <div style="display:flex;flex-wrap:wrap;gap:4px;margin-top:4px;">
          ${pl.initial.map(l => `<span style="font-size:.72rem;background:var(--teal);color:#fff;padding:2px 9px;border-radius:10px;font-weight:600;">${(LAB_META[l]||{label:l}).label}</span>`).join('')}
        </div>
        <div style="font-size:.72rem;color:var(--slate-lt);margin-top:4px;">${pl.rationale}</div>
      </div>` : '';

    const labs = (r.lab_findings || []).slice(0, 4).map(l =>
      `<div class="lab-pill">
        <span class="lab-test">${escHtml(l.test)}</span>
        <div class="lab-val">
          <span class="lab-num">${escHtml(l.value)}</span>
          <span class="dir-tag dir-${l.direction}">${l.direction.toUpperCase()}</span>
        </div>
      </div>`
    ).join('');

    const feats = Object.entries(r.key_symptoms || {}).slice(0, 4).map(([k, v]) =>
      `<li><strong>${escHtml(k)}:</strong> ${escHtml(v)}</li>`
    ).join('');

    const ddxHtml = Object.keys(r.differential_diagnosis || {}).slice(0, 3).map(d =>
      `<span class="ddx-tag">${escHtml(d)}</span>`
    ).join('');

    const demoNote = r.demo_boost > 0
      ? `<span style="font-size:.68rem;color:var(--teal);margin-left:6px;"><i class="fa-solid fa-arrow-trend-up"></i> +${r.demo_boost}% demographic match</span>` : '';

    const combinedBadge = hasLabs2 ? `
      <div style="font-size:.72rem;color:var(--slate-lt);margin-top:4px;">
        Symptom: <strong>${symPct}%</strong> &nbsp;·&nbsp; Lab: <strong>${labPct2}%</strong> &nbsp;·&nbsp;
        <span style="color:var(--teal);font-weight:700;">Combined: ${pct}%</span>
      </div>` : '';

    const confidence = r.combined_confidence || r.confidence;

    return `
    <div class="diag-card priority-${r.priority}">
      <div class="card-head">
        <div class="card-title-area">
          <div class="card-organ">${escHtml(r.organ)}</div>
          <div class="card-name" style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">${escHtml(r.name)}<span class="pri-badge pri-${r.priority}" style="font-size:.62rem;padding:3px 11px;">${(r.priority === 'medium' || r.priority === 'moderate') ? 'Moderate' : r.priority.charAt(0).toUpperCase() + r.priority.slice(1)}</span></div>
          <div class="card-pattern"><i class="fa-solid fa-microscope" style="color:var(--gold)"></i> ${escHtml(r.clinical_pattern)}</div>
          ${demoNote}
          ${combinedBadge}
        </div>
        <div class="card-right">
          <div class="ring-wrap">
            <svg class="ring-svg" width="52" height="52" viewBox="0 0 52 52">
              <circle class="ring-track" cx="26" cy="26" r="20"/>
              <circle class="ring-fill ${ringClass}" cx="26" cy="26" r="20"
                stroke-dasharray="${dash.toFixed(1)} ${gap.toFixed(1)}" stroke-dashoffset="0"/>
            </svg>
            <div class="ring-label">${pct}%</div>
            <div class="ring-sub">${r.cardinal_hits} cardinal</div>
          </div>
          <span class="conf-badge conf-${confidence}">${confidence} Confidence</span>
        </div>
      </div>
      <div class="card-body">
        <div class="card-col">
          <div class="col-label"><i class="fa-solid fa-user-doctor"></i> Key Clinical Features</div>
          <ul class="feat-list">${feats}</ul>
        </div>
        <div class="card-col">
          <div class="col-label"><i class="fa-solid fa-flask"></i> Expected Lab Findings</div>
          <div class="lab-pills">${labs}</div>
        </div>
      </div>
      <div class="card-foot">
        <div class="foot-left">
          <div class="foot-sec-label">Matched Symptoms</div>
          <div class="matched-chips">${matchedHtml}</div>
          ${missingHtml}
          ${labMatchedHtml}
          ${recLabsHtml}
          <div style="margin-top:8px;">
            <span class="foot-sec-label">Differential: </span>
            <span class="ddx-strip">${ddxHtml}</span>
          </div>
        </div>
        <div class="foot-btns">
          <button class="btn-detail" onclick="openModal('${r.id}')">
            <i class="fa-solid fa-expand"></i> Full Details
          </button>
        </div>
      </div>
    </div>`;
  }).join('');
}

// ── MODAL (identical to v3.0) ──────────────────────────
function openModal(patternId) {
  const p = PATTERNS[patternId];
  if (!p) return;
  document.getElementById('modalTitle').textContent = p.name;
  document.getElementById('modalSub').textContent   = `${p.organ} \u00B7 ICD-10: ${p.icd10} \u00B7 ${p.clinical_pattern}`;
  const glLink = document.getElementById('modalGuidelineLink');
  if (p.guideline_url) {
    glLink.href = p.guideline_url;
    glLink.style.display = 'inline-flex';
    document.getElementById('modalGuidelineText').textContent = p.guideline_ref || 'View Guideline';
  } else {
    glLink.style.display = 'none';
  }
  const epiItems = Object.entries(p.epidemiology || {}).map(([k,v]) =>
    `<div class="epi-item"><div class="epi-key">${escHtml(k.replace(/_/g,' '))}</div><div class="epi-val">${escHtml(v)}</div></div>`
  ).join('');
  const labRows = (p.lab_findings || []).map(l =>
    `<div class="lab-pill" style="padding:9px 12px;">
      <span class="lab-test" style="font-size:.86rem;font-weight:500;">${escHtml(l.test)}</span>
      <div class="lab-val"><span class="lab-num">${escHtml(l.value)}</span>
      <span class="dir-tag dir-${l.direction}">${l.direction.toUpperCase()}</span></div>
    </div>`
  ).join('');
  const algoSteps = Object.entries(p.diagnostic_algorithm || {}).map(([k,v],i) =>
    `<div class="algo-step"><div class="step-num">${i+1}</div><div class="step-txt"><strong>${escHtml(k)}:</strong> ${escHtml(v)}</div></div>`
  ).join('');
  const mgmtItems = (p.management || []).map(m => `<div class="mgmt-item">${escHtml(m)}</div>`).join('');
  const ddxItems  = Object.entries(p.differential_diagnosis || {}).map(([name,note]) =>
    `<div class="ddx-item"><div class="ddx-name">${escHtml(name)}</div><div class="ddx-note">${escHtml(note)}</div></div>`
  ).join('');
  document.getElementById('modalBody').innerHTML =
    `<div class="modal-sec"><div class="modal-sec-title"><i class="fa-solid fa-diagram-project"></i> Pathophysiology</div><div class="pathophys-box">${escHtml(p.pathophysiology)}</div></div>` +
    (epiItems ? `<div class="modal-sec"><div class="modal-sec-title"><i class="fa-solid fa-chart-pie"></i> Epidemiology</div><div class="epi-grid">${epiItems}</div></div>` : '') +
    `<div class="modal-sec"><div class="modal-sec-title"><i class="fa-solid fa-vial"></i> Laboratory Findings</div><div class="lab-pills">${labRows}</div></div>` +
    (algoSteps ? `<div class="modal-sec"><div class="modal-sec-title"><i class="fa-solid fa-sitemap"></i> Diagnostic Algorithm</div><div class="algo-steps">${algoSteps}</div></div>` : '') +
    (mgmtItems ? `<div class="modal-sec"><div class="modal-sec-title"><i class="fa-solid fa-pills"></i> Management</div><div class="mgmt-list">${mgmtItems}</div></div>` : '') +
    (ddxItems  ? `<div class="modal-sec"><div class="modal-sec-title"><i class="fa-solid fa-scale-balanced"></i> Differential Diagnosis</div><div class="ddx-grid">${ddxItems}</div></div>` : '');
  document.getElementById('detailModal').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeModal() { document.getElementById('detailModal').classList.remove('open'); document.body.style.overflow = ''; }
function closeModalOnBg(e) { if (e.target === document.getElementById('detailModal')) closeModal(); }
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });


// ── UTILITY ────────────────────────────────────────────
function escHtml(str) {
  if (typeof str !== 'string') return str ?? '';
  return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
</script>
</body>
</html>