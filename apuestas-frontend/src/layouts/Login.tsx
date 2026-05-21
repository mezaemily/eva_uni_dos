import { useState } from 'react';
import './Login.css'; // Importaremos los estilos específicos aquí

export default function Login() {
    // Simulación de los errores de Laravel ($errors->any())
    const [hasErrors, setHasErrors] = useState(false);
    const [emailError, setEmailError] = useState('');
    const [passwordError, setPasswordError] = useState('');

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        // Aquí iría tu lógica de conexión con Laravel usando fetch()
        // Por ahora, solo evitamos que la página se recargue
        console.log("Intentando iniciar sesión...");
    };

    return (
        <div className="login-wrapper">
            <div className="card">
                <div className="logo">
                    <div class="logo-icon">B</div>
                    <div class="logo-title">Bet<span>Arena</span></div>
                    <div class="logo-sub">Panel de acceso</div>
                </div>

                {hasErrors && (
                    <div className="alert-error">
                        <div>Las credenciales proporcionadas no son válidas.</div>
                    </div>
                )}

                <form onSubmit={handleSubmit}>
                    <div className="form-group">
                        <label>Correo electrónico</label>
                        <input 
                            type="email" 
                            name="email" 
                            className={emailError ? 'error' : ''}
                            placeholder="correo@ejemplo.com" 
                            required 
                            autoFocus
                        />
                        {emailError && <div className="field-error">{emailError}</div>}
                    </div>

                    <div className="form-group">
                        <label>Contraseña</label>
                        <input 
                            type="password" 
                            name="password"
                            className={passwordError ? 'error' : ''}
                            placeholder="••••••••" 
                            required 
                        />
                        {passwordError && <div className="field-error">{passwordError}</div>}
                    </div>

                    <div className="check-row">
                        <input type="checkbox" name="remember" id="remember" />
                        <label htmlFor="remember" style={{ margin: 0, textTransform: 'none', letterSpacing: 0 }}>
                            Recordar sesión
                        </label>
                    </div>

                    <button type="submit" className="btn">ENTRAR →</button>
                </form>

                <div className="register-link">
                    ¿No tienes cuenta? <a href="/register">Regístrate aquí</a>
                </div>
            </div>
        </div>
    );
}