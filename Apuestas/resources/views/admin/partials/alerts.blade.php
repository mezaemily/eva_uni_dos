@if(session('success'))
<div style="background:rgba(52,211,153,.12);border:1px solid rgba(52,211,153,.3);color:#34d399;
    padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px;display:flex;
    align-items:center;gap:8px;">
    <span>✓</span> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div style="background:rgba(248,113,113,.12);border:1px solid rgba(248,113,113,.3);color:#f87171;
    padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px;display:flex;
    align-items:center;gap:8px;">
    <span>✕</span> {{ session('error') }}
</div>
@endif

@if($errors->any())
<div style="background:rgba(248,113,113,.1);border:1px solid rgba(248,113,113,.25);color:#f87171;
    padding:14px 16px;border-radius:8px;margin-bottom:20px;font-size:13px;">
    <div style="font-weight:600;margin-bottom:8px;">⚠ Corrige los siguientes errores:</div>
    <ul style="margin:0;padding-left:18px;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif