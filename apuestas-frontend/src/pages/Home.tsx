// src/pages/Home.tsx
import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { useAuth } from '../lib/auth';
import { matchesApi, apuestasApi, GameMatch, Bet } from '../lib/api';

export default function Home() {
  const { user } = useAuth();
  const [nextMatches, setNextMatches] = useState<GameMatch[]>([]);
  const [myBets,      setMyBets]      = useState<Bet[]>([]);
  const [stats, setStats] = useState({ won: 0, pending: 0, scheduled: 0, challenges: 0 });

  useEffect(() => {
    matchesApi.list(undefined, 1).then(res => setNextMatches(res.data.slice(0, 4))).catch(() => {});
    apuestasApi.list(1).then(res => {
      const bets = res.data.slice(0, 5);
      setMyBets(bets);
      setStats(s => ({
        ...s,
        won:     res.data.filter(b => b.status === 'won').length,
        pending: res.data.filter(b => b.status === 'pending').length,
      }));
    }).catch(() => {});
  }, []);

  return (
    <>
      {/* Hero */}
      <div style={{
        marginBottom: 28, padding: '28px 32px',
        background: 'linear-gradient(135deg, rgba(240,192,64,.06), rgba(139,92,246,.04))',
        border: '1px solid rgba(240,192,64,.12)',
        borderRadius: 20,
        display: 'flex', justifyContent: 'space-between', alignItems: 'center', flexWrap: 'wrap', gap: 16,
      }}>
        <div>
          <div style={{ fontFamily: 'var(--h)', fontSize: 30, fontWeight: 700, letterSpacing: 1, lineHeight: 1.1 }}>
            Bienvenido, <span style={{ color: 'var(--gold)' }}>{user?.name}</span> 👋
          </div>
          <div style={{ color: 'var(--text2)', fontSize: 14, marginTop: 6 }}>Tus estadísticas de hoy</div>
        </div>
        <div style={{ display: 'flex', gap: 20, flexWrap: 'wrap' }}>
          <div style={{ textAlign: 'center' }}>
            <div style={{ fontFamily: 'var(--h)', fontSize: 26, fontWeight: 700, color: 'var(--green)' }}>{stats.won}</div>
            <div style={{ fontSize: 11, color: 'var(--text2)' }}>Apuestas ganadas</div>
          </div>
          <div style={{ textAlign: 'center' }}>
            <div style={{ fontFamily: 'var(--h)', fontSize: 26, fontWeight: 700, color: 'var(--gold)' }}>{stats.pending}</div>
            <div style={{ fontSize: 11, color: 'var(--text2)' }}>En juego</div>
          </div>
          <div style={{ textAlign: 'center' }}>
            <div style={{ fontFamily: 'var(--h)', fontSize: 26, fontWeight: 700, color: 'var(--blue)' }}>
              ${Number(user?.balance ?? 0).toFixed(2)}
            </div>
            <div style={{ fontSize: 11, color: 'var(--text2)' }}>Saldo disponible</div>
          </div>
        </div>
      </div>

      {/* Quick access */}
      <div className="g3" style={{ marginBottom: 22 }}>
        {[
          { to: '/partidos',    icon: '⚽', label: 'Apostar',  sub: `${nextMatches.length} partidos disponibles`, accent: 'rgba(240,192,64,.35)',  arrow: 'var(--gold)' },
          { to: '/minas',       icon: '💣', label: 'Minas',    sub: 'Juego de riesgo y recompensa',              accent: 'rgba(139,92,246,.35)',  arrow: 'var(--violet)' },
          { to: '/desafios',    icon: '⚔️', label: 'Desafíos', sub: 'Reta a otros jugadores',                    accent: 'rgba(52,152,219,.35)',  arrow: 'var(--blue)' },
        ].map(({ to, icon, label, sub, accent, arrow }) => (
          <Link key={to} to={to} style={{ textDecoration: 'none' }}>
            <QuickCard icon={icon} label={label} sub={sub} accent={accent} arrow={arrow} />
          </Link>
        ))}
      </div>

      <div className="g2">
        {/* Próximos partidos */}
        <div className="card">
          <div className="card-hdr">Próximos Partidos</div>
          {nextMatches.length === 0
            ? <div className="empty">No hay partidos próximos</div>
            : nextMatches.map(m => (
              <div key={m.id} style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', padding: '12px 0', borderBottom: '1px solid var(--border)', gap: 10 }}>
                <div>
                  <div style={{ fontFamily: 'var(--h)', fontSize: 15, fontWeight: 700 }}>
                    {m.teamHome?.name} <span className="vs">VS</span> {m.teamAway?.name}
                  </div>
                  <div style={{ fontSize: 11, color: 'var(--text2)', marginTop: 3 }}>
                    {m.sport?.name} · {m.match_date}
                  </div>
                </div>
                <Link to="/partidos" className="btn" style={{ padding: '6px 14px', fontSize: 11 }}>Apostar</Link>
              </div>
            ))
          }
        </div>

        {/* Mis últimas apuestas */}
        <div className="card">
          <div className="card-hdr">Mis Últimas Apuestas</div>
          {myBets.length === 0
            ? <div className="empty">Aún no has realizado apuestas</div>
            : (
              <div className="tw">
                <table>
                  <thead>
                    <tr><th>Partido</th><th>Monto</th><th>Estado</th></tr>
                  </thead>
                  <tbody>
                    {myBets.map(bet => (
                      <tr key={bet.id}>
                        <td>
                          <div style={{ fontSize: 13, fontWeight: 500 }}>
                            {bet.match?.teamHome?.name ?? '?'} <span className="vs">vs</span> {bet.match?.teamAway?.name ?? '?'}
                          </div>
                          <div className="cm">{bet.odd?.option_name ?? '-'}</div>
                        </td>
                        <td className="cr">-${Number(bet.amount).toFixed(2)}</td>
                        <td><span className={`bx ${bet.status}`}>{bet.status}</span></td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            )
          }
        </div>
      </div>
    </>
  );
}

function QuickCard({ icon, label, sub, accent, arrow }: { icon: string; label: string; sub: string; accent: string; arrow: string }) {
  const [h, setH] = useState(false);
  return (
    <div
      onMouseEnter={() => setH(true)}
      onMouseLeave={() => setH(false)}
      className="card"
      style={{ borderColor: h ? accent : 'var(--border)', transition: 'border-color .2s', cursor: 'pointer', display: 'flex', alignItems: 'center', gap: 14, padding: 20 }}
    >
      <div style={{ fontSize: 36 }}>{icon}</div>
      <div>
        <div style={{ fontFamily: 'var(--h)', fontSize: 17, fontWeight: 700, letterSpacing: 1 }}>{label}</div>
        <div style={{ fontSize: 12, color: 'var(--text2)', marginTop: 2 }}>{sub}</div>
      </div>
      <div style={{ marginLeft: 'auto', color: arrow, fontSize: 20 }}>→</div>
    </div>
  );
}
