<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BetArena')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Nunito:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:      #070810;
            --bg2:     #0c0d18;
            --bg3:     #111320;
            --card:    #131526;
            --border:  #1d2035;
            --border2: #252845;
            --gold:    #f0c040;
            --gold2:   #d4a800;
            --gold3:   #ffe880;
            --green:   #2ecc71;
            --red:     #e74c3c;
            --blue:    #3498db;
            --violet:  #8b5cf6;
            --muted:   #3d4160;
            --muted2:  #6b7280;
            --text:    #e2e4f0;
            --text2:   #8891b0;
            --h:       'Rajdhani', sans-serif;
            --b:       'Nunito', sans-serif;
            --r:       10px;
            --r2:      16px;
        }
        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: var(--b);
            min-height: 100vh;
        }

        /* subtle noise overlay */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        /* ── TOPBAR ── */
        .topbar {
            height: 64px;
            background: var(--bg2);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 200;
        }

        .logo {
            font-family: var(--h);
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            background: linear-gradient(135deg, var(--gold2), var(--gold), var(--gold3));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .logo::before { content: '◆'; font-size: 14px; }

        .top-nav {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .top-nav a {
            font-family: var(--h);
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--text2);
            text-decoration: none;
            padding: 8px 14px;
            border-radius: var(--r);
            transition: all .15s;
        }
        .top-nav a:hover { color: var(--text); background: var(--bg3); }
        .top-nav a.active {
            color: var(--gold);
            background: rgba(240,192,64,.07);
            border: 1px solid rgba(240,192,64,.15);
        }

        .top-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .balance-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, rgba(240,192,64,.1), rgba(240,192,64,.05));
            border: 1px solid rgba(240,192,64,.2);
            border-radius: 30px;
            padding: 7px 16px 7px 10px;
            font-size: 14px;
        }
        .balance-pill .coin {
            width: 22px; height: 22px;
            background: linear-gradient(135deg, var(--gold2), var(--gold));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: #000;
            font-weight: 700;
        }
        .balance-pill .amount {
            font-family: var(--h);
            font-weight: 700;
            font-size: 15px;
            color: var(--gold);
            letter-spacing: .5px;
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--bg3);
            border: 1px solid var(--border2);
            border-radius: 30px;
            padding: 5px 14px 5px 6px;
        }
        .user-avatar {
            width: 28px; height: 28px;
            background: linear-gradient(135deg, var(--violet), #6366f1);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-family: var(--h);
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }
        .user-chip span { font-size: 13px; font-weight: 500; }

        .logout-btn {
            background: none;
            border: 1px solid var(--muted);
            color: var(--muted2);
            border-radius: var(--r);
            padding: 6px 12px;
            font-size: 12px;
            font-family: var(--b);
            cursor: pointer;
            transition: all .15s;
        }
        .logout-btn:hover { border-color: var(--red); color: var(--red); }

        /* ── CONTENT ── */
        .wrap { max-width: 1280px; margin: 0 auto; padding: 28px 24px; position:relative; z-index:1; }

        /* ── CARDS ── */
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--r2);
            padding: 20px 22px;
            position: relative;
        }

        .card-hdr {
            font-family: var(--h);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text2);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .card-hdr::before {
            content: '';
            width: 3px; height: 14px;
            background: var(--gold);
            border-radius: 2px;
            display: inline-block;
        }

        /* ── STAT ── */
        .stat {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--r2);
            padding: 18px 20px;
            overflow: hidden;
        }
        .stat-label { font-size: 12px; color: var(--text2); margin-bottom: 6px; }
        .stat-val {
            font-family: var(--h);
            font-size: 34px;
            font-weight: 700;
            line-height: 1;
            letter-spacing: 1px;
        }
        .stat-sub { font-size: 12px; color: var(--muted2); margin-top: 8px; }
        .stat.g .stat-val { color: var(--green); }
        .stat.r .stat-val { color: var(--red); }
        .stat.y .stat-val { color: var(--gold); }
        .stat.b .stat-val { color: var(--blue); }

        /* glow line on stat */
        .stat::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 1px;
            border-radius: 0 0 var(--r2) var(--r2);
        }
        .stat.g::after { background: linear-gradient(90deg,transparent,var(--green),transparent); opacity:.4; }
        .stat.r::after { background: linear-gradient(90deg,transparent,var(--red),transparent);   opacity:.4; }
        .stat.y::after { background: linear-gradient(90deg,transparent,var(--gold),transparent);  opacity:.4; }
        .stat.b::after { background: linear-gradient(90deg,transparent,var(--blue),transparent);  opacity:.4; }

        /* ── GRIDS ── */
        .g4 { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; }
        .g3 { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; }
        .g2 { display:grid; grid-template-columns:repeat(2,1fr); gap:14px; }
        .mt { margin-top: 22px; }

        /* ── TABLE ── */
        .tw { overflow-x: auto; }
        table { width:100%; border-collapse:collapse; font-size:13px; }
        thead th {
            font-family: var(--h);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--muted2);
            padding: 8px 10px;
            border-bottom: 1px solid var(--border);
            text-align: left;
            white-space: nowrap;
        }
        tbody td {
            padding: 11px 10px;
            border-bottom: 1px solid var(--bg3);
            vertical-align: middle;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr { transition: background .1s; }
        tbody tr:hover td { background: rgba(255,255,255,.018); }

        /* ── BADGES ── */
        .bx {
            font-family: var(--h);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 3px 9px;
            border-radius: 4px;
            display: inline-block;
        }
        .bx.pending   { background:rgba(52,152,219,.15);  color:#60a5fa; border:1px solid rgba(52,152,219,.25); }
        .bx.won       { background:rgba(46,204,113,.12);  color:#4ade80; border:1px solid rgba(46,204,113,.25); }
        .bx.lost      { background:rgba(231,76,60,.12);   color:#f87171; border:1px solid rgba(231,76,60,.25); }
        .bx.scheduled { background:rgba(240,192,64,.1);   color:#e8c840; border:1px solid rgba(240,192,64,.2); }
        .bx.finished  { background:rgba(107,114,128,.1);  color:#9ca3af; border:1px solid rgba(107,114,128,.2); }
        .bx.playing   { background:rgba(139,92,246,.15);  color:#c4b5fd; border:1px solid rgba(139,92,246,.25); }
        .bx.accepted  { background:rgba(46,204,113,.12);  color:#4ade80; border:1px solid rgba(46,204,113,.25); }
        .bx.rejected  { background:rgba(231,76,60,.12);   color:#f87171; border:1px solid rgba(231,76,60,.25); }
        .bx.completed { background:rgba(107,114,128,.1);  color:#9ca3af; border:1px solid rgba(107,114,128,.2); }
        .bx.deposit   { background:rgba(46,204,113,.12);  color:#4ade80; border:1px solid rgba(46,204,113,.25); }
        .bx.withdrawal{ background:rgba(231,76,60,.12);   color:#f87171; border:1px solid rgba(231,76,60,.25); }
        .bx.bet_win   { background:rgba(52,152,219,.15);  color:#60a5fa; border:1px solid rgba(52,152,219,.25); }

        /* colors */
        .cy { color: var(--gold);  font-weight: 600; }
        .cg { color: var(--green); font-weight: 600; }
        .cr { color: var(--red);   font-weight: 600; }
        .cb { color: var(--blue);  font-weight: 600; }
        .cm { color: var(--text2); font-size: 12px; }

        .vs {
            font-family: var(--h);
            font-size: 10px;
            font-weight: 700;
            background: var(--bg3);
            border: 1px solid var(--border2);
            border-radius: 3px;
            padding: 1px 5px;
            color: var(--muted2);
            letter-spacing: 1px;
        }

        .empty { text-align:center; padding:36px; color:var(--muted2); font-size:13px; }

        /* form */
        select, input {
            background: var(--bg3);
            border: 1px solid var(--border2);
            color: var(--text);
            border-radius: var(--r);
            padding: 8px 12px;
            font-size: 13px;
            font-family: var(--b);
            outline: none;
        }
        select:focus, input:focus { border-color: var(--gold2); }

        .btn {
            background: linear-gradient(135deg, var(--gold2), var(--gold));
            color: #000;
            border: none;
            border-radius: var(--r);
            padding: 8px 18px;
            font-size: 13px;
            font-family: var(--h);
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            transition: opacity .15s;
        }
        .btn:hover { opacity: .85; }

        .btn-ghost {
            background: none;
            border: 1px solid var(--border2);
            color: var(--muted2);
            border-radius: var(--r);
            padding: 8px 14px;
            font-size: 12px;
            font-family: var(--b);
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all .15s;
        }
        .btn-ghost:hover { color: var(--text); border-color: var(--text2); }

        @media(max-width:900px){
            .g4,.g3 { grid-template-columns: repeat(2,1fr); }
            .g2 { grid-template-columns: 1fr; }
            .top-nav { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>

<header class="topbar">
    <a href="{{ route('front.home') }}" class="logo">BetArena</a>

    <nav class="top-nav">
        <a href="{{ route('front.home') }}"        class="{{ request()->routeIs('front.home')        ? 'active' : '' }}">Inicio</a>
        <a href="{{ route('front.matches') }}"     class="{{ request()->routeIs('front.matches')     ? 'active' : '' }}">Partidos</a>
        <a href="{{ route('front.mines') }}"       class="{{ request()->routeIs('front.mines')       ? 'active' : '' }}">Minas</a>
        <a href="{{ route('front.challenges') }}"  class="{{ request()->routeIs('front.challenges')  ? 'active' : '' }}">Desafíos</a>
        <a href="{{ route('front.mybets') }}"      class="{{ request()->routeIs('front.mybets')      ? 'active' : '' }}">Mis Apuestas</a>
        <a href="{{ route('front.profile') }}"     class="{{ request()->routeIs('front.profile')     ? 'active' : '' }}">Perfil</a>
    </nav>

    <div class="top-right">
        <div class="balance-pill">
            <div class="coin">$</div>
            <span class="amount">${{ number_format(auth()->user()->balance, 2) }}</span>
        </div>

        <div class="user-chip">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <span>{{ auth()->user()->username }}</span>
        </div>

        <form method="POST" action="{{ route('logout') }}" style="margin:0">
            @csrf
            <button type="submit" class="logout-btn">Salir</button>
        </form>
    </div>
</header>

<div class="wrap">
    @yield('content')
</div>

@stack('scripts')
</body>
</html>