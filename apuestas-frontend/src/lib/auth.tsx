import { createContext, useContext, useState, useEffect, ReactNode } from 'react';
import { authApi } from './api';
import type { User } from './api'; // Importación específica de tipo

interface AuthCtx {
  user: User | null;
  loading: boolean;
  login:  (email: string, password: string) => Promise<void>;
  logout: () => Promise<void>;
}

const Ctx = createContext<AuthCtx>(null!);

export function AuthProvider({ children }: { children: ReactNode }) {
  const [user, setUser] = useState<User | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const token = localStorage.getItem('token');
    if (!token) { 
        setLoading(false); 
        return; 
    }
    
    authApi.me()
      .then((data) => setUser(data))
      .catch(() => localStorage.removeItem('token'))
      .finally(() => setLoading(false));
  }, []);

async function login(email: string, password: string) {
    const res = await authApi.login(email, password);
    localStorage.setItem('token', res.token);
    setUser(res.user); // <--- ESTO ES LO QUE HACE QUE LA APP SEPA QUE YA ESTÁS LOGUEADO
}

  async function logout() {
    await authApi.logout().catch(() => {});
    localStorage.removeItem('token');
    setUser(null);
  }

  return <Ctx.Provider value={{ user, loading, login, logout }}>{children}</Ctx.Provider>;
}

export const useAuth = () => useContext(Ctx);