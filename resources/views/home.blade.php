@extends('layouts.app')
@section('title', 'Inicio')
@section('styles')
<style>
/* ── Animaciones ── */
@keyframes fadeUp   { from { opacity:0; transform:translateY(28px) } to { opacity:1; transform:none } }
@keyframes fadeIn   { from { opacity:0 } to { opacity:1 } }
@keyframes scaleIn  { from { opacity:0; transform:scale(.92) } to { opacity:1; transform:scale(1) } }
@keyframes countUp  { from { opacity:0; transform:translateY(10px) } to { opacity:1; transform:none } }
.anim-fade-up  { opacity:0; animation: fadeUp  .7s ease forwards; }
.anim-fade-in  { opacity:0; animation: fadeIn  .6s ease forwards; }
.anim-scale-in { opacity:0; animation: scaleIn .6s ease forwards; }
.hero-badge   { animation-delay:.1s }
.hero h1      { animation-delay:.25s }
.hero-sub     { animation-delay:.4s }
.search-card  { animation-delay:.55s }
.scroll-anim  { opacity:0; transform:translateY(24px); transition: opacity .6s ease, transform .6s ease; }
.scroll-anim.visible { opacity:1; transform:none; }

/* ── Hero ── */
.hero {
    background: linear-gradient(135deg, #0f2d6b 0%, #1a56db 50%, #0a7a54 100%);
    color: #fff;
    padding: 5rem 2rem 7rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.hero-content { position: relative; z-index: 1; max-width: 760px; margin: 0 auto; }
.hero-badge { display: inline-block; background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25); color: #fff; font-size: .8rem; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; padding: .35rem 1rem; border-radius: 999px; margin-bottom: 1.5rem; }
.hero h1 { font-size: clamp(2rem, 5vw, 3.25rem); font-weight: 900; line-height: 1.12; margin-bottom: 1.25rem; }
.hero h1 em { font-style: normal; color: #fde68a; }
.hero-sub { font-size: 1.1rem; opacity: .88; margin-bottom: 2.5rem; line-height: 1.6; }
.search-card { background: #fff; border-radius: 14px; padding: 1rem 1rem 1rem 1.25rem; display: flex; gap: .75rem; max-width: 680px; margin: 0 auto; box-shadow: 0 20px 60px rgba(0,0,0,.25); }
.search-card input { flex: 1; border: none; outline: none; font-size: 1rem; color: #111; background: transparent; min-width: 0; }
.search-card input::placeholder { color: #9ca3af; }
.search-divider { width: 1px; background: #e5e7eb; margin: .15rem 0; }
.search-city { border: none; outline: none; font-size: .9rem; color: #374151; background: transparent; padding: 0 .75rem; cursor: pointer; min-width: 120px; }

/* ── Stats strip ── */
.stats-strip { background: #fff; border-bottom: 1px solid #e5e7eb; }
.stats-inner { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; display: grid; grid-template-columns: repeat(3, 1fr); }
.stat-item { padding: 1.5rem 1rem; text-align: center; border-right: 1px solid #e5e7eb; }
.stat-item:last-child { border-right: none; }
.stat-num { font-size: 1.9rem; font-weight: 900; color: #1a56db; line-height: 1; }
.stat-lbl { font-size: .82rem; color: #6b7280; margin-top: .25rem; font-weight: 500; }

/* ── Sections ── */
.section { padding: 4.5rem 0; }
.section-alt { background: #f9fafb; }
.section-header { text-align: center; margin-bottom: 2.75rem; }
.section-header h2 { font-size: 1.85rem; font-weight: 800; color: #111827; margin-bottom: .5rem; }
.section-header p { color: #6b7280; font-size: 1rem; }
.wave { display: block; width: 100%; line-height: 0; }

/* ── Category cards ── */
.cat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem; }
.cat-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; padding: 1.5rem 1rem 1.25rem; text-align: center; text-decoration: none; color: inherit; transition: all .22s; display: block; }
.cat-card:hover { border-color: transparent; box-shadow: 0 8px 24px rgba(26,86,219,.15); transform: translateY(-3px); }
.cat-icon { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; margin: 0 auto .85rem; }
.cat-card strong { display: block; font-size: .88rem; font-weight: 700; color: #1f2937; margin-bottom: .2rem; }
.cat-card small { color: #6b7280; font-size: .77rem; font-weight: 500; }
.cat-colors { --c0:#ebf5ff;--c1:#def7ec;--c2:#fde8e8;--c3:#fff3e0;--c4:#f3e8ff;--c5:#e0f2fe;--c6:#fef3c7;--c7:#fce7f3;--c8:#e7f5ee;--c9:#ede9fe;--c10:#fee2e2;--c11:#ecfdf5; }

/* ── Job cards ── */
.job-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(330px, 1fr)); gap: 1.1rem; }
.job-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; padding: 1.4rem; transition: all .22s; display: flex; flex-direction: column; gap: .85rem; }
.job-card:hover { border-color: #1a56db; box-shadow: 0 6px 20px rgba(26,86,219,.1); transform: translateY(-2px); }
.job-card-top { display: flex; align-items: flex-start; gap: .85rem; }
.job-logo { width: 48px; height: 48px; border-radius: 10px; object-fit: cover; border: 1px solid #e5e7eb; flex-shrink: 0; }
.job-logo-placeholder { width: 48px; height: 48px; border-radius: 10px; background: #ebf5ff; display: flex; align-items: center; justify-content: center; color: #1a56db; font-weight: 800; font-size: 1.15rem; flex-shrink: 0; }
.job-title { font-weight: 700; font-size: .97rem; color: #111827; margin-bottom: .15rem; line-height: 1.3; }
.job-company { font-size: .82rem; color: #6b7280; }
.job-tags { display: flex; flex-wrap: wrap; gap: .35rem; }
.job-footer { display: flex; align-items: center; justify-content: space-between; padding-top: .6rem; border-top: 1px solid #f3f4f6; }
.job-location { font-size: .8rem; color: #6b7280; display: flex; align-items: center; gap: .3rem; }
.job-salary { font-size: .88rem; color: #0e9f6e; font-weight: 700; }
.job-deadline { font-size: .75rem; color: #9ca3af; }

/* ── CTA dual ── */
.cta-dual { display: grid; grid-template-columns: 1fr 1fr; gap: 0; }
.cta-block { padding: 4.5rem 3rem; text-align: center; }
.cta-block.cta-left { background: linear-gradient(135deg, #1a56db, #1e40af); color: #fff; }
.cta-block.cta-right { background: linear-gradient(135deg, #057a55, #0e9f6e); color: #fff; }
.cta-block .cta-icon { font-size: 3rem; margin-bottom: 1.25rem; opacity: .9; }
.cta-block h2 { font-size: 1.6rem; font-weight: 800; margin-bottom: .75rem; }
.cta-block p { opacity: .88; margin-bottom: 2rem; line-height: 1.6; font-size: .97rem; }
.btn-white-blue { background: #fff; color: #1a56db; font-weight: 700; display: inline-flex; align-items: center; gap: .4rem; padding: .7rem 1.5rem; border-radius: 8px; font-size: .9rem; text-decoration: none; transition: all .2s; }
.btn-white-blue:hover { background: #eff6ff; }
.btn-white-green { background: #fff; color: #057a55; font-weight: 700; display: inline-flex; align-items: center; gap: .4rem; padding: .7rem 1.5rem; border-radius: 8px; font-size: .9rem; text-decoration: none; transition: all .2s; }
.btn-white-green:hover { background: #f0fdf4; }

@media (max-width: 768px) {
    .hero { padding: 3.5rem 1.25rem 5rem; }
    .search-card { flex-direction: column; gap: .5rem; }
    .search-divider { width: 100%; height: 1px; }
    .search-city { padding: .5rem 0; }
    .stats-inner { grid-template-columns: repeat(3, 1fr); }
    .stat-num { font-size: 1.4rem; }
    .cta-dual { grid-template-columns: 1fr; }
    .cat-grid { grid-template-columns: repeat(auto-fill, minmax(130px,1fr)); }
    .job-grid { grid-template-columns: 1fr; }
}
</style>
@endsection
@section('content')

{{-- ── HERO ── --}}
<section class="hero">
    <div class="hero-content">
        <span class="hero-badge anim-fade-up"><i class="fas fa-map-marker-alt"></i> &nbsp;Bolivia</span>
        <h1 class="anim-fade-up">Encuentra tu próximo<br>empleo <em>ideal</em> en Bolivia</h1>
        <p class="hero-sub anim-fade-up">Miles de oportunidades laborales de las mejores empresas del país,<br>en un solo lugar.</p>
        <div class="search-card anim-fade-up">
            <i class="fas fa-search" style="color:#9ca3af;font-size:1.05rem;align-self:center;flex-shrink:0"></i>
            <input type="text" id="buscarInput" placeholder="Cargo, empresa o palabra clave..." onkeydown="if(event.key==='Enter') buscar()">
            <div class="search-divider"></div>
            <select class="search-city" id="ciudadInput">
                <option value="">Toda Bolivia</option>
                @foreach(['La Paz','Santa Cruz','Cochabamba','Oruro','Potosí','Sucre','Tarija','Beni','Pando'] as $c)
                    <option value="{{ $c }}">{{ $c }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary" onclick="buscar()" style="white-space:nowrap;padding:.6rem 1.25rem">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>
    </div>
</section>

{{-- Ola decorativa --}}
<svg class="wave" style="margin-top:-1px;background:#fff" viewBox="0 0 1440 54" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
    <path d="M0,27 C360,54 1080,0 1440,27 L1440,54 L0,54 Z" fill="white"/>
    <path d="M0,27 C360,54 1080,0 1440,27 L1440,54 L0,54 Z" fill="#f9fafb" opacity="0"/>
</svg>

{{-- ── STATS ── --}}
<div class="stats-strip">
    <div class="stats-inner">
        <div class="stat-item scroll-anim" style="transition-delay:.0s">
            <div class="stat-num" data-count="{{ $totalOfertas }}">0</div>
            <div class="stat-lbl"><i class="fas fa-briefcase" style="color:#1a56db"></i> Empleos activos</div>
        </div>
        <div class="stat-item scroll-anim" style="transition-delay:.15s">
            <div class="stat-num" data-count="{{ $totalEmpresas }}">0</div>
            <div class="stat-lbl"><i class="fas fa-building" style="color:#0e9f6e"></i> Empresas</div>
        </div>
        <div class="stat-item scroll-anim" style="transition-delay:.3s">
            <div class="stat-num" data-count="{{ $totalCandidatos }}">0</div>
            <div class="stat-lbl"><i class="fas fa-users" style="color:#f59e0b"></i> Candidatos</div>
        </div>
    </div>
</div>

{{-- ── CATEGORÍAS ── --}}
@php
$catColors = ['#ebf5ff','#def7ec','#fde8e8','#fff3e0','#f3e8ff','#e0f2fe','#fef3c7','#fce7f3','#e7f5ee','#ede9fe','#fee2e2','#ecfdf5'];
$catIcon   = ['#1a56db','#0e9f6e','#e02424','#d97706','#7c3aed','#0284c7','#b45309','#be185d','#059669','#6d28d9','#dc2626','#065f46'];
@endphp
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <h2>Explora por categoría</h2>
            <p>Encuentra empleos en tu área de especialización</p>
        </div>
        <div class="cat-grid">
            @foreach($categorias as $i => $cat)
            <a href="{{ route('ofertas.index', ['categoria' => $cat->id]) }}" class="cat-card scroll-anim" style="transition-delay:{{ $i * 0.06 }}s">
                <div class="cat-icon" style="background:{{ $catColors[$i % count($catColors)] }};color:{{ $catIcon[$i % count($catIcon)] }}">
                    <i class="fas fa-{{ $cat->icono ?? 'briefcase' }}"></i>
                </div>
                <strong>{{ $cat->nombre }}</strong>
                <small>{{ $cat->ofertas_count }} {{ $cat->ofertas_count === 1 ? 'oferta' : 'ofertas' }}</small>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ── OFERTAS RECIENTES ── --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2>Ofertas recientes</h2>
            <p>Las últimas oportunidades publicadas en Bolivia</p>
        </div>
        <div class="job-grid">
            @forelse($ofertasDestacadas as $oferta)
            <a href="{{ route('ofertas.show', $oferta) }}" class="scroll-anim" style="text-decoration:none;color:inherit;transition-delay:{{ $loop->index * 0.08 }}s">
                <div class="job-card">
                    <div class="job-card-top">
                        @if($oferta->empresa->logo)
                            <img src="{{ route('storage.serve', ['path' => $oferta->empresa->logo]) }}" alt="Logo" class="job-logo">
                        @else
                            <div class="job-logo-placeholder">{{ mb_strtoupper(mb_substr($oferta->empresa->razon_social, 0, 1)) }}</div>
                        @endif
                        <div style="min-width:0">
                            <div class="job-title">{{ $oferta->titulo }}</div>
                            <div class="job-company">{{ $oferta->empresa->razon_social }}</div>
                        </div>
                    </div>
                    <div class="job-tags">
                        <span class="badge badge-primary">{{ $oferta->categoria->nombre }}</span>
                        <span class="badge badge-secondary">{{ ucfirst(str_replace('_', ' ', $oferta->tipo_contrato)) }}</span>
                        @if($oferta->modalidad !== 'presencial')
                            <span class="badge badge-success">{{ ucfirst($oferta->modalidad) }}</span>
                        @endif
                    </div>
                    <div class="job-footer">
                        <span class="job-location">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $oferta->ubicacion ?? 'Bolivia' }}
                        </span>
                        <div style="text-align:right">
                            @if($oferta->salario_min)
                                <div class="job-salary">Bs. {{ number_format($oferta->salario_min, 0) }}+</div>
                            @endif
                            @if($oferta->fecha_limite)
                                <div class="job-deadline"><i class="fas fa-clock"></i> Hasta {{ $oferta->fecha_limite->format('d/m/Y') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:3rem;color:#6b7280">
                <i class="fas fa-briefcase" style="font-size:2.5rem;opacity:.3;display:block;margin-bottom:1rem"></i>
                Aún no hay ofertas publicadas.
            </div>
            @endforelse
        </div>
        <div style="text-align:center;margin-top:2.25rem">
            <a href="{{ route('ofertas.index') }}" class="btn btn-outline" style="padding:.65rem 1.75rem">
                Ver todas las ofertas &nbsp;<i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

{{-- ── CTA DUAL ── --}}
<div class="cta-dual">
    <div class="cta-block cta-left">
        <div class="cta-icon"><i class="fas fa-user-tie"></i></div>
        <h2>¿Buscas empleo?</h2>
        <p>Crea tu perfil gratis, sube tu CV y postula a cientos de ofertas en Bolivia con un solo clic.</p>
        <a href="{{ route('register') }}" class="btn-white-blue">
            <i class="fas fa-user-plus"></i> Crear cuenta gratis
        </a>
    </div>
    <div class="cta-block cta-right">
        <div class="cta-icon"><i class="fas fa-building"></i></div>
        <h2>¿Tienes una empresa?</h2>
        <p>Publica tus vacantes y encuentra el talento boliviano que necesitas de forma rápida y sencilla.</p>
        <a href="{{ route('register') }}" class="btn-white-green">
            <i class="fas fa-briefcase"></i> Publicar vacante gratis
        </a>
    </div>
</div>

@endsection
@section('scripts')
<script>
// Scroll reveal
const observer = new IntersectionObserver((entries) => {
    entries.forEach(el => {
        if (el.isIntersecting) {
            el.target.classList.add('visible');
            observer.unobserve(el.target);
        }
    });
}, { threshold: 0.12 });
document.querySelectorAll('.scroll-anim').forEach(el => observer.observe(el));

// Count-up
function animateCount(el, target, duration = 1200) {
    let start = 0, step = target / (duration / 16);
    const tick = () => {
        start = Math.min(start + step, target);
        el.textContent = Math.floor(start).toLocaleString('es-BO');
        if (start < target) requestAnimationFrame(tick);
    };
    requestAnimationFrame(tick);
}
const countObserver = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            const el = e.target;
            animateCount(el, parseInt(el.dataset.count));
            countObserver.unobserve(el);
        }
    });
}, { threshold: 0.5 });
document.querySelectorAll('[data-count]').forEach(el => countObserver.observe(el));

function buscar() {
    const q    = document.getElementById('buscarInput').value.trim();
    const city = document.getElementById('ciudadInput').value;
    let url    = '{{ route("ofertas.index") }}';
    const params = new URLSearchParams();
    if (q)    params.set('buscar', q);
    if (city) params.set('ciudad', city);
    window.location = params.toString() ? url + '?' + params : url;
}
</script>
@endsection
