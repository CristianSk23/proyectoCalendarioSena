<?php

namespace App\Http\Controllers\Evento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResponsableController extends Controller
{
  
    public function index(Request $request)
    {
        $searchTerm = $request->get('q'); // Obtiene el término de búsqueda
        $responsables = Participante::where('par_nombres', 'LIKE', "%{$searchTerm}%")
            ->orWhere('par_apellidos', 'LIKE', "%{$searchTerm}%")
            ->limit(10) // Limita la cantidad de resultados
            ->get(['par_identificacion', 'par_nombres', 'par_apellidos']); // Selecciona solo los campos necesarios

        return response()->json($responsables);
    }

}
