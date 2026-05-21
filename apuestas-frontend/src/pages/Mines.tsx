// src/pages/Mines.tsx
// Juego de Minas — replica de front/mines.blade.php + MineGameController.php
// API endpoints usados:
//   POST   /api/minas/start       { amount, mines_count }
//   POST   /api/minas/reveal      { game_id, tile_index }
//   POST   /api/minas/cashout     { game_id }
//   GET    /api/minas/active      → MineGame | null
//   GET    /api/minas/history     → MineGame[]

import { useState, useEffect } from 'react';

// ── Tipos ──────────────────────────────────────────────────────────────────────
interface MineGame {
  id: number;
  bet_amount: number;
  mines_count: number;
  status: 'playing' | 'won' | 'lost';
  multiplier: number;
  winnings: number;
  tiles: Tile[];
}

interface Tile {
  index: number;
  revealed: boolean;
  is_mine: boolean;
}

const BASE = import.meta.env.VITE_API_URL ?? 'http://127.0.0.1:8000/api';
function token() { return localStorage.getItem('token') ?? ''; }
async function api<T>(method: string, path: string, body?: unknown): Promise<T> {
  const res = await fetch(`${BASE}${path}`, {
    method,
    headers: { 'Content-Type': 'application/json', Authorization: `Bearer ${token()}` },
    body: body ? JSON.stringify(body) : undefined,
  });
  const d = await res.json();
  if (!res.ok) throw new Error(d.error ?? d.message ?? 'Error');
  return d;
}

// ── Multiplicador inicial según número de minas ────────────────────────────────
function calcInitMult(mines: number): number {
  const safe = 25 - mines;
  return safe > 0 ? parseFloat(((25 / safe) * 0.97).toFixed(2)) : 0;
}

