<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Casino') }} — Juega. Gana. Vive.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;900&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold:    #d4a843;
            --gold2:   #f0c96a;
            --dark:    #080810;
            --dark2:   #0d0d1a;
            --dark3:   #13132a;
            --card:    #111128;
            --border:  rgba(212,168,67,.18);
            --text:    #e8e0cc;
            --muted:   #7a7090;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--dark);
            color: var(--text);
            overflow-x: hidden;
            cursor: default;
        }

        /* ── NOISE OVERLAY ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 9999;
            opacity: .45;
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--dark2); }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 3px; }

        /* ═══════════════════════════════════
           NAV
        ═══════════════════════════════════ */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.2rem 4rem;
            background: linear-gradient(to bottom, rgba(8,8,16,.95), transparent);
            backdrop-filter: blur(12px);
        }

        .nav-logo {
            font-family: 'Cinzel', serif;
            font-size: 1.4rem;
            font-weight: 900;
            letter-spacing: .12em;
            background: linear-gradient(135deg, var(--gold), var(--gold2), var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2.5rem;
            list-style: none;
        }

        .nav-links a {
            color: var(--muted);
            text-decoration: none;
            font-size: .875rem;
            font-weight: 500;
            letter-spacing: .06em;
            text-transform: uppercase;
            transition: color .25s;
        }
        .nav-links a:hover { color: var(--gold2); }

        .btn-nav {
            padding: .55rem 1.5rem;
            border: 1px solid var(--gold);
            border-radius: 4px;
            color: var(--gold) !important;
            font-weight: 600 !important;
            transition: background .25s, color .25s !important;
        }
        .btn-nav:hover {
            background: var(--gold) !important;
            color: var(--dark) !important;
        }

        /* ═══════════════════════════════════
           HERO
        ═══════════════════════════════════ */
        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            overflow: hidden;
            padding: 8rem 2rem 4rem;
        }

        /* fondo radial */
        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 50% 40%, rgba(212,168,67,.08) 0%, transparent 70%),
                radial-gradient(ellipse 40% 30% at 20% 80%, rgba(99,60,180,.12) 0%, transparent 60%),
                radial-gradient(ellipse 40% 30% at 80% 10%, rgba(180,60,99,.08) 0%, transparent 60%);
            pointer-events: none;
        }

        /* líneas decorativas */
        .hero-lines {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }
        .hero-lines span {
            position: absolute;
            display: block;
            border: 1px solid rgba(212,168,67,.06);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            left: 50%; top: 45%;
            animation: pulse-ring 6s ease-in-out infinite;
        }
        .hero-lines span:nth-child(1) { width: 400px;  height: 400px;  animation-delay: 0s; }
        .hero-lines span:nth-child(2) { width: 700px;  height: 700px;  animation-delay: 1s; }
        .hero-lines span:nth-child(3) { width: 1000px; height: 1000px; animation-delay: 2s; }
        .hero-lines span:nth-child(4) { width: 1300px; height: 1300px; animation-delay: 3s; }

        @keyframes pulse-ring {
            0%, 100% { opacity: .3; transform: translate(-50%,-50%) scale(1); }
            50%       { opacity: .7; transform: translate(-50%,-50%) scale(1.03); }
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: rgba(212,168,67,.1);
            border: 1px solid rgba(212,168,67,.25);
            border-radius: 100px;
            padding: .35rem 1rem;
            font-size: .75rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--gold2);
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
            animation: fade-up .8s ease both;
        }
        .hero-badge::before {
            content: '';
            width: 6px; height: 6px;
            background: var(--gold2);
            border-radius: 50%;
            animation: blink 1.5s ease infinite;
        }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.2} }

        .hero h1 {
            font-family: 'Cinzel', serif;
            font-size: clamp(3rem, 8vw, 7rem);
            font-weight: 900;
            line-height: .95;
            letter-spacing: -.01em;
            position: relative;
            z-index: 1;
            animation: fade-up .9s .1s ease both;
        }

        .hero h1 .gold {
            background: linear-gradient(135deg, #b8922a 0%, var(--gold2) 40%, var(--gold) 60%, #f5e0a0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: block;
        }

        .hero-sub {
            font-size: clamp(1rem, 2vw, 1.25rem);
            color: var(--muted);
            max-width: 520px;
            line-height: 1.7;
            margin-top: 1.5rem;
            position: relative;
            z-index: 1;
            animation: fade-up 1s .2s ease both;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2.5rem;
            position: relative;
            z-index: 1;
            animation: fade-up 1s .3s ease both;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: .6rem;
            padding: .9rem 2.2rem;
            background: linear-gradient(135deg, #c49a30, var(--gold2));
            color: #0a0a14;
            font-weight: 700;
            font-size: .95rem;
            letter-spacing: .04em;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
            box-shadow: 0 0 30px rgba(212,168,67,.35);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 50px rgba(212,168,67,.55);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: .6rem;
            padding: .9rem 2.2rem;
            background: transparent;
            color: var(--text);
            font-weight: 500;
            font-size: .95rem;
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 6px;
            text-decoration: none;
            transition: border-color .2s, color .2s;
        }
        .btn-secondary:hover { border-color: var(--gold); color: var(--gold2); }

        /* stats bajo hero */
        .hero-stats {
            display: flex;
            gap: 3rem;
            margin-top: 4rem;
            position: relative;
            z-index: 1;
            animation: fade-up 1s .4s ease both;
        }
        .stat { text-align: center; }
        .stat-num {
            font-family: 'Cinzel', serif;
            font-size: 2rem;
            font-weight: 900;
            color: var(--gold2);
        }
        .stat-label {
            font-size: .75rem;
            color: var(--muted);
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-top: .2rem;
        }
        .stat-sep { width: 1px; background: var(--border); align-self: stretch; }

        @keyframes fade-up {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ═══════════════════════════════════
           SECCIÓN: JUEGOS
        ═══════════════════════════════════ */
        section { padding: 6rem 4rem; }

        .section-label {
            font-size: .75rem;
            font-weight: 600;
            letter-spacing: .15em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: .75rem;
        }
        .section-title {
            font-family: 'Cinzel', serif;
            font-size: clamp(1.8rem, 4vw, 3rem);
            font-weight: 700;
            line-height: 1.15;
            margin-bottom: 1rem;
        }
        .section-desc {
            color: var(--muted);
            max-width: 480px;
            line-height: 1.7;
            font-size: .95rem;
        }

        .games-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 3.5rem;
        }

        .game-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: transform .3s, border-color .3s, box-shadow .3s;
            cursor: pointer;
        }
        .game-card::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity .3s;
        }
        .game-card:hover {
            transform: translateY(-6px);
            border-color: rgba(212,168,67,.4);
            box-shadow: 0 20px 60px rgba(0,0,0,.5), 0 0 30px rgba(212,168,67,.1);
        }
        .game-card:hover::before { opacity: 1; }

        .game-card.featured {
            grid-column: span 2;
            background: linear-gradient(135deg, #12122a 0%, #1a1035 100%);
            border-color: rgba(212,168,67,.3);
        }

        .game-icon {
            font-size: 3rem;
            margin-bottom: 1.25rem;
            display: block;
            filter: drop-shadow(0 0 12px rgba(212,168,67,.4));
        }

        .game-tag {
            display: inline-block;
            padding: .2rem .7rem;
            background: rgba(212,168,67,.12);
            border: 1px solid rgba(212,168,67,.2);
            border-radius: 100px;
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: .75rem;
        }
        .game-tag.hot { background: rgba(239,68,68,.12); border-color: rgba(239,68,68,.25); color: #f87171; }
        .game-tag.new { background: rgba(34,197,94,.12); border-color: rgba(34,197,94,.25); color: #4ade80; }

        .game-name {
            font-family: 'Cinzel', serif;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: .5rem;
        }
        .game-desc { color: var(--muted); font-size: .875rem; line-height: 1.6; }

        .game-meta {
            display: flex;
            gap: 1.5rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
        }
        .game-meta-item { font-size: .8rem; color: var(--muted); }
        .game-meta-item strong { color: var(--gold2); display: block; font-size: 1rem; }

        /* ═══════════════════════════════════
           SECCIÓN: CARACTERÍSTICAS
        ═══════════════════════════════════ */
        .features-section {
            background: var(--dark2);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .features-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: center;
        }

        .features-list { margin-top: 2.5rem; display: flex; flex-direction: column; gap: 1.5rem; }

        .feature-item {
            display: flex;
            gap: 1.25rem;
            align-items: flex-start;
        }
        .feature-icon {
            width: 44px; height: 44px;
            background: rgba(212,168,67,.1);
            border: 1px solid rgba(212,168,67,.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        .feature-text h4 { font-weight: 600; margin-bottom: .25rem; }
        .feature-text p { color: var(--muted); font-size: .875rem; line-height: 1.6; }

        /* panel derecho */
        .features-visual {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem;
            position: relative;
        }
        .features-visual::before {
            content: '';
            position: absolute;
            top: -1px; left: 20%; right: 20%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .visual-header {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border);
        }
        .visual-avatar {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, var(--gold), var(--gold2));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: var(--dark); font-size: .95rem;
        }
        .visual-name { font-weight: 600; }
        .visual-balance { font-size: .8rem; color: var(--muted); }
        .visual-badge {
            margin-left: auto;
            padding: .25rem .7rem;
            background: rgba(34,197,94,.12);
            border: 1px solid rgba(34,197,94,.2);
            border-radius: 100px;
            font-size: .7rem;
            font-weight: 600;
            color: #4ade80;
        }

        .visual-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .visual-stat {
            background: rgba(255,255,255,.03);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: .9rem 1rem;
        }
        .visual-stat-label { font-size: .7rem; color: var(--muted); text-transform: uppercase; letter-spacing: .08em; margin-bottom: .4rem; }
        .visual-stat-value { font-family: 'Cinzel', serif; font-size: 1.2rem; font-weight: 700; color: var(--gold2); }
        .visual-stat-value.green { color: #4ade80; }
        .visual-stat-value.red   { color: #f87171; }

        .visual-bets { display: flex; flex-direction: column; gap: .6rem; }
        .visual-bet {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .65rem .85rem;
            background: rgba(255,255,255,.03);
            border-radius: 8px;
            font-size: .8rem;
        }
        .visual-bet-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .visual-bet-dot.won  { background: #4ade80; box-shadow: 0 0 6px #4ade80; }
        .visual-bet-dot.lost { background: #f87171; box-shadow: 0 0 6px #f87171; }
        .visual-bet-dot.pend { background: var(--gold); box-shadow: 0 0 6px var(--gold); }
        .visual-bet-name { flex: 1; color: var(--text); }
        .visual-bet-amount { font-weight: 600; color: var(--gold2); }

        /* ═══════════════════════════════════
           SECCIÓN: CTA FINAL
        ═══════════════════════════════════ */
        .cta-section {
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .cta-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 70% 70% at 50% 50%, rgba(212,168,67,.06) 0%, transparent 70%);
            pointer-events: none;
        }

        .cta-section .section-title { font-size: clamp(2rem, 5vw, 4rem); }

        .cta-divider {
            width: 60px; height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            margin: 1.5rem auto;
        }

        .cta-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2.5rem;
        }

        /* ═══════════════════════════════════
           FOOTER
        ═══════════════════════════════════ */
        footer {
            background: var(--dark2);
            border-top: 1px solid var(--border);
            padding: 3rem 4rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .footer-logo {
            font-family: 'Cinzel', serif;
            font-size: 1.1rem;
            font-weight: 900;
            letter-spacing: .1em;
            background: linear-gradient(135deg, var(--gold), var(--gold2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .footer-copy { font-size: .8rem; color: var(--muted); }

        .footer-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }
        .footer-links a {
            color: var(--muted);
            font-size: .8rem;
            text-decoration: none;
            transition: color .2s;
        }
        .footer-links a:hover { color: var(--gold2); }

        /* ═══════════════════════════════════
           SCROLL ANIMATIONS
        ═══════════════════════════════════ */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity .7s ease, transform .7s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ═══════════════════════════════════
           RESPONSIVE
        ═══════════════════════════════════ */
        @media (max-width: 900px) {
            nav { padding: 1rem 1.5rem; }
            .nav-links { display: none; }
            section { padding: 4rem 1.5rem; }
            .games-grid { grid-template-columns: 1fr; }
            .game-card.featured { grid-column: span 1; }
            .features-inner { grid-template-columns: 1fr; gap: 3rem; }
            .hero-stats { gap: 1.5rem; }
            footer { flex-direction: column; gap: 1.5rem; text-align: center; }
            .footer-links { justify-content: center; }
            .hero-actions, .cta-actions { flex-direction: column; align-items: center; }
        }
    </style>
</head>
<body>

    {{-- ═══ NAV ═══ --}}
    <nav>
        <a href="/" class="nav-logo">{{ config('app.name', 'APUESTAS') }}</a>
        <ul class="nav-links">
            <li><a href="#juegos">Juegos</a></li>
            <li><a href="#caracteristicas">Características</a></li>
            @auth
                <li><a href="{{ route('front.home') }}" class="btn-nav">Mi cuenta</a></li>
            @else
                <li><a href="{{ route('login') }}" class="btn-nav">Iniciar sesión</a></li>
            @endauth
        </ul>
    </nav>

    {{-- ═══ HERO ═══ --}}
    <section class="hero">
        <div class="hero-lines">
            <span></span><span></span><span></span><span></span>
        </div>

        <div class="hero-badge">🎰 Plataforma de apuestas online</div>

        <h1>
            Juega.<br>
            <span class="gold">Gana. Vive.</span>
        </h1>

        <p class="hero-sub">
            Apuestas deportivas, juego de minas y desafíos entre jugadores.
            La emoción del casino en tus manos.
        </p>

        <div class="hero-actions">
            @auth
                <a href="{{ route('front.home') }}" class="btn-primary">
                    🎮 Ir al casino
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-primary">
                    🎮 Comenzar ahora
                </a>
                <a href="#juegos" class="btn-secondary">
                    Ver juegos ↓
                </a>
            @endauth
        </div>

        <div class="hero-stats">
            <div class="stat">
                <div class="stat-num">3+</div>
                <div class="stat-label">Juegos</div>
            </div>
            <div class="stat-sep"></div>
            <div class="stat">
                <div class="stat-num">24/7</div>
                <div class="stat-label">Disponible</div>
            </div>
            <div class="stat-sep"></div>
            <div class="stat">
                <div class="stat-num">100%</div>
                <div class="stat-label">Online</div>
            </div>
        </div>
    </section>

    {{-- ═══ JUEGOS ═══ --}}
    <section id="juegos" style="max-width:1200px; margin: 0 auto;">
        <div class="reveal">
            <div class="section-label">Nuestros juegos</div>
            <h2 class="section-title">Todo en un solo lugar</h2>
            <p class="section-desc">Desde apuestas deportivas hasta juegos de azar, tenemos todo lo que necesitas para una experiencia completa.</p>
        </div>

        <div class="games-grid">
            {{-- Apuestas deportivas --}}
            <div class="game-card featured reveal">
                <span class="game-icon">⚽</span>
                <span class="game-tag hot">🔥 Popular</span>
                <div class="game-name">Apuestas Deportivas</div>
                <p class="game-desc">Apuesta en partidos de tus deportes favoritos. Fútbol, básquet, tenis y más. Elige tu equipo, analiza las cuotas y gana en grande.</p>
                <div class="game-meta">
                    <div class="game-meta-item"><strong>1X2</strong>Resultado final</div>
                    <div class="game-meta-item"><strong>Handicap</strong>Asiático</div>
                    <div class="game-meta-item"><strong>+/-</strong>Más/Menos goles</div>
                </div>
            </div>

            {{-- Minas --}}
            <div class="game-card reveal" style="transition-delay:.1s">
                <span class="game-icon">💣</span>
                <span class="game-tag new">✨ Nuevo</span>
                <div class="game-name">Juego de Minas</div>
                <p class="game-desc">Descubre casillas sin explotar minas. A más riesgo, mayor recompensa. ¿Hasta dónde te atreves a llegar?</p>
            </div>

            {{-- Desafíos --}}
            <div class="game-card reveal" style="transition-delay:.2s">
                <span class="game-icon">⚔️</span>
                <span class="game-tag">PVP</span>
                <div class="game-name">Desafíos 1v1</div>
                <p class="game-desc">Reta a otros jugadores directamente. Crea desafíos, acepta apuestas y demuestra quién sabe más de deportes.</p>
            </div>
        </div>
    </section>

    {{-- ═══ CARACTERÍSTICAS ═══ --}}
    <section id="caracteristicas" class="features-section">
        <div class="features-inner">
            <div class="reveal">
                <div class="section-label">¿Por qué elegirnos?</div>
                <h2 class="section-title">Todo bajo control</h2>
                <p class="section-desc">Una plataforma diseñada para que disfrutes sin complicaciones.</p>

                <div class="features-list">
                    <div class="feature-item">
                        <div class="feature-icon">💰</div>
                        <div class="feature-text">
                            <h4>Saldo en tiempo real</h4>
                            <p>Tu balance siempre actualizado. Deposita, retira y apuesta sin esperas.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">📊</div>
                        <div class="feature-text">
                            <h4>Historial completo</h4>
                            <p>Revisa todas tus apuestas, partidas y transacciones cuando quieras.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">👥</div>
                        <div class="feature-text">
                            <h4>Comunidad de jugadores</h4>
                            <p>Sigue a otros jugadores, comenta partidos y compite en desafíos directos.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">🔒</div>
                        <div class="feature-text">
                            <h4>Seguro y confiable</h4>
                            <p>Plataforma protegida. Tu cuenta y tu dinero siempre están seguros.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Panel visual --}}
            <div class="features-visual reveal" style="transition-delay:.15s">
                <div class="visual-header">
                    <div class="visual-avatar">PL</div>
                    <div>
                        <div class="visual-name">Pablo López</div>
                        <div class="visual-balance">Saldo: $1,000.00</div>
                    </div>
                    <div class="visual-badge">● En línea</div>
                </div>

                <div class="visual-stats">
                    <div class="visual-stat">
                        <div class="visual-stat-label">Apuestas ganadas</div>
                        <div class="visual-stat-value green">12</div>
                    </div>
                    <div class="visual-stat">
                        <div class="visual-stat-label">Apuestas perdidas</div>
                        <div class="visual-stat-value red">4</div>
                    </div>
                    <div class="visual-stat">
                        <div class="visual-stat-label">Partidas minas</div>
                        <div class="visual-stat-value">8</div>
                    </div>
                    <div class="visual-stat">
                        <div class="visual-stat-label">Desafíos activos</div>
                        <div class="visual-stat-value">3</div>
                    </div>
                </div>

                <div style="font-size:.75rem; color:var(--muted); text-transform:uppercase; letter-spacing:.08em; margin-bottom:.75rem;">Últimas apuestas</div>
                <div class="visual-bets">
                    <div class="visual-bet">
                        <div class="visual-bet-dot won"></div>
                        <div class="visual-bet-name">Real Madrid vs Barcelona</div>
                        <div class="visual-bet-amount">+$185</div>
                    </div>
                    <div class="visual-bet">
                        <div class="visual-bet-dot pend"></div>
                        <div class="visual-bet-name">PSG vs Manchester City</div>
                        <div class="visual-bet-amount">$50</div>
                    </div>
                    <div class="visual-bet">
                        <div class="visual-bet-dot lost"></div>
                        <div class="visual-bet-name">Juego de Minas</div>
                        <div class="visual-bet-amount">-$75</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ CTA ═══ --}}
    <section class="cta-section">
        <div class="reveal">
            <div class="section-label">¿Listo para empezar?</div>
            <h2 class="section-title">La suerte favorece<br>a los valientes</h2>
            <div class="cta-divider"></div>
            <p class="section-desc" style="margin: 0 auto;">
                Entra a tu cuenta y empieza a ganar ahora mismo.
            </p>
            <div class="cta-actions">
                @auth
                    <a href="{{ route('front.home') }}" class="btn-primary">🎮 Ir al casino</a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary">🎮 Iniciar sesión</a>
                    <a href="#juegos" class="btn-secondary">Ver juegos</a>
                @endauth
            </div>
        </div>
    </section>

    {{-- ═══ FOOTER ═══ --}}
    <footer>
        <div class="footer-logo">{{ config('app.name', 'APUESTAS') }}</div>
        <div class="footer-copy">© {{ date('Y') }} — Todos los derechos reservados</div>
        <ul class="footer-links">
            <li><a href="#">Términos</a></li>
            <li><a href="#">Privacidad</a></li>
            <li><a href="{{ route('login') }}">Acceder</a></li>
        </ul>
    </footer>

    <script>
        // Scroll reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>

</body>
</html>