@extends('layouts.app')
@section('title', 'Iniciar sesión')
@section('styles')
<style>
@keyframes fadeUp   { from { opacity:0; transform:translateY(32px) } to { opacity:1; transform:none } }
@keyframes blob1    { 0%,100%{ transform:translate(0,0) scale(1) } 33%{ transform:translate(30px,-20px) scale(1.08) } 66%{ transform:translate(-15px,15px) scale(.96) } }
@keyframes blob2    { 0%,100%{ transform:translate(0,0) scale(1) } 33%{ transform:translate(-25px,20px) scale(1.05) } 66%{ transform:translate(20px,-10px) scale(.97) } }
@keyframes blob3    { 0%,100%{ transform:translate(0,0) scale(1) } 33%{ transform:translate(15px,25px) scale(1.06) } 66%{ transform:translate(-20px,-15px) scale(.95) } }
@keyframes shimmer  { 0%{ background-position:200% center } 100%{ background-position:-200% center } }

.auth-bg {
    min-height: calc(100vh - 64px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #0f2d6b 0%, #1a56db 60%, #0a7a54 100%);
}
.blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(70px);
    opacity: .35;
    pointer-events: none;
}
.blob-1 { width:420px; height:420px; background:#3b82f6; top:-100px; left:-120px; animation:blob1 9s ease-in-out infinite; }
.blob-2 { width:350px; height:350px; background:#10b981; bottom:-80px; right:-80px; animation:blob2 11s ease-in-out infinite; }
.blob-3 { width:280px; height:280px; background:#8b5cf6; top:40%; left:50%; animation:blob3 13s ease-in-out infinite; }

.auth-card {
    background: #fff;
    border-radius: 20px;
    width: 100%;
    max-width: 420px;
    overflow: hidden;
    box-shadow: 0 32px 80px rgba(0,0,0,.28);
    position: relative;
    z-index: 1;
    animation: fadeUp .65s cubic-bezier(.22,.68,0,1.2) forwards;
}
.auth-card-header {
    background: linear-gradient(135deg, #1a56db, #1e40af);
    padding: 2.25rem 2rem 2rem;
    text-align: center;
    color: #fff;
    position: relative;
    overflow: hidden;
}
.auth-card-header::after {
    content:'';
    position:absolute;
    inset:0;
    background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M20 20c0-5.5-4.5-10-10-10S0 14.5 0 20s4.5 10 10 10 10-4.5 10-10zm10 0c0 5.5 4.5 10 10 10s10-4.5 10-10-4.5-10-10-10-10 4.5-10 10z'/%3E%3C/g%3E%3C/svg%3E");
}
.auth-card-header .logo-icon {
    width: 56px; height: 56px;
    background: rgba(255,255,255,.18);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem;
    margin: 0 auto 1rem;
    position: relative;
    z-index: 1;
    border: 1px solid rgba(255,255,255,.25);
}
.auth-card-header h1 { font-size:1.4rem; font-weight:800; position:relative; z-index:1; }
.auth-card-header p  { opacity:.8; font-size:.88rem; margin-top:.3rem; position:relative; z-index:1; }

.auth-body { padding: 2rem; }

.input-wrap { position: relative; }
.input-wrap .input-icon {
    position:absolute; left:.85rem; top:50%; transform:translateY(-50%);
    color:#9ca3af; font-size:.9rem; pointer-events:none;
    transition: color .2s;
}
.input-wrap .form-control { padding-left: 2.5rem; transition: border-color .2s, box-shadow .2s; }
.input-wrap .form-control:focus + .input-icon,
.input-wrap:focus-within .input-icon { color: #1a56db; }

.btn-login {
    width: 100%; padding: .8rem;
    background: linear-gradient(135deg, #1a56db, #1e40af);
    color: #fff; border: none; border-radius: 10px;
    font-size: 1rem; font-weight: 700; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: .5rem;
    transition: transform .18s, box-shadow .18s;
    background-size: 200% auto;
}
.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(26,86,219,.35);
}
.btn-login:active { transform: translateY(0); }

.pass-toggle {
    position:absolute; right:.75rem; top:50%; transform:translateY(-50%);
    background:none; border:none; cursor:pointer; color:#9ca3af; font-size:.95rem;
    padding:0; transition:color .2s;
}
.pass-toggle:hover { color:#1a56db; }

.form-group { animation: fadeUp .5s ease both; }
.form-group:nth-child(1) { animation-delay:.15s }
.form-group:nth-child(2) { animation-delay:.25s }
.remember-row { animation: fadeUp .5s .35s ease both; opacity:0; }
.btn-login    { animation: fadeUp .5s .42s ease both; opacity:0; }
.auth-footer  { animation: fadeUp .5s .5s ease both; opacity:0; }
</style>
@endsection
@section('content')
<div class="auth-bg">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <div class="auth-card">
        <div class="auth-card-header">
            <div class="logo-icon"><i class="fas fa-briefcase"></i></div>
            <h1>Bienvenido de nuevo</h1>
            <p>Accede a tu cuenta Workia</p>
        </div>
        <div class="auth-body">
            @if($errors->any())
                <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Correo electrónico</label>
                    <div class="input-wrap">
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                               required autofocus placeholder="tu@correo.com">
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <div class="input-wrap" style="position:relative">
                        <input type="password" id="loginPass" name="password" class="form-control"
                               required placeholder="••••••••" style="padding-left:2.5rem;padding-right:2.5rem">
                        <i class="fas fa-lock input-icon"></i>
                        <button type="button" class="pass-toggle" onclick="toggleLoginPass()">
                            <i class="fas fa-eye" id="loginEye"></i>
                        </button>
                    </div>
                </div>
                <div class="remember-row" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem">
                    <label style="display:flex;align-items:center;gap:.5rem;font-size:.875rem;cursor:pointer;color:#374151">
                        <input type="checkbox" name="remember" style="accent-color:#1a56db"> Recordarme
                    </label>
                </div>
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Iniciar sesión
                </button>
            </form>
            <p class="auth-footer" style="text-align:center;margin-top:1.5rem;font-size:.9rem;color:#6b7280">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}" style="color:#1a56db;font-weight:700">Regístrate gratis</a>
            </p>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
function toggleLoginPass() {
    const i = document.getElementById('loginPass');
    const e = document.getElementById('loginEye');
    i.type = i.type === 'password' ? 'text' : 'password';
    e.classList.toggle('fa-eye'); e.classList.toggle('fa-eye-slash');
}
</script>
@endsection
