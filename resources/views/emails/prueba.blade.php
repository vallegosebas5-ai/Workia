<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Prueba técnica</title>
<style>body{font-family:'Segoe UI',sans-serif;background:#f3f4f6;margin:0;padding:20px}.container{background:#fff;max-width:560px;margin:0 auto;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08)}.header{background:linear-gradient(135deg,#ff5a1f,#d97706);padding:32px 40px;text-align:center;color:#fff}.header h1{margin:0;font-size:22px;font-weight:800}.body{padding:32px 40px;color:#374151;line-height:1.7}.info-box{background:#fff7ed;border:1px solid #fed7aa;border-radius:8px;padding:16px 20px;margin:20px 0}.btn{display:inline-block;background:#1a56db;color:#fff;padding:14px 32px;border-radius:8px;text-decoration:none;font-weight:700;font-size:1rem;margin:20px 0}.footer{background:#f9fafb;padding:20px 40px;text-align:center;font-size:.8rem;color:#9ca3af;border-top:1px solid #e5e7eb}</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>📋 Prueba técnica</h1>
        <p style="margin:6px 0 0;opacity:.9;font-size:.95rem">Completa tu evaluación para continuar el proceso</p>
    </div>
    <div class="body">
        <p>Hola <strong>{{ $postulacion->candidato->name }}</strong>,</p>
        <p>Como parte del proceso de selección para el puesto de <strong>{{ $postulacion->oferta->titulo }}</strong> en <strong>{{ $postulacion->oferta->empresa->razon_social }}</strong>, debes completar la siguiente prueba técnica:</p>

        <div class="info-box">
            <p><strong>📌 Prueba:</strong> {{ $prueba->titulo }}</p>
            @if($prueba->descripcion)<p><strong>📝 Instrucciones:</strong> {{ $prueba->descripcion }}</p>@endif
            <p><strong>⏱ Duración estimada:</strong> {{ $prueba->duracion_minutos }} minutos</p>
        </div>

        <div style="text-align:center">
            <a href="{{ $prueba->url_formulario }}" class="btn">Acceder a la prueba</a>
        </div>

        <p style="font-size:.875rem;color:#6b7280">Si el botón no funciona, copia y pega este enlace en tu navegador:<br>
        <a href="{{ $prueba->url_formulario }}" style="color:#1a56db">{{ $prueba->url_formulario }}</a></p>

        <p>Completa la prueba antes de la fecha indicada por la empresa. ¡Mucho éxito!</p>
        <p style="margin-top:20px">Equipo <strong>Workia Bolivia</strong></p>
    </div>
    <div class="footer">© {{ date('Y') }} Workia Bolivia · Este es un correo automático</div>
</div>
</body>
</html>
