<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\PerfilCandidato;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()],
            'role' => ['required', 'in:candidato,empresa'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'ciudad' => ['nullable', 'string', 'max:100'],
            'razon_social' => ['required_if:role,empresa', 'nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'telefono' => $request->telefono,
            'ciudad' => $request->ciudad,
        ]);

        if ($request->role === 'empresa') {
            Empresa::create([
                'user_id' => $user->id,
                'razon_social' => $request->razon_social,
                'ciudad' => $request->ciudad,
                'telefono' => $request->telefono,
            ]);
        } else {
            PerfilCandidato::create(['user_id' => $user->id]);
        }

        Auth::login($user);

        return redirect()->route($user->role . '.dashboard');
    }
}
