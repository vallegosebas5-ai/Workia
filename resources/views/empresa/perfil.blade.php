@extends('layouts.panel')
@section('title', 'Perfil Empresa')
@section('sidebar-links')
<li><a href="{{ route('empresa.dashboard') }}"><i class="fas fa-home"></i> Inicio</a></li>
<li><a href="{{ route('empresa.ofertas') }}"><i class="fas fa-briefcase"></i> Mis ofertas</a></li>
<li><a href="{{ route('empresa.ofertas.crear') }}"><i class="fas fa-plus-circle"></i> Nueva oferta</a></li>
<li><a href="{{ route('empresa.perfil') }}" class="active"><i class="fas fa-building"></i> Perfil empresa</a></li>
@endsection
@section('panel-content')
<div class="page-header"><div><h1>Perfil de empresa</h1><p>Información visible para los candidatos</p></div></div>

<form method="POST" action="{{ route('empresa.perfil.guardar') }}" enctype="multipart/form-data">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 2fr;gap:1.5rem;align-items:start">
        <div class="card">
            <div class="card-body" style="text-align:center">
                @if($empresa->logo)
                    <img src="{{ Storage::url($empresa->logo) }}" alt="Logo" style="width:100px;height:100px;border-radius:12px;object-fit:cover;border:1px solid #e5e7eb;margin-bottom:1rem">
                @else
                    <div style="width:100px;height:100px;border-radius:12px;background:#eff6ff;display:flex;align-items:center;justify-content:center;color:#1a56db;font-size:2.5rem;font-weight:800;margin:0 auto 1rem">{{ substr($empresa->razon_social ?? '?',0,1) }}</div>
                @endif
                <div class="form-group">
                    <label class="form-label">Logo empresarial</label>
                    <input type="file" name="logo" class="form-control" accept="image/*">
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Datos de la empresa</div>
            <div class="card-body">
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Razón social *</label>
                        <input type="text" name="razon_social" value="{{ old('razon_social', $empresa->razon_social) }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">NIT</label>
                        <input type="text" name="nit" value="{{ old('nit', $empresa->nit) }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Rubro / Industria</label>
                        <input type="text" name="rubro" value="{{ old('rubro', $empresa->rubro) }}" class="form-control" placeholder="Ej: Tecnología, Minería...">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ciudad</label>
                        <select name="ciudad" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach(['La Paz','Santa Cruz','Cochabamba','Oruro','Potosí','Sucre','Tarija','Beni','Pando'] as $c)
                                <option value="{{ $c }}" {{ ($empresa->ciudad ?? old('ciudad')) == $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="direccion" value="{{ old('direccion', $empresa->direccion) }}" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Sitio web</label>
                    <input type="url" name="sitio_web" value="{{ old('sitio_web', $empresa->sitio_web) }}" class="form-control" placeholder="https://...">
                </div>
                <div class="form-group">
                    <label class="form-label">Descripción de la empresa</label>
                    <textarea name="descripcion" class="form-control" rows="5" placeholder="Cuéntanos sobre tu empresa, misión, visión...">{{ old('descripcion', $empresa->descripcion) }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar cambios</button>
            </div>
        </div>
    </div>
</form>
@endsection
