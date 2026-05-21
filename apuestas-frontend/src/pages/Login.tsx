import { useState, FormEvent } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useAuth } from '../lib/auth';

export default function Login() {
  const { login } = useAuth();
  const navigate = useNavigate();

  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  async function handleSubmit(e: FormEvent) {
    e.preventDefault();
    setError('');
    setLoading(true);

    try {
      // Intentamos el login
      await login(email, password);
      
      // Una vez que el login y el contexto de Auth se actualizan, navegamos
      // Forzamos un pequeño retraso o simplemente navegamos directo
      navigate('/'); 
    } catch (err: any) {
      // Capturamos el error específico del backend
      const message = err.response?.data?.message || err.message || 'Credenciales inválidas';
      setError(message);
    } finally {
      setLoading(false);
    }
  }

  return (
    <div style={{
      minHeight: '100vh',
      background: '#080c12',
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      fontFamily: "'DM Mono', monospace",
    }}>
      <div style={{
        background: '#0d1520',
        border: '1px solid #1a2d45',
        borderRadius: 16,
        padding: 40,
        width: '100%',
        maxWidth: 420,
        position: 'relative',
      }}>
        {/* Top accent line */}
        <div style={{ position: 'absolute', top: 0, left: 0, right: 0, height: 2, background: '#00e5ff', borderRadius: '16px 16px 0 0' }} />

        {/* Logo */}
        <div style={{ textAlign: 'center', marginBottom: 32 }}>
          <div style={{
            width: 52, height: 52,
            background: '#00e5ff',
            borderRadius: 12,
            display: 'inline-flex',
            alignItems: 'center',
            justifyContent: 'center',
            fontFamily: "'Syne', sans-serif",
            fontWeight: 800,
            fontSize: 24,
            color: '#080c12',
            boxShadow: '0 0 30px rgba(0,229,255,0.3)',
            marginBottom: 12,
          }}>B</div>
          <div style={{ fontFamily: "'Syne', sans-serif", fontWeight: 800, fontSize: 22, color: '#e2eaf4' }}>
            Bet<span style={{ color: '#00e5ff' }}>Arena</span>
          </div>
          <div style={{ fontSize: 11, color: '#4a6080', marginTop: 4, letterSpacing: 2, textTransform: 'uppercase' }}>
            Panel de acceso
          </div>
        </div>

        {error && (
          <div style={{
            background: 'rgba(255,61,113,0.1)',
            border: '1px solid #ff3d71',
            color: '#ff3d71',
            borderRadius: 8,
            padding: '12px 14px',
            fontSize: 12,
            marginBottom: 20,
          }}>{error}</div>
        )}

        <form onSubmit={handleSubmit}>
          <div style={{ marginBottom: 18 }}>
            <label style={{ display: 'block', fontSize: 11, color: '#4a6080', textTransform: 'uppercase', letterSpacing: 1.5, marginBottom: 8 }}>
              Correo electrónico
            </label>
            <input
              type="email"
              value={email}
              onChange={e => setEmail(e.target.value)}
              placeholder="correo@ejemplo.com"
              required
              style={{ width: '100%', background: '#080c12', border: '1px solid #1a2d45', color: '#e2eaf4', borderRadius: 8, padding: '11px 14px', fontFamily: "'DM Mono', monospace", fontSize: 13, outline: 'none' }}
            />
          </div>

          <div style={{ marginBottom: 22 }}>
            <label style={{ display: 'block', fontSize: 11, color: '#4a6080', textTransform: 'uppercase', letterSpacing: 1.5, marginBottom: 8 }}>
              Contraseña
            </label>
            <input
              type="password"
              value={password}
              onChange={e => setPassword(e.target.value)}
              placeholder="••••••••"
              required
              style={{ width: '100%', background: '#080c12', border: '1px solid #1a2d45', color: '#e2eaf4', borderRadius: 8, padding: '11px 14px', fontFamily: "'DM Mono', monospace", fontSize: 13, outline: 'none' }}
            />
          </div>

          <button type="submit" disabled={loading} style={{
            width: '100%',
            background: '#00e5ff',
            color: '#080c12',
            border: 'none',
            borderRadius: 8,
            padding: 13,
            fontFamily: "'Syne', sans-serif",
            fontWeight: 700,
            fontSize: 14,
            cursor: loading ? 'not-allowed' : 'pointer',
            letterSpacing: 1,
            opacity: loading ? .7 : 1,
          }}>
            {loading ? 'ENTRANDO…' : 'ENTRAR →'}
          </button>
        </form>

        <div style={{ textAlign: 'center', marginTop: 20, fontSize: 12, color: '#4a6080' }}>
          ¿No tienes cuenta?{' '}
          <Link to="/register" style={{ color: '#00e5ff', textDecoration: 'none' }}>Regístrate</Link>
        </div>
      </div>
    </div>
  );
}