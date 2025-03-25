<?php

namespace App\Http\Controllers\Login;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    // Muestra la vista del login
    public function index() 
    {
        return view('login.iniciar'); // Asegúrate de que la vista existe en "resources/views/login/iniciar.blade.php"
    }

    // Procesa el inicio de sesión
    public function login(Request $request)
    {
        $request->validate([
            'documento' => 'required',
            'password' => 'required',
        ]);
        
        $user = User::where('par_identificacion', $request->documento)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['mensaje' => 'Identificación o contraseña incorrecta']);
        }

        Auth::login($user);

        return redirect()->route('dashboard'); // Asegúrate de que esta ruta existe
    }

    // Cierra la sesión
    public function logout()
    {
        Auth::logout();

        // Invalidar la sesión y regenerar el token CSRF
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sesión cerrada exitosamente.');
    }
}
