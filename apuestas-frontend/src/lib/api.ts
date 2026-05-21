// src/lib/api.ts
// Conecta con las rutas de Apuestas/routes/api.php

const BASE = import.meta.env.VITE_API_URL ?? 'http://127.0.0.1:8000/api';

function token() {
  return localStorage.getItem('token') ?? '';
}

async function req<T>(method: string, path: string, body?: unknown): Promise<T> {
  const res = await fetch(`${BASE}${path}`, {
    method,
    headers: {
      'Content-Type': 'application/json',
      ...(token() ? { Authorization: `Bearer ${token()}` } : {}),
    },
    body: body ? JSON.stringify(body) : undefined,
  });

  const data = await res.json();
  if (!res.ok) throw new Error(data.error ?? data.message ?? 'Error');
  return data as T;
}

const get  = <T>(path: string)                  => req<T>('GET',    path);
const post = <T>(path: string, body: unknown)   => req<T>('POST',   path, body);
const put  = <T>(path: string, body: unknown)   => req<T>('PUT',    path, body);
const del  = <T>(path: string)                  => req<T>('DELETE', path);

// ── Auth ──────────────────────────────────────────────────────────────────────
export const authApi = {
  login:    (email: string, password: string) =>
    post<{ token: string; user: User }>('/login', { email, password }),
  register: (data: RegisterData) =>
    post<{ token: string; user: User }>('/register', data),
  logout:   () => post<{ message: string }>('/logout', {}),
  me:       () => get<User>('/user'),
  update:   (data: Partial<User>) => put<{ user: User }>('/user', data),
};

// ── Partidos (matches come from FrontController via web routes,
//    but we expose them via a proxy-friendly pattern here)
//    In production: add a GET /api/partidos route in api.php
export const matchesApi = {
  list: (sport?: number, page = 1) =>
    get<PaginatedResponse<GameMatch>>(
      `/partidos?page=${page}${sport ? `&sport=${sport}` : ''}`
    ),
};

// ── Sports
export const sportsApi = {
  list: () => get<Sport[]>('/deportes'),
};

// ── Apuestas ──────────────────────────────────────────────────────────────────
export const apuestasApi = {
  list:    (page = 1)                             => get<PaginatedResponse<Bet>>(`/apuestas?page=${page}`),
  create:  (odd_id: number, amount: number)       => post<Bet>('/apuestas', { odd_id, amount }),
  show:    (id: number)                           => get<Bet>(`/apuestas/${id}`),
  destroy: (id: number)                           => del<{ message: string }>(`/apuestas/${id}`),
};

// ── Transacciones ─────────────────────────────────────────────────────────────
export const transaccionesApi = {
  list:     (page = 1)    => get<PaginatedResponse<Transaction>>(`/transacciones?page=${page}`),
  saldo:    ()            => get<{ balance: number }>('/transacciones/saldo'),
  deposito: (amount: number) => post<Transaction>('/transacciones/deposito', { amount }),
  retiro:   (amount: number) => post<Transaction>('/transacciones/retiro',   { amount }),
};

// ── Desafíos ──────────────────────────────────────────────────────────────────
export const desafiosApi = {
  list:     (page = 1)                => get<PaginatedResponse<Challenge>>(`/desafios?page=${page}`),
  create:   (opponent_id: number)     => post<Challenge>('/desafios', { opponent_id }),
  resolver: (id: number, ganador_id: number) =>
    post<Challenge>(`/desafios/${id}/resolver`, { ganador_id }),
  destroy:  (id: number)              => del<{ message: string }>(`/desafios/${id}`),
};

// ── Types ─────────────────────────────────────────────────────────────────────

export interface User {
  id: number;
  name: string;
  username: string;
  email: string;
  balance: number;
  role: 'admin' | 'user';
  created_at?: string;
}

export interface RegisterData {
  name: string;
  username: string;
  email: string;
  password: string;
  password_confirmation: string;
}

export interface Sport {
  id: number;
  name: string;
}

export interface Team {
  id: number;
  name: string;
}

export interface Odd {
  id: number;
  option_name: string;
  odd_value: number;
}

export interface GameMatch {
  id: number;
  sport: Sport;
  teamHome: Team;
  teamAway: Team;
  status: 'scheduled' | 'live' | 'finished' | 'cancelled';
  match_date?: string;
  home_score?: number;
  away_score?: number;
  odds: Odd[];
  comments_count?: number;
}

export interface Bet {
  id: number;
  amount: number;
  potential_win: number;
  status: 'pending' | 'won' | 'lost' | 'cancelled';
  created_at: string;
  match?: GameMatch;
  odd?: Odd;
}

export interface Transaction {
  id: number;
  type: 'deposit' | 'withdrawal' | 'bet_place' | 'bet_win';
  amount: number;
  description?: string;
  created_at: string;
}

export interface Challenge {
  id: number;
  creator: User;
  opponent: User;
  creator_id: number;
  opponent_id: number;
  status: 'pending' | 'active' | 'completed' | 'cancelled' | 'accepted' | 'rejected';
  created_at: string;
  challengeBets?: { count: number }[];
}

export interface PaginatedResponse<T> {
  data: T[];
  current_page: number;
  last_page: number;
  total: number;
}