// ── Componente principal ───────────────────────────────────────────────────────
export default function Mines() {
  const [betAmount,  setBetAmount]  = useState(100);
  const [minesCount, setMinesCount] = useState(3);
  const [game,       setGame]       = useState<MineGame | null>(null);
  const [loading,    setLoading]    = useState(false);
  const [msg,        setMsg]        = useState('');
  const [history,    setHistory]    = useState<MineGame[]>([]);

  const initMult = calcInitMult(minesCount);

  // Cargar partida activa e historial al montar
  useEffect(() => {
    api<{ game: MineGame | null }>('GET', '/minas/active')
      .then(r => { if (r.game) setGame(r.game); })
      .catch(() => {});
    api<{ data: MineGame[] }>('GET', '/minas/history')
      .then(r => setHistory(r.data ?? []))
      .catch(() => {});
  }, []);

  async function startGame() {
    setLoading(true); setMsg('');
    try {
      const r = await api<{ game: MineGame }>('POST', '/minas/start', { amount: betAmount, mines_count: minesCount });
      setGame(r.game);
    } catch (e: unknown) { setMsg((e as Error).message); }
    finally { setLoading(false); }
  }

  async function revealTile(index: number) {
    if (!game || loading) return;
    setLoading(true);
    try {
      const r = await api<{ game: MineGame; hit_mine: boolean }>('POST', '/minas/reveal', { game_id: game.id, tile_index: index });
      setGame(r.game);
      if (r.hit_mine) setMsg('💥 ¡Pisaste una mina!');
    } catch (e: unknown) { setMsg((e as Error).message); }
    finally { setLoading(false); }
  }

  async function cashout() {
    if (!game || loading) return;
    setLoading(true);
    try {
      const r = await api<{ game: MineGame; winnings: number }>('POST', '/minas/cashout', { game_id: game.id });
      setGame(r.game);
      setMsg(`💰 ¡Cobraste $${Number(r.winnings).toFixed(2)}!`);
      refreshHistory();
    } catch (e: unknown) { setMsg((e as Error).message); }
    finally { setLoading(false); }
  }

  function refreshHistory() {
    api<{ data: MineGame[] }>('GET', '/minas/history')
      .then(r => setHistory(r.data ?? []))
      .catch(() => {});
  }

  const isPlaying = game?.status === 'playing';
  const potentialWin = game ? (betAmount * (game.multiplier || 1)).toFixed(2) : '0.00';

  return (
    <div style={{ display: 'grid', gridTemplateColumns: '360px 1fr', gap: 24, alignItems: 'start' }}>

      {/* ── Panel izquierdo ── */}
      <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>
        <div className="card">
          <div className="card-hdr">💣 Mines</div>

          {!isPlaying ? (
            /* Setup form */
            <>
              <div style={{ marginBottom: 14 }}>
                <label>Monto a apostar</label>
                <div style={{ position: 'relative', marginBottom: 8 }}>
                  <span style={{ position: 'absolute', left: 10, top: '50%', transform: 'translateY(-50%)', color: 'var(--gold)', fontWeight: 700 }}>$</span>
                  <input type="number" value={betAmount} min={1} step={1}
                    onChange={e => setBetAmount(Number(e.target.value))}
                    style={{ paddingLeft: 24 }} />
                </div>
                <div style={{ display: 'flex', gap: 6 }}>
                  {[50, 100, 250, 500].map(a => (
                    <button key={a} onClick={() => setBetAmount(a)} style={{
                      flex: 1, background: 'var(--bg3)', border: '1px solid var(--border2)',
                      color: 'var(--text2)', padding: '5px 0', borderRadius: 6,
                      fontSize: 11, cursor: 'pointer',
                    }}>${a}</button>
                  ))}
                </div>
              </div>

              <div style={{ marginBottom: 20 }}>
                <label>Número de minas</label>
                <select value={minesCount} onChange={e => setMinesCount(Number(e.target.value))}>
                  {Array.from({ length: 24 }, (_, i) => i + 1).map(i => (
                    <option key={i} value={i}>{i} {i === 1 ? 'mina' : 'minas'}</option>
                  ))}
                </select>
                <div style={{ marginTop: 8, fontSize: 11, color: 'var(--muted2)' }}>
                  Multiplicador inicial: <span style={{ color: 'var(--gold)', fontWeight: 600 }}>x{initMult}</span>
                </div>
              </div>

              <button onClick={startGame} disabled={loading} style={{
                width: '100%', background: 'linear-gradient(135deg,var(--gold2),var(--gold))',
                color: '#000', border: 'none', padding: 13, borderRadius: 8,
                fontFamily: 'var(--h)', fontSize: 16, fontWeight: 700, letterSpacing: 1,
                cursor: loading ? 'not-allowed' : 'pointer', opacity: loading ? .7 : 1,
              }}>JUGAR</button>
            </>
          ) : (
            /* Active panel */
            <>
              <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 10, marginBottom: 16 }}>
                <InfoBox label="Apuesta" value={`$${game!.bet_amount}`} color="var(--red)" />
                <InfoBox label="Minas"   value={`💣 ${game!.mines_count}`} color="var(--red)" />
              </div>

              <div style={{ background: 'linear-gradient(135deg,rgba(240,192,64,.08),rgba(240,192,64,.03))', border: '1px solid rgba(240,192,64,.2)', borderRadius: 10, padding: 16, textAlign: 'center', marginBottom: 16 }}>
                <div style={{ fontSize: 11, color: 'var(--text2)', marginBottom: 4, textTransform: 'uppercase', letterSpacing: 1 }}>Multiplicador</div>
                <div style={{ fontFamily: 'var(--h)', fontSize: 36, fontWeight: 700, color: 'var(--gold)', letterSpacing: 1 }}>
                  x{Number(game!.multiplier ?? 1).toFixed(2) ?? '1.00'}
                </div>
                <div style={{ fontSize: 12, color: 'var(--text2)', marginTop: 4 }}>
                  Ganancia potencial: <span style={{ color: 'var(--green)', fontWeight: 600 }}>${potentialWin}</span>
                </div>
              </div>

              <button onClick={cashout} disabled={loading} style={{
                width: '100%', background: 'linear-gradient(135deg,#16a34a,#22c55e)',
                color: '#000', border: 'none', padding: 13, borderRadius: 8,
                fontFamily: 'var(--h)', fontSize: 16, fontWeight: 700, letterSpacing: 1,
                cursor: loading ? 'not-allowed' : 'pointer', opacity: loading ? .7 : 1,
                marginBottom: 8,
              }}>COBRAR ${potentialWin}</button>
            </>
          )}

          {msg && (
            <div style={{ marginTop: 12, padding: '10px 14px', background: 'rgba(240,192,64,.08)', border: '1px solid rgba(240,192,64,.2)', borderRadius: 8, fontSize: 13, color: 'var(--gold)', textAlign: 'center' }}>
              {msg}
            </div>
          )}
        </div>

        {/* History */}
        {history.length > 0 && (
          <div className="card">
            <div className="card-hdr">Partidas recientes</div>
            <div style={{ display: 'flex', flexDirection: 'column', gap: 6 }}>
              {history.slice(0, 8).map(g => (
                <div key={g.id} style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', padding: '8px 0', borderBottom: '1px solid var(--border)', fontSize: 12 }}>
                  <span className="cm">#{g.id} · 💣{g.mines_count}</span>
                  <span className={`bx ${g.status}`}>{g.status}</span>
                  <span className={g.status === 'won' ? 'cg' : 'cr'}>
                    {g.status === 'won' ? `+$${Number(g.winnings ?? 0).toFixed(2)}` : `-$${g.bet_amount}`}
                  </span>
                </div>
              ))}
            </div>
          </div>
        )}
      </div>

      {/* ── Board ── */}
      <div className="card">
        <div className="card-hdr">Tablero</div>
        {!game ? (
          <div className="empty" style={{ minHeight: 320 }}>Configura y presiona JUGAR para comenzar</div>
        ) : (
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(5, 1fr)', gap: 8 }}>
            {Array.from({ length: 25 }, (_, i) => {
              const tile = game.tiles?.find(t => t.index === i);
              return (
                <Tile
                  key={i}
                  index={i}
                  tile={tile}
                  playing={isPlaying}
                  loading={loading}
                  onClick={() => revealTile(i)}
                />
              );
            })}
          </div>
        )}
      </div>
    </div>
  );
}

