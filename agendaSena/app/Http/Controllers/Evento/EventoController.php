<?php

namespace App\Http\Controllers\Evento;

use App\Http\Controllers\Controller;
use App\Models\Ambiente\Ambiente;
use App\Models\Evento\Evento;
use App\Models\Categoria\Categoria;
use App\Models\Ficha\Ficha;
use App\Models\Horario\Horario;
use App\Models\Participante\Participante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\CalendarTrait;
use Carbon\Carbon;


class EventoController extends Controller
{
    use CalendarTrait;
    public function index()
    {
        // Carga eventos nuevos 
        $eventos = Evento::with(['categoria', 'horario', 'ambiente', 'participante', 'ficha'])
            ->where('estadoEvento', 1) // Filtrar solo los eventos con estado 1
            ->get();
        return view('Evento.inicioEvento', compact('eventos'));
    }

    public function create(Request $request)
    {
        // Cargar categorías y fichas para el formulario
        $calendario = $this->calendarioGenerado();
        $categorias = Categoria::all();
        $fichas = Ficha::all();
        $participantes = Participante::where('est_apr_id',  2)->select('par_identificacion', 'par_nombres')->paginate(10);
        $ambientes = Ambiente::all();

        return view('Evento.crearEvento', compact('categorias', 'fichas', 'calendario', 'participantes', 'ambientes'));
    }

