<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Evento\Evento; // Importa el modelo Evento
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
   
    
    public function index()
    {
        // Obtener todos los eventos públicos (estadoEvento = 1)
        $eventos = Evento::with(['categoria', 'horario', 'ambiente', 'participante', 'ficha'])
            ->where('estadoEvento', 1) // Filtrar solo los eventos con estado 1
            ->get();

        


        // Verificar que los eventos se están cargando correctamente
        if ($eventos->isEmpty()) {
            // // Puedes agregar un mensaje de depuración aquí
            // dd('No hay eventos disponibles con estado 1.');
        }

        return view('public.index', compact('eventos'));
    }


    public function show($id)
    {
        // Obtener un evento específico
        $evento = Evento::with(['categoria', 'horario', 'ambiente', 'participante', 'ficha'])
            ->where('idEvento', $id)
            ->where('estadoEvento', 1)
            ->firstOrFail();

        // Pasar los datos a la vista
        return view('public.show', compact('evento'));
    }








}