function InfoBox({ label, value, color }: { label: string; value: string; color: string }) {
  return (
    <div style={{ background: 'var(--bg3)', border: '1px solid var(--border2)', borderRadius: 8, padding: 12, textAlign: 'center' }}>
      <div style={{ fontSize: 11, color: 'var(--text2)', marginBottom: 4 }}>{label}</div>
      <div style={{ fontFamily: 'var(--h)', fontSize: 20, fontWeight: 700, color }}>{value}</div>
    </div>
  );
}

function Tile({ index, tile, playing, loading, onClick }: {
  index: number;
  tile?: { revealed: boolean; is_mine: boolean };
  playing: boolean;
  loading: boolean;
  onClick: () => void;
}) {
  const revealed = tile?.revealed ?? false;
  const isMine   = tile?.is_mine  ?? false;
  const [h, setH] = useState(false);

  let bg = revealed
    ? (isMine ? 'rgba(231,76,60,.25)' : 'rgba(46,204,113,.15)')
    : h && playing ? 'rgba(240,192,64,.1)' : 'var(--bg3)';

  let border = revealed
    ? (isMine ? '1px solid var(--red)' : '1px solid var(--green)')
    : h && playing ? '1px solid rgba(240,192,64,.4)' : '1px solid var(--border2)';

  return (
    <div
      onMouseEnter={() => setH(true)}
      onMouseLeave={() => setH(false)}
      onClick={() => !revealed && playing && !loading && onClick()}
      style={{
        background: bg,
        border,
        borderRadius: 8,
        height: 68,
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        fontSize: 24,
        cursor: !revealed && playing && !loading ? 'pointer' : 'default',
        transition: 'all .1s',
        userSelect: 'none',
      }}
    >
      {revealed ? (isMine ? '💣' : '💎') : ''}
    </div>
  );
}