    public function store(Request $request)
    {
        try {
            // Validar los datos enviados al controlador usando la función privada
            $validatedData = $this->validateRequest($request);

            //* Guardar la imagen en el sistema de archivos si se proporciona
            if ($request->hasFile('publicidad')) {
                $rutaImagen = $request->file('publicidad')->store('imagenes', 'public');
                $validatedData['publicidad'] = $rutaImagen; // Agregar la ruta de la imagen a los datos validados
            }

            // Buscar al participante
            $participante = Participante::where('par_identificacion', $request->par_identificacion)->first();

            if (!$participante) {
                return redirect()->back()->with('error', 'Participante no encontrado.');
            }

            // Agregar el nombre del participante a los datos validados
            $validatedData['nomSolicitante'] = $participante->par_nombres;

            // Crear el horario
            $horario = Horario::create([
                'pla_amb_id' => $request->pla_amb_id,
                'inicio' => $request->horarioEventoInicio,
                'fin' => $request->horarioEventoFin,
            ]);

            if (!$horario) {
                return redirect()->back()->with('error', 'Error al crear el horario.');
            }

            // Agregar el ID del horario a los datos validados
            $validatedData['idHorario'] = $horario->idHora;

            // Crear el evento utilizando los datos validados
            Evento::create([
                'par_identificacion' => $validatedData['par_identificacion'],
                'pla_amb_id' => $validatedData['pla_amb_id'],
                'idHorario' => $validatedData['idHorario'],
                'nomEvento' => $validatedData['nomEvento'],
                'descripcion' => $validatedData['descripcion'],
                'fechaEvento' => $validatedData['fechaEvento'],
                'aforoEvento' => $validatedData['aforoEvento'],
                'fic_numero' => $validatedData['fic_numero'],
                'idCategoria' => $validatedData['idCategoria'],
                'publicidad' => $validatedData['publicidad'] ?? null, // Usar null si no se proporciona una imagen
                'estadoEvento' => $validatedData['estadoEvento'],
                'nomSolicitante' => $validatedData['nomSolicitante'], // Agregado desde la búsqueda del participante
            ]);

            // Redirigir con un mensaje de éxito
            return redirect()->route('calendario.index')->with('success', 'Evento creado exitosamente.');
        } catch (\Exception $e) {
            // Registrar el error en los logs y devolver un mensaje
            return redirect()->back()->with('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }


    public function edit(Request $request)
    {
        // Cargar categorías y fichas para el formulario de edición
        $calendario = $this->calendarioGenerado();
        $idEvento = $request->__get('idEvento');
        //*BUSCO EL EVENTO CON EL ID QUE SE ENVÍA DEL FRONTEND
        $evento = Evento::where('idEvento', $idEvento)->first();
        $fechaEvento = $evento->fechaEvento;
        $timestamp = strtotime($fechaEvento);
        $fechaArray = getdate($timestamp);
        //*OBTENER LOS DATOS DE LA FECHA INDIVIDUALMENTE
        $dia = $fechaArray['mday']; // Día
        $mes = $fechaArray['mon']; // Mes
        $anio = $fechaArray['year']; // Año

        $fecha = sprintf('%04d-%02d-%02d', $anio, $mes, $dia);
        $categorias = Categoria::all();
        //*BUSCO LOS PARTICIPANTES
        $participantes = Participante::where('est_apr_id',  2)->select('par_identificacion', 'par_nombres')->paginate(10);
        $fichas = Ficha::all();

        $idHorario = $evento->idHorario;
        $horario = Horario::find($idHorario);
        $inicioEvento = $horario->inicio;
        $finalEvento = $horario->fin;
        if ($evento) {
            return view('Evento.crearEvento', compact('evento', 'categorias', 'fichas', 'participantes', 'dia', 'mes', 'anio', 'fecha', 'calendario', 'inicioEvento', 'finalEvento'));
        }
    }

    public function update(Request $request, Evento $evento)
    {
        $validatedData = $this->validateRequest($request);
        $idEvento = $request->__get('idEvento');
        $participante = Participante::where('par_identificacion', $request->par_identificacion)->first();
        $validatedData['nomSolicitante'] = $participante->par_nombres;
        $evento = Evento::findOrFail($idEvento);

        if ($request->hasFile('publicidad')) {
            $rutaImagen = $request->file('publicidad')->store('imagenes', 'public');
            $validatedData['publicidad'] = $rutaImagen; // Agregar la ruta de la imagen a los datos validados
        }

        $horario = Horario::find($evento->idHorario);
        if (!$horario) {
            return redirect()->back()->with('error', 'Error al crear el horario.');
        }

        $horario->update([
            'inicio' => $request->input('horarioEventoInicio'),
            'fin' => $request->input('horarioEventoFin'),
        ]);

        // Actualizar el evento
        $evento->update($validatedData);

        if (!$participante) {
            return redirect()->back()->with('error', 'Participante no encontrado.');
        }
        $evento->update($validatedData);
        return redirect()->route('calendario.index')->with('success', 'Evento actualizado exitosamente.');
    }

    public function buscarEventos(Request $request)
    {

        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        // Construir la fecha en formato YYYY-MM-DD
        $fecha = sprintf('%04d-%02d-%02d', $anio, $mes, $dia);

        // Buscar eventos para la fecha específica
        try {
            $eventos = Evento::whereDate('fechaEvento', $fecha)
            ->where('estadoEvento', "<>", 0)
            ->get();
            $resultados = [];
            foreach ($eventos as $evento) {
                $idAmbiente = $evento->pla_amb_id;
                $idHorario = $evento->idHorario;
                $idCategoria = $evento->idCategoria;
                $idEncargado = $evento->par_identificacion;


                $ambiente = Ambiente::find($idAmbiente); // Busca por clave primaria
                $horario = Horario::find($idHorario);
                $categoria = Categoria::find($idCategoria);
                $encargado = Participante::find($idEncargado);

                $resultados[] = [
                    'evento' => $evento,
                    'ambiente' => $ambiente,
                    'horario' => $horario,
                    'categoria' => $categoria,
                    'encargado' => $encargado
                ];
            };

            return response()->json([
                'success' => true,
                'data' => $resultados,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al buscar los eventos.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function buscarEventosPorNombre(Request $request)
    {
        $nombre = $request->input('nombre');
        try {
            if ($nombre) {
                // Búsqueda insensible a mayúsculas/minúsculas
                $eventos = Evento::whereRaw('LOWER(nomEvento) LIKE LOWER(?)', ['%' . $nombre . '%'])
                    ->where('estadoEvento', "<>", 2)
                    ->where('estadoEvento', "<>", 0)
                    ->paginate(10);



                $resultados = [];
                foreach ($eventos as $evento) {
                    $idAmbiente = $evento->pla_amb_id;
                    $idHorario = $evento->idHorario;
                    $idCategoria = $evento->idCategoria;
                    $idEncargado = $evento->par_identificacion;


                    $ambiente = Ambiente::find($idAmbiente); // Busca por clave primaria
                    $horario = Horario::find($idHorario);
                    $categoria = Categoria::find($idCategoria);
                    $encargado = Participante::find($idEncargado);

                    $resultados[] = [
                        'evento' => $evento,
                        'ambiente' => $ambiente,
                        'horario' => $horario,
                        'categoria' => $categoria,
                        'encargado' => $encargado
                    ];
                };

                /*     $horario = Horario::find($idHorario); */

                return response()->json([
                    'evento' => $resultados
                ]);
            }

            return response()->json([
                'evento' => null
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al buscar el evento.',
            ], 500);
        }
    }



    public function cargarParticipantes(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = 10;

        $participantes = Participante::where('est_apr_id', 2)
            ->select('par_identificacion', 'par_nombres')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'items' => $participantes->items(),
            'more' => $participantes->hasMorePages()
        ]);
    }

    public function eventosPorConfirmar()
    {
        $eventos = Evento::where('estadoEvento', 2)->get(); //* Filtrar solo los eventos con estado 2 SERIA EL ESTADO POR CONFIRMAR
        $cantidadEventos = count($eventos);
        if ($cantidadEventos > 0) {
            # code...
            foreach ($eventos as $evento) {
                $idAmbiente = $evento->pla_amb_id;
                $idHorario = $evento->idHorario;
               
                $ambiente = Ambiente::find($idAmbiente); // Busca por clave primaria
                $horario = Horario::find($idHorario);
               
            };
            return response()->json([
                'eventos' => $eventos,
                'ambiente' => $ambiente,
                'horario' => $horario,
                'cantidadEventos' => $cantidadEventos
            ]);
        }
        return response()->json([
            'eventos' => null,
            'cantidadEventos' => $cantidadEventos
        ]);
    }


    public function confirmarEvento(Request $request)
    {
        $idEvento = $request->input('idEvento');
        //log::info($idEvento);
        $evento = Evento::find($idEvento);

        if ($evento) {
            $evento->estadoEvento = 1; // Cambiar el estado a confirmado
            $evento->save();

            return response()->json(['success' => true, 'message' => 'Evento confirmado exitosamente.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Evento no encontrado.']);
        }
    }

    public function confirmarEventoPorFecha()
    {
        $fechaActual = Carbon::now()->format('Y-m-d');

        // Obtener los eventos que cumplen con la condición
        $eventos = Evento::where("fechaEvento", "<", $fechaActual)->get(); // Cambié a get()

        // Loguear la cantidad de eventos encontrados
        log::info("Eventos encontrados que se realizaron: " . $eventos->count());

        if ($eventos->isNotEmpty()) { // Verificar si hay eventos
            foreach ($eventos as $evento) {
                $evento->estadoEvento = 3; // Cambiar el estado a confirmado
                $evento->save();
            }

            return response()->json(['success' => true, 'message' => 'Eventos confirmados exitosamente.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Evento no encontrado.']);
        }
    }


    public function delete(Request $request)
    {
        $idEvento = $request->__get('idEvento');


        $eventoEncontrado = Evento::find($idEvento);

        if ($eventoEncontrado) {
            $eventoEncontrado->estadoEvento = false;
            $eventoEncontrado->save();

            return redirect()->route('calendario.index')->with('success', 'Evento eliminado exitosamente.');
        } else {
            return redirect()->route('calendario.index')->with('error', 'No se pudo eliminar el evento.');
        }
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'par_identificacion' => 'required|string|max:30',
            'pla_amb_id' => 'required|integer',
            'idHorario' => 'nullable|integer',
            'nomEvento' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'fechaEvento' => 'required|date',
            'aforoEvento' => 'required|integer',
            'fic_numero' => 'nullable|string|max:20',
            'idCategoria' => 'nullable|integer',
            'publicidad' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estadoEvento' => 'required|integer',
        ]);
    }
}
