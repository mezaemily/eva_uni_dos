// src/components/Navbar.tsx
export default function Navbar() {
  const isAuthenticated = false; // Simulación de @auth de Laravel

  return (
      <nav>
          <a href="/" className="nav-logo">BETARENA</a>
          <ul className="nav-links">
              <li><a href="#juegos">Juegos</a></li>
              <li><a href="#caracteristicas">Características</a></li>
              {isAuthenticated ? (
                  <li><a href="/home" className="btn-nav">Mi cuenta</a></li>
              ) : (
                  <li><a href="/login" className="btn-nav">Iniciar sesión</a></li>
              )}
          </ul>
      </nav>
  );
}