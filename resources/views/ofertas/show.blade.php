@extends('layouts.app')
@section('title', $oferta->titulo)
@section('content')
<div class="container" style="padding-top:2rem;padding-bottom:3rem">
    <div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start">
        <div>
            <a href="{{ route('ofertas.index') }}" style="color:#6b7280;font-size:.875rem;text-decoration:none;display:inline-flex;align-items:center;gap:.4rem;margin-bottom:1rem"><i class="fas fa-arrow-left"></i> Volver a empleos</a>

            <div class="card" style="margin-bottom:1.5rem">
                <div class="card-body">
                    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem">
                        @if($oferta->empresa->logo)
                            <img src="{{ Storage::url($oferta->empresa->logo) }}" alt="Logo" style="width:64px;height:64px;border-radius:12px;object-fit:cover;border:1px solid #e5e7eb">
                        @else
                            <div style="width:64px;height:64px;border-radius:12px;background:#eff6ff;display:flex;align-items:center;justify-content:center;color:#1a56db;font-weight:800;font-size:1.5rem">{{ substr($oferta->empresa->razon_social,0,1) }}</div>
                        @endif
                        <div>
                            <h1 style="font-size:1.4rem;font-weight:800">{{ $oferta->titulo }}</h1>
                            <p style="color:#6b7280;font-size:.9rem">{{ $oferta->empresa->razon_social }}</p>
                        </div>
                    </div>

                    <div style="display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:1.5rem">
                        <span class="badge badge-primary" style="font-size:.8rem;padding:.4rem .85rem"><i class="fas fa-tag"></i> {{ $oferta->categoria->nombre }}</span>
                        <span class="badge badge-secondary" style="font-size:.8rem;padding:.4rem .85rem"><i class="fas fa-clock"></i> {{ ucfirst(str_replace('_',' ',$oferta->tipo_contrato)) }}</span>
                        <span class="badge badge-info" style="font-size:.8rem;padding:.4rem .85rem"><i class="fas fa-laptop-house"></i> {{ ucfirst($oferta->modalidad) }}</span>
                        @if($oferta->ubicacion)<span class="badge badge-secondary" style="font-size:.8rem;padding:.4rem .85rem"><i class="fas fa-map-marker-alt"></i> {{ $oferta->ubicacion }}</span>@endif
                        @if($oferta->salario_min)<span class="badge badge-success" style="font-size:.8rem;padding:.4rem .85rem"><i class="fas fa-money-bill"></i> Bs. {{ number_format($oferta->salario_min,0) }}{{ $oferta->salario_max ? ' - ' . number_format($oferta->salario_max,0) : '+' }}</span>@endif
                    </div>

                    <h3 style="font-size:1rem;font-weight:700;margin-bottom:.75rem;color:#374151">Descripción del puesto</h3>
                    <div style="line-height:1.8;color:#374151;font-size:.95rem">{!! nl2br(e($oferta->descripcion)) !!}</div>

                    @if($oferta->requisitos)
                    <h3 style="font-size:1rem;font-weight:700;margin-top:1.5rem;margin-bottom:.75rem;color:#374151">Requisitos</h3>
                    <div style="line-height:1.8;color:#374151;font-size:.95rem">{!! nl2br(e($oferta->requisitos)) !!}</div>
                    @endif
                </div>
            </div>
        </div>

        <div style="position:sticky;top:80px">
            <div class="card" style="margin-bottom:1rem">
                <div class="card-body">
                    <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem">Información de la vacante</h3>
                    <div style="display:flex;flex-direction:column;gap:.6rem;font-size:.875rem;color:#374151">
                        <div><i class="fas fa-users" style="color:#1a56db;width:20px"></i> <strong>{{ $oferta->vacantes }}</strong> vacante(s)</div>
                        @if($oferta->fecha_limite)<div><i class="fas fa-calendar" style="color:#1a56db;width:20px"></i> Hasta {{ $oferta->fecha_limite->format('d/m/Y') }}</div>@endif
                        <div><i class="fas fa-clock" style="color:#1a56db;width:20px"></i> Publicado {{ $oferta->created_at->diffForHumans() }}</div>
                    </div>

                    @if($yaPostulado)
                        <div class="alert alert-success" style="margin-top:1rem"><i class="fas fa-check-circle"></i> Ya te postulaste a esta oferta</div>
                    @elseif(auth()->check() && auth()->user()->isCandidato())
                        <button onclick="document.getElementById('modal-postular').style.display='flex'" class="btn btn-primary" style="width:100%;justify-content:center;padding:.85rem;margin-top:1rem;font-size:1rem">
                            <i class="fas fa-paper-plane"></i> Postularme ahora
                        </button>
                    @elseif(!auth()->check())
                        <div style="margin-top:1rem">
                            <a href="{{ route('login') }}" class="btn btn-primary" style="width:100%;justify-content:center;padding:.85rem;font-size:1rem"><i class="fas fa-sign-in-alt"></i> Iniciar sesión para postular</a>
                            <a href="{{ route('register') }}" class="btn btn-outline" style="width:100%;justify-content:center;padding:.85rem;margin-top:.5rem">Crear cuenta gratis</a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3 style="font-size:1rem;font-weight:700;margin-bottom:.75rem">Sobre la empresa</h3>
                    <div style="font-size:.875rem;color:#374151">
                        @if($oferta->empresa->descripcion)
                            <p style="line-height:1.7;margin-bottom:.75rem">{{ Str::limit($oferta->empresa->descripcion, 120) }}</p>
                        @endif
                        @if($oferta->empresa->ciudad)<p><i class="fas fa-city" style="color:#6b7280;width:16px"></i> {{ $oferta->empresa->ciudad }}</p>@endif
                        @if($oferta->empresa->sitio_web)<p style="margin-top:.4rem"><i class="fas fa-globe" style="color:#6b7280;width:16px"></i> <a href="{{ $oferta->empresa->sitio_web }}" target="_blank" style="color:#1a56db">Sitio web</a></p>@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Postular -->
<div id="modal-postular" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:1000;align-items:center;justify-content:center;padding:1rem">
    <div class="card" style="max-width:500px;width:100%;max-height:90vh;overflow-y:auto">
        <div class="card-header" style="display:flex;justify-content:space-between;align-items:center">
            <span>Postularme a: {{ Str::limit($oferta->titulo,40) }}</span>
            <button onclick="document.getElementById('modal-postular').style.display='none'" style="background:none;border:none;cursor:pointer;font-size:1.25rem;color:#6b7280">&times;</button>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('candidato.postular', $oferta) }}" enctype="multipart/form-data">
                @csrf
                @if(auth()->user()?->perfil?->cv)
                    <div class="alert alert-info"><i class="fas fa-file-pdf"></i> Se usará tu CV del perfil. Puedes subir uno diferente si quieres.</div>
                @endif
                <div class="form-group">
                    <label class="form-label">CV (PDF/DOC) - opcional si tienes uno en el perfil</label>
                    <input type="file" name="cv" class="form-control" accept=".pdf,.doc,.docx">
                </div>
                <div class="form-group">
                    <label class="form-label">Carta de presentación (opcional)</label>
                    <textarea name="carta_presentacion" class="form-control" placeholder="¿Por qué eres el candidato ideal para este puesto?..." rows="4"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:.75rem">
                    <i class="fas fa-paper-plane"></i> Enviar postulación
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
