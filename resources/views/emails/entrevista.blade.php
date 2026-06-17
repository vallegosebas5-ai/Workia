<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Confirmación de entrevista</title>
<style>body{font-family:'Segoe UI',sans-serif;background:#f3f4f6;margin:0;padding:20px}.container{background:#fff;max-width:560px;margin:0 auto;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08)}.header{background:linear-gradient(135deg,#1a56db,#1e40af);padding:32px 40px;text-align:center;color:#fff}.header h1{margin:0;font-size:22px;font-weight:800}.body{padding:32px 40px;color:#374151;line-height:1.7}.body h2{font-size:1.1rem;color:#111;margin-bottom:8px}.info-box{background:#eff6ff;border:1px solid #dbeafe;border-radius:8px;padding:16px 20px;margin:20px 0}.info-box p{margin:4px 0;font-size:.9rem}.footer{background:#f9fafb;padding:20px 40px;text-align:center;font-size:.8rem;color:#9ca3af;border-top:1px solid #e5e7eb}</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🎉 ¡Felicitaciones!</h1>
        <p style="margin:6px 0 0;opacity:.9;font-size:.95rem">Has avanzado al proceso de entrevista</p>
    </div>
    <div class="body">
        <p>Hola <strong>{{ $postulacion->candidato->name }}</strong>,</p>
        <p>Nos complace informarte que has sido seleccionado(a) para una entrevista para el puesto de:</p>
        <h2>{{ $postulacion->oferta->titulo }}</h2>
        <p style="color:#6b7280">en <strong>{{ $postulacion->oferta->empresa->razon_social }}</strong></p>

        @if($postulacion->fecha_entrevista)
        <div class="info-box">
            <p><strong>📅 Fecha y hora:</strong> {{ $postulacion->fecha_entrevista->format('d \d\e F \d\e Y, H:i') }}</p>
            @if($postulacion->observaciones)
            <p><strong>📍 Detalles:</strong> {{ $postulacion->observaciones }}</p>
            @endif
        </div>
        @endif

        <p>Por favor, confirma tu asistencia respondiendo a este correo o contactando directamente a la empresa.</p>
        <p>¡Mucho éxito en tu entrevista!</p>
        <p style="margin-top:20px">Con cariño,<br><strong>Equipo Workia Bolivia</strong></p>
    </div>
    <div class="footer">© {{ date('Y') }} Workia Bolivia · Este es un correo automático</div>
</div>
</body>
</html>
