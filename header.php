<?php // header.php - Layout moderno con sidebar + topbar (colores sólidos) ?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dieta Pro — Integradorll</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root{
      --bg:#0b1020; --panel:#121735; --panel-2:#0f1430; --text:#eef3fb; --muted:#b9c4de;
      --primary:#2563eb; --primary-700:#1e49ce; --accent:#22c55e; --warning:#f59e0b; --danger:#ef4444;
      --border:#243056; --shadow:0 10px 26px rgba(0,0,0,.25); --radius:16px; --radius-sm:12px;
      --sidebar-w:260px; --topbar-h:64px;
    }
    *{box-sizing:border-box} html,body{height:100%}
    body{margin:0;background:var(--bg);color:var(--text);font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Noto Sans,"Helvetica Neue",Arial}
    a{color:inherit;text-decoration:none}

    .layout{display:grid;grid-template-columns:var(--sidebar-w) 1fr;grid-template-rows:var(--topbar-h) 1fr;
      grid-template-areas:"sidebar topbar" "sidebar content";min-height:100vh}

    .sidebar{grid-area:sidebar;background:var(--panel);border-right:1px solid var(--border);position:sticky;top:0;height:100vh;padding:18px 16px}
    .brand{display:flex;align-items:center;gap:10px;padding:8px;border-radius:12px;font-weight:800;font-size:1.15rem;color:#fff;letter-spacing:.3px}
    .brand .dot{width:10px;height:10px;border-radius:50%;background:linear-gradient(135deg,var(--primary),#60a5fa);box-shadow:0 0 0 6px rgba(37,99,235,.15)}
    .nav-title{color:var(--muted);font-size:.78rem;margin:14px 10px;text-transform:uppercase;letter-spacing:.1rem}
    .nav-link{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:12px;color:#dfe6ff}
    .nav-link:hover{background:#1a2246}
    .nav-link.active{background:#1a2a66;color:#fff}

    .topbar{grid-area:topbar;background:var(--panel-2);border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;padding:0 16px;position:sticky;top:0;z-index:10}
    .topbar .title{font-weight:900;font-size:clamp(1.05rem,1rem + 0.7vw,1.6rem);letter-spacing:.3px}
    .topbar .hint{color:var(--muted);font-size:.9rem}

    .content{grid-area:content;padding:22px;max-width:1220px;width:100%;margin-inline:auto}

    .card{background:var(--panel);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow)}
    .card-ghost{background:#101436}
    .kpi{display:flex;align-items:center;justify-content:space-between;padding:16px}
    .kpi .left .label{color:var(--muted);font-size:.9rem}
    .kpi .left .value{font-weight:800;font-size:1.8rem;margin-top:2px}
    .kpi .emoji{font-size:2rem}

    .btn{border-radius:12px;font-weight:700}
    .btn-primary{background:var(--primary);border-color:var(--primary)}
    .btn-primary:hover{background:var(--primary-700)}
    .btn-warning{color:#241500}

    .table-dark{--bs-table-bg:transparent;--bs-table-striped-bg:rgba(255,255,255,.05);--bs-table-hover-bg:rgba(255,255,255,.07);color:var(--text);border-color:var(--border)}
    thead th{border-bottom:1px solid var(--border)!important;color:#cfe0ff;font-weight:700}

    .muted{color:var(--muted)} .divider{height:1px;background:var(--border);margin:10px 0 18px}

    .rise{transform:translateY(10px);opacity:0;transition:transform .45s ease,opacity .45s ease}
    .rise.show{transform:none;opacity:1}
    .reveal{opacity:0;transform:translateY(12px)}
    .reveal.show{opacity:1;transform:none;transition:all .55s ease}
    .lift{transition:transform .22s ease,box-shadow .22s ease}
    .lift:hover{transform:translateY(-4px);box-shadow:0 16px 36px rgba(0,0,0,.35)}

    @media (max-width:992px){.layout{grid-template-columns:72px 1fr}.nav-title,.nav-link span{display:none}.nav-link{justify-content:center}}
    @media (max-width:640px){.content{padding:16px}}
  </style>
</head>
<body>
<div class="layout">
  <aside class="sidebar">
    <div class="brand"><span class="dot"></span><span>Dieta Pro</span></div>
    <div class="nav-section">
      <div class="nav-title">Menú</div>
      <a class="nav-link <?= basename($_SERVER['PHP_SELF'])==='index.php'?'active':'' ?>" href="index.php"><span>🏠</span><span>Dashboard</span></a>
      <a class="nav-link <?= in_array(basename($_SERVER['PHP_SELF']),['diets.php','diet_form.php'])?'active':'' ?>" href="diets.php"><span>🥗</span><span>Dietas</span></a>
      <a class="nav-link <?= in_array(basename($_SERVER['PHP_SELF']),['meals.php','meal_form.php'])?'active':'' ?>" href="diets.php"><span>🍽️</span><span>Comidas</span></a>
    </div>
  </aside>

  <header class="topbar">
    <div>
      <div class="title"><?= htmlspecialchars(ucfirst(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME))) ?></div>
      <div class="hint">Integradorll · Sistema de Dieta</div>
    </div>
    <div><!-- espacio para perfil/futuras acciones --></div>
  </header>

  <main class="content">



