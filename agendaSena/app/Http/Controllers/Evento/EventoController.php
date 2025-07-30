<?php

namespace App\Http\Controllers\Evento;

use App\Http\Controllers\Controller;
use App\Models\Ambiente\Ambiente;
use App\Models\Evento\Evento;
use App\Models\Categoria\Categoria;
use App\Models\Ficha\Ficha;
use App\Models\Horario\Horario;
use App\Models\Participante\Participante;
use App\Models\fotografiasEvento\fotografiaEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\CalendarTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventoController extends Controller
{
    use CalendarTrait;

    public function create(Request $request)
    {
        // Cargar categorías y fichas para el formulario
        $calendario = $this->calendarioGenerado();
        $categorias = Categoria::all();
        /*  $fichas = Ficha::all(); */
        $participantes = Participante::where('est_apr_id',  2)->select('par_identificacion', 'par_nombres')->paginate(10);
        $ambientes = Ambiente::all();

        return view('Evento.crearEvento', compact('categorias',  'calendario', 'participantes', 'ambientes'));
    }



    public function store(Request $request)
    {
        try {
            // Validar los datos
            $validatedData = $this->validateRequest($request);

            // Guardar la imagen si existe
            if ($request->hasFile('publicidad')) {
                $rutaImagen = $request->file('publicidad')->store('imagenes', 'public');
                $validatedData['publicidad'] = $rutaImagen;
            }

            // Procesar encargados
            $encargadosIds = array_filter(array_map('trim', explode(',', $request->par_identificacion)));

            if (empty($encargadosIds)) {
                return redirect()->back()->with('error', 'Debe seleccionar al menos un encargado.');
            }

            $primerEncargado = Participante::where('par_identificacion', $encargadosIds[0])->first();

            if (!$participante || !password_verify($request->auth_password, $participante->par_password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Credenciales incorrectas.'
                ]);
            }



            if (!$primerEncargado) {
                return redirect()->back()->with('error', 'Participante no encontrado.');
            }

            $validatedData['nomSolicitante'] = $primerEncargado->par_nombres;

            // Crear horario
            $horario = Horario::create([
                'pla_amb_id' => $request->pla_amb_id,
                'inicio' => $request->horarioEventoInicio,
                'fin' => $request->horarioEventoFin,
            ]);

            if (!$horario) {
                return redirect()->back()->with('error', 'Error al crear el horario.');
            }

            $validatedData['idHorario'] = $horario->idHora;


            $fichasRaw = $request->input('fichas');
            $numerosFicha = [];
            $nombresFicha = [];

            if ($fichasRaw) {
                $fichasArray = explode('|', $fichasRaw);

                foreach ($fichasArray as $fichaString) {
                    $fichaPartes = explode(':', $fichaString);
                    if (count($fichaPartes) == 2) {
                        $numerosFicha[] = trim($fichaPartes[0]);
                        $nombresFicha[] = trim($fichaPartes[1]);
                    }
                }

                foreach ($numerosFicha as $numero) {
                    log::info('Número de ficha procesado: ' . $numero);
                }
                foreach ($nombresFicha as $nombre) {
                    log::info('Nombre de ficha procesado: ' . $nombre);
                }
            }

            // Guardar los datos concatenados en el evento
            $evento = Evento::create([
                'pla_amb_id' => $validatedData['pla_amb_id'],
                'idHorario' => $validatedData['idHorario'],
                'nomEvento' => $validatedData['nomEvento'],
                'descripcion' => $validatedData['descripcion'],
                'fechaEvento' => $validatedData['fechaEvento'],
                'aforoEvento' => $validatedData['aforoEvento'],
                'fic_numero' => implode('|', $numerosFicha),
                'nombreFicha' => implode('|', $nombresFicha),
                'idCategoria' => $validatedData['idCategoria'],
                'publicidad' => $validatedData['publicidad'] ?? null,
                'estadoEvento' => $validatedData['estadoEvento'],
                'nomSolicitante' => $validatedData['nomSolicitante'],
            ]);

            // Relacionar encargados
            $evento->encargados()->attach($encargadosIds);

            return redirect()->route('calendario.index')->with('success', 'Evento creado exitosamente.');
        } catch (\Exception $e) {

            return redirect()->route('eventos.crearEvento')->with('error', 'Ocurrió un error al crear el Evento: ' . $e->getMessage());
        }
    }



    public function edit(Request $request)
    {
        // Cargar calendario, categorías y fichas para el formulario de edición
        $calendario = $this->calendarioGenerado();
        $idEvento = $request->__get('idEvento');

        // Buscar el evento con sus relaciones
        $evento = Evento::with(['encargados', 'horario', 'ambiente'])->where('idEvento', $idEvento)->first();

        if (!$evento) {
            return redirect()->route('calendario.index')->with('error', 'Evento no encontrado.');
        }

        // Preparar la fecha
        $fechaEvento = $evento->fechaEvento;
        $timestamp = strtotime($fechaEvento);
        $fechaArray = getdate($timestamp);
        $dia = $fechaArray['mday'];
        $mes = $fechaArray['mon'];
        $anio = $fechaArray['year'];
        $fecha = sprintf('%04d-%02d-%02d', $anio, $mes, $dia);

        // Datos relacionados
        $categorias = Categoria::all();

        // Cargar encargados
        $encargados = $evento->encargados;

        $nombresEncargados = $encargados->map(function ($encargado) {
            return $encargado->par_nombres . ' ' . $encargado->par_apellidos;
        })->implode(', ');

        $idsEncargados = $encargados->pluck('par_identificacion')->implode(',');

        // Cargar horario y ambiente
        $horario = $evento->horario;
        $ambiente = $evento->ambiente;

        $nombreAmbiente = $ambiente ? $ambiente->pla_amb_descripcion : '';
        $inicioEvento = $horario ? $horario->inicio : '';
        $finalEvento = $horario ? $horario->fin : '';

        // 👉 Procesar las fichas para edición
        $fichas = [];
        if ($evento->fic_numero && $evento->nombreFicha) {
            $numerosFicha = explode('|', $evento->fic_numero);
            $nombresFicha = explode('|', $evento->nombreFicha);

            foreach ($numerosFicha as $index => $numero) {
                $fichas[] = [
                    'numero' => trim($numero),
                    'nombre' => isset($nombresFicha[$index]) ? trim($nombresFicha[$index]) : ''
                ];
            }
        }

        return view('Evento.crearEvento', compact(
            'evento',
            'categorias',
            'nombresEncargados',
            'idsEncargados',
            'dia',
            'mes',
            'anio',
            'fecha',
            'calendario',
            'inicioEvento',
            'finalEvento',
            'nombreAmbiente',
            'fichas'
        ));
    }



    public function update(Request $request, Evento $evento)
    {
        try {
            // Validar los datos enviados al controlador
            log::info('Datos recibidos para actualizar el evento: ', $request->all());
            $validatedData = $this->validateRequest($request);

            // Obtener el ID del evento desde el formulario
            $idEvento = $request->input('idEvento');
            $evento = Evento::findOrFail($idEvento);

            // Obtener los IDs de los encargados
            $encargadosIds = array_filter(array_map('trim', explode(',', $request->par_identificacion)));

            if (empty($encargadosIds)) {
                return redirect()->back()->with('error', 'Debe seleccionar al menos un encargado.');
            }

            // Buscar el primer participante para actualizar el nombre del solicitante
            $primerEncargado = Participante::where('par_identificacion', $encargadosIds[0])->first();

            if (!$primerEncargado) {
                return redirect()->back()->with('error', 'Participante no encontrado.');
            }

            $validatedData['nomSolicitante'] = $primerEncargado->par_nombres;

            // Actualizar la imagen si se proporciona una nueva
            if ($request->hasFile('publicidad')) {
                $rutaImagen = $request->file('publicidad')->store('imagenes', 'public');
                $validatedData['publicidad'] = $rutaImagen;
            }

            // Actualizar el horario asociado al evento
            $horario = Horario::find($evento->idHorario);
            if (!$horario) {
                return redirect()->back()->with('error', 'Error al encontrar el horario.');
            }

            $horario->update([
                'inicio' => $request->input('horarioEventoInicio'),
                'fin' => $request->input('horarioEventoFin'),
            ]);

            // 🔹 Procesar las fichas (número y nombre)
            $fichasRaw = $request->input('fichas'); // Formato: numero:nombre|numero:nombre
            log::info('Fichas recibidas en update: ' . $fichasRaw);

            $numerosFicha = [];
            $nombresFicha = [];

            if ($fichasRaw) {
                $fichasArray = explode('|', $fichasRaw);

                foreach ($fichasArray as $fichaString) {
                    $fichaPartes = explode(':', $fichaString);
                    if (count($fichaPartes) == 2) {
                        $numerosFicha[] = trim($fichaPartes[0]);
                        $nombresFicha[] = trim($fichaPartes[1]);
                    }
                }
            }

            // Guardar las fichas en formato string
            $validatedData['fic_numero'] = implode('|', $numerosFicha); // Ejemplo: 1234|5678
            $validatedData['nombreFicha'] = implode('|', $nombresFicha); // Ejemplo: Ficha A|Ficha B

            // Eliminar campo que no pertenece a la tabla evento
            unset($validatedData['par_identificacion']);

            // Actualizar el evento con los datos restantes
            $evento->update($validatedData);

            // Actualizar los encargados relacionados (sincroniza)
            $evento->encargados()->sync($encargadosIds);

            return redirect()->route('calendario.index')->with('success', 'Evento actualizado exitosamente.');
        } catch (\Exception $e) {
            log::error('Error al actualizar el evento: ' . $e->getMessage());
            return redirect()->route('calendario.index')->with('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }




    public function buscarEventos(Request $request)
    {
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');

        // Construir la fecha en formato YYYY-MM-DD
        $fecha = sprintf('%04d-%02d-%02d', $anio, $mes, $dia);

        try {
            // Buscar eventos para la fecha específica y cargar sus relaciones
            $eventos = Evento::whereDate('fechaEvento', $fecha)
                ->where('estadoEvento', '<>', 0)
                ->with(['ambiente', 'horario', 'categoria', 'encargados']) // Eager Loading
                ->get();

            $resultados = [];

            foreach ($eventos as $evento) {
                $resultados[] = [
                    'evento' => $evento,
                    'ambiente' => $evento->ambiente,
                    'horario' => $evento->horario,
                    'categoria' => $evento->categoria,
                    'encargados' => $evento->encargados, // Ahora trae todos los encargados asociados
                ];
            }

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


    public function buscarParticipantes(Request $request)
    {
        $term = $request->input('term');

        $participantes = Participante::where('par_nombres', 'LIKE', '%' . $term . '%')
            ->get(['par_identificacion', 'par_nombres', 'par_apellidos', 'par_correo']);

        $resultado = $participantes->map(function ($p) {
            return [
                'id' => $p->par_identificacion,
                'nombre' => $p->par_nombres,
                'apellido' => $p->par_apellidos,
                'correo' => $p->par_correo ?? null, // Asegurarse de que el campo correo exista
            ];
        });

        return response()->json($resultado);
    }

    public function buscarAmbientes(Request $request)
    {
        $term = $request->input('term');

        $ambientes = Ambiente::where('pla_amb_descripcion', 'LIKE', '%' . $term . '%')
            ->limit(10)
            ->get(['pla_amb_id', 'pla_amb_descripcion']);

        $resultado = $ambientes->map(function ($p) {
            return [
                'id' => $p->pla_amb_id,
                'nombre' => $p->pla_amb_descripcion,
            ];
        });

        return response()->json($resultado);
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
        $eventos = Evento::where("fechaEvento", "<", $fechaActual)
            ->where('estadoEvento', '!=', 0)
            ->get();


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
        $idEvento =  $request->__get('idEvento');
        $eventoEncontrado = Evento::find($idEvento);
        log::info('ID del evento a eliminar: ' . $idEvento);
        log::info('Evento encontrado: ' . ($eventoEncontrado ? 'Sí' : 'No'));
        if ($eventoEncontrado) {
            // Eliminar las imágenes físicas
            $fotos = FotografiaEvento::where('idEvento', $idEvento)->get();
            foreach ($fotos as $foto) {
                if (Storage::disk('public')->exists($foto->ruta)) {
                    Storage::disk('public')->delete($foto->ruta);
                }
            }

            // Eliminar registros de fotografías
            FotografiaEvento::where('idEvento', $idEvento)->delete();

            // Guardar el ID de horario antes de eliminar el evento
            $idHorario = $eventoEncontrado->idHorario;

            // Eliminar las relaciones de la tabla pivote
            $eventoEncontrado->encargados()->detach();

            // Eliminar la imagen de publicidad si existe
            Storage::disk('public')->delete($eventoEncontrado->publicidad);

            // Eliminar el evento
            $eventoEncontrado->delete();

            // Ahora que el evento fue eliminado, puedes borrar el horario
            Horario::where('idHora', $idHorario)->delete();

            return redirect()->route('calendario.index')->with('success', 'Evento eliminado exitosamente.');
        } else {
            return redirect()->route('calendario.index')->with('error', 'No se pudo eliminar el evento.');
        }
    }


    public function validarDisponibilidad(Request $request)
    {
        $request->validate([
            'pla_amb_id' => 'required|exists:sep_planeacion_ambiente,pla_amb_id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $idEvento = $request->idEvento;
        log::info('ID del evento: ' . $idEvento);
        $ambienteId = $request->pla_amb_id;
        $fechaEvento = $request->fecha;
        $inicio = date('H:i', strtotime($request->hora_inicio)); // Normaliza el formato
        $fin = date('H:i', strtotime($request->hora_fin));       // Normaliza el formato

        $eventoExistente = Evento::where('fechaEvento', $fechaEvento)
            ->where('pla_amb_id', $ambienteId)
            ->when($idEvento, function ($query, $idEvento) {
                return $query->where('idEvento', '!=', $idEvento); // <- solo si hay un ID
            })
            ->whereHas('horario', function ($query) use ($inicio, $fin) {
                $query->where(function ($q) use ($inicio, $fin) {
                    $q->whereBetween('inicio', [$inicio, $fin])
                        ->orWhereBetween('fin', [$inicio, $fin])
                        ->orWhere(function ($sub) use ($inicio, $fin) {
                            $sub->where('inicio', '<=', $inicio)
                                ->where('fin', '>=', $fin);
                        });
                });
            })
            ->exists();

        Log::info(($eventoExistente));

        if ($eventoExistente) {
            log::info('El ambiente no está disponible para la fecha y hora solicitada.');
            return response()->json([
                'error' => true,
                'message' => 'El ambiente con la fecha y hora solicitada no está disponible.'
            ]);
        }

        return response()->json(['disponible' => true]);
    }


    public function aumentarVisualizacion($idEvento)
    {
        try {
            $evento = Evento::findOrFail($idEvento);
            $evento->increment('visualizaciones');

            return response()->json(['success' => true, 'visualizaciones' => $evento->visualizaciones]);
        } catch (\Exception $e) {
            Log::error('Error al registrar visualización: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al registrar visualización'], 500);
        }
    }



    private function validateRequest(Request $request)
    {
        return $request->validate([
            'par_identificacion' => 'required',
            'pla_amb_id' => 'required|integer',
            'idHorario' => 'nullable|integer',
            'nomEvento' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'fechaEvento' => 'required|date',
            'aforoEvento' => 'nullable|integer',
            'fic_numero' => 'nullable|string|max:20',
            'idCategoria' => 'nullable|integer',
            'publicidad' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estadoEvento' => 'required|integer',
        ]);
    }







    //*Fin Funciones Realizadas por CRISTIAN

    public function index()
    {
        // Carga eventos nuevos 
        $eventos = Evento::with(['categoria', 'horario', 'ambiente', 'participante', 'ficha'])
            ->whereIn('estadoEvento', [1, 3]) // Filtrar solo los eventos con estado 1
            ->get();
        return view('Evento.inicioEvento', compact('eventos'));
    }

    public function solicitudPublica(Request $request)
{
    // Verificamos si ya se autenticó en esta sesión
    if (!$request->session()->has('solicitud_autenticada')) {
        // Pasa bandera a la vista para mostrar el modal
        return view('public.SolicitudEvento', [
            'showAuth' => true,
            'categorias' => Categoria::where('estadoCategoria', 1)->get(),
            'fichas' => Ficha::all(),
            'calendario' => $this->calendarioGenerado(),
            'participantes' => Participante::where('est_apr_id', 2)
                ->select('par_identificacion', 'par_nombres')
                ->paginate(10),
            'ambientes' => Ambiente::all(),
            'eventos' => null
        ]);
    }

    // Si ya está autenticado
    return view('public.SolicitudEvento', [
        'showAuth' => false,
        'categorias' => Categoria::where('estadoCategoria', 1)->get(),
        'fichas' => Ficha::all(),
        'calendario' => $this->calendarioGenerado(),
        'participantes' => Participante::where('est_apr_id', 2)
            ->select('par_identificacion', 'par_nombres')
            ->paginate(10),
        'ambientes' => Ambiente::all(),
        'eventos' => null
    ]);
}


    public function authenticated(Request $request, $user)
    {

        // Redirige al usuario a la vista para crear un evento
        return redirect()->route('evento.solicitud');
    }

    // solicitud evento publico
    public function updatepublica(Request $request, Evento $evento)

    {
        $validatedData = $this->validateRequest($request);
        $idEvento = $request->input('idEvento');

        $evento = Evento::findOrFail($idEvento);

        $participante = Participante::where('par_identificacion', $request->par_identificacion)->first();
        if (!$participante) {
            return redirect()->back()->with('error', 'Participante no encontrado.');
        }

        $validatedData['nomSolicitante'] = $participante->par_nombres;

        if ($request->hasFile('publicidad')) {
            $rutaImagen = $request->file('publicidad')->store('imagenes', 'public');
            $validatedData['publicidad'] = $rutaImagen;
        }

        $horario = Horario::find($evento->idHorario);
        if (!$horario) {
            return redirect()->back()->with('error', 'Error al crear el horario.');
        }

        $horario->update([
            'inicio' => $request->input('horarioEventoInicio'),
            'fin' => $request->input('horarioEventoFin'),
        ]);

        $evento->update($validatedData);

        // Actualizar relación evento-participante (insertar si no existe)
        DB::table('evento_participante')->updateOrInsert(
            ['evento_id' => $evento->idEvento],
            ['par_identificacion' => $participante->par_identificacion]
        );

        return redirect()->route('public.index')->with('success', 'Evento actualizado exitosamente.');
    }



    // Método para manejar el formulario externo  -oky
    public function storeExterno(Request $request)
    {

        try {
            $validatedData = $this->validateRequest($request);
            log::info('Datos validados: ', $request->all());

            if ($request->hasFile('publicidad')) {
                $rutaImagen = $request->file('publicidad')->store('imagenes', 'public');
                $validatedData['publicidad'] = $rutaImagen;
            }

            $participante = Participante::where('par_identificacion', $request->par_identificacion)->first();
            if (!$participante) {
                return redirect()->back()->with('error', 'Participante no encontrado.');
            }

            $validatedData['nomSolicitante'] = $participante->par_nombres;

            $horario = Horario::create([
                'pla_amb_id' => $request->pla_amb_id,
                'inicio' => $request->horarioEventoInicio,
                'fin' => $request->horarioEventoFin,
            ]);

            if (!$horario) {
                return redirect()->back()->with('error', 'Error al crear el horario.');
            }

            $validatedData['idHorario'] = $horario->idHora;

            $evento = Evento::create([
                // 'par_identificacion' se elimina
                'pla_amb_id' => $validatedData['pla_amb_id'],
                'idHorario' => $validatedData['idHorario'],
                'nomEvento' => $validatedData['nomEvento'],
                'descripcion' => $validatedData['descripcion'],
                'fechaEvento' => $validatedData['fechaEvento'],
                'aforoEvento' => $validatedData['aforoEvento'] ?? null,
                'fic_numero' => $validatedData['fic_numero'] ?? null,
                'idCategoria' => $validatedData['idCategoria'],
                'publicidad' => $validatedData['publicidad'] ?? null,
                'estadoEvento' => $validatedData['estadoEvento'],
                'nomSolicitante' => $validatedData['nomSolicitante'],
            ]);













            // Relación en tabla pivote
            DB::table('evento_participante')->insert([
                'evento_id' => $evento->idEvento,
                'par_identificacion' => $participante->par_identificacion,
            ]);

            return redirect()->route('public.index')->with('success', '¡Evento creado exitosamente!');
        } catch (\Exception $e) {
            return redirect()->route('public.index')->with('error', 'Error al crear el evento: ' . $e->getMessage());
        }
    }


    public function buscarFichas(Request $request)
    {
        $term = $request->input('term');

        $fichas = Ficha::where('fic_numero', 'like', "%{$term}%")
            ->limit(10)
            ->get(['fic_numero']);

        return response()->json($fichas);
    }



    // Fin Método para manejar el formulario externo





public function autenticarSolicitud(Request $request)
{
    $identificacion = $request->input('auth_identificacion');
    $password = $request->input('auth_password');

    // Aquí colocas la validación que necesites (ejemplo simple)
    $usuario = Participante::where('par_identificacion', $identificacion)->first();

    if ($usuario && $password === 'clave123') { // Aquí puedes usar hash real si deseas
        // Guardar autenticación en sesión
        $request->session()->put('solicitud_autenticada', true);

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'message' => 'Credenciales inválidas']);
}



}
