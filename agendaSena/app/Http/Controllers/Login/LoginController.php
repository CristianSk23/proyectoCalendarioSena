<?php

namespace App\Http\Controllers\Login;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Credenciales para la autenticación
        $credentials = [
            'par_correo' => $request->email,
            'password' => $request->password, // Laravel automáticamente verificará el hash de la contraseña
        ];

        // Intentar iniciar sesión
        if (Auth::attempt($credentials)) {
            // Autenticación exitosa
            return redirect()->intended('/'); // Redirigir al usuario
        }

        // Si la autenticación falla
        return back()->withErrors(['error' => 'Credenciales incorrectas']);
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
        return redirect('login')->with('success', 'Sesión cerrada exitosamente.');
    }
    public function create() {}

    public function store(Request $request) {}

    public function edit() {}

    public function update(Request $request) {}

    public function destroy() {}
}
