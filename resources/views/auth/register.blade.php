@extends('layouts.app')
@section('title', 'Registrarse')
@section('styles')
<style>
@keyframes fadeUp  { from { opacity:0; transform:translateY(32px) } to { opacity:1; transform:none } }
@keyframes blob1   { 0%,100%{ transform:translate(0,0) scale(1) } 33%{ transform:translate(30px,-20px) scale(1.08) } 66%{ transform:translate(-15px,15px) scale(.96) } }
@keyframes blob2   { 0%,100%{ transform:translate(0,0) scale(1) } 33%{ transform:translate(-25px,20px) scale(1.05) } 66%{ transform:translate(20px,-10px) scale(.97) } }
@keyframes blob3   { 0%,100%{ transform:translate(0,0) scale(1) } 33%{ transform:translate(15px,25px) scale(1.06) } 66%{ transform:translate(-20px,-15px) scale(.95) } }

.auth-bg {
    min-height: calc(100vh - 64px);
    display: flex; align-items: center; justify-content: center;
    padding: 2rem;
    position: relative; overflow: hidden;
    background: linear-gradient(135deg, #0a4f3a 0%, #0e9f6e 50%, #1a56db 100%);
}
.blob { position:absolute; border-radius:50%; filter:blur(70px); opacity:.3; pointer-events:none; }
.blob-1 { width:380px; height:380px; background:#10b981; top:-80px; left:-100px; animation:blob1 10s ease-in-out infinite; }
.blob-2 { width:320px; height:320px; background:#3b82f6; bottom:-60px; right:-60px; animation:blob2 12s ease-in-out infinite; }
.blob-3 { width:250px; height:250px; background:#8b5cf6; top:35%; left:55%; animation:blob3 14s ease-in-out infinite; }

.auth-card {
    background: #fff;
    border-radius: 20px;
    width: 100%; max-width: 520px;
    overflow: hidden;
    box-shadow: 0 32px 80px rgba(0,0,0,.28);
    position: relative; z-index: 1;
    animation: fadeUp .65s cubic-bezier(.22,.68,0,1.2) forwards;
}
.auth-card-header {
    background: linear-gradient(135deg, #057a55, #0e9f6e, #1a56db);
    padding: 2rem 2rem 1.75rem;
    text-align: center; color: #fff;
    position: relative; overflow: hidden;
}
.auth-card-header::after {
    content:''; position:absolute; inset:0;
    background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='20' cy='20' r='10'/%3E%3C/g%3E%3C/svg%3E");
}
.auth-card-header .logo-icon {
    width:52px; height:52px;
    background: rgba(255,255,255,.18);
    border-radius:14px;
    display:flex; align-items:center; justify-content:center;
    font-size:1.4rem; margin:0 auto .85rem;
    position:relative; z-index:1;
    border:1px solid rgba(255,255,255,.25);
}
.auth-card-header h1 { font-size:1.35rem; font-weight:800; position:relative; z-index:1; }
.auth-card-header p  { opacity:.8; font-size:.87rem; margin-top:.25rem; position:relative; z-index:1; }

.auth-body { padding: 1.75rem 2rem 2rem; }

/* Role cards */
.role-selector { display:grid; grid-template-columns:1fr 1fr; gap:.85rem; margin-bottom:1.5rem; }
.role-card {
    border: 2px solid #e5e7eb; border-radius: 12px; padding: 1.1rem 1rem;
    text-align: center; cursor: pointer;
    transition: all .22s cubic-bezier(.22,.68,0,1.2);
    position: relative; overflow: hidden;
}
.role-card::before {
    content:''; position:absolute; inset:0;
    opacity:0; transition:opacity .22s;
}
.role-card.candidato::before { background: linear-gradient(135deg,#f0fdf4,#dcfce7); }
.role-card.empresa::before   { background: linear-gradient(135deg,#eff6ff,#dbeafe); }
.role-card:hover, .role-card.selected { border-color:transparent; transform:translateY(-2px); box-shadow:0 6px 18px rgba(0,0,0,.1); }
.role-card:hover::before, .role-card.selected::before { opacity:1; }
.role-card i { font-size:1.75rem; margin-bottom:.4rem; display:block; position:relative; z-index:1; transition: transform .22s; }
.role-card:hover i, .role-card.selected i { transform:scale(1.12); }
.role-card.candidato i { color:#0e9f6e; }
.role-card.empresa   i { color:#1a56db; }
.role-card strong { display:block; font-size:.9rem; font-weight:700; position:relative; z-index:1; }
.role-card small  { color:#6b7280; font-size:.78rem; position:relative; z-index:1; }

/* Inputs */
.input-wrap { position:relative; }
.input-wrap .input-icon {
    position:absolute; left:.85rem; top:50%; transform:translateY(-50%);
    color:#9ca3af; font-size:.88rem; pointer-events:none; transition:color .2s;
}
.input-wrap:focus-within .input-icon { color:#0e9f6e; }
.input-wrap .form-control { padding-left:2.5rem; }

.pass-toggle {
    position:absolute; right:.7rem; top:50%; transform:translateY(-50%);
    background:none; border:none; cursor:pointer; color:#9ca3af; font-size:.95rem; padding:0;
    transition:color .2s;
}
.pass-toggle:hover { color:#0e9f6e; }

/* Staggered entrance */
.role-selector   { animation: fadeUp .5s .1s ease both; opacity:0; }
.form-field-1    { animation: fadeUp .5s .18s ease both; opacity:0; }
.form-field-2    { animation: fadeUp .5s .24s ease both; opacity:0; }
.form-field-3    { animation: fadeUp .5s .30s ease both; opacity:0; }
.form-field-4    { animation: fadeUp .5s .36s ease both; opacity:0; }
.form-field-5    { animation: fadeUp .5s .42s ease both; opacity:0; }
.form-field-6    { animation: fadeUp .5s .48s ease both; opacity:0; }
.btn-register    { animation: fadeUp .5s .54s ease both; opacity:0; }
.auth-footer     { animation: fadeUp .5s .60s ease both; opacity:0; }

.btn-register {
    width:100%; padding:.8rem;
    background: linear-gradient(135deg, #057a55, #0e9f6e);
    color:#fff; border:none; border-radius:10px;
    font-size:1rem; font-weight:700; cursor:pointer;
    display:flex; align-items:center; justify-content:center; gap:.5rem;
    transition: transform .18s, box-shadow .18s;
}
.btn-register:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(14,159,110,.35); }
.btn-register:active { transform:translateY(0); }
</style>
@endsection
@section('content')
<div class="auth-bg">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <div class="auth-card">
        <div class="auth-card-header">
            <div class="logo-icon"><i class="fas fa-user-plus"></i></div>
            <h1>Crear cuenta</h1>
            <p>Únete a Workia Bolivia</p>
        </div>
        <div class="auth-body">
            @if($errors->any())
                <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
            @endif

            <p style="font-size:.85rem;font-weight:600;color:#374151;margin-bottom:.6rem">¿Qué tipo de cuenta quieres crear?</p>
            <div class="role-selector">
                <div class="role-card candidato" id="card-candidato" onclick="selectRole('candidato')">
                    <i class="fas fa-user-tie"></i>
                    <strong>Candidato</strong>
                    <small>Busco empleo</small>
                </div>
                <div class="role-card empresa" id="card-empresa" onclick="selectRole('empresa')">
                    <i class="fas fa-building"></i>
                    <strong>Empresa</strong>
                    <small>Publico vacantes</small>
                </div>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="hidden" name="role" id="role" value="{{ old('role', 'candidato') }}">

                <div class="form-group form-field-1">
                    <label class="form-label">Nombre completo</label>
                    <div class="input-wrap">
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required placeholder="Tu nombre completo">
                        <i class="fas fa-user input-icon"></i>
                    </div>
                </div>

                <div class="form-group form-field-2">
                    <label class="form-label">Correo electrónico</label>
                    <div class="input-wrap">
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required placeholder="tu@correo.com">
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                </div>

                <div id="empresa-fields" style="display:none">
                    <div class="form-group">
                        <label class="form-label">Razón social / Nombre de empresa</label>
                        <div class="input-wrap">
                            <input type="text" name="razon_social" value="{{ old('razon_social') }}" class="form-control" placeholder="Empresa S.R.L.">
                            <i class="fas fa-building input-icon"></i>
                        </div>
                    </div>
                </div>

                <div class="form-field-3" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                    <div class="form-group">
                        <label class="form-label">Teléfono</label>
                        <div class="input-wrap">
                            <input type="text" name="telefono" value="{{ old('telefono') }}" class="form-control" placeholder="70000000">
                            <i class="fas fa-phone input-icon"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ciudad</label>
                        <select name="ciudad" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach(['La Paz','Santa Cruz','Cochabamba','Oruro','Potosí','Sucre','Tarija','Beni','Pando'] as $c)
                                <option value="{{ $c }}" {{ old('ciudad') == $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group form-field-4">
                    <label class="form-label">Contraseña</label>
                    <div class="input-wrap" style="position:relative">
                        <input type="password" name="password" id="password" class="form-control" required
                               placeholder="Mínimo 8 caracteres" style="padding-left:2.5rem;padding-right:2.5rem"
                               oninput="checkStrength(this.value)">
                        <i class="fas fa-lock input-icon"></i>
                        <button type="button" class="pass-toggle" onclick="togglePass('password','eye1')">
                            <i class="fas fa-eye" id="eye1"></i>
                        </button>
                    </div>
                    <div style="margin-top:.5rem">
                        <div style="display:flex;gap:.25rem;height:5px">
                            <div id="bar1" style="flex:1;border-radius:3px;background:#e5e7eb;transition:background .3s"></div>
                            <div id="bar2" style="flex:1;border-radius:3px;background:#e5e7eb;transition:background .3s"></div>
                            <div id="bar3" style="flex:1;border-radius:3px;background:#e5e7eb;transition:background .3s"></div>
                            <div id="bar4" style="flex:1;border-radius:3px;background:#e5e7eb;transition:background .3s"></div>
                        </div>
                        <p id="strength-text" style="font-size:.75rem;margin-top:.25rem"></p>
                    </div>
                    <ul style="font-size:.75rem;color:#6b7280;margin-top:.4rem;padding-left:1.1rem;line-height:1.9">
                        <li id="req-len">Mínimo 8 caracteres</li>
                        <li id="req-upper">Al menos una mayúscula</li>
                        <li id="req-lower">Al menos una minúscula</li>
                        <li id="req-num">Al menos un número</li>
                    </ul>
                </div>

                <div class="form-group form-field-5">
                    <label class="form-label">Confirmar contraseña</label>
                    <div class="input-wrap" style="position:relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                               required placeholder="Repite la contraseña" style="padding-left:2.5rem;padding-right:2.5rem"
                               oninput="checkMatch()">
                        <i class="fas fa-lock input-icon"></i>
                        <button type="button" class="pass-toggle" onclick="togglePass('password_confirmation','eye2')">
                            <i class="fas fa-eye" id="eye2"></i>
                        </button>
                    </div>
                    <p id="match-text" style="font-size:.75rem;margin-top:.3rem"></p>
                </div>

                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus"></i> Crear cuenta
                </button>
            </form>

            <p class="auth-footer" style="text-align:center;margin-top:1.5rem;font-size:.9rem;color:#6b7280">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" style="color:#0e9f6e;font-weight:700">Iniciar sesión</a>
            </p>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
function togglePass(id, eyeId) {
    const input = document.getElementById(id);
    const eye   = document.getElementById(eyeId);
    input.type  = input.type === 'password' ? 'text' : 'password';
    eye.classList.toggle('fa-eye');
    eye.classList.toggle('fa-eye-slash');
}

function checkStrength(val) {
    const rules = {
        'req-len':   val.length >= 8,
        'req-upper': /[A-Z]/.test(val),
        'req-lower': /[a-z]/.test(val),
        'req-num':   /[0-9]/.test(val),
    };
    const score = Object.values(rules).filter(Boolean).length;
    Object.entries(rules).forEach(([id, ok]) => {
        const el = document.getElementById(id);
        el.style.color = ok ? '#0e9f6e' : '#6b7280';
        el.style.fontWeight = ok ? '600' : 'normal';
    });
    const colors    = ['#e5e7eb','#e02424','#ff8c00','#1a56db','#0e9f6e'];
    const labels    = ['','Muy débil','Débil','Buena','Fuerte'];
    const txtColors = ['','#e02424','#ff8c00','#1a56db','#0e9f6e'];
    for (let i = 1; i <= 4; i++)
        document.getElementById('bar'+i).style.background = i <= score ? colors[score] : '#e5e7eb';
    const t = document.getElementById('strength-text');
    t.textContent = val.length ? labels[score] : '';
    t.style.color = txtColors[score];
    checkMatch();
}

function checkMatch() {
    const pass = document.getElementById('password').value;
    const conf = document.getElementById('password_confirmation').value;
    const el   = document.getElementById('match-text');
    if (!conf) { el.textContent = ''; return; }
    el.textContent = pass === conf ? '✓ Las contraseñas coinciden' : '✗ Las contraseñas no coinciden';
    el.style.color = pass === conf ? '#0e9f6e' : '#e02424';
}

function selectRole(role) {
    document.getElementById('role').value = role;
    document.getElementById('card-candidato').classList.toggle('selected', role === 'candidato');
    document.getElementById('card-empresa').classList.toggle('selected', role === 'empresa');
    document.getElementById('empresa-fields').style.display = role === 'empresa' ? 'block' : 'none';
    document.querySelector('[name=razon_social]').required = role === 'empresa';
}
selectRole('{{ old("role","candidato") }}');
</script>
@endsection
