// src/components/Layout.tsx
import type { ReactNode } from 'react';
import Navbar from '../Navbar';

interface LayoutProps {
  children: ReactNode;
}

export default function Layout({ children }: LayoutProps) {
  return (
    <>
      <Navbar />

      {/* Área principal sin restricciones */}
      <main>
        {children}
      </main>

      {/* Tu Footer original con el nombre BETARENA */}
      <footer>
          <div className="footer-logo">BETARENA</div>
          <div className="footer-copy">© 2026 Grupo MERCA24-TD — Todos los derechos reservados</div>
          <ul className="footer-links">
              <li><a href="#">Términos</a></li>
              <li><a href="#">Privacidad</a></li>
              <li><a href="/login">Acceder</a></li>
          </ul>
      </footer>
    </>
  );
}