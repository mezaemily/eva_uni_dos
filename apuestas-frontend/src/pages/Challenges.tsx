// src/pages/Challenges.tsx
import { useState, useEffect } from 'react';
import { desafiosApi, Challenge } from '../lib/api';
import Pagination from '../components/Pagination';

export default function Challenges() {
  const [challenges, setChallenges] = useState<Challenge[]>([]);
  const [page,       setPage]       = useState(1);
  const [lastPage,   setLastPage]   = useState(1);
  const [loading,    setLoading]    = useState(true);
  const [stats, setStats] = useState({ total: 0, pending: 0, accepted: 0, rejected: 0 });

  useEffect(() => {
    setLoading(true);
    desafiosApi.list(page)
      .then(res => {
        setChallenges(res.data);
        setLastPage(res.last_page);
        setStats({
          total:    res.total,
          pending:  res.data.filter(c => c.status === 'pending').length,
          accepted: res.data.filter(c => c.status === 'accepted').length,
          rejected: res.data.filter(c => c.status === 'rejected').length,
        });
      })
      .catch(() => {})
      .finally(() => setLoading(false));
  }, [page]);

  function Avatar({ name, color }: { name: string; color: string }) {
    return (
      <div style={{
        width: 28, height: 28,
        background: color,
        borderRadius: '50%',
        display: 'flex', alignItems: 'center', justifyContent: 'center',
        fontFamily: 'var(--h)', fontSize: 12, fontWeight: 700, color: '#000',
        flexShrink: 0,
      }}>
        {name?.charAt(0).toUpperCase() ?? '?'}
      </div>
    );
  }

  return (
    <>
      <div style={{ display: 'flex', alignItems: 'baseline', gap: 14, marginBottom: 24, flexWrap: 'wrap', justifyContent: 'space-between' }}>
        <div>
          <div style={{ fontFamily: 'var(--h)', fontSize: 24, fontWeight: 700, letterSpacing: 1 }}>⚔️ Desafíos</div>
          <div style={{ fontSize: 13, color: 'var(--text2)', marginTop: 4 }}>Reta a otros jugadores</div>
        </div>
      </div>

      {/* Stats */}
      <div className="g4" style={{ marginBottom: 22 }}>
        <div className="stat y"><div className="stat-label">Total</div><div className="stat-val">{stats.total}</div></div>
        <div className="stat b"><div className="stat-label">Pendientes</div><div className="stat-val">{stats.pending}</div></div>
        <div className="stat g"><div className="stat-label">Aceptados</div><div className="stat-val">{stats.accepted}</div></div>
        <div className="stat r"><div className="stat-label">Rechazados</div><div className="stat-val">{stats.rejected}</div></div>
      </div>

      <div className="card">
        <div className="card-hdr">Mis Desafíos</div>

        {loading ? (
          <div className="empty">Cargando…</div>
        ) : challenges.length === 0 ? (
          <div className="empty">Sin desafíos registrados aún</div>
        ) : (
          <>
            <div className="tw">
              <table>
                <thead>
                  <tr><th>#</th><th>Creador</th><th>Rival</th><th>Estado</th><th>Apuestas</th><th>Fecha</th></tr>
                </thead>
                <tbody>
                  {challenges.map(ch => (
                    <tr key={ch.id}>
                      <td className="cm">{ch.id}</td>
                      <td>
                        <div style={{ display: 'flex', alignItems: 'center', gap: 8 }}>
                          <Avatar name={ch.creator?.name} color="linear-gradient(135deg,var(--gold2),var(--gold))" />
                          <div>
                            <div style={{ fontSize: 13, fontWeight: 500 }}>{ch.creator?.name ?? '-'}</div>
                            <div className="cm">@{ch.creator?.username ?? ''}</div>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div style={{ display: 'flex', alignItems: 'center', gap: 8 }}>
                          <Avatar name={ch.opponent?.name} color="linear-gradient(135deg,#3498db,#60a5fa)" />
                          <div>
                            <div style={{ fontSize: 13, fontWeight: 500 }}>{ch.opponent?.name ?? '-'}</div>
                            <div className="cm">@{ch.opponent?.username ?? ''}</div>
                          </div>
                        </div>
                      </td>
                      <td><span className={`bx ${ch.status}`}>{ch.status}</span></td>
                      <td className="cm">{ch.challengeBets?.length ?? 0} apuesta(s)</td>
                      <td className="cm">{ch.created_at?.slice(0, 16).replace('T', ' ')}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
            <Pagination current={page} last={lastPage} onChange={setPage} />
          </>
        )}
      </div>
    </>
  );
}
