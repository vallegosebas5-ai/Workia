<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\Oferta;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $categorias = Categoria::withCount(['ofertas' => fn($q) => $q->where('estado', 'activa')])->get();
        $ofertasDestacadas = Oferta::with('empresa', 'categoria')
            ->where('estado', 'activa')
            ->latest()
            ->take(6)
            ->get();
        $totalOfertas   = Oferta::where('estado', 'activa')->count();
        $totalEmpresas  = Empresa::count();
        $totalCandidatos = User::where('role', 'candidato')->count();
        return view('home', compact('categorias', 'ofertasDestacadas', 'totalOfertas', 'totalEmpresas', 'totalCandidatos'));
    }

    public function ofertas()
    {
        $query = Oferta::with('empresa', 'categoria')->where('estado', 'activa');

        if (request('categoria')) {
            $query->where('categoria_id', request('categoria'));
        }
        if (request('ciudad')) {
            $query->where('ubicacion', 'like', '%' . request('ciudad') . '%');
        }
        if (request('salario_min')) {
            $query->where('salario_min', '>=', request('salario_min'));
        }
        if (request('tipo')) {
            $query->where('tipo_contrato', request('tipo'));
        }
        if (request('modalidad')) {
            $query->where('modalidad', request('modalidad'));
        }
        if (request('buscar')) {
            $query->where('titulo', 'like', '%' . request('buscar') . '%');
        }

        $ofertas = $query->latest()->paginate(12)->withQueryString();
        $categorias = Categoria::where('activo', true)->get();
        return view('ofertas.index', compact('ofertas', 'categorias'));
    }

    public function oferta(Oferta $oferta)
    {
        if ($oferta->estado !== 'activa') abort(404);
        $oferta->load('empresa', 'categoria');
        $yaPostulado = false;
        if (auth()->check() && auth()->user()->isCandidato()) {
            $yaPostulado = $oferta->postulaciones()->where('user_id', auth()->id())->exists();
        }
        return view('ofertas.show', compact('oferta', 'yaPostulado'));
    }
}
