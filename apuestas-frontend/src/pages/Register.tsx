// src/pages/Register.tsx
import { useState, FormEvent } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { authApi } from '../lib/api';

export default function Register() {
  const navigate = useNavigate();
  const [form, setForm] = useState({ name: '', username: '', email: '', password: '', password_confirmation: '' });
  const [error,   setError]   = useState('');
  const [loading, setLoading] = useState(false);

  const set = (k: keyof typeof form) => (e: React.ChangeEvent<HTMLInputElement>) =>
    setForm(f => ({ ...f, [k]: e.target.value }));

  async function handleSubmit(e: FormEvent) {
    e.preventDefault();
    setError('');
    if (form.password !== form.password_confirmation) { setError('Las contraseñas no coinciden'); return; }
    setLoading(true);
    try {
      const res = await authApi.register(form);
      localStorage.setItem('token', res.token);
      navigate('/');
    } catch (err: unknown) {
      setError((err as Error).message ?? 'Error al registrar');
    } finally {
      setLoading(false);
    }
  }

  const inp = (placeholder: string, type: string, k: keyof typeof form) => (
    <div style={{ marginBottom: 16 }}>
      <label style={{ display: 'block', fontSize: 11, color: '#4a6080', textTransform: 'uppercase', letterSpacing: 1.5, marginBottom: 7 }}>
        {placeholder}
      </label>
      <input
        type={type}
        value={form[k]}
        onChange={set(k)}
        placeholder={placeholder}
        required
        style={{ width: '100%', background: '#080c12', border: '1px solid #1a2d45', color: '#e2eaf4', borderRadius: 8, padding: '10px 14px', fontFamily: "'DM Mono', monospace", fontSize: 13, outline: 'none' }}
      />
    </div>
  );

  return (
    <div style={{ minHeight: '100vh', background: '#080c12', display: 'flex', alignItems: 'center', justifyContent: 'center', padding: 20, fontFamily: "'DM Mono', monospace" }}>
      <div style={{ background: '#0d1520', border: '1px solid #1a2d45', borderRadius: 16, padding: 40, width: '100%', maxWidth: 440, position: 'relative' }}>
        <div style={{ position: 'absolute', top: 0, left: 0, right: 0, height: 2, background: '#00e5ff', borderRadius: '16px 16px 0 0' }} />

        <div style={{ textAlign: 'center', marginBottom: 28 }}>
          <div style={{ width: 48, height: 48, background: '#00e5ff', borderRadius: 10, display: 'inline-flex', alignItems: 'center', justifyContent: 'center', fontFamily: "'Syne', sans-serif", fontWeight: 800, fontSize: 22, color: '#080c12', boxShadow: '0 0 30px rgba(0,229,255,0.3)', marginBottom: 10 }}>B</div>
          <div style={{ fontFamily: "'Syne', sans-serif", fontWeight: 800, fontSize: 20, color: '#e2eaf4' }}>
            Bet<span style={{ color: '#00e5ff' }}>Arena</span>
          </div>
        </div>

        {error && (
          <div style={{ background: 'rgba(255,61,113,0.1)', border: '1px solid #ff3d71', color: '#ff3d71', borderRadius: 8, padding: '12px 14px', fontSize: 12, marginBottom: 18 }}>{error}</div>
        )}

        <form onSubmit={handleSubmit}>
          {inp('Nombre completo', 'text',     'name')}
          {inp('Username',        'text',     'username')}
          {inp('Correo electrónico', 'email', 'email')}
          {inp('Contraseña',      'password', 'password')}
          {inp('Confirmar contraseña', 'password', 'password_confirmation')}

          <button type="submit" disabled={loading} style={{ width: '100%', background: '#00e5ff', color: '#080c12', border: 'none', borderRadius: 8, padding: 12, fontFamily: "'Syne', sans-serif", fontWeight: 700, fontSize: 14, cursor: loading ? 'not-allowed' : 'pointer', letterSpacing: 1, marginTop: 8, opacity: loading ? .7 : 1 }}>
            {loading ? 'REGISTRANDO…' : 'CREAR CUENTA →'}
          </button>
        </form>

        <div style={{ textAlign: 'center', marginTop: 18, fontSize: 12, color: '#4a6080' }}>
          ¿Ya tienes cuenta?{' '}
          <Link to="/login" style={{ color: '#00e5ff', textDecoration: 'none' }}>Inicia sesión</Link>
        </div>
      </div>
    </div>
  );
}
