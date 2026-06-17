@extends('layouts.app')
@section('title', 'Buscar empleos')
@section('styles')
<style>
.search-header { background:linear-gradient(135deg,#1a56db,#1e40af); padding:2.5rem 2rem; color:#fff; }
.search-header h1 { font-size:1.75rem; font-weight:800; margin-bottom:1rem; }
.filters-row { display:flex; gap:.75rem; flex-wrap:wrap; }
.filters-row input, .filters-row select { background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.3); color:#fff; border-radius:8px; padding:.5rem .85rem; font-size:.875rem; }
.filters-row input::placeholder { color:rgba(255,255,255,.7); }
.filters-row select option { color:#111; background:#fff; }
.results-area { display:grid; grid-template-columns:240px 1fr; gap:1.5rem; padding:2rem; max-width:1200px; margin:0 auto; }
.filter-sidebar { background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:1.25rem; height:fit-content; position:sticky; top:80px; }
.filter-sidebar h3 { font-size:.9rem; font-weight:700; margin-bottom:.75rem; color:#374151; }
.filter-group { margin-bottom:1.25rem; }
.filter-group label { display:flex; align-items:center; gap:.5rem; padding:.3rem 0; cursor:pointer; font-size:.875rem; }
.filter-group label:hover { color:#1a56db; }
.no-results { text-align:center; padding:4rem 2rem; color:#6b7280; }
@media(max-width:768px){ .results-area{grid-template-columns:1fr} .filter-sidebar{display:none} }
</style>
@endsection
@section('content')
<div class="search-header">
    <div class="container">
        <h1><i class="fas fa-search"></i> Buscar empleos</h1>
        <form method="GET" action="{{ route('ofertas.index') }}">
            <div class="filters-row">
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Cargo o palabra clave..." style="flex:2;min-width:200px">
                <input type="text" name="ciudad" value="{{ request('ciudad') }}" placeholder="Ciudad..." style="flex:1;min-width:150px">
                <select name="categoria" style="flex:1;min-width:150px">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
                @if(request()->anyFilled(['buscar','ciudad','categoria','tipo','modalidad','salario_min']))
                    <a href="{{ route('ofertas.index') }}" class="btn" style="background:rgba(255,255,255,.2);color:#fff">Limpiar</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="results-area">
    <aside class="filter-sidebar">
        <h3><i class="fas fa-filter"></i> Filtros</h3>
        <form method="GET" action="{{ route('ofertas.index') }}" id="filterForm">
            <input type="hidden" name="buscar" value="{{ request('buscar') }}">
            <input type="hidden" name="ciudad" value="{{ request('ciudad') }}">
            <input type="hidden" name="categoria" value="{{ request('categoria') }}">

            <div class="filter-group">
                <h3>Tipo de contrato</h3>
                @foreach(['tiempo_completo'=>'Tiempo completo','medio_tiempo'=>'Medio tiempo','freelance'=>'Freelance','practicante'=>'Practicante','temporal'=>'Temporal'] as $val=>$label)
                <label><input type="radio" name="tipo" value="{{ $val }}" {{ request('tipo')==$val?'checked':'' }} onchange="document.getElementById('filterForm').submit()"> {{ $label }}</label>
                @endforeach
                @if(request('tipo'))<label><input type="radio" name="tipo" value="" onchange="document.getElementById('filterForm').submit()"> Todos</label>@endif
            </div>

            <div class="filter-group">
                <h3>Modalidad</h3>
                @foreach(['presencial'=>'Presencial','remoto'=>'Remoto','hibrido'=>'Híbrido'] as $val=>$label)
                <label><input type="radio" name="modalidad" value="{{ $val }}" {{ request('modalidad')==$val?'checked':'' }} onchange="document.getElementById('filterForm').submit()"> {{ $label }}</label>
                @endforeach
                @if(request('modalidad'))<label><input type="radio" name="modalidad" value="" onchange="document.getElementById('filterForm').submit()"> Todas</label>@endif
            </div>

            <div class="filter-group">
                <h3>Salario mínimo (Bs.)</h3>
                <select name="salario_min" onchange="document.getElementById('filterForm').submit()" class="form-control" style="font-size:.85rem">
                    <option value="">Sin filtro</option>
                    @foreach([1000,2000,3000,5000,8000,10000] as $s)
                        <option value="{{ $s }}" {{ request('salario_min')==$s?'selected':'' }}>{{ number_format($s) }}+</option>
                    @endforeach
                </select>
            </div>
        </form>
    </aside>

    <div>
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
            <p style="color:#6b7280;font-size:.9rem"><strong>{{ $ofertas->total() }}</strong> ofertas encontradas</p>
        </div>

        @forelse($ofertas as $oferta)
        <a href="{{ route('ofertas.show', $oferta) }}" style="text-decoration:none;color:inherit;display:block;margin-bottom:1rem">
            <div class="job-card" style="display:grid;grid-template-columns:auto 1fr auto;align-items:center;gap:1rem">
                @if($oferta->empresa->logo)
                    <img src="{{ Storage::url($oferta->empresa->logo) }}" alt="Logo" style="width:52px;height:52px;border-radius:10px;object-fit:cover;border:1px solid #e5e7eb">
                @else
                    <div style="width:52px;height:52px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center;color:#1a56db;font-weight:800;font-size:1.2rem;flex-shrink:0">{{ substr($oferta->empresa->razon_social,0,1) }}</div>
                @endif
                <div>
                    <div style="font-weight:700;font-size:1rem;margin-bottom:.25rem">{{ $oferta->titulo }}</div>
                    <div style="color:#6b7280;font-size:.85rem;margin-bottom:.5rem">{{ $oferta->empresa->razon_social }} · {{ $oferta->ubicacion ?? 'Bolivia' }}</div>
                    <div style="display:flex;gap:.4rem;flex-wrap:wrap">
                        <span class="badge badge-primary">{{ $oferta->categoria->nombre }}</span>
                        <span class="badge badge-secondary">{{ ucfirst(str_replace('_',' ',$oferta->tipo_contrato)) }}</span>
                        @if($oferta->modalidad !== 'presencial')<span class="badge badge-success">{{ ucfirst($oferta->modalidad) }}</span>@endif
                    </div>
                </div>
                <div style="text-align:right;flex-shrink:0">
                    @if($oferta->salario_min)
                        <div style="color:#0e9f6e;font-weight:700;font-size:.95rem">Bs. {{ number_format($oferta->salario_min,0) }}+</div>
                    @endif
                    <div style="color:#9ca3af;font-size:.8rem;margin-top:.25rem">{{ $oferta->created_at->diffForHumans() }}</div>
                    @if($oferta->fecha_limite && $oferta->fecha_limite->isPast())
                        <span class="badge badge-danger" style="margin-top:.25rem">Vencida</span>
                    @elseif($oferta->fecha_limite)
                        <div style="color:#6b7280;font-size:.78rem;margin-top:.25rem">Hasta {{ $oferta->fecha_limite->format('d/m/Y') }}</div>
                    @endif
                </div>
            </div>
        </a>
        @empty
        <div class="no-results">
            <i class="fas fa-search" style="font-size:3rem;color:#d1d5db;margin-bottom:1rem;display:block"></i>
            <h3 style="color:#374151;margin-bottom:.5rem">No se encontraron ofertas</h3>
            <p>Intenta con otros filtros o palabras clave</p>
            <a href="{{ route('ofertas.index') }}" class="btn btn-outline" style="margin-top:1rem">Ver todas las ofertas</a>
        </div>
        @endforelse

        {{ $ofertas->links('partials.pagination') }}
    </div>
</div>
@endsection
