// src/views/CasinoHome.tsx
import './home.css';

export default function CasinoHome() {
    
    // 1. Simulación de los datos que enviaría el controlador de Laravel
    const user = { name: "jaime p", balance: 600.00 };
    const stats = { wonBets: 1, pendingBets: 0 };
    const accessStats = { scheduledMatches: 3, pendingChallenges: 0 };
    
    const nextMatches = [
        { id: 1, teamHome: 'Real Madrid', teamAway: 'FC Barcelona', sport: 'Fútbol', date: '23/05 15:09' },
        { id: 2, teamHome: 'LA Lakers', teamAway: 'Chicago Bulls', sport: 'Básquetbol', date: '25/05 15:09' },
        { id: 3, teamHome: 'FC Barcelona', teamAway: 'Real Madrid', sport: 'Fútbol', date: '27/05 15:09' },
    ];

    const myBets = [
        { id: 1, matchHome: 'LA Lakers', matchAway: 'Chicago Bulls', option: 'Más de 200.5 puntos', amount: 200.00, status: 'WON' }
    ];

    return (
        <div className="casino-wrapper">
            
            {/* --- NAV (Mantenido de la captura original) --- */}
            <nav className="casino-nav">
                <div className="nav-left">
                    <div className="casino-brand">BETARENA</div>
                    <div className="nav-links">
                        <a href="#inicio" className="active">INICIO</a>
                        <a href="#partidos">PARTIDOS</a>
                        <a href="#minas">MINAS</a>
                        <a href="#desafios">DESAFÍOS</a>
                        <a href="#mis-apuestas">MIS APUESTAS</a>
                        <a href="#perfil">PERFIL</a>
                    </div>
                </div>
                <div className="nav-right">
                    <div className="balance-badge">
                        <span>$</span> {user.balance.toFixed(2)}
                    </div>
                    <div className="user-profile">
                        <div className="avatar">j</div>
                        <span className="username">jimil</span>
                    </div>
                    <button className="btn-logout">Salir</button>
                </div>
            </nav>

            {/* --- CONTENIDO PRINCIPAL (Traducción exacta de tu Blade) --- */}
            <main className="casino-main">
                
                {/* Hero greeting */}
                <div style={{
                    marginBottom: '28px', padding: '28px 32px',
                    background: 'linear-gradient(135deg, rgba(240,192,64,.06), rgba(139,92,246,.04))',
                    border: '1px solid rgba(240,192,64,.12)',
                    borderRadius: '20px', display: 'flex', justifyContent: 'space-between', 
                    alignItems: 'center', flexWrap: 'wrap', gap: '16px'
                }}>
                    <div>
                        <div style={{ fontFamily: 'var(--h)', fontSize: '30px', fontWeight: 700, letterSpacing: '1px', lineHeight: 1.1 }}>
                            Bienvenido, <span style={{ color: 'var(--gold)' }}>{user.name}</span> 👋
                        </div>
                        <div style={{ color: 'var(--text2)', fontSize: '14px', marginTop: '6px' }}>
                            Tus estadísticas de hoy
                        </div>
                    </div>

                    <div style={{ display: 'flex', gap: '20px', flexWrap: 'wrap' }}>
                        <div style={{ textAlign: 'center' }}>
                            <div style={{ fontFamily: 'var(--h)', fontSize: '26px', fontWeight: 700, color: 'var(--green)' }}>
                                {stats.wonBets}
                            </div>
                            <div style={{ fontSize: '11px', color: 'var(--text2)' }}>Apuestas ganadas</div>
                        </div>
                        <div style={{ textAlign: 'center' }}>
                            <div style={{ fontFamily: 'var(--h)', fontSize: '26px', fontWeight: 700, color: 'var(--gold)' }}>
                                {stats.pendingBets}
                            </div>
                            <div style={{ fontSize: '11px', color: 'var(--text2)' }}>En juego</div>
                        </div>
                        <div style={{ textAlign: 'center' }}>
                            <div style={{ fontFamily: 'var(--h)', fontSize: '26px', fontWeight: 700, color: 'var(--blue)' }}>
                                ${user.balance.toFixed(2)}
                            </div>
                            <div style={{ fontSize: '11px', color: 'var(--text2)' }}>Saldo disponible</div>
                        </div>
                    </div>
                </div>

                {/* Quick access */}
                <div className="g3" style={{ marginBottom: '22px' }}>
                    <a href="#apostar" style={{ textDecoration: 'none' }}>
                        <div className="action-link gold">
                            <div style={{ fontSize: '36px' }}>⚽</div>
                            <div>
                                <div style={{ fontFamily: 'var(--h)', fontSize: '17px', fontWeight: 700, letterSpacing: '1px', color: '#fff' }}>Apostar</div>
                                <div style={{ fontSize: '12px', color: 'var(--text2)', marginTop: '2px' }}>{accessStats.scheduledMatches} partidos disponibles</div>
                            </div>
                            <div style={{ marginLeft: 'auto', color: 'var(--gold)', fontSize: '20px' }}>→</div>
                        </div>
                    </a>

                    <a href="#minas" style={{ textDecoration: 'none' }}>
                        <div className="action-link violet">
                            <div style={{ fontSize: '36px' }}>💣</div>
                            <div>
                                <div style={{ fontFamily: 'var(--h)', fontSize: '17px', fontWeight: 700, letterSpacing: '1px', color: '#fff' }}>Minas</div>
                                <div style={{ fontSize: '12px', color: 'var(--text2)', marginTop: '2px' }}>Juego de riesgo y recompensa</div>
                            </div>
                            <div style={{ marginLeft: 'auto', color: 'var(--violet)', fontSize: '20px' }}>→</div>
                        </div>
                    </a>

                    <a href="#desafios" style={{ textDecoration: 'none' }}>
                        <div className="action-link blue">
                            <div style={{ fontSize: '36px' }}>⚔️</div>
                            <div>
                                <div style={{ fontFamily: 'var(--h)', fontSize: '17px', fontWeight: 700, letterSpacing: '1px', color: '#fff' }}>Desafíos</div>
                                <div style={{ fontSize: '12px', color: 'var(--text2)', marginTop: '2px' }}>{accessStats.pendingChallenges} desafío(s) pendiente(s)</div>
                            </div>
                            <div style={{ marginLeft: 'auto', color: 'var(--blue)', fontSize: '20px' }}>→</div>
                        </div>
                    </a>
                </div>

                {/* Grids inferiores */}
                <div className="g2">
                    
                    {/* Próximos partidos */}
                    <div className="card">
                        <div className="card-hdr">Próximos Partidos</div>
                        {nextMatches.length === 0 ? (
                            <div className="empty">No hay partidos próximos</div>
                        ) : (
                            nextMatches.map((m, index) => (
                                <div key={m.id} style={{
                                    display: 'flex', alignItems: 'center', justifyContent: 'space-between',
                                    padding: '12px 0', 
                                    borderBottom: index === nextMatches.length - 1 ? 'none' : '1px solid var(--border)', 
                                    gap: '10px'
                                }}>
                                    <div>
                                        <div style={{ fontFamily: 'var(--h)', fontSize: '15px', fontWeight: 700 }}>
                                            {m.teamHome} <span className="vs">VS</span> {m.teamAway}
                                        </div>
                                        <div style={{ fontSize: '11px', color: 'var(--text2)', marginTop: '3px' }}>
                                            {m.sport} · {m.date}
                                        </div>
                                    </div>
                                    <a href="#apostar" className="btn-blade" style={{ padding: '6px 14px', fontSize: '11px' }}>
                                        Apostar
                                    </a>
                                </div>
                            ))
                        )}
                    </div>

                    {/* Mis últimas apuestas */}
                    <div className="card">
                        <div className="card-hdr">Mis Últimas Apuestas</div>
                        {myBets.length === 0 ? (
                            <div className="empty">Aún no has realizado apuestas</div>
                        ) : (
                            <div className="tw">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Partido</th><th>Monto</th><th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {myBets.map(bet => (
                                            <tr key={bet.id}>
                                                <td>
                                                    <div style={{ fontSize: '13px', fontWeight: 500 }}>
                                                        {bet.matchHome} <span className="vs">vs</span> {bet.matchAway}
                                                    </div>
                                                    <div className="cm">{bet.option}</div>
                                                </td>
                                                <td className="cr">-${bet.amount.toFixed(2)}</td>
                                                <td><span className={`bx ${bet.status}`}>{bet.status}</span></td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        )}
                    </div>

                </div>
            </main>
        </div>
    );
}