<?php

namespace App\Http\Controllers\Candidato;

use App\Http\Controllers\Controller;
use App\Models\PerfilCandidato;
use App\Models\Postulacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $perfil = $user->perfil ?? PerfilCandidato::create(['user_id' => $user->id]);
        $postulaciones = Postulacion::with('oferta.empresa')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);
        return view('candidato.dashboard', compact('perfil', 'postulaciones'));
    }

    public function perfil()
    {
        $perfil = auth()->user()->perfil ?? PerfilCandidato::create(['user_id' => auth()->id()]);
        return view('candidato.perfil', compact('perfil'));
    }

    public function actualizarPerfil(Request $request)
    {
        $request->validate([
            'fecha_nacimiento' => ['nullable', 'date'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'ciudad' => ['nullable', 'string', 'max:100'],
            'resumen_profesional' => ['nullable', 'string'],
            'nivel_educacion' => ['nullable', 'string', 'max:100'],
            'carrera' => ['nullable', 'string', 'max:150'],
            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        $perfil = auth()->user()->perfil ?? PerfilCandidato::create(['user_id' => auth()->id()]);
        $data = $request->only(['fecha_nacimiento', 'direccion', 'ciudad', 'resumen_profesional', 'nivel_educacion', 'carrera']);

        if ($request->hasFile('cv')) {
            if ($perfil->cv) Storage::disk('public')->delete($perfil->cv);
            $data['cv'] = $request->file('cv')->store('cvs', 'public');
        }
        if ($request->hasFile('foto')) {
            if ($perfil->foto) Storage::disk('public')->delete($perfil->foto);
            $data['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        $perfil->update($data);
        auth()->user()->update(['ciudad' => $request->ciudad]);

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function postular(Request $request, \App\Models\Oferta $oferta)
    {
        if (!auth()->user()->isCandidato()) abort(403);
        if ($oferta->estado !== 'activa') return back()->with('error', 'Esta oferta ya no está disponible.');

        $existe = Postulacion::where('oferta_id', $oferta->id)->where('user_id', auth()->id())->exists();
        if ($existe) return back()->with('error', 'Ya te postulaste a esta oferta.');

        $request->validate([
            'carta_presentacion' => ['nullable', 'string'],
            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $data = [
            'oferta_id' => $oferta->id,
            'user_id' => auth()->id(),
            'carta_presentacion' => $request->carta_presentacion,
        ];

        if ($request->hasFile('cv')) {
            $data['cv'] = $request->file('cv')->store('cvs_postulaciones', 'public');
        } else {
            $perfil = auth()->user()->perfil;
            $data['cv'] = $perfil?->cv;
        }

        $postulacion = Postulacion::create($data);

        return redirect()->route('candidato.dashboard')->with('success', '¡Postulación enviada exitosamente!');
    }

    public function misPostulaciones()
    {
        $postulaciones = Postulacion::with('oferta.empresa', 'oferta.categoria')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(15);
        return view('candidato.postulaciones', compact('postulaciones'));
    }
}
