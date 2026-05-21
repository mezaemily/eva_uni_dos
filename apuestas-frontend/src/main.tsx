import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import App from './App.tsx'

// ¡Esta es la línea clave! 
// Aquí le decimos a React que cargue todo el diseño oscuro, las fuentes y el oro.
import './index.css' 

createRoot(document.getElementById('root')!).render(
  <StrictMode>
    <App />
  </StrictMode>,
)