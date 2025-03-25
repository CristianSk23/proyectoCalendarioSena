<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Evento\Evento; // Importa el modelo Evento
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        // Obtener todos los eventos públicos (estadoEvento = 1)
        $eventos = Evento::where('estadoEvento', 1)->get();

        // Pasar los datos a la vista
        return view('public.index', compact('eventos'));
    }

    // public function show($id)
    // {
    //     // Obtener un evento específico
    //     $evento = Evento::findOrFail($id);

    //     // Pasar los datos a la vista
    //     return view('public.show', compact('evento'));
    // }

    public function showEventos()
{
    // Obtener los eventos desde la base de datos
    $eventos = Evento::all();  // O ajusta la consulta según lo que necesites

    return view('eventos', compact('eventos'));
}


}