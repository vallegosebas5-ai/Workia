@extends('layouts.panel')
@section('title', 'Gestionar Prueba')
@section('sidebar-links')
<li><a href="{{ route('empresa.dashboard') }}"><i class="fas fa-home"></i> Inicio</a></li>
<li><a href="{{ route('empresa.ofertas') }}" class="active"><i class="fas fa-briefcase"></i> Mis ofertas</a></li>
<li><a href="{{ route('empresa.ofertas.crear') }}"><i class="fas fa-plus-circle"></i> Nueva oferta</a></li>
<li><a href="{{ route('empresa.perfil') }}"><i class="fas fa-building"></i> Perfil empresa</a></li>
@endsection
@section('panel-content')
<div class="page-header">
    <div><h1>Prueba técnica: {{ $oferta->titulo }}</h1><p>Configura el formulario de prueba que recibirán los candidatos</p></div>
    <a href="{{ route('empresa.postulantes', $oferta) }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Volver a postulantes</a>
</div>

<div class="card" style="max-width:600px">
    <div class="card-header"><i class="fas fa-clipboard-check"></i> Configuración de prueba</div>
    <div class="card-body">
        <div class="alert alert-info"><i class="fas fa-info-circle"></i> Cuando marques el estado de un postulante como "Enviar prueba", recibirá automáticamente el enlace del formulario por correo.</div>
        <form method="POST" action="{{ route('empresa.prueba.guardar', $oferta) }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Título de la prueba *</label>
                <input type="text" name="titulo" value="{{ old('titulo', $prueba?->titulo) }}" class="form-control" required placeholder="Ej: Prueba técnica de programación">
            </div>
            <div class="form-group">
                <label class="form-label">Descripción / Instrucciones</label>
                <textarea name="descripcion" class="form-control" rows="4" placeholder="Instrucciones para el candidato...">{{ old('descripcion', $prueba?->descripcion) }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">URL del formulario de prueba (Google Forms, Typeform, etc.) *</label>
                <input type="url" name="url_formulario" value="{{ old('url_formulario', $prueba?->url_formulario) }}" class="form-control" required placeholder="https://forms.google.com/...">
            </div>
            <div class="form-group">
                <label class="form-label">Duración (minutos)</label>
                <input type="number" name="duracion_minutos" value="{{ old('duracion_minutos', $prueba?->duracion_minutos ?? 60) }}" class="form-control" min="5" required>
            </div>
            <div class="form-group">
                <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;font-size:.875rem">
                    <input type="checkbox" name="activa" value="1" {{ old('activa', $prueba?->activa ?? true) ? 'checked' : '' }}> Prueba activa
                </label>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar configuración</button>
        </form>
    </div>
</div>
@endsection
