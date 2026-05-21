import { useEffect } from 'react';

export default function Dashboard() {
    
    // Simulación de la variable @auth de Laravel
    const isAuthenticated = false; 

    // Efecto de scroll (Scroll Reveal) que tenías en tu etiqueta <script>
    useEffect(() => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        const elements = document.querySelectorAll('.reveal');
        elements.forEach(el => observer.observe(el));

        return () => observer.disconnect();
    }, []);

    return (
        <>
            {/* ═══ HERO ═══ */}
            <section className="hero">
                <div className="hero-lines">
                    <span></span><span></span><span></span><span></span>
                </div>

                <div className="hero-badge">🎰 Plataforma de apuestas online</div>

                <h1>
                    Juega.<br />
                    <span className="gold">Gana. Vive.</span>
                </h1>

                <p className="hero-sub">
                    Apuestas deportivas, juego de minas y desafíos entre jugadores.
                    La emoción del casino en tus manos.
                </p>

                <div className="hero-actions">
                    {isAuthenticated ? (
                        <a href="/home" className="btn-primary">
                            🎮 Ir al casino
                        </a>
                    ) : (
                        <>
                            <a href="/login" className="btn-primary">
                                🎮 Comenzar ahora
                            </a>
                            <a href="#juegos" className="btn-secondary">
                                Ver juegos ↓
                            </a>
                        </>
                    )}
                </div>

                <div className="hero-stats">
                    <div className="stat">
                        <div className="stat-num">3+</div>
                        <div className="stat-label">Juegos</div>
                    </div>
                    <div className="stat-sep"></div>
                    <div className="stat">
                        <div className="stat-num">24/7</div>
                        <div className="stat-label">Disponible</div>
                    </div>
                    <div className="stat-sep"></div>
                    <div className="stat">
                        <div className="stat-num">100%</div>
                        <div className="stat-label">Online</div>
                    </div>
                </div>
            </section>

            {/* ═══ JUEGOS ═══ */}
            <section id="juegos" style={{ maxWidth: '1200px', margin: '0 auto' }}>
                <div className="reveal">
                    <div className="section-label">Nuestros juegos</div>
                    <h2 className="section-title">Todo en un solo lugar</h2>
                    <p className="section-desc">Desde apuestas deportivas hasta juegos de azar, tenemos todo lo que necesitas para una experiencia completa.</p>
                </div>

                <div className="games-grid">
                    {/* Apuestas deportivas */}
                    <div className="game-card featured reveal">
                        <span className="game-icon">⚽</span>
                        <span className="game-tag hot">🔥 Popular</span>
                        <div className="game-name">Apuestas Deportivas</div>
                        <p className="game-desc">Apuesta en partidos de tus deportes favoritos. Fútbol, básquet, tenis y más. Elige tu equipo, analiza las cuotas y gana en grande.</p>
                        <div className="game-meta">
                            <div className="game-meta-item"><strong>1X2</strong>Resultado final</div>
                            <div className="game-meta-item"><strong>Handicap</strong>Asiático</div>
                            <div className="game-meta-item"><strong>+/-</strong>Más/Menos goles</div>
                        </div>
                    </div>

                    {/* Minas */}
                    <div className="game-card reveal" style={{ transitionDelay: '.1s' }}>
                        <span className="game-icon">💣</span>
                        <span className="game-tag new">✨ Nuevo</span>
                        <div className="game-name">Juego de Minas</div>
                        <p className="game-desc">Descubre casillas sin explotar minas. A más riesgo, mayor recompensa. ¿Hasta dónde te atreves a llegar?</p>
                    </div>

                    {/* Desafíos */}
                    <div className="game-card reveal" style={{ transitionDelay: '.2s' }}>
                        <span className="game-icon">⚔️</span>
                        <span className="game-tag">PVP</span>
                        <div className="game-name">Desafíos 1v1</div>
                        <p className="game-desc">Reta a otros jugadores directamente. Crea desafíos, acepta apuestas y demuestra quién sabe más de deportes.</p>
                    </div>
                </div>
            </section>

            {/* ═══ CARACTERÍSTICAS ═══ */}
            <section id="caracteristicas" className="features-section">
                <div className="features-inner">
                    <div className="reveal">
                        <div className="section-label">¿Por qué elegirnos?</div>
                        <h2 className="section-title">Todo bajo control</h2>
                        <p className="section-desc">Una plataforma diseñada para que disfrutes sin complicaciones.</p>

                        <div className="features-list">
                            <div className="feature-item">
                                <div className="feature-icon">💰</div>
                                <div className="feature-text">
                                    <h4>Saldo en tiempo real</h4>
                                    <p>Tu balance siempre actualizado. Deposita, retira y apuesta sin esperas.</p>
                                </div>
                            </div>
                            <div className="feature-item">
                                <div className="feature-icon">📊</div>
                                <div className="feature-text">
                                    <h4>Historial completo</h4>
                                    <p>Revisa todas tus apuestas, partidas y transacciones cuando quieras.</p>
                                </div>
                            </div>
                            <div className="feature-item">
                                <div className="feature-icon">👥</div>
                                <div className="feature-text">
                                    <h4>Comunidad de jugadores</h4>
                                    <p>Sigue a otros jugadores, comenta partidos y compite en desafíos directos.</p>
                                </div>
                            </div>
                            <div className="feature-item">
                                <div className="feature-icon">🔒</div>
                                <div className="feature-text">
                                    <h4>Seguro y confiable</h4>
                                    <p>Plataforma protegida. Tu cuenta y tu dinero siempre están seguros.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Panel visual */}
                    <div className="features-visual reveal" style={{ transitionDelay: '.15s' }}>
                        <div className="visual-header">
                            <div className="visual-avatar">PL</div>
                            <div>
                                <div className="visual-name">Pablo López</div>
                                <div className="visual-balance">Saldo: $1,000.00</div>
                            </div>
                            <div className="visual-badge">● En línea</div>
                        </div>

                        <div className="visual-stats">
                            <div className="visual-stat">
                                <div className="visual-stat-label">Apuestas ganadas</div>
                                <div className="visual-stat-value green">12</div>
                            </div>
                            <div className="visual-stat">
                                <div className="visual-stat-label">Apuestas perdidas</div>
                                <div className="visual-stat-value red">4</div>
                            </div>
                            <div className="visual-stat">
                                <div className="visual-stat-label">Partidas minas</div>
                                <div className="visual-stat-value">8</div>
                            </div>
                            <div className="visual-stat">
                                <div className="visual-stat-label">Desafíos activos</div>
                                <div className="visual-stat-value">3</div>
                            </div>
                        </div>

                        <div style={{ fontSize: '.75rem', color: 'var(--muted)', textTransform: 'uppercase', letterSpacing: '.08em', marginBottom: '.75rem' }}>
                            Últimas apuestas
                        </div>
                        <div className="visual-bets">
                            <div className="visual-bet">
                                <div className="visual-bet-dot won"></div>
                                <div className="visual-bet-name">Real Madrid vs Barcelona</div>
                                <div className="visual-bet-amount">+$185</div>
                            </div>
                            <div className="visual-bet">
                                <div className="visual-bet-dot pend"></div>
                                <div className="visual-bet-name">PSG vs Manchester City</div>
                                <div className="visual-bet-amount">$50</div>
                            </div>
                            <div className="visual-bet">
                                <div className="visual-bet-dot lost"></div>
                                <div className="visual-bet-name">Juego de Minas</div>
                                <div className="visual-bet-amount">-$75</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* ═══ CTA ═══ */}
            <section className="cta-section">
                <div className="reveal">
                    <div className="section-label">¿Listo para empezar?</div>
                    <h2 className="section-title">La suerte favorece<br />a los valientes</h2>
                    <div className="cta-divider"></div>
                    <p className="section-desc" style={{ margin: '0 auto' }}>
                        Entra a tu cuenta y empieza a ganar ahora mismo.
                    </p>
                    <div className="cta-actions">
                        {isAuthenticated ? (
                            <a href="/home" className="btn-primary">🎮 Ir al casino</a>
                        ) : (
                            <>
                                <a href="/login" className="btn-primary">🎮 Iniciar sesión</a>
                                <a href="#juegos" className="btn-secondary">Ver juegos</a>
                            </>
                        )}
                    </div>
                </div>
            </section>
        </>
    );
}