<?php

use App\Http\Controllers\Admin\DashboardController as AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Candidato\DashboardController as CandidatoController;
use App\Http\Controllers\Empresa\DashboardController as EmpresaController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Servir archivos de storage (fix junction XAMPP/Windows)
Route::get('/storage/{path}', function (string $path) {
    $fullPath = storage_path('app/public/' . $path);
    abort_unless(file_exists($fullPath), 404);
    return response()->file($fullPath);
})->where('path', '.+')->name('storage.serve');

// Rutas públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/empleos', [HomeController::class, 'ofertas'])->name('ofertas.index');
Route::get('/empleos/{oferta}', [HomeController::class, 'oferta'])->name('ofertas.show');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

// Panel Candidato
Route::middleware(['auth', 'role:candidato'])->prefix('candidato')->name('candidato.')->group(function () {
    Route::get('/dashboard', [CandidatoController::class, 'index'])->name('dashboard');
    Route::get('/perfil', [CandidatoController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [CandidatoController::class, 'actualizarPerfil'])->name('perfil.actualizar');
    Route::get('/postulaciones', [CandidatoController::class, 'misPostulaciones'])->name('postulaciones');
    Route::post('/postular/{oferta}', [CandidatoController::class, 'postular'])->name('postular');
});

// Panel Empresa
Route::middleware(['auth', 'role:empresa'])->prefix('empresa')->name('empresa.')->group(function () {
    Route::get('/dashboard', [EmpresaController::class, 'index'])->name('dashboard');
    Route::get('/perfil', [EmpresaController::class, 'perfil'])->name('perfil');
    Route::get('/completar-perfil', [EmpresaController::class, 'completarPerfil'])->name('completar-perfil');
    Route::post('/perfil', [EmpresaController::class, 'guardarPerfil'])->name('perfil.guardar');
    Route::get('/ofertas', [EmpresaController::class, 'ofertas'])->name('ofertas');
    Route::get('/ofertas/crear', [EmpresaController::class, 'crearOferta'])->name('ofertas.crear');
    Route::post('/ofertas', [EmpresaController::class, 'guardarOferta'])->name('ofertas.guardar');
    Route::get('/ofertas/{oferta}/editar', [EmpresaController::class, 'editarOferta'])->name('ofertas.editar');
    Route::put('/ofertas/{oferta}', [EmpresaController::class, 'actualizarOferta'])->name('ofertas.actualizar');
    Route::delete('/ofertas/{oferta}', [EmpresaController::class, 'eliminarOferta'])->name('ofertas.eliminar');
    Route::get('/ofertas/{oferta}/postulantes', [EmpresaController::class, 'postulantes'])->name('postulantes');
    Route::put('/postulaciones/{postulacion}/estado', [EmpresaController::class, 'actualizarEstado'])->name('postulaciones.estado');
    Route::get('/ofertas/{oferta}/pdf', [EmpresaController::class, 'exportarPDF'])->name('ofertas.pdf');
    Route::get('/ofertas/{oferta}/prueba', [EmpresaController::class, 'gestionarPrueba'])->name('prueba');
    Route::post('/ofertas/{oferta}/prueba', [EmpresaController::class, 'guardarPrueba'])->name('prueba.guardar');
    Route::get('/postulaciones/{postulacion}/cv', [EmpresaController::class, 'verCV'])->name('postulaciones.cv');
});

// Panel Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');
    Route::put('/usuarios/{user}/toggle', [AdminController::class, 'toggleUsuario'])->name('usuarios.toggle');
    Route::delete('/usuarios/{user}', [AdminController::class, 'eliminarUsuario'])->name('usuarios.eliminar');
    Route::get('/ofertas', [AdminController::class, 'ofertas'])->name('ofertas');
    Route::put('/ofertas/{oferta}/toggle', [AdminController::class, 'toggleOferta'])->name('ofertas.toggle');
    Route::delete('/ofertas/{oferta}', [AdminController::class, 'eliminarOferta'])->name('ofertas.eliminar');
    Route::get('/empresas', [AdminController::class, 'empresas'])->name('empresas');
    Route::put('/empresas/{empresa}/verificar', [AdminController::class, 'verificarEmpresa'])->name('empresas.verificar');
    Route::get('/categorias', [AdminController::class, 'categorias'])->name('categorias');
    Route::post('/categorias', [AdminController::class, 'guardarCategoria'])->name('categorias.guardar');
    Route::put('/categorias/{categoria}', [AdminController::class, 'editarCategoria'])->name('categorias.editar');
    Route::delete('/categorias/{categoria}', [AdminController::class, 'eliminarCategoria'])->name('categorias.eliminar');
});
