// src/pages/MyBets.tsx
import { useState, useEffect } from 'react';
import { apuestasApi, Bet } from '../lib/api';
import Pagination from '../components/Pagination';

export default function MyBets() {
  const [bets,     setBets]     = useState<Bet[]>([]);
  const [page,     setPage]     = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const [loading,  setLoading]  = useState(true);

  const [stats, setStats] = useState({ total: 0, won: 0, lost: 0, pending: 0, won_amount: 0, lost_amount: 0, pending_amount: 0 });

  useEffect(() => {
    setLoading(true);
    apuestasApi.list(page)
      .then(res => {
        setBets(res.data);
        setLastPage(res.last_page);
        setStats({
          total:          res.total,
          won:            res.data.filter(b => b.status === 'won').length,
          lost:           res.data.filter(b => b.status === 'lost').length,
          pending:        res.data.filter(b => b.status === 'pending').length,
          won_amount:     res.data.filter(b => b.status === 'won').reduce((a, b) => a + b.potential_win, 0),
          lost_amount:    res.data.filter(b => b.status === 'lost').reduce((a, b) => a + b.amount, 0),
          pending_amount: res.data.filter(b => b.status === 'pending').reduce((a, b) => a + b.amount, 0),
        });
      })
      .catch(() => {})
      .finally(() => setLoading(false));
  }, [page]);

  return (
    <>
      <div style={{ fontFamily: 'var(--h)', fontSize: 24, fontWeight: 700, letterSpacing: 1, marginBottom: 24 }}>
        🎯 Mis Apuestas
      </div>

      {/* Stats */}
      <div className="g4" style={{ marginBottom: 22 }}>
        <div className="stat y"><div className="stat-label">Total</div><div className="stat-val">{stats.total}</div></div>
        <div className="stat g">
          <div className="stat-label">Ganadas</div>
          <div className="stat-val">{stats.won}</div>
          <div className="stat-sub cg">+${stats.won_amount.toFixed(2)}</div>
        </div>
        <div className="stat r">
          <div className="stat-label">Perdidas</div>
          <div className="stat-val">{stats.lost}</div>
          <div className="stat-sub cr">-${stats.lost_amount.toFixed(2)}</div>
        </div>
        <div className="stat b">
          <div className="stat-label">Pendientes</div>
          <div className="stat-val">{stats.pending}</div>
          <div className="stat-sub cb">${stats.pending_amount.toFixed(2)} en juego</div>
        </div>
      </div>

      <div className="card">
        <div className="card-hdr">Historial completo</div>

        {loading ? (
          <div className="empty">Cargando…</div>
        ) : bets.length === 0 ? (
          <div className="empty">No has realizado ninguna apuesta aún</div>
        ) : (
          <>
            <div className="tw">
              <table>
                <thead>
                  <tr>
                    <th>#</th><th>Partido</th><th>Opción</th><th>Cuota</th>
                    <th>Monto</th><th>Ganancia pot.</th><th>Estado</th><th>Fecha</th>
                  </tr>
                </thead>
                <tbody>
                  {bets.map(bet => (
                    <tr key={bet.id}>
                      <td className="cm">{bet.id}</td>
                      <td>
                        <div style={{ fontSize: 13, fontWeight: 500 }}>
                          {bet.match?.teamHome?.name ?? '?'} <span className="vs">vs</span> {bet.match?.teamAway?.name ?? '?'}
                        </div>
                        <div className="cm">{bet.match?.sport?.name} · {bet.match?.match_date?.slice(0, 10)}</div>
                      </td>
                      <td style={{ fontSize: 12, color: 'var(--text2)' }}>{bet.odd?.option_name ?? '-'}</td>
                      <td className="cy">x{Number(bet.odd?.odd_value ?? 0).toFixed(2) ?? '-'}</td>
                      <td className="cr">-${Number(bet.amount).toFixed(2)}</td>
                      <td className="cg">+${Number(bet.potential_win).toFixed(2)}</td>
                      <td><span className={`bx ${bet.status}`}>{bet.status}</span></td>
                      <td className="cm">{bet.created_at?.slice(0, 16).replace('T', ' ')}</td>
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
