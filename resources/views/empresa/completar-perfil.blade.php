@extends('layouts.panel')
@section('title', 'Completar Perfil')
@section('sidebar-links')
<li><a href="{{ route('empresa.dashboard') }}"><i class="fas fa-home"></i> Inicio</a></li>
<li><a href="{{ route('empresa.perfil') }}" class="active"><i class="fas fa-building"></i> Perfil empresa</a></li>
@endsection
@section('panel-content')
<div class="page-header"><div><h1>Completar perfil de empresa</h1><p>Necesitas completar tu perfil antes de publicar ofertas</p></div></div>

<div class="card" style="max-width:600px">
    <div class="card-body">
        <div class="alert alert-info"><i class="fas fa-info-circle"></i> Para publicar ofertas de empleo, primero debes completar el perfil de tu empresa.</div>
        <form method="POST" action="{{ route('empresa.perfil.guardar') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">Razón social *</label>
                <input type="text" name="razon_social" value="{{ old('razon_social') }}" class="form-control" required>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">NIT</label>
                    <input type="text" name="nit" value="{{ old('nit') }}" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Ciudad</label>
                    <select name="ciudad" class="form-control">
                        <option value="">Seleccionar...</option>
                        @foreach(['La Paz','Santa Cruz','Cochabamba','Oruro','Potosí','Sucre','Tarija','Beni','Pando'] as $c)
                            <option value="{{ $c }}">{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Rubro / Industria</label>
                <input type="text" name="rubro" value="{{ old('rubro') }}" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center"><i class="fas fa-check"></i> Guardar y continuar</button>
        </form>
    </div>
</div>
@endsection
