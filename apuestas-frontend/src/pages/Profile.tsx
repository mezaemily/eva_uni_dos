// src/pages/Profile.tsx
import { useState, useEffect } from 'react';
import { useAuth } from '../lib/auth';
import { transaccionesApi, apuestasApi, Transaction } from '../lib/api';
import Pagination from '../components/Pagination';

export default function Profile() {
  const { user } = useAuth();
  const [transactions, setTransactions] = useState<Transaction[]>([]);
  const [page,         setPage]         = useState(1);
  const [lastPage,     setLastPage]     = useState(1);
  const [loading,      setLoading]      = useState(true);
  const [stats, setStats] = useState({ totalBets: 0, wonBets: 0, mineGames: 0, followers: 0 });

  useEffect(() => {
    transaccionesApi.list(page)
      .then(res => { setTransactions(res.data); setLastPage(res.last_page); })
      .catch(() => {})
      .finally(() => setLoading(false));

    apuestasApi.list(1).then(res => {
      setStats(s => ({
        ...s,
        totalBets: res.total,
        wonBets:   res.data.filter(b => b.status === 'won').length,
      }));
    }).catch(() => {});
  }, [page]);

  const isIncome = (type: string) => ['deposit', 'bet_win'].includes(type);

  return (
    <>
      <div style={{ fontFamily: 'var(--h)', fontSize: 24, fontWeight: 700, letterSpacing: 1, marginBottom: 24 }}>
        👤 Mi Perfil
      </div>

      <div className="g2">
        {/* Left column */}
        <div style={{ display: 'flex', flexDirection: 'column', gap: 14 }}>

          {/* User card */}
          <div className="card" style={{ display: 'flex', alignItems: 'center', gap: 18 }}>
            <div style={{
              width: 64, height: 64, flexShrink: 0,
              background: 'linear-gradient(135deg, var(--gold2), var(--gold))',
              borderRadius: '50%',
              display: 'flex', alignItems: 'center', justifyContent: 'center',
              fontFamily: 'var(--h)', fontSize: 30, fontWeight: 700, color: '#000',
              boxShadow: '0 0 24px rgba(240,192,64,.25)',
            }}>
              {user?.name?.charAt(0).toUpperCase()}
            </div>
            <div>
              <div style={{ fontFamily: 'var(--h)', fontSize: 22, fontWeight: 700, letterSpacing: .5 }}>{user?.name}</div>
              <div style={{ fontSize: 13, color: 'var(--text2)' }}>@{user?.username}</div>
              <div style={{ fontSize: 12, color: 'var(--muted2)', marginTop: 4 }}>{user?.email}</div>
              <div style={{ marginTop: 8 }}>
                <span className={`bx ${user?.role}`}>{user?.role}</span>
              </div>
            </div>
          </div>

          {/* Balance + member since */}
          <div className="g2" style={{ gap: 10 }}>
            <div className="stat y">
              <div className="stat-label">Saldo</div>
              <div className="stat-val">${Number(user?.balance ?? 0).toFixed(2)}</div>
            </div>
            <div className="stat g">
              <div className="stat-label">Miembro desde</div>
              <div style={{ fontFamily: 'var(--h)', fontSize: 18, fontWeight: 700, color: 'var(--green)' }}>
                {user?.created_at?.slice(0, 7) ?? '-'}
              </div>
            </div>
          </div>

          {/* Stats */}
          <div className="card">
            <div className="card-hdr">Estadísticas</div>
            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(2,1fr)', gap: 12 }}>
              {[
                { label: 'Apuestas totales', val: stats.totalBets, color: 'var(--text)' },
                { label: 'Apuestas ganadas', val: stats.wonBets,   color: 'var(--green)' },
                { label: 'Partidas minas',   val: stats.mineGames, color: 'var(--violet)' },
                { label: 'Seguidores',       val: stats.followers, color: 'var(--blue)' },
              ].map(({ label, val, color }) => (
                <div key={label} style={{ background: 'var(--bg3)', border: '1px solid var(--border2)', borderRadius: 8, padding: 12 }}>
                  <div style={{ fontSize: 11, color: 'var(--text2)' }}>{label}</div>
                  <div style={{ fontFamily: 'var(--h)', fontSize: 22, fontWeight: 700, color }}>{val}</div>
                </div>
              ))}
            </div>
          </div>
        </div>

        {/* Right column — transactions */}
        <div className="card">
          <div className="card-hdr">Últimas Transacciones</div>
          {loading ? (
            <div className="empty">Cargando…</div>
          ) : transactions.length === 0 ? (
            <div className="empty">Sin movimientos</div>
          ) : (
            <>
              <div className="tw">
                <table>
                  <thead>
                    <tr><th>Tipo</th><th>Monto</th><th>Descripción</th><th>Fecha</th></tr>
                  </thead>
                  <tbody>
                    {transactions.map(tx => (
                      <tr key={tx.id}>
                        <td><span className={`bx ${tx.type}`}>{tx.type.replace('_', ' ')}</span></td>
                        <td className={isIncome(tx.type) ? 'cg' : 'cr'}>
                          {isIncome(tx.type) ? '+' : '-'}${Number(tx.amount).toFixed(2)}
                        </td>
                        <td className="cm">{tx.description ?? '-'}</td>
                        <td className="cm">{tx.created_at?.slice(0, 16).replace('T', ' ')}</td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
              <Pagination current={page} last={lastPage} onChange={setPage} />
            </>
          )}
        </div>
      </div>
    </>
  );
}
