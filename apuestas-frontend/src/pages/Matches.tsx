// src/pages/Matches.tsx
import { useState, useEffect } from 'react';
import { matchesApi, sportsApi, GameMatch, Sport } from '../lib/api';
import Pagination from '../components/Pagination';

function OddBox({ name, value }: { name: string; value: number }) {
  const [h, setH] = useState(false);
  return (
    <div
      onMouseEnter={() => setH(true)}
      onMouseLeave={() => setH(false)}
      style={{
        flex: 1, minWidth: 60,
        background: h ? 'rgba(240,192,64,.07)' : 'var(--bg3)',
        border: `1px solid ${h ? 'var(--gold)' : 'var(--border2)'}`,
        borderRadius: 8, padding: '8px 6px', textAlign: 'center',
        cursor: 'pointer', transition: 'all .15s',
      }}
    >
      <div style={{ fontSize: 10, color: 'var(--text2)', marginBottom: 4, lineHeight: 1.2 }}>
        {name.length > 12 ? name.slice(0, 12) + '…' : name}
      </div>
      <div style={{ fontFamily: 'var(--h)', fontSize: 20, fontWeight: 700, color: 'var(--gold)' }}>
        x{Number(value).toFixed(2)}
      </div>
    </div>
  );
}

function MatchCard({ match }: { match: GameMatch }) {
  const [h, setH] = useState(false);
  return (
    <div
      onMouseEnter={() => setH(true)}
      onMouseLeave={() => setH(false)}
      className="card"
      style={{
        display: 'flex', flexDirection: 'column', gap: 14,
        transition: 'border-color .2s',
        borderColor: h ? 'rgba(240,192,64,.25)' : 'var(--border)',
      }}
    >
      {/* Sport + status */}
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
        <span style={{ fontSize: 11, color: 'var(--text2)', textTransform: 'uppercase', letterSpacing: 1, fontFamily: 'var(--h)' }}>
          {match.sport?.name}
        </span>
        <span className={`bx ${match.status}`}>{match.status}</span>
      </div>

      {/* Teams */}
      <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', textAlign: 'center', gap: 8 }}>
        <div style={{ flex: 1 }}>
          <div style={{ fontFamily: 'var(--h)', fontSize: 18, fontWeight: 700, letterSpacing: .5, lineHeight: 1.1 }}>
            {match.teamHome?.name}
          </div>
          <div style={{ fontSize: 10, color: 'var(--muted2)', textTransform: 'uppercase', letterSpacing: 1, marginTop: 4 }}>Local</div>
        </div>

        <div style={{ padding: '0 10px' }}>
          {match.status === 'finished' ? (
            <>
              <div style={{ fontFamily: 'var(--h)', fontSize: 30, fontWeight: 700, color: 'var(--gold)', letterSpacing: 3, textShadow: '0 0 20px rgba(240,192,64,.3)' }}>
                {match.home_score}—{match.away_score}
              </div>
              <div style={{ fontSize: 10, color: 'var(--muted2)', textAlign: 'center' }}>FINAL</div>
            </>
          ) : (
            <>
              <div className="vs" style={{ fontSize: 14, padding: '5px 10px' }}>VS</div>
              <div style={{ fontSize: 11, color: 'var(--text2)', marginTop: 6, textAlign: 'center' }}>
                {match.match_date}
              </div>
            </>
          )}
        </div>

        <div style={{ flex: 1 }}>
          <div style={{ fontFamily: 'var(--h)', fontSize: 18, fontWeight: 700, letterSpacing: .5, lineHeight: 1.1 }}>
            {match.teamAway?.name}
          </div>
          <div style={{ fontSize: 10, color: 'var(--muted2)', textTransform: 'uppercase', letterSpacing: 1, marginTop: 4 }}>Visitante</div>
        </div>
      </div>

      {/* Odds */}
      {match.odds?.length > 0 && match.status === 'scheduled' && (
        <div>
          <div style={{ fontSize: 11, color: 'var(--muted2)', textTransform: 'uppercase', letterSpacing: 1, marginBottom: 8, fontFamily: 'var(--h)' }}>Cuotas</div>
          <div style={{ display: 'flex', gap: 6, flexWrap: 'wrap' }}>
            {match.odds.slice(0, 3).map(odd => (
              <OddBox key={odd.id} name={odd.option_name} value={odd.odd_value} />
            ))}
          </div>
        </div>
      )}

      {/* Comments */}
      <div style={{ fontSize: 11, color: 'var(--muted2)', paddingTop: 6, borderTop: '1px solid var(--border)' }}>
        💬 {match.comments_count ?? 0} comentario(s)
      </div>
    </div>
  );
}

export default function Matches() {
  const [matches, setMatches]   = useState<GameMatch[]>([]);
  const [sports,  setSports]    = useState<Sport[]>([]);
  const [sport,   setSport]     = useState<number | ''>('');
  const [page,    setPage]      = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const [loading, setLoading]   = useState(true);

  useEffect(() => {
    sportsApi.list().then(setSports).catch(() => {});
  }, []);

  useEffect(() => {
    setLoading(true);
    matchesApi.list(sport || undefined, page)
      .then(res => { setMatches(res.data); setLastPage(res.last_page); })
      .catch(() => {})
      .finally(() => setLoading(false));
  }, [sport, page]);

  function handleSportChange(val: string) {
    setSport(val === '' ? '' : Number(val));
    setPage(1);
  }

  return (
    <>
      {/* Header */}
      <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: 22, flexWrap: 'wrap', gap: 12 }}>
        <div>
          <div style={{ fontFamily: 'var(--h)', fontSize: 24, fontWeight: 700, letterSpacing: 1 }}>
            Partidos disponibles
          </div>
          <div style={{ fontSize: 13, color: 'var(--text2)', marginTop: 4 }}>
            Elige un partido y selecciona tu apuesta
          </div>
        </div>

        <div style={{ display: 'flex', gap: 8, alignItems: 'center', flexWrap: 'wrap' }}>
          <select value={sport} onChange={e => handleSportChange(e.target.value)} style={{ width: 'auto', minWidth: 160 }}>
            <option value="">Todos los deportes</option>
            {sports.map(s => <option key={s.id} value={s.id}>{s.name}</option>)}
          </select>
          {sport !== '' && (
            <button className="btn-ghost" onClick={() => handleSportChange('')}>Limpiar</button>
          )}
        </div>
      </div>

      {/* Grid */}
      {loading ? (
        <div className="empty">Cargando partidos…</div>
      ) : matches.length === 0 ? (
        <div className="card"><div className="empty">No hay partidos disponibles ahora mismo.</div></div>
      ) : (
        <>
          <div className="g3">
            {matches.map(m => <MatchCard key={m.id} match={m} />)}
          </div>
          <div style={{ marginTop: 22, display: 'flex', justifyContent: 'flex-end' }}>
            <Pagination current={page} last={lastPage} onChange={setPage} />
          </div>
        </>
      )}
    </>
  );
}
