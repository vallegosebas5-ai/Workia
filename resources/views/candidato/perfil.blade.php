@extends('layouts.panel')
@section('title', 'Mi Perfil')
@section('sidebar-links')
<li><a href="{{ route('candidato.dashboard') }}"><i class="fas fa-home"></i> Inicio</a></li>
<li><a href="{{ route('candidato.perfil') }}" class="active"><i class="fas fa-user-edit"></i> Mi perfil</a></li>
<li><a href="{{ route('candidato.postulaciones') }}"><i class="fas fa-file-alt"></i> Mis postulaciones</a></li>
<li><a href="{{ route('ofertas.index') }}"><i class="fas fa-search"></i> Buscar empleos</a></li>
@endsection
@section('panel-content')
<div class="page-header">
    <div><h1>Mi perfil profesional</h1><p>Completa tu perfil para destacar ante los empleadores</p></div>
</div>

<form method="POST" action="{{ route('candidato.perfil.actualizar') }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div style="display:grid;grid-template-columns:1fr 2fr;gap:1.5rem;align-items:start">
        <div>
            <div class="card" style="margin-bottom:1rem">
                <div class="card-body" style="text-align:center">
                    @if($perfil->foto)
                        <img src="{{ Storage::url($perfil->foto) }}" alt="Foto" style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:3px solid #1a56db;margin-bottom:1rem">
                    @else
                        <div style="width:100px;height:100px;border-radius:50%;background:#eff6ff;display:flex;align-items:center;justify-content:center;color:#1a56db;font-size:2.5rem;margin:0 auto 1rem">
                            <i class="fas fa-user-circle"></i>
                        </div>
                    @endif
                    <div class="form-group">
                        <label class="form-label">Foto de perfil</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label class="form-label">CV (PDF/DOC)</label>
                        <input type="file" name="cv" class="form-control" accept=".pdf,.doc,.docx">
                        @if($perfil->cv)
                            <small style="color:#0e9f6e;margin-top:.35rem;display:block"><i class="fas fa-check"></i> CV subido</small>
                        @else
                            <small style="color:#e02424;margin-top:.35rem;display:block"><i class="fas fa-times"></i> Sin CV</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="card" style="margin-bottom:1rem">
                <div class="card-header">Información personal</div>
                <div class="card-body">
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Fecha de nacimiento</label>
                            <input type="date" name="fecha_nacimiento" value="{{ $perfil->fecha_nacimiento?->format('Y-m-d') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Ciudad</label>
                            <select name="ciudad" class="form-control">
                                <option value="">Seleccionar...</option>
                                @foreach(['La Paz','Santa Cruz','Cochabamba','Oruro','Potosí','Sucre','Tarija','Beni','Pando'] as $c)
                                    <option value="{{ $c }}" {{ $perfil->ciudad == $c ? 'selected' : '' }}>{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Dirección</label>
                        <input type="text" name="direccion" value="{{ $perfil->direccion }}" class="form-control" placeholder="Dirección completa">
                    </div>
                </div>
            </div>

            <div class="card" style="margin-bottom:1rem">
                <div class="card-header">Información profesional</div>
                <div class="card-body">
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Nivel de educación</label>
                            <select name="nivel_educacion" class="form-control">
                                <option value="">Seleccionar...</option>
                                @foreach(['Secundaria','Técnico','Universitario en curso','Licenciatura','Maestría','Doctorado'] as $n)
                                    <option value="{{ $n }}" {{ $perfil->nivel_educacion == $n ? 'selected' : '' }}>{{ $n }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Carrera / Especialidad</label>
                            <input type="text" name="carrera" value="{{ $perfil->carrera }}" class="form-control" placeholder="Ej: Ingeniería de Sistemas">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Resumen profesional</label>
                        <textarea name="resumen_profesional" class="form-control" rows="5" placeholder="Describe tu experiencia, habilidades y objetivos profesionales...">{{ $perfil->resumen_profesional }}</textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar perfil</button>
        </div>
    </div>
</form>
@endsection
