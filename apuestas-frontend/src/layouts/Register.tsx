// src/layouts/Register.tsx
import { useState } from 'react';
import './Register.css'; // Importaremos los estilos específicos de registro

export default function Register() {
    // Simulación de los errores de Laravel ($errors->any())
    const [hasErrors, setHasErrors] = useState(false);
    const [errors, setErrors] = useState({
        name: '',
        username: '',
        email: '',
        password: ''
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        // Aquí conectaremos con el endpoint de registro de Laravel (/api/register)
        console.log("Intentando registrar nuevo usuario...");
    };

    return (
        <div className="register-wrapper">
            <div className="card">
                <div className="logo">
                    <div className="logo-icon">B</div>
                    <div className="logo-title">Bet<span>Arena</span></div>
                </div>

                {hasErrors && (
                    <div className="alert-error">
                        <div>Por favor, revisa los errores en el formulario.</div>
                    </div>
                )}

                <form onSubmit={handleSubmit}>
                    <div className="form-group">
                        <label>Nombre completo</label>
                        <input 
                            type="text" 
                            name="name" 
                            className={errors.name ? 'error' : ''}
                            placeholder="Tu nombre" 
                            required 
                            autoFocus
                        />
                        {errors.name && <div className="field-error">{errors.name}</div>}
                    </div>

                    <div className="form-group">
                        <label>Username</label>
                        <input 
                            type="text" 
                            name="username" 
                            className={errors.username ? 'error' : ''}
                            placeholder="usuario123" 
                            required 
                        />
                        {errors.username && <div className="field-error">{errors.username}</div>}
                    </div>

                    <div className="form-group">
                        <label>Correo electrónico</label>
                        <input 
                            type="email" 
                            name="email" 
                            className={errors.email ? 'error' : ''}
                            placeholder="correo@ejemplo.com" 
                            required 
                        />
                        {errors.email && <div className="field-error">{errors.email}</div>}
                    </div>

                    <div className="form-group">
                        <label>Contraseña</label>
                        <input 
                            type="password" 
                            name="password"
                            className={errors.password ? 'error' : ''}
                            placeholder="Mínimo 8 caracteres" 
                            required 
                        />
                        {errors.password && <div className="field-error">{errors.password}</div>}
                    </div>

                    <div className="form-group">
                        <label>Confirmar contraseña</label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            placeholder="Repite la contraseña" 
                            required 
                        />
                    </div>

                    <button type="submit" className="btn">CREAR CUENTA →</button>
                </form>

                <div className="login-link">
                    ¿Ya tienes cuenta? <a href="/login">Inicia sesión</a>
                </div>
            </div>
        </div>
    );
}