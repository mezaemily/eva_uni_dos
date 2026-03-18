<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro — BetArena</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root { --bg:#080c12; --surface:#0d1520; --border:#1a2d45; --accent:#00e5ff; --accent2:#ff3d71; --text:#e2eaf4; --muted:#4a6080; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'DM Mono',monospace; background:var(--bg); color:var(--text); min-height:100vh; display:flex; align-items:center; justify-content:center; padding:20px; }
        body::before { content:''; position:fixed; inset:0; background:repeating-linear-gradient(0deg,transparent,transparent 2px,rgba(0,229,255,0.015) 2px,rgba(0,229,255,0.015) 4px); pointer-events:none; }

        .card { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:40px; width:100%; max-width:440px; position:relative; }
        .card::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; background:var(--accent); border-radius:16px 16px 0 0; }

        .logo { text-align:center; margin-bottom:28px; }
        .logo-icon { width:48px; height:48px; background:var(--accent); border-radius:10px; display:inline-flex; align-items:center; justify-content:center; font-family:'Syne',sans-serif; font-weight:800; font-size:22px; color:var(--bg); box-shadow:0 0 30px rgba(0,229,255,0.3); margin-bottom:10px; }
        .logo-title { font-family:'Syne',sans-serif; font-weight:800; font-size:20px; }
        .logo-title span { color:var(--accent); }

        .form-group { margin-bottom:16px; }
        label { display:block; font-size:11px; color:var(--muted); text-transform:uppercase; letter-spacing:1.5px; margin-bottom:7px; }
        input { width:100%; background:var(--bg); border:1px solid var(--border); color:var(--text); border-radius:8px; padding:10px 14px; font-family:'DM Mono',monospace; font-size:13px; outline:none; transition:border-color .2s; }
        input:focus { border-color:var(--accent); }
        input.error { border-color:var(--accent2); }
        .field-error { color:var(--accent2); font-size:11px; margin-top:4px; }

        .btn { width:100%; background:var(--accent); color:var(--bg); border:none; border-radius:8px; padding:12px; font-family:'Syne',sans-serif; font-weight:700; font-size:14px; cursor:pointer; transition:all .2s; letter-spacing:1px; margin-top:8px; }
        .btn:hover { box-shadow:0 0 24px rgba(0,229,255,0.3); transform:translateY(-1px); }

        .login-link { text-align:center; margin-top:18px; font-size:12px; color:var(--muted); }
        .login-link a { color:var(--accent); text-decoration:none; }

        .alert-error { background:rgba(255,61,113,0.1); border:1px solid var(--accent2); color:var(--accent2); border-radius:8px; padding:12px 14px; font-size:12px; margin-bottom:18px; }
    </style>
</head>
<body>
<div class="card">
    <div class="logo">
        <div class="logo-icon">B</div>
        <div class="logo-title">Bet<span>Arena</span></div>
    </div>

    @if($errors->any())
    <div class="alert-error">
        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label>Nombre completo</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="{{ $errors->has('name') ? 'error' : '' }}"
                   placeholder="Tu nombre" required>
            @error('name')<div class="field-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="{{ old('username') }}"
                   class="{{ $errors->has('username') ? 'error' : '' }}"
                   placeholder="usuario123" required>
            @error('username')<div class="field-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Correo electrónico</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="{{ $errors->has('email') ? 'error' : '' }}"
                   placeholder="correo@ejemplo.com" required>
            @error('email')<div class="field-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="password"
                   class="{{ $errors->has('password') ? 'error' : '' }}"
                   placeholder="Mínimo 8 caracteres" required>
            @error('password')<div class="field-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Confirmar contraseña</label>
            <input type="password" name="password_confirmation" placeholder="Repite la contraseña" required>
        </div>
        <button type="submit" class="btn">CREAR CUENTA →</button>
    </form>

    <div class="login-link">
        ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
    </div>
</div>
</body>
</html>
