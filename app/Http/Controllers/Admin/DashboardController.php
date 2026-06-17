<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\Oferta;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsuarios = User::count();
        $totalEmpresas = Empresa::count();
        $totalOfertas = Oferta::count();
        $ofertasActivas = Oferta::where('estado', 'activa')->count();
        $usuariosRecientes = User::latest()->take(5)->get();
        $ofertasRecientes = Oferta::with('empresa')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsuarios', 'totalEmpresas', 'totalOfertas', 'ofertasActivas',
            'usuariosRecientes', 'ofertasRecientes'
        ));
    }

    public function usuarios(Request $request)
    {
        $query = User::query();
        if ($request->rol) $query->where('role', $request->rol);
        if ($request->buscar) $query->where('name', 'like', '%' . $request->buscar . '%')
            ->orWhere('email', 'like', '%' . $request->buscar . '%');
        $usuarios = $query->latest()->paginate(20);
        return view('admin.usuarios', compact('usuarios'));
    }

    public function toggleUsuario(User $user)
    {
        if ($user->isAdmin()) return back()->with('error', 'No se puede desactivar al administrador.');
        $user->update(['activo' => !$user->activo]);
        return back()->with('success', 'Estado del usuario actualizado.');
    }

    public function eliminarUsuario(User $user)
    {
        if ($user->isAdmin()) return back()->with('error', 'No se puede eliminar al administrador.');
        $user->delete();
        return back()->with('success', 'Usuario eliminado.');
    }

    public function ofertas(Request $request)
    {
        $query = Oferta::with('empresa', 'categoria');
        if ($request->estado) $query->where('estado', $request->estado);
        $ofertas = $query->latest()->paginate(20);
        return view('admin.ofertas', compact('ofertas'));
    }

    public function toggleOferta(Oferta $oferta)
    {
        $nuevoEstado = $oferta->estado === 'activa' ? 'pausada' : 'activa';
        $oferta->update(['estado' => $nuevoEstado]);
        return back()->with('success', 'Estado de la oferta actualizado.');
    }

    public function eliminarOferta(Oferta $oferta)
    {
        $oferta->delete();
        return back()->with('success', 'Oferta eliminada.');
    }

    public function empresas(Request $request)
    {
        $empresas = Empresa::with('user')->withCount('ofertas')->latest()->paginate(20);
        return view('admin.empresas', compact('empresas'));
    }

    public function verificarEmpresa(Empresa $empresa)
    {
        $empresa->update(['verificada' => !$empresa->verificada]);
        return back()->with('success', 'Estado de verificación actualizado.');
    }

    public function categorias()
    {
        $categorias = Categoria::withCount('ofertas')->get();
        return view('admin.categorias', compact('categorias'));
    }

    public function guardarCategoria(Request $request)
    {
        $request->validate(['nombre' => ['required', 'string', 'max:100'], 'icono' => ['nullable', 'string', 'max:50']]);
        Categoria::create($request->only(['nombre', 'icono']));
        return back()->with('success', 'Categoría creada.');
    }

    public function editarCategoria(Request $request, Categoria $categoria)
    {
        $request->validate(['nombre' => ['required', 'string', 'max:100'], 'icono' => ['nullable', 'string', 'max:50']]);
        $categoria->update($request->only(['nombre', 'icono', 'activo']));
        return back()->with('success', 'Categoría actualizada.');
    }

    public function eliminarCategoria(Categoria $categoria)
    {
        if ($categoria->ofertas()->count() > 0) return back()->with('error', 'No se puede eliminar, tiene ofertas asociadas.');
        $categoria->delete();
        return back()->with('success', 'Categoría eliminada.');
    }
}
