<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin — BetArena')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;600&family=IBM+Plex+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:      #08090c;
            --bg2:     #0d0f14;
            --bg3:     #13161e;
            --card:    #161921;
            --border:  #1e2230;
            --border2: #252a38;
            --accent:  #e8c840;
            --accent2: #c9a800;
            --green:   #34d399;
            --red:     #f87171;
            --blue:    #60a5fa;
            --muted:   #4b5563;
            --muted2:  #6b7280;
            --text:    #d1d5db;
            --text2:   #9ca3af;
            --mono:    'IBM Plex Mono', monospace;
            --sans:    'IBM Plex Sans', sans-serif;
            --r:       6px;
        }
        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: var(--sans);
            min-height: 100vh;
            display: flex;
            font-size: 14px;
        }

        ::-webkit-scrollbar { width:4px; height:4px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: var(--border2); border-radius:2px; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 220px;
            min-height: 100vh;
            background: var(--bg2);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 100;
            overflow-y: auto;
        }

        .s-logo {
            padding: 24px 20px 18px;
            border-bottom: 1px solid var(--border);
        }
        .s-logo-mark {
            font-family: var(--mono);
            font-size: 13px;
            font-weight: 600;
            color: var(--accent);
            letter-spacing: .5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .s-logo-mark::before { content: '▸'; font-size: 10px; }
        .s-logo sub {
            display: block;
            font-family: var(--mono);
            font-size: 9px;
            color: var(--muted);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .s-nav { padding: 14px 10px; flex: 1; }

        .s-group {
            font-family: var(--mono);
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 2px;
            color: var(--muted);
            padding: 10px 10px 4px;
            text-transform: uppercase;
        }

        .s-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 10px;
            border-radius: var(--r);
            color: var(--text2);
            text-decoration: none;
            font-size: 13px;
            font-weight: 400;
            transition: background .1s, color .1s;
            margin-bottom: 1px;
            position: relative;
        }
        .s-item:hover { background: var(--bg3); color: var(--text); }
        .s-item.active {
            background: var(--bg3);
            color: var(--accent);
            font-weight: 500;
        }
        .s-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            width: 2px;
            height: 28px;
            background: var(--accent);
            border-radius: 0 2px 2px 0;
        }
        .s-ico { width: 16px; text-align: center; font-size: 14px; flex-shrink: 0; }

        .s-footer {
            border-top: 1px solid var(--border);
            padding: 14px 16px;
        }
        .s-user { display: flex; align-items: center; gap: 10px; }
        .s-avatar {
            width: 30px; height: 30px;
            background: var(--accent2);
            color: #000;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--mono);
            font-size: 13px;
            font-weight: 600;
            flex-shrink: 0;
        }
        .s-user-name  { font-size: 12px; font-weight: 500; }
        .s-user-role  { font-family: var(--mono); font-size: 10px; color: var(--muted); }

        /* ── MAIN ── */
        .main { margin-left: 220px; flex: 1; display: flex; flex-direction: column; }

        .topbar {
            height: 52px;
            background: var(--bg2);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .t-breadcrumb {
            font-family: var(--mono);
            font-size: 12px;
            color: var(--muted2);
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .t-breadcrumb .sep { color: var(--muted); }
        .t-breadcrumb .cur { color: var(--text); }

        .t-right { display: flex; align-items: center; gap: 12px; }
        .t-balance {
            font-family: var(--mono);
            font-size: 12px;
            background: var(--bg3);
            border: 1px solid var(--border2);
            padding: 5px 12px;
            border-radius: var(--r);
            color: var(--accent);
        }
        .t-logout {
            font-family: var(--mono);
            font-size: 11px;
            color: var(--muted);
            background: none;
            border: none;
            cursor: pointer;
            transition: color .15s;
            letter-spacing: .5px;
        }
        .t-logout:hover { color: var(--red); }

        .content { padding: 24px; flex: 1; }

        /* ── COMPONENTS ── */
        .page-header {
            margin-bottom: 22px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: baseline;
            gap: 12px;
        }
        .page-title { font-family: var(--mono); font-size: 18px; font-weight: 600; color: var(--text); }
        .page-sub   { font-size: 12px; color: var(--muted2); }

        .grid-4 { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; }
        .grid-3 { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; }
        .grid-2 { display: grid; grid-template-columns: repeat(2,1fr); gap: 12px; }
        .gap    { margin-top: 20px; }

        .sc {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--r);
            padding: 16px 18px;
            position: relative;
            overflow: hidden;
        }
        .sc-label { font-family: var(--mono); font-size: 10px; letter-spacing: 1.5px; text-transform: uppercase; color: var(--muted2); margin-bottom: 8px; }
        .sc-value { font-family: var(--mono); font-size: 28px; font-weight: 600; line-height: 1; color: var(--text); }
        .sc-sub   { font-family: var(--mono); font-size: 11px; color: var(--muted2); margin-top: 8px; padding-top: 8px; border-top: 1px solid var(--border); }
        .sc-dot   { position: absolute; top: 14px; right: 16px; width: 6px; height: 6px; border-radius: 50%; }
        .sc.y .sc-dot { background: var(--accent); }
        .sc.g .sc-dot { background: var(--green); }
        .sc.r .sc-dot { background: var(--red); }
        .sc.b .sc-dot { background: var(--blue); }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--r);
            padding: 18px 20px;
        }
        .card-title { font-family: var(--mono); font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: var(--muted2); margin-bottom: 14px; }

        .tw { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead th {
            font-family: var(--mono); font-size: 10px; font-weight: 600;
            letter-spacing: 1.5px; text-transform: uppercase; color: var(--muted);
            padding: 6px 10px; border-bottom: 1px solid var(--border);
            text-align: left; white-space: nowrap;
        }
        tbody td { padding: 10px 10px; border-bottom: 1px solid var(--bg3); font-size: 13px; vertical-align: middle; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: rgba(255,255,255,.015); }

        .b {
            font-family: var(--mono); font-size: 10px; font-weight: 600;
            letter-spacing: .5px; text-transform: uppercase;
            padding: 2px 8px; border-radius: 3px; display: inline-block;
        }
        .b.pending    { background:#0c1a2e; color:#60a5fa; border:1px solid #1e3a5f; }
        .b.won        { background:#052e16; color:#4ade80; border:1px solid #14532d; }
        .b.lost       { background:#2d0a0a; color:#f87171; border:1px solid #450a0a; }
        .b.scheduled  { background:#1a1200; color:#e8c840; border:1px solid #2d2000; }
        .b.finished   { background:#0d1117; color:#9ca3af; border:1px solid #1e2230; }
        .b.playing    { background:#0a1f0a; color:#86efac; border:1px solid #14532d; }
        .b.accepted   { background:#052e16; color:#4ade80; border:1px solid #14532d; }
        .b.rejected   { background:#2d0a0a; color:#f87171; border:1px solid #450a0a; }
        .b.completed  { background:#0d1117; color:#9ca3af; border:1px solid #1e2230; }
        .b.deposit    { background:#052e16; color:#4ade80; border:1px solid #14532d; }
        .b.withdrawal { background:#2d0a0a; color:#f87171; border:1px solid #450a0a; }
        .b.bet_win    { background:#0c1a2e; color:#60a5fa; border:1px solid #1e3a5f; }
        .b.admin      { background:#1a1200; color:#e8c840; border:1px solid #2d2000; }
        .b.user       { background:#0d1117; color:#9ca3af; border:1px solid #1e2230; }
        .b.live       { background:#2d0a0a; color:#f87171; border:1px solid #450a0a; }
        .b.cancelled  { background:#0d1117; color:#9ca3af; border:1px solid #1e2230; }

        .cy  { color: var(--accent); font-family: var(--mono); }
        .cg  { color: var(--green);  font-family: var(--mono); }
        .cr  { color: var(--red);    font-family: var(--mono); }
        .cb  { color: var(--blue);   font-family: var(--mono); }
        .cm  { color: var(--muted2); font-family: var(--mono); font-size: 12px; }

        .vs {
            font-family: var(--mono); font-size: 10px; color: var(--muted);
            background: var(--bg3); border: 1px solid var(--border);
            border-radius: 3px; padding: 1px 5px;
        }

        .empty { text-align:center; padding:32px; color:var(--muted); font-family:var(--mono); font-size:12px; }

        select, input[type=text], input[type=email], input[type=password],
        input[type=number], input[type=datetime-local], input[type=search] {
            background: var(--bg3);
            border: 1px solid var(--border2);
            color: var(--text);
            border-radius: var(--r);
            padding: 7px 10px;
            font-size: 12px;
            font-family: var(--mono);
            outline: none;
            transition: border-color .15s;
        }
        select:focus, input:focus { border-color: var(--accent2); }

        .btn {
            background: var(--accent);
            color: #000;
            border: none;
            border-radius: var(--r);
            padding: 7px 16px;
            font-size: 12px;
            font-family: var(--mono);
            font-weight: 600;
            cursor: pointer;
            transition: background .15s;
        }
        .btn:hover { background: var(--accent2); }

        .btn-ghost {
            background: none;
            border: 1px solid var(--border2);
            color: var(--muted2);
            border-radius: var(--r);
            padding: 7px 14px;
            font-size: 11px;
            font-family: var(--mono);
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-ghost:hover { color: var(--text); border-color: var(--muted2); }

        @media(max-width:900px){
            .grid-4,.grid-3 { grid-template-columns: repeat(2,1fr); }
            .grid-2 { grid-template-columns: 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>

<aside class="sidebar">
    <div class="s-logo">
        <div class="s-logo-mark">BETARENA ADMIN</div>
        <sub>// panel de control</sub>
    </div>

    <nav class="s-nav">
        <div class="s-group">General</div>
        <a href="{{ route('dash.index') }}" class="s-item {{ request()->routeIs('dash.index') ? 'active' : '' }}">
            <span class="s-ico">◈</span> Resumen
        </a>

        <div class="s-group">Gestión</div>
        <a href="{{ route('dash.users') }}" class="s-item {{ request()->routeIs('dash.users') ? 'active' : '' }}">
            <span class="s-ico">◉</span> Usuarios
        </a>
        <a href="{{ route('dash.matches') }}" class="s-item {{ request()->routeIs('dash.matches') ? 'active' : '' }}">
            <span class="s-ico">◈</span> Partidos
        </a>
        <a href="{{ route('dash.bets') }}" class="s-item {{ request()->routeIs('dash.bets') ? 'active' : '' }}">
            <span class="s-ico">◈</span> Apuestas
        </a>
        <a href="{{ route('dash.mines') }}" class="s-item {{ request()->routeIs('dash.mines') ? 'active' : '' }}">
            <span class="s-ico">◈</span> Minas
        </a>
        <a href="{{ route('dash.challenges') }}" class="s-item {{ request()->routeIs('dash.challenges') ? 'active' : '' }}">
            <span class="s-ico">◈</span> Desafíos
        </a>
        <a href="{{ route('dash.transactions') }}" class="s-item {{ request()->routeIs('dash.transactions') ? 'active' : '' }}">
            <span class="s-ico">◈</span> Transacciones
        </a>

        <div class="s-group">CRUDs</div>
        <a href="{{ route('admin.usuarios.index') }}" class="s-item {{ request()->routeIs('admin.usuarios*') ? 'active' : '' }}">
            <span class="s-ico">👤</span> Usuarios
        </a>
        <a href="{{ route('admin.deportes.index') }}" class="s-item {{ request()->routeIs('admin.deportes*') ? 'active' : '' }}">
            <span class="s-ico">🏆</span> Deportes
        </a>
        <a href="{{ route('admin.equipos.index') }}" class="s-item {{ request()->routeIs('admin.equipos*') ? 'active' : '' }}">
            <span class="s-ico">🛡️</span> Equipos
        </a>
        <a href="{{ route('admin.partidos.index') }}" class="s-item {{ request()->routeIs('admin.partidos*') ? 'active' : '' }}">
            <span class="s-ico">⚽</span> Partidos
        </a>
    </nav>

    <div class="s-footer">
        <div class="s-user">
            <div class="s-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div class="s-user-name">{{ auth()->user()->name }}</div>
                <div class="s-user-role">// {{ auth()->user()->role }}</div>
            </div>
        </div>
    </div>
</aside>

<div class="main">
    <header class="topbar">
        <div class="t-breadcrumb">
            <span>betarena</span>
            <span class="sep">/</span>
            <span>admin</span>
            <span class="sep">/</span>
            <span class="cur">@yield('page-slug', 'index')</span>
        </div>
        <div class="t-right">
            <div class="t-balance">$ {{ number_format(auth()->user()->balance ?? 0, 2) }}</div>
            <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="t-logout">salir →</button>
            </form>
        </div>
    </header>

    <main class="content">
        <div class="page-header">
            <span class="page-title">@yield('page-title', 'Resumen')</span>
            <span class="page-sub">@yield('page-desc', '')</span>
        </div>
        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>