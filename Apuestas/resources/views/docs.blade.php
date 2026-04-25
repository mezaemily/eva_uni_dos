<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apuestas API | Documentación Oficial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --sidebar-bg: #ffffff;
            --content-bg: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
        }
        body { font-family: 'Syne', sans-serif; background: var(--content-bg); color: var(--text-main); overflow-x: hidden; }
        code, pre, .mono { font-family: 'JetBrains Mono', monospace !important; }

        /* SIDEBAR */
        .sidebar {
            position: fixed; top: 0; bottom: 0; left: 0; z-index: 100;
            width: 280px; background: var(--sidebar-bg);
            border-right: 1px solid var(--border); overflow-y: auto;
        }
        .sidebar-header { padding: 1.5rem; border-bottom: 1px solid var(--border); }
        .brand-logo { font-weight: 800; font-size: 1.15rem; color: var(--primary); display: flex; align-items: center; gap: .5rem; text-decoration: none; }
        .nav-section-label { padding: .5rem 1.5rem; font-size: .65rem; text-transform: uppercase; letter-spacing: .07rem; color: var(--text-muted); font-weight: 700; margin-top: .75rem; }
        .nav-link { padding: .6rem 1.5rem; color: var(--text-muted); font-weight: 500; font-size: .875rem; display: flex; align-items: center; gap: .65rem; border-left: 3px solid transparent; transition: all .2s; }
        .nav-link:hover { color: var(--primary); background: #f1f5f9; }
        .nav-link.active { color: var(--primary); background: #eef2ff; border-left-color: var(--primary); }

        /* MAIN */
        main { margin-left: 280px; padding: 2rem 3rem; min-height: 100vh; }
        .doc-section { padding-top: 4rem; margin-top: -2rem; margin-bottom: 3.5rem; }
        .section-title { font-weight: 800; font-size: 1.35rem; margin-bottom: 1.25rem; display: flex; align-items: center; gap: .75rem; }

        /* BADGES */
        .badge-method { padding: .35rem .75rem; font-weight: 700; font-size: .7rem; border-radius: 6px; text-transform: uppercase; min-width: 68px; text-align: center; font-family: 'JetBrains Mono', monospace; }
        .badge-get    { background: #dcfce7; color: #166534; }
        .badge-post   { background: #dbeafe; color: #1e40af; }
        .badge-put    { background: #fef9c3; color: #854d0e; }
        .badge-delete { background: #fee2e2; color: #991b1b; }

        /* CARDS */
        .api-card { background: #fff; border-radius: 12px; border: 1px solid var(--border); overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,.05); margin-bottom: 1.75rem; }
        .api-header { padding: 1.1rem 1.5rem; background: #fff; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
        .api-endpoint { font-family: 'JetBrains Mono', monospace; font-weight: 600; color: var(--text-main); font-size: .9rem; }
        .api-body { padding: 1.5rem; }
        .api-desc { color: var(--text-muted); margin-bottom: 1rem; font-size: .92rem; }
        .auth-note { font-size: .82rem; color: var(--text-muted); margin-bottom: 1rem; }

        /* NEW: admin badge */
        .badge-admin { display: inline-flex; align-items: center; gap: .3rem; background: #fef3c7; color: #92400e; border: 1px solid #fde68a; border-radius: 6px; padding: .2rem .6rem; font-size: .75rem; font-weight: 700; }

        /* CODE BLOCKS */
        .code-block-header { display: flex; justify-content: space-between; align-items: center; background: #2d2d2d; padding: .45rem 1rem; border-radius: 8px 8px 0 0; color: #ccc; font-size: .75rem; font-weight: 600; font-family: 'JetBrains Mono', monospace; }
        pre[class*="language-"] { margin-top: 0 !important; border-radius: 0 0 8px 8px !important; font-size: .82rem !important; max-height: 340px; overflow-y: auto; }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .sidebar { width: 68px; }
            .sidebar:hover { width: 280px; }
            main { margin-left: 68px; padding: 2rem 1.25rem; }
            .nav-link span, .nav-section-label, .sidebar-header .brand-text { display: none; }
            .sidebar:hover .nav-link span, .sidebar:hover .nav-section-label, .sidebar:hover .sidebar-header .brand-text { display: inline; }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#intro" class="brand-logo">
            <i class="bi bi-controller"></i>
            <span class="brand-text">Apuestas API</span>
        </a>
    </div>

    <div class="nav-section-label">Introducción</div>
    <a href="#intro" class="nav-link active"><i class="bi bi-house-door"></i><span>Inicio</span></a>

    <div class="nav-section-label">Autenticación</div>
    <a href="#post-register" class="nav-link"><i class="bi bi-person-plus"></i><span>Registro</span></a>
    <a href="#post-login"    class="nav-link"><i class="bi bi-shield-lock"></i><span>Login</span></a>
    <a href="#post-logout"   class="nav-link"><i class="bi bi-box-arrow-right"></i><span>Logout</span></a>

    <div class="nav-section-label">Usuario</div>
    <a href="#get-usuarios-sistema" class="nav-link"><i class="bi bi-people"></i><span>Listar Usuarios</span></a>
    <a href="#get-user"    class="nav-link"><i class="bi bi-person-badge"></i><span>Ver Perfil</span></a>
    <a href="#put-user"    class="nav-link"><i class="bi bi-pencil-square"></i><span>Actualizar Perfil</span></a>

    <div class="nav-section-label">Apuestas</div>
    <a href="#get-apuestas"    class="nav-link"><i class="bi bi-list-ul"></i><span>Listar Apuestas</span></a>
    <a href="#post-apuestas"   class="nav-link"><i class="bi bi-plus-circle"></i><span>Crear Apuesta</span></a>
    <a href="#get-apuesta-id"  class="nav-link"><i class="bi bi-eye"></i><span>Ver Apuesta</span></a>
    <a href="#delete-apuesta"  class="nav-link"><i class="bi bi-trash"></i><span>Cancelar Apuesta</span></a>
    <a href="#post-subasta"    class="nav-link"><i class="bi bi-megaphone"></i><span>Publicar Subasta</span></a>

    <div class="nav-section-label">Transacciones</div>
    <a href="#get-saldo"     class="nav-link"><i class="bi bi-wallet2"></i><span>Consultar Saldo</span></a>
    <a href="#post-deposito" class="nav-link"><i class="bi bi-arrow-down-circle"></i><span>Depositar</span></a>
    <a href="#post-retiro"   class="nav-link"><i class="bi bi-arrow-up-circle"></i><span>Retirar</span></a>

    <div class="nav-section-label">Desafíos</div>
    <a href="#post-desafios"   class="nav-link"><i class="bi bi-trophy"></i><span>Crear Desafío</span></a>
    <a href="#post-resolver"   class="nav-link"><i class="bi bi-check-circle"></i><span>Resolver Desafío</span></a>

    <div class="nav-section-label">Cuotas</div>
    <a href="#post-cuotas" class="nav-link"><i class="bi bi-percent"></i><span>Crear Cuota</span></a>

    <div class="nav-section-label">Errores</div>
    <a href="#errors" class="nav-link"><i class="bi bi-exclamation-triangle"></i><span>Formatos de Error</span></a>
</nav>

<!-- MAIN -->
<main>
<div class="container-fluid">

    <!-- INTRO -->
    <section id="intro" class="doc-section">
        <div class="row"><div class="col-lg-8">
            <h1 class="fw-bold mb-3" style="font-size:2rem;">Documentación de la API</h1>
            <p class="lead text-muted">API RESTful del sistema <strong>Apuestas</strong>. Utiliza JWT para autenticación y JSON para el intercambio de datos.</p>
            <div class="alert alert-info border-0 shadow-sm">
                <i class="bi bi-info-circle-fill me-2"></i>
                Todas las peticiones deben incluir el header <code>Accept: application/json</code>.<br>
                Los endpoints protegidos requieren además: <code>Authorization: Bearer &lt;token&gt;</code>
            </div>
            <div class="alert alert-secondary border-0 shadow-sm mt-2">
                <i class="bi bi-server me-2"></i>
                <strong>Base URL:</strong> <code>http://localhost:8000/api</code>
            </div>
        </div></div>
    </section>

    <hr class="my-4 border-secondary-subtle">

    <!-- ===== AUTENTICACIÓN ===== -->
    <h3 class="fw-bold text-muted mb-3" style="font-size:.85rem; text-transform:uppercase; letter-spacing:.1rem;">Autenticación</h3>

    <!-- POST /register -->
    <section id="post-register" class="doc-section">
        <h2 class="section-title"><i class="bi bi-person-plus-fill text-primary"></i>Registro de Usuario</h2>
        <div class="api-card">
            <div class="api-header">
                <span class="badge-method badge-post">POST</span>
                <span class="api-endpoint">/api/register</span>
            </div>
            <div class="api-body">
                <p class="api-desc">Crea una nueva cuenta de usuario en el sistema.</p>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Request Body</h6>
                        <div class="code-block-header">JSON Payload</div>
                        <pre><code class="language-json">{
    "name": "leo",
    "email": "pleon@gmail.com",
    "username": "leopena22",
    "password": "password123",
    "password_confirmation": "password123"
}</code></pre>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Response (201 Created)</h6>
                        <div class="code-block-header">JSON Response</div>
                        <pre><code class="language-json">{
    "token": "eyJ0eXAiOiJKV1Qi...",
    "user": {
        "id": 5,
        "name": "leo",
        "username": "leopena22",
        "email": "pleon@gmail.com",
        "created_at": "2026-04-25T21:21:38.000000Z",
        "updated_at": "2026-04-25T21:21:38.000000Z"
    }
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- POST /login -->
    <section id="post-login" class="doc-section">
        <h2 class="section-title"><i class="bi bi-shield-lock-fill text-primary"></i>Login</h2>
        <div class="api-card">
            <div class="api-header">
                <span class="badge-method badge-post">POST</span>
                <span class="api-endpoint">/api/login</span>
            </div>
            <div class="api-body">
                <p class="api-desc">Inicia sesión y obtiene un token JWT de acceso.</p>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Request Body</h6>
                        <div class="code-block-header">JSON Payload</div>
                        <pre><code class="language-json">{
    "email": "pjaime@apuestas.com",
    "password": "password"
}</code></pre>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Response (200 OK)</h6>
                        <div class="code-block-header">JSON Response</div>
                        <pre><code class="language-json">{
    "token": "eyJ0eXAiOiJKV1Qi...",
    "user": {
        "id": 4,
        "name": "jaime p",
        "username": "jimil",
        "email": "pjaime@apuestas.com",
        "balance": "1200.00",
        "role": "user",
        "expires_in": 3600
    }
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- POST /logout -->
    <section id="post-logout" class="doc-section">
        <h2 class="section-title"><i class="bi bi-box-arrow-right text-danger"></i>Logout</h2>
        <div class="api-card">
            <div class="api-header">
                <span class="badge-method badge-post">POST</span>
                <span class="api-endpoint">/api/logout</span>
            </div>
            <div class="api-body">
                <p class="api-desc">Cierra la sesión e invalida el token JWT actual.</p>
                <p class="auth-note"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Request Body</h6>
                        <div class="code-block-header">JSON Payload</div>
                        <pre><code class="language-json">{
    "email": "admin@apuestas.com"
}</code></pre>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Response (200 OK)</h6>
                        <div class="code-block-header">JSON Response</div>
                        <pre><code class="language-json">{
    "message": "successfully logged out"
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-4 border-secondary-subtle">

    <!-- ===== USUARIO ===== -->
    <h3 class="fw-bold text-muted mb-3" style="font-size:.85rem; text-transform:uppercase; letter-spacing:.1rem;">Usuario</h3>

    <!-- ★ GET /usuarios-sistema (NUEVO) -->
    <section id="get-usuarios-sistema" class="doc-section">
        <h2 class="section-title"><i class="bi bi-people-fill text-primary"></i>Listar Usuarios del Sistema</h2>
        <div class="api-card">
            <div class="api-header">
                <span class="badge-method badge-get">GET</span>
                <span class="api-endpoint">/api/usuarios-sistema</span>
                <span class="badge-admin"><i class="bi bi-shield-fill"></i> Solo Admin</span>
            </div>
            <div class="api-body">
                <p class="api-desc">Retorna la lista completa de todos los usuarios registrados en el sistema, incluyendo su balance y rol. Solo accesible para usuarios con rol <code>admin</code>.</p>
                <p class="auth-note"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code> (rol: <strong>admin</strong>)</p>
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="fw-bold mb-2">Response (200 OK)</h6>
                        <div class="code-block-header">JSON Response</div>
                        <pre><code class="language-json">{
    "total": 5,
    "usuarios": [
        {
            "id": 1,
            "name": "admin principal",
            "email": "admin@apuestas.com",
            "balance": "5000.00",
            "role": "admin"
        },
        {
            "id": 2,
            "name": "Pablo",
            "email": "pablo@apuestas.com",
            "balance": "1000.00",
            "role": "user"
        },
        {
            "id": 3,
            "name": "Meza",
            "email": "meza@apuestas.com",
            "balance": "1250.00",
            "role": "user"
        },
        {
            "id": 4,
            "name": "jaime p",
            "email": "pjaime@apuestas.com",
            "balance": "1597.50",
            "role": "user"
        },
        {
            "id": 5,
            "name": "leo",
            "email": "pleon@gmail.com",
            "balance": "0.00",
            "role": "user"
        }
    ]
}</code></pre>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Campos de respuesta</h6>
                        <table class="table table-sm table-bordered" style="font-size:.85rem;">
                            <thead class="table-light">
                                <tr><th>Campo</th><th>Tipo</th><th>Descripción</th></tr>
                            </thead>
                            <tbody>
                                <tr><td><code>total</code></td><td>integer</td><td>Total de usuarios en el sistema</td></tr>
                                <tr><td><code>usuarios[].id</code></td><td>integer</td><td>ID único del usuario</td></tr>
                                <tr><td><code>usuarios[].name</code></td><td>string</td><td>Nombre del usuario</td></tr>
                                <tr><td><code>usuarios[].email</code></td><td>string</td><td>Correo electrónico</td></tr>
                                <tr><td><code>usuarios[].balance</code></td><td>string</td><td>Saldo disponible en cuenta</td></tr>
                                <tr><td><code>usuarios[].role</code></td><td>string</td><td><code>admin</code> o <code>user</code></td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Posibles errores</h6>
                        <div class="code-block-header">403 — Sin permisos</div>
                        <pre><code class="language-json">{
    "message": "Esta acción no está autorizada."
}</code></pre>
                        <div class="code-block-header mt-2">401 — No autenticado</div>
                        <pre><code class="language-json">{
    "message": "Unauthenticated."
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- GET /user -->
    <section id="get-user" class="doc-section">
        <h2 class="section-title"><i class="bi bi-person-badge-fill text-success"></i>Ver Perfil</h2>
        <div class="api-card">
            <div class="api-header">
                <span class="badge-method badge-get">GET</span>
                <span class="api-endpoint">/api/user</span>
            </div>
            <div class="api-body">
                <p class="api-desc">Obtiene los datos del usuario autenticado.</p>
                <p class="auth-note"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="fw-bold mb-2">Response (200 OK)</h6>
                        <div class="code-block-header">JSON Response</div>
                        <pre><code class="language-json">{
    "id": 1,
    "name": "Admin Principal",
    "username": "admin",
    "email": "admin@apuestas.com",
    "balance": "1000.00",
    "role": "admin",
    "created_at": "2026-04-25T20:35:21.000000Z",
    "updated_at": "2026-04-25T20:35:21.000000Z"
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PUT /user -->
    <section id="put-user" class="doc-section">
        <h2 class="section-title"><i class="bi bi-pencil-square text-warning"></i>Actualizar Perfil</h2>
        <div class="api-card">
            <div class="api-header">
                <span class="badge-method badge-put">PUT</span>
                <span class="api-endpoint">/api/user</span>
            </div>
            <div class="api-body">
                <p class="api-desc">Actualiza el nombre o email del usuario autenticado.</p>
                <p class="auth-note"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Request Body</h6>
                        <div class="code-block-header">JSON Payload</div>
                        <pre><code class="language-json">{
    "name": "admin principal",
    "email": "admin@apuestas.com"
}</code></pre>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Response (200 OK)</h6>
                        <div class="code-block-header">JSON Response</div>
                        <pre><code class="language-json">{
    "message": "Usuario actualizado con éxito",
    "user": {
        "id": 1,
        "name": "admin principal",
        "username": "admin",
        "email": "admin@apuestas.com",
        "balance": "1000.00",
        "role": "admin"
    }
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-4 border-secondary-subtle">

    <!-- ===== APUESTAS ===== -->
    <h3 class="fw-bold text-muted mb-3" style="font-size:.85rem; text-transform:uppercase; letter-spacing:.1rem;">Apuestas</h3>

    <!-- GET /apuestas -->
    <section id="get-apuestas" class="doc-section">
        <h2 class="section-title"><i class="bi bi-list-ul text-primary"></i>Listar Apuestas</h2>
        <div class="api-card">
            <div class="api-header">
                <span class="badge-method badge-get">GET</span>
                <span class="api-endpoint">/api/apuestas</span>
            </div>
            <div class="api-body">
                <p class="api-desc">Retorna todas las apuestas del usuario autenticado con paginación.</p>
                <p class="auth-note"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="fw-bold mb-2">Response (200 OK)</h6>
                        <div class="code-block-header">JSON Response</div>
                        <pre><code class="language-json">{
    "current_page": 1,
    "data": [
        {
            "id": 3,
            "user_id": 4,
            "match_id": 2,
            "odd_id": 4,
            "amount": 200,
            "potential_win": 380,
            "status": "won",
            "created_at": "2026-04-25T20:36:36.000000Z",
            "updated_at": null,
            "match": {
                "id": 2,
                "team_home": { "name": "LA Lakers", "strength": 85 },
                "team_away": { "name": "Chicago Bulls", "strength": 80 },
                "match_date": "2026-04-30T20:36:36.000000Z",
                "status": "scheduled"
            },
            "odd": {
                "option_name": "Más de 200.5 puntos",
                "odd_value": 1.9,
                "bet_type": { "name": "Más/Menos goles" }
            }
        }
    ],
    "per_page": 20,
    "total": 1,
    "last_page": 1
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- POST /apuestas -->
    <section id="post-apuestas" class="doc-section">
        <h2 class="section-title"><i class="bi bi-plus-circle-fill text-primary"></i>Crear Apuesta</h2>
        <div class="api-card">
            <div class="api-header">
                <span class="badge-method badge-post">POST</span>
                <span class="api-endpoint">/api/apuestas</span>
            </div>
            <div class="api-body">
                <p class="api-desc">Coloca una nueva apuesta sobre una cuota existente. El monto se descuenta del balance del usuario.</p>
                <p class="auth-note"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Request Body</h6>
                        <div class="code-block-header">JSON Payload</div>
                        <pre><code class="language-json">{
    "odd_id": 1,
    "amount": 50.00
}</code></pre>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Response (201 Created)</h6>
                        <div class="code-block-header">JSON Response</div>
                        <pre><code class="language-json">{
    "message": "Apuesta colocada correctamente.",
    "bet": {
        "id": 5,
        "user_id": 4,
        "match_id": 1,
        "odd_id": 1,
        "amount": 50,
        "potential_win": 92.5,
        "status": "pending",
        "odd": {
            "option_name": "Real Madrid gana",
            "odd_value": 1.85,
            "bet_type": { "name": "Resultado final (1X2)" }
        }
    },
    "balance": "1150.00"
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- GET /apuestas/{id} -->
    <section id="get-apuesta-id" class="doc-section">
        <h2 class="section-title"><i class="bi bi-eye-fill text-success"></i>Ver Apuesta</h2>
        <div class="api-card">
            <div class="api-header">
                <span class="badge-method badge-get">GET</span>
                <span class="api-endpoint">/api/apuestas/{id}</span>
            </div>
            <div class="api-body">
                <p class="api-desc">Obtiene el detalle completo de una apuesta específica del usuario.</p>
                <p class="auth-note"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="fw-bold mb-2">Response (200 OK)</h6>
                        <div class="code-block-header">JSON Response</div>
                        <pre><code class="language-json">{
    "id": 5,
    "user_id": 4,
    "match_id": 1,
    "odd_id": 1,
    "amount": 50,
    "potential_win": 92.5,
    "status": "pending",
    "created_at": "2026-04-25T21:45:25.000000Z",
    "updated_at": "2026-04-25T21:45:25.000000Z",
    "match": {
        "id": 1,
        "team_home": { "name": "Real Madrid", "strength": 90 },
        "team_away": { "name": "FC Barcelona", "strength": 88 },
        "match_date": "2026-04-28T20:36:36.000000Z",
        "status": "scheduled"
    },
    "odd": {
        "option_name": "Real Madrid gana",
        "odd_value": 1.85,
        "bet_type": { "name": "Resultado final (1X2)" }
    }
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- DELETE /apuestas/{id} -->
    <section id="delete-apuesta" class="doc-section">
        <h2 class="section-title"><i class="bi bi-trash-fill text-danger"></i>Cancelar Apuesta</h2>
        <div class="api-card">
            <div class="api-header">
                <span class="badge-method badge-delete">DELETE</span>
                <span class="api-endpoint">/api/apuestas/{id}</span>
            </div>
            <div class="api-body">
                <p class="api-desc">Cancela una apuesta en estado <code>pending</code>. Aplica una penalización al reembolso.</p>
                <p class="auth-note"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="fw-bold mb-2">Response (200 OK)</h6>
                        <div class="code-block-header">JSON Response</div>
                        <pre><code class="language-json">{
    "message": "Apuesta cancelada.",
    "devolucion": 47.5,
    "penalizacion": 2.5,
    "balance": "1192.50"
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- POST /apuestas/subasta -->
    <section id="post-subasta" class="doc-section">
        <h2 class="section-title"><i class="bi bi-megaphone-fill text-warning"></i>Publicar en Subasta</h2>
        <div class="api-card">
            <div class="api-header">
                <span class="badge-method badge-post">POST</span>
                <span class="api-endpoint">/api/apuestas/subasta</span>
            </div>
            <div class="api-body">
                <p class="api-desc">Publica una apuesta existente en el mercado de subastas con un precio de venta.</p>
                <p class="auth-note"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Request Body</h6>
                        <div class="code-block-header">JSON Payload</div>
                        <pre><code class="language-json">{
    "bet_id": 6,
    "precio_venta": 120.00
}</code></pre>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Response (200 OK)</h6>
                        <div class="code-block-header">JSON Response</div>
                        <pre><code class="language-json">{
    "message": "Apuesta publicada en subasta.",
    "apuesta_id": 6,
    "precio_venta": 120
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-4 border-secondary-subtle">

    <!-- ===== TRANSACCIONES ===== -->
    <h3 class="fw-bold text-muted mb-3" style="font-size:.85rem; text-transform:uppercase; letter-spacing:.1rem;">Transacciones</h3>

    <!-- GET /transacciones/saldo -->
    <section id="get-saldo" class="doc-section">
        <h2 class="section-title"><i class="bi bi-wallet2 text-success"></i>Consultar Saldo</h2>
        <div class="api-card">
            <div class="api-header">
                <span class="badge-method badge-get">GET</span>
                <span class="api-endpoint">/api/transacciones/saldo</span>
            </div>
            <div class="api-body">
                <p class="api-desc">Retorna el balance actual del usuario autenticado.</p>
                <p class="auth-note"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="fw-bold mb-2">Response (200 OK)</h6>
                        <div class="code-block-header">JSON Response</div>
                        <pre><code class="language-json">{
    "balance": "1597.50"
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- POST /transacciones/deposito -->
    <section id="post-deposito" class="doc-section">
        <h2 class="section-title"><i class="bi bi-arrow-down-circle-fill text-success"></i>Depositar</h2>
        <div class="api-card">
            <div class="api-header">
                <span class="badge-method badge-post">POST</span>
                <span class="api-endpoint">/api/transacciones/deposito</span>
            </div>
            <div class="api-body">
                <p class="api-desc">Añade fondos al balance del usuario.</p>
                <p class="auth-note"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Request Body</h6>
                        <div class="code-block-header">JSON Payload</div>
                        <pre><code class="language-json">{
    "amount": 1000,
    "description": "Carga inicial de prueba"
}</code></pre>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Response (201 Created)</h6>
                        <div class="code-block-header">JSON Response</div>
                        <pre><code class="language-json">{
    "message": "Depósito realizado.",
    "transaction": {
        "type": "deposito",
        "amount": 1000,
        "description": "Carga inicial de prueba",
        "user_id": 4,
        "id": 9
    },
    "balance": "2097.50"
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- POST /transacciones/retiro -->
    <section id="post-retiro" class="doc-section">
        <h2 class="section-title"><i class="bi bi-arrow-up-circle-fill text-danger"></i>Retirar</h2>
        <div class="api-card">
            <div class="api-header">
                <span class="badge-method badge-post">POST</span>
                <span class="api-endpoint">/api/transacciones/retiro</span>
            </div>
            <div class="api-body">
                <p class="api-desc">Retira fondos del balance del usuario.</p>
                <p class="auth-note"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Request Body</h6>
                        <div class="code-block-header">JSON Payload</div>
                        <pre><code class="language-json">{
    "amount": 500
}</code></pre>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Response (200 OK)</h6>
                        <div class="code-block-header">JSON Response</div>
                        <pre><code class="language-json">{
    "message": "Retiro procesado.",
    "transaction": {
        "type": "retiro",
        "amount": 500,
        "description": "retiro de saldo",
        "user_id": 4,
        "id": 10
    },
    "balance": "1597.50"
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-4 border-secondary-subtle">

    <!-- ===== DESAFÍOS ===== -->
    <h3 class="fw-bold text-muted mb-3" style="font-size:.85rem; text-transform:uppercase; letter-spacing:.1rem;">Desafíos</h3>

    <!-- POST /desafios -->
    <section id="post-desafios" class="doc-section">
        <h2 class="section-title"><i class="bi bi-trophy-fill text-warning"></i>Crear Desafío</h2>
        <div class="api-card">
            <div class="api-header">
                <span class="badge-method badge-post">POST</span>
                <span class="api-endpoint">/api/desafios</span>
            </div>
            <div class="api-body">
                <p class="api-desc">Envía un desafío a otro usuario del sistema.</p>
                <p class="auth-note"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Request Body</h6>
                        <div class="code-block-header">JSON Payload</div>
                        <pre><code class="language-json">{
    "opponent_id": 2
}</code></pre>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Response (201 Created)</h6>
                        <div class="code-block-header">JSON Response</div>
                        <pre><code class="language-json">{
    "message": "Desafío creado correctamente.",
    "desafio": {
        "id": 5,
        "creator_id": 4,
        "opponent_id": 2,
        "status": "pending",
        "creator": {
            "id": 4,
            "name": "jaime p",
            "username": "jimil",
            "balance": "1597.50"
        },
        "opponent": {
            "id": 2,
            "name": "Pablo",
            "username": "pabloo",
            "balance": "1000.00"
        }
    }
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- POST /desafios/{id}/resolver -->
    <section id="post-resolver" class="doc-section">
        <h2 class="section-title"><i class="bi bi-check-circle-fill text-success"></i>Resolver Desafío</h2>
        <div class="api-card">
            <div class="api-header">
                <span class="badge-method badge-post">POST</span>
                <span class="api-endpoint">/api/desafios/{id}/resolver</span>
            </div>
            <div class="api-body">
                <p class="api-desc">Declara al ganador de un desafío y distribuye el premio.</p>
                <p class="auth-note"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code></p>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Request Body</h6>
                        <div class="code-block-header">JSON Payload</div>
                        <pre><code class="language-json">{
    "ganador_id": 5
}</code></pre>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Response (200 OK)</h6>
                        <div class="code-block-header">JSON Response</div>
                        <pre><code class="language-json">{
    "status": "success",
    "message": "Desafío resuelto correctamente.",
    "ganador": "Pérez",
    "premio_pagado": 500,
    "nuevo_saldo": "1350.00"
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-4 border-secondary-subtle">

    <!-- ===== CUOTAS ===== -->
    <h3 class="fw-bold text-muted mb-3" style="font-size:.85rem; text-transform:uppercase; letter-spacing:.1rem;">Cuotas</h3>

    <!-- POST /cuotas -->
    <section id="post-cuotas" class="doc-section">
        <h2 class="section-title"><i class="bi bi-percent text-primary"></i>Crear Cuota</h2>
        <div class="api-card">
            <div class="api-header">
                <span class="badge-method badge-post">POST</span>
                <span class="api-endpoint">/api/cuotas</span>
            </div>
            <div class="api-body">
                <p class="api-desc">Crea una nueva cuota/odd asociada a un partido y tipo de apuesta. Requiere rol administrador.</p>
                <p class="auth-note"><i class="bi bi-lock-fill"></i> Requiere: <code>Bearer Token</code> (rol: admin)</p>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Request Body</h6>
                        <div class="code-block-header">JSON Payload</div>
                        <pre><code class="language-json">{
    "match_id": 1,
    "bet_type_id": 1,
    "option_name": "Victoria Local",
    "odd_value": 1.85
}</code></pre>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Response (201 Created)</h6>
                        <div class="code-block-header">JSON Response</div>
                        <pre><code class="language-json">{
    "message": "Cuota creada correctamente.",
    "cuota": {
        "id": 5,
        "match_id": 1,
        "bet_type_id": 1,
        "option_name": "Victoria Local",
        "odd_value": 1.85,
        "match": {
            "team_home": { "name": "Real Madrid", "strength": 90 },
            "team_away": { "name": "FC Barcelona", "strength": 88 },
            "match_date": "2026-04-28T20:36:36.000000Z"
        },
        "bet_type": { "name": "Resultado final (1X2)" }
    }
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-4 border-secondary-subtle">

    <!-- ERRORS -->
    <section id="errors" class="doc-section">
        <h2 class="section-title"><i class="bi bi-exclamation-triangle-fill text-secondary"></i>Formatos de Error</h2>
        <div class="api-card">
            <div class="api-header"><span class="fw-bold">Estándar Apuestas API</span></div>
            <div class="api-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">422 — Validación fallida</h6>
                        <div class="code-block-header">JSON Response</div>
                        <pre><code class="language-json">{
    "error": "Validación fallida",
    "message": "Los datos enviados no son correctos.",
    "details": {
        "email": ["El correo ya ha sido registrado."],
        "password": ["Mínimo 8 caracteres."]
    }
}</code></pre>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">401 — No autenticado</h6>
                        <div class="code-block-header">JSON Response</div>
                        <pre><code class="language-json">{
    "message": "Unauthenticated."
}</code></pre>
                        <h6 class="fw-bold mb-2 mt-3">403 — Sin permisos</h6>
                        <div class="code-block-header">JSON Response</div>
                        <pre><code class="language-json">{
    "message": "Esta acción no está autorizada."
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="mt-5 py-4 border-top text-center text-muted small">
        &copy; 2026 Apuestas API System. Todos los derechos reservados.
    </footer>

</div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-json.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sections = document.querySelectorAll('.doc-section');
        const navLinks = document.querySelectorAll('.nav-link');
        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(s => { if (pageYOffset >= s.offsetTop - 120) current = s.getAttribute('id'); });
            navLinks.forEach(l => {
                l.classList.remove('active');
                if (l.getAttribute('href') === '#' + current) l.classList.add('active');
            });
        });
    });
</script>
</body>
</html>