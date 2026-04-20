<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BitCorp API | Documentación Oficial</title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Prism.js for Syntax Highlighting (Dark Theme) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />

    <style>
        :root {
            --primary-color: #6366f1;
            --primary-hover: #4f46e5;
            --sidebar-bg: #ffffff;
            --content-bg: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --code-bg: #1e293b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--content-bg);
            color: var(--text-main);
            overflow-x: hidden;
        }

        /* Lateral Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            width: 280px;
            padding: 0;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .brand-logo {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .nav-links {
            padding: 1.5rem 0;
        }

        .nav-link {
            padding: 0.75rem 1.5rem;
            color: var(--text-muted);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            color: var(--primary-color);
            background-color: #f1f5f9;
        }

        .nav-link.active {
            color: var(--primary-color);
            background-color: #eef2ff;
            border-left-color: var(--primary-color);
        }

        /* Main Content */
        main {
            margin-left: 280px;
            padding: 2rem 3rem;
            min-height: 100vh;
        }

        .doc-section {
            padding-top: 4rem;
            margin-top: -2rem;
            margin-bottom: 4rem;
        }

        .section-title {
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* Badges */
        .badge-method {
            padding: 0.4rem 0.8rem;
            font-weight: 700;
            font-size: 0.75rem;
            border-radius: 6px;
            text-transform: uppercase;
            min-width: 70px;
            text-align: center;
        }

        .badge-get { background-color: #dcfce7; color: #166534; }
        .badge-post { background-color: #dbeafe; color: #1e40af; }
        .badge-put { background-color: #fef9c3; color: #854d0e; }
        .badge-delete { background-color: #fee2e2; color: #991b1b; }

        /* API Cards */
        .api-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .api-header {
            padding: 1.25rem 1.5rem;
            background-color: #fff;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .api-endpoint {
            font-family: 'JetBrains Mono', 'Courier New', monospace;
            font-weight: 600;
            color: var(--text-main);
            font-size: 0.95rem;
        }

        .api-body {
            padding: 1.5rem;
        }

        .code-block-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #2d2d2d;
            padding: 0.5rem 1rem;
            border-radius: 8px 8px 0 0;
            color: #ccc;
            font-size: 0.8rem;
            font-weight: 500;
        }

        pre[class*="language-"] {
            margin-top: 0 !important;
            border-radius: 0 0 8px 8px !important;
            font-size: 0.85rem !important;
        }

        /* Glassmorphism utility */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }
            .sidebar:hover {
                width: 280px;
            }
            main {
                margin-left: 70px;
                padding: 2rem 1.5rem;
            }
            .nav-link span {
                display: none;
            }
            .sidebar:hover .nav-link span {
                display: inline;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <a href="#" class="brand-logo">
                <i class="bi bi-cpu-fill"></i>
                <span>BitCorp API</span>
            </a>
        </div>
        <div class="nav-links">
            <a href="#intro" class="nav-link active">
                <i class="bi bi-house-door"></i>
                <span>Introducción</span>
            </a>
            <div class="px-4 py-2 small text-uppercase text-muted fw-bold" style="font-size: 0.65rem; letter-spacing: 0.05rem;">
                Endpoints de Usuario
            </div>
            <a href="#post-login" class="nav-link">
                <i class="bi bi-shield-lock"></i>
                <span>Autenticación (Login)</span>
            </a>
            <a href="#get-user" class="nav-link">
                <i class="bi bi-person-badge"></i>
                <span>Ver Perfil</span>
            </a>
            <a href="#put-user" class="nav-link">
                <i class="bi bi-pencil-square"></i>
                <span>Actualizar Cuenta</span>
            </a>
            <a href="#delete-user" class="nav-link">
                <i class="bi bi-person-x"></i>
                <span>Eliminar Cuenta</span>
            </a>
            <div class="px-4 py-2 mt-3 small text-uppercase text-muted fw-bold" style="font-size: 0.65rem; letter-spacing: 0.05rem;">
                Guía de Errores
            </div>
            <a href="#errors" class="nav-link">
                <i class="bi bi-exclamation-triangle"></i>
                <span>Formatos de Error</span>
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <div class="container-fluid">
            
            <!-- Intro -->
            <section id="intro" class="doc-section">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="display-6 fw-bold mb-4">Documentación de la API</h1>
                        <p class="lead text-muted">
                            Bienvenido a la documentación técnica de <strong>BitCorp</strong>. Nuestra API está diseñada bajo los estándares RESTful, utilizando JWT para la autenticación y JSON para el intercambio de datos.
                        </p>
                        <div class="alert alert-info border-0 shadow-sm glass">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            Todas las peticiones deben incluir el header <code>Accept: application/json</code>.
                        </div>
                    </div>
                </div>
            </section>

            <hr class="my-5 border-secondary-subtle">

            <!-- POST /login -->
            <section id="post-login" class="doc-section">
                <h2 class="section-title"><i class="bi bi-shield-lock-fill text-primary"></i>Autenticación</h2>
                <div class="api-card">
                    <div class="api-header">
                        <span class="badge-method badge-post">POST</span>
                        <span class="api-endpoint">/api/login</span>
                    </div>
                    <div class="api-body">
                        <p>Inicia sesión en el sistema para obtener un token de acceso (JWT).</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">Request Body</h6>
                                <div class="code-block-header">JSON Payload</div>
                                <pre><code class="language-json">{
    "email": "usuario@bitcorp.com",
    "password": "password123"
}</code></pre>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">Response (200 OK)</h6>
                                <div class="code-block-header">JSON Recovery</div>
                                <pre><code class="language-json">{
    "access_token": "eyJhbGciOiJIUzI1NiIsInR5c...",
    "token_type": "bearer",
    "expires_in": 3600
}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- GET /user -->
            <section id="get-user" class="doc-section">
                <h2 class="section-title"><i class="bi bi-person-badge-fill text-success"></i>Perfil de Usuario</h2>
                <div class="api-card">
                    <div class="api-header">
                        <span class="badge-method badge-get">GET</span>
                        <span class="api-endpoint">/api/user</span>
                    </div>
                    <div class="api-body">
                        <p>Obtiene los detalles del usuario autenticado actualmente.</p>
                        <p class="small text-muted"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
                        
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h6 class="fw-bold mb-3">Response (200 OK)</h6>
                                <div class="code-block-header">JSON Payload</div>
                                <pre><code class="language-json">{
    "id": 1,
    "name": "Admin BitCorp",
    "email": "admin@bitcorp.com",
    "created_at": "2026-04-20T10:45:00.000000Z"
}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- PUT /user -->
            <section id="put-user" class="doc-section">
                <h2 class="section-title"><i class="bi bi-pencil-square text-warning"></i>Actualizar Cuenta</h2>
                <div class="api-card">
                    <div class="api-header">
                        <span class="badge-method badge-put">PUT</span>
                        <span class="api-endpoint">/api/user</span>
                    </div>
                    <div class="api-body">
                        <p>Actualiza la información del perfil del usuario.</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">Request Body</h6>
                                <div class="code-block-header">JSON Payload</div>
                                <pre><code class="language-json">{
    "name": "Nuevo Nombre",
    "email": "nuevo@email.com"
}</code></pre>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">Response (200 OK)</h6>
                                <div class="code-block-header">JSON Payload</div>
                                <pre><code class="language-json">{
    "status": "success",
    "message": "Perfil actualizado correctamente",
    "user": {
        "id": 1,
        "name": "Nuevo Nombre",
        "email": "nuevo@email.com"
    }
}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- DELETE /user -->
            <section id="delete-user" class="doc-section">
                <h2 class="section-title"><i class="bi bi-person-x-fill text-danger"></i>Eliminar Cuenta</h2>
                <div class="api-card">
                    <div class="api-header">
                        <span class="badge-method badge-delete">DELETE</span>
                        <span class="api-endpoint">/api/user</span>
                    </div>
                    <div class="api-body">
                        <p class="text-danger fw-bold">Esta acción es irreversible.</p>
                        <p>Elimina permanentemente la cuenta del usuario autenticado.</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h6 class="fw-bold mb-3">Response (204 No Content)</h6>
                                <div class="border p-3 bg-light rounded text-center text-muted">
                                    <em>La respuesta no contiene cuerpo de mensaje.</em>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Errors -->
            <section id="errors" class="doc-section">
                <h2 class="section-title"><i class="bi bi-exclamation-triangle-fill text-secondary"></i>Formatos de Error</h2>
                <div class="api-card">
                    <div class="api-header">
                        <span class="fw-bold">Estándar BitCorp</span>
                    </div>
                    <div class="api-body">
                        <p>En caso de error en la validación, la API retornará un código <strong>422 Unprocessable Entity</strong> con el siguiente formato:</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="code-block-header">JSON Response</div>
                                <pre><code class="language-json">{
    "error": "Validación fallida",
    "message": "Los datos enviados no son correctos para los estándares de BitCorp.",
    "details": {
        "email": [
            "El correo electrónico ya ha sido registrado."
        ],
        "password": [
            "La contraseña debe tener al menos 8 caracteres."
        ]
    }
}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <footer class="mt-5 py-4 border-top text-center text-muted small">
                &copy; {{ date('Y') }} BitCorp API System. Todos los derechos reservados.
            </footer>

        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-json.min.js"></script>
    
    <script>
        // Active link switching on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.doc-section');
            const navLinks = document.querySelectorAll('.nav-link');

            window.addEventListener('scroll', () => {
                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    if (pageYOffset >= sectionTop - 100) {
                        current = section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href').includes(current)) {
                        link.classList.add('active');
                    }
                });
            });
        });
    </script>
</body>
</html>
