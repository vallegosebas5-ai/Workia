<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\Oferta;
use App\Models\Postulacion;
use App\Models\Prueba;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    private function empresa()
    {
        return auth()->user()->empresa;
    }

    public function index()
    {
        $empresa = $this->empresa();
        if (!$empresa) return redirect()->route('empresa.completar-perfil');

        $totalOfertas = $empresa->ofertas()->count();
        $ofertasActivas = $empresa->ofertas()->where('estado', 'activa')->count();
        $totalPostulantes = Postulacion::whereHas('oferta', fn($q) => $q->where('empresa_id', $empresa->id))->count();
        $nuevasPostulaciones = Postulacion::whereHas('oferta', fn($q) => $q->where('empresa_id', $empresa->id))
            ->where('estado', 'pendiente')->count();

        $ofertas = $empresa->ofertas()->with('categoria')->withCount('postulaciones')->latest()->take(5)->get();

        return view('empresa.dashboard', compact('empresa', 'totalOfertas', 'ofertasActivas', 'totalPostulantes', 'nuevasPostulaciones', 'ofertas'));
    }

    public function perfil()
    {
        $empresa = $this->empresa() ?? new Empresa(['user_id' => auth()->id()]);
        return view('empresa.perfil', compact('empresa'));
    }

    public function completarPerfil()
    {
        return view('empresa.completar-perfil');
    }

    public function guardarPerfil(Request $request)
    {
        $request->validate([
            'razon_social' => ['required', 'string', 'max:255'],
            'nit' => ['nullable', 'string', 'max:30'],
            'rubro' => ['nullable', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'ciudad' => ['nullable', 'string', 'max:100'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'sitio_web' => ['nullable', 'url'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $empresa = $this->empresa() ?? new Empresa(['user_id' => auth()->id()]);
        $data = $request->only(['razon_social', 'nit', 'rubro', 'descripcion', 'ciudad', 'direccion', 'sitio_web']);

        if ($request->hasFile('logo')) {
            if ($empresa->logo) Storage::disk('public')->delete($empresa->logo);
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $empresa->fill($data)->save();
        return redirect()->route('empresa.dashboard')->with('success', 'Perfil actualizado.');
    }

    public function ofertas()
    {
        $empresa = $this->empresa();
        $ofertas = $empresa->ofertas()->with('categoria')->withCount('postulaciones')->latest()->paginate(15);
        return view('empresa.ofertas.index', compact('empresa', 'ofertas'));
    }

    public function crearOferta()
    {
        $categorias = Categoria::where('activo', true)->get();
        return view('empresa.ofertas.crear', compact('categorias'));
    }

    public function guardarOferta(Request $request)
    {
        $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'descripcion' => ['required', 'string'],
            'requisitos' => ['nullable', 'string'],
            'ubicacion' => ['nullable', 'string', 'max:150'],
            'salario_min' => ['nullable', 'numeric', 'min:0'],
            'salario_max' => ['nullable', 'numeric', 'min:0'],
            'tipo_contrato' => ['required'],
            'modalidad' => ['required'],
            'fecha_limite' => ['nullable', 'date', 'after:today'],
            'vacantes' => ['required', 'integer', 'min:1'],
        ]);

        $empresa = $this->empresa();
        $empresa->ofertas()->create($request->only([
            'titulo', 'categoria_id', 'descripcion', 'requisitos', 'ubicacion',
            'salario_min', 'salario_max', 'tipo_contrato', 'modalidad',
            'fecha_limite', 'vacantes', 'requiere_cv',
        ]));

        return redirect()->route('empresa.ofertas')->with('success', 'Oferta publicada correctamente.');
    }

    public function editarOferta(Oferta $oferta)
    {
        $this->autorizarOferta($oferta);
        $categorias = Categoria::where('activo', true)->get();
        return view('empresa.ofertas.editar', compact('oferta', 'categorias'));
    }

    public function actualizarOferta(Request $request, Oferta $oferta)
    {
        $this->autorizarOferta($oferta);
        $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'descripcion' => ['required', 'string'],
            'tipo_contrato' => ['required'],
            'modalidad' => ['required'],
            'vacantes' => ['required', 'integer', 'min:1'],
        ]);

        $oferta->update($request->only([
            'titulo', 'categoria_id', 'descripcion', 'requisitos', 'ubicacion',
            'salario_min', 'salario_max', 'tipo_contrato', 'modalidad',
            'fecha_limite', 'vacantes', 'estado', 'requiere_cv',
        ]));

        return redirect()->route('empresa.ofertas')->with('success', 'Oferta actualizada.');
    }

    public function eliminarOferta(Oferta $oferta)
    {
        $this->autorizarOferta($oferta);
        $oferta->delete();
        return back()->with('success', 'Oferta eliminada.');
    }

    public function postulantes(Oferta $oferta)
    {
        $this->autorizarOferta($oferta);
        $postulaciones = $oferta->postulaciones()->with('candidato.perfil')->latest()->paginate(20);
        return view('empresa.postulantes', compact('oferta', 'postulaciones'));
    }

    public function actualizarEstado(Request $request, Postulacion $postulacion)
    {
        $this->autorizarOferta($postulacion->oferta);
        $request->validate([
            'estado' => ['required', 'in:pendiente,revision,prueba,entrevista,aceptado,rechazado'],
            'observaciones' => ['nullable', 'string'],
            'nota_prueba' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'fecha_entrevista' => ['nullable', 'date'],
        ]);

        $postulacion->update($request->only(['estado', 'observaciones', 'nota_prueba', 'fecha_entrevista']));

        if ($request->estado === 'entrevista' && $request->fecha_entrevista) {
            $this->enviarCorreoEntrevista($postulacion);
        }

        if ($request->estado === 'prueba') {
            $this->enviarEnlacePrueba($postulacion);
        }

        return back()->with('success', 'Estado actualizado.');
    }

    public function exportarPDF(Oferta $oferta)
    {
        $this->autorizarOferta($oferta);
        $postulaciones = $oferta->postulaciones()->with('candidato.perfil')->get();
        $pdf = Pdf::loadView('empresa.pdf.postulantes', compact('oferta', 'postulaciones'));
        return $pdf->download('postulantes-' . $oferta->id . '.pdf');
    }

    public function gestionarPrueba(Oferta $oferta)
    {
        $this->autorizarOferta($oferta);
        $prueba = $oferta->prueba;
        return view('empresa.prueba', compact('oferta', 'prueba'));
    }

    public function guardarPrueba(Request $request, Oferta $oferta)
    {
        $this->autorizarOferta($oferta);
        $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'url_formulario' => ['required', 'url'],
            'duracion_minutos' => ['required', 'integer', 'min:5'],
        ]);

        $oferta->prueba()->updateOrCreate(
            ['oferta_id' => $oferta->id],
            $request->only(['titulo', 'descripcion', 'url_formulario', 'duracion_minutos', 'activa'])
        );

        return back()->with('success', 'Prueba guardada.');
    }

    public function verCV(Postulacion $postulacion)
    {
        $this->autorizarOferta($postulacion->oferta);

        $cvPath = $postulacion->cv ?? $postulacion->candidato->perfil?->cv;

        abort_unless($cvPath, 404);

        $fullPath = storage_path('app/public/' . $cvPath);

        abort_unless(file_exists($fullPath), 404);

        return response()->file($fullPath, ['Content-Type' => 'application/pdf']);
    }

    private function autorizarOferta(Oferta $oferta)
    {
        if ($oferta->empresa_id !== $this->empresa()?->id) abort(403);
    }

    private function enviarCorreoEntrevista(Postulacion $postulacion)
    {
        try {
            Mail::send('emails.entrevista', ['postulacion' => $postulacion], function ($m) use ($postulacion) {
                $m->to($postulacion->candidato->email, $postulacion->candidato->name)
                  ->subject('Confirmación de entrevista - ' . $postulacion->oferta->titulo);
            });
        } catch (\Exception $e) {
            // El correo falla silenciosamente en desarrollo
        }
    }

    private function enviarEnlacePrueba(Postulacion $postulacion)
    {
        $prueba = $postulacion->oferta->prueba;
        if (!$prueba) return;
        try {
            Mail::send('emails.prueba', ['postulacion' => $postulacion, 'prueba' => $prueba], function ($m) use ($postulacion) {
                $m->to($postulacion->candidato->email, $postulacion->candidato->name)
                  ->subject('Prueba técnica - ' . $postulacion->oferta->titulo);
            });
        } catch (\Exception $e) {}
    }
}
