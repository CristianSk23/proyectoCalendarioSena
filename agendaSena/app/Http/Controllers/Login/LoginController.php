<?php

namespace App\Http\Controllers\Login;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function index() 
    {
        return view('login.iniciar');
    }

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

        return redirect()->route('calendario.index');
    }


    public function logout()
    {
        Auth::logout();

        
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sesión cerrada exitosamente.');
    }
}
