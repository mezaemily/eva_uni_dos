// src/App.tsx
import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';
import { AuthProvider, useAuth } from './lib/auth';
import Layout   from './components/Layout';
import Login    from './pages/Login';
import Register from './pages/Register';
import Home       from './pages/Home';
import Matches    from './pages/Matches';
import Mines      from './pages/Mines';
import Challenges from './pages/Challenges';
import MyBets     from './pages/MyBets';
import Profile    from './pages/Profile';

function Protected({ children }: { children: React.ReactNode }) {
  const { user, loading } = useAuth();
  if (loading) return <div style={{ color: 'var(--text2)', padding: 40, textAlign: 'center' }}>Cargando…</div>;
  if (!user)   return <Navigate to="/login" replace />;
  return <Layout>{children}</Layout>;
}

function Guest({ children }: { children: React.ReactNode }) {
  const { user, loading } = useAuth();
  if (loading) return null;
  if (user)    return <Navigate to="/" replace />;
  return <>{children}</>;
}

export default function App() {
  return (
    <AuthProvider>
      <BrowserRouter>
        <Routes>
          {/* Guest routes */}
          <Route path="/login"    element={<Guest><Login /></Guest>} />
          <Route path="/register" element={<Guest><Register /></Guest>} />

          {/* Protected routes */}
          <Route path="/"            element={<Protected><Home /></Protected>} />
          <Route path="/partidos"    element={<Protected><Matches /></Protected>} />
          <Route path="/minas"       element={<Protected><Mines /></Protected>} />
          <Route path="/desafios"    element={<Protected><Challenges /></Protected>} />
          <Route path="/mis-apuestas" element={<Protected><MyBets /></Protected>} />
          <Route path="/perfil"      element={<Protected><Profile /></Protected>} />

          {/* Catch-all */}
          <Route path="*" element={<Navigate to="/" replace />} />
        </Routes>
      </BrowserRouter>
    </AuthProvider>
  );
}
