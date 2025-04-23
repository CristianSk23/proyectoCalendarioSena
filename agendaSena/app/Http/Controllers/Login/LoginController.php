<?php

namespace App\Http\Controllers\Login;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.Login.login');
    }
    public function login(Request $request)
    {

        // Validar los datos de entrada
        $request->validate([
            'par_identificacion' => 'required|int',
            'password' => 'required|string',
        ]);

        // Credenciales para la autenticación
        $credentials = [
            'par_identificacion' => $request->par_identificacion,
            'password' => $request->password, // Laravel automáticamente verificará el hash de la contraseña
        ];

        // Intentar iniciar sesión
        if (Auth::attempt($credentials)) {
            // Autenticación exitosa
            return redirect()->route('calendario.index')->with('success', 'Inicio de sesión exitoso');
        } else {
            Log::error('Error de inicio de sesión: ' . $request->par_identificacion);
            return redirect()->route('login')->with('error', 'Número de identificación o contraseña incorrectos.');
        } // Si la autenticación falla

    }

    public function logout()
    {
        // Cerrar sesión del usuario
        Auth::logout();

        // Invalidar la sesión actual
        request()->session()->invalidate();

        // Regenerar el token CSRF para mayor seguridad
        request()->session()->regenerateToken();

        // Redirigir al usuario a la página de inicio de sesión u otra página
        return redirect('/')->with('success', 'Sesión cerrada exitosamente.');
    }

    public function username()
    {
        return 'par_identificacion';
    }

    public function create() {}

    public function store(Request $request) {}

    public function edit() {}

    public function update(Request $request) {}

    public function destroy() {}
}
