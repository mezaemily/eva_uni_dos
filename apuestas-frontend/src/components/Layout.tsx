// src/components/Layout.tsx
import { ReactNode } from 'react';
import { Link, useLocation, useNavigate } from 'react-router-dom';
import { useAuth } from '../lib/auth';

const NAV = [
  { label: 'Inicio',       to: '/' },
  { label: 'Partidos',     to: '/partidos' },
  { label: 'Minas',        to: '/minas' },
  { label: 'Desafíos',     to: '/desafios' },
  { label: 'Mis Apuestas', to: '/mis-apuestas' },
  { label: 'Perfil',       to: '/perfil' },
];

export default function Layout({ children }: { children: ReactNode }) {
  const { user, logout } = useAuth();
  const { pathname }     = useLocation();
  const navigate         = useNavigate();

  async function handleLogout() {
    await logout();
    navigate('/login');
  }

  return (
    <div style={{ minHeight: '100vh', background: 'var(--bg)' }}>
      {/* ── Topbar ── */}
      <header style={{
        height: 64,
        background: 'var(--bg2)',
        borderBottom: '1px solid var(--border)',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'space-between',
        padding: '0 28px',
        position: 'sticky',
        top: 0,
        zIndex: 200,
      }}>
        {/* Logo + Nav */}
        <div style={{ display: 'flex', alignItems: 'center', gap: 4 }}>
          <Link to="/" style={{
            fontFamily: 'var(--h)',
            fontSize: 26,
            fontWeight: 700,
            letterSpacing: 3,
            textTransform: 'uppercase',
            background: 'linear-gradient(135deg, var(--gold2), var(--gold), var(--gold3))',
            WebkitBackgroundClip: 'text',
            WebkitTextFillColor: 'transparent',
            textDecoration: 'none',
            display: 'flex',
            alignItems: 'center',
            gap: 8,
            marginRight: 24,
          }}>
            <span style={{ fontSize: 14 }}>◆</span> BETARENA
          </Link>

          <nav style={{ display: 'flex', alignItems: 'center', gap: 4 }}>
            {NAV.map(({ label, to }) => {
              const active = to === '/' ? pathname === '/' : pathname.startsWith(to);
              return (
                <Link key={to} to={to} style={{
                  fontFamily: 'var(--h)',
                  fontSize: 14,
                  fontWeight: 600,
                  letterSpacing: 1,
                  textTransform: 'uppercase',
                  color: active ? 'var(--gold)' : 'var(--text2)',
                  textDecoration: 'none',
                  padding: '8px 14px',
                  borderRadius: 'var(--r)',
                  background: active ? 'rgba(240,192,64,.07)' : 'transparent',
                  border: active ? '1px solid rgba(240,192,64,.15)' : '1px solid transparent',
                  transition: 'all .15s',
                }}>
                  {label}
                </Link>
              );
            })}
          </nav>
        </div>

        {/* Right side */}
        <div style={{ display: 'flex', alignItems: 'center', gap: 12 }}>
          {/* Balance */}
          <div style={{
            display: 'flex', alignItems: 'center', gap: 8,
            background: 'linear-gradient(135deg, rgba(240,192,64,.1), rgba(240,192,64,.05))',
            border: '1px solid rgba(240,192,64,.2)',
            borderRadius: 30,
            padding: '7px 16px 7px 10px',
          }}>
            <div style={{
              width: 22, height: 22,
              background: 'linear-gradient(135deg, var(--gold2), var(--gold))',
              borderRadius: '50%',
              display: 'flex', alignItems: 'center', justifyContent: 'center',
              fontSize: 11, color: '#000', fontWeight: 700,
            }}>$</div>
            <span style={{
              fontFamily: 'var(--h)', fontWeight: 700, fontSize: 15,
              color: 'var(--gold)', letterSpacing: .5,
            }}>
              ${Number(user?.balance ?? 0).toFixed(2)}
            </span>
          </div>

          {/* User chip */}
          <div style={{
            display: 'flex', alignItems: 'center', gap: 8,
            background: 'var(--bg3)',
            border: '1px solid var(--border2)',
            borderRadius: 30,
            padding: '5px 14px 5px 6px',
          }}>
            <div style={{
              width: 28, height: 28,
              background: 'linear-gradient(135deg, var(--violet), #6366f1)',
              borderRadius: '50%',
              display: 'flex', alignItems: 'center', justifyContent: 'center',
              fontFamily: 'var(--h)', fontSize: 13, fontWeight: 700, color: '#fff',
            }}>
              {user?.name?.charAt(0).toUpperCase()}
            </div>
            <span style={{ fontSize: 13, fontWeight: 500 }}>{user?.name}</span>
          </div>

          {/* Logout */}
          <button onClick={handleLogout} style={{
            background: 'none',
            border: '1px solid var(--muted)',
            color: 'var(--muted2)',
            borderRadius: 'var(--r)',
            padding: '6px 12px',
            fontSize: 12,
            fontFamily: 'var(--b)',
            cursor: 'pointer',
            transition: 'all .15s',
          }}
            onMouseEnter={e => {
              (e.currentTarget as HTMLButtonElement).style.borderColor = 'var(--red)';
              (e.currentTarget as HTMLButtonElement).style.color = 'var(--red)';
            }}
            onMouseLeave={e => {
              (e.currentTarget as HTMLButtonElement).style.borderColor = 'var(--muted)';
              (e.currentTarget as HTMLButtonElement).style.color = 'var(--muted2)';
            }}
          >
            Salir
          </button>
        </div>
      </header>

      {/* ── Page content ── */}
      <main className="wrap">{children}</main>
    </div>
  );
}
