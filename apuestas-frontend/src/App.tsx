import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';

// Importaciones (Asegúrate de que las carpetas coincidan)
import Layout from './layouts/Layout';
import Dashboard from './Dashboard'; 
import Login from './layouts/Login';
import Register from './layouts/Register';
import CasinoHome from './layouts/home'; // <-- Asume que creaste la carpeta "views"

function App() {
  return (
    <Router>
      <Routes>
        
        {/* Ruta 1: El Inicio público (con menú dorado y footer) */}
        <Route path="/" element={
          <Layout>
            <Dashboard />
          </Layout>
        } />

        {/* Ruta 2 y 3: Login y Registro (pantallas limpias neón) */}
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />
        
        {/* Ruta 4: El panel privado del casino ya logueado */}
        <Route path="/casino/home" element={<CasinoHome />} />

      </Routes>
    </Router>
  );
}

export default App;