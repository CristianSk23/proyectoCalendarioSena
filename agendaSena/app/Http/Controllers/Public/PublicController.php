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



    public function store(Request $request)
{
    // Validación de los datos
    $validated = $request->validate([
        'par_identificacion' => 'required',
        'pla_amb_id' => 'required',
        'horarioEventoInicio' => 'required|date_format:H:i',
        'horarioEventoFin' => 'required|date_format:H:i',
        'nomEvento' => 'required|min:5|max:100',
        'descripcion' => 'required|min:10|max:500',
        'fechaEvento' => 'required|date|after_or_equal:today',
        'aforoEvento' => 'required|integer|min:1|max:500',
        'idFicha' => 'required',
        'idCategoria' => 'required',
        'publicidad' => 'nullable|image|max:2048',
    ]);

    // Crear el evento en la base de datos
    $evento = new Evento();
    $evento->par_identificacion = $request->par_identificacion;
    $evento->pla_amb_id = $request->pla_amb_id;
    $evento->horarioEventoInicio = $request->horarioEventoInicio;
    $evento->horarioEventoFin = $request->horarioEventoFin;
    $evento->nomEvento = $request->nomEvento;
    $evento->descripcion = $request->descripcion;
    $evento->fechaEvento = $request->fechaEvento;
    $evento->aforoEvento = $request->aforoEvento;
    $evento->idFicha = $request->idFicha;
    $evento->idCategoria = $request->idCategoria;
    $evento->estadoEvento = 2; // Se puede dejar como "Separado" por defecto o ajustarlo según sea necesario

    // Subir la imagen de publicidad si se ha seleccionado una
    if ($request->hasFile('publicidad')) {
        $publicidadPath = $request->file('publicidad')->store('publicidad_eventos', 'public');
        $evento->publicidad = $publicidadPath;
    }

    // Guardar el evento en la base de datos
    $evento->save();

    return redirect()->route('evento.solicitud')->with('success', 'Evento creado con éxito');
}


}