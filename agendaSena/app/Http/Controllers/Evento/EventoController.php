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

class EventoController extends Controller
{
    use CalendarTrait;
    public function index()
    {
        // Carga eventos nuevos 
        $eventos = Evento::with(['categoria', 'horario', 'ambiente', 'participante', 'ficha'])->get();
        return view('Evento.inicioEvento', compact('eventos'));
    }

    public function create(Request $request)
    {
        // Cargar categorías y fichas para el formulario
        $calendario = $this->calendarioGenerado();
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        // Construir la fecha en formato YYYY-MM-DD
        $fecha = sprintf('%04d-%02d-%02d', $anio, $mes, $dia);

        $categorias = Categoria::all();
        $fichas = Ficha::all();
        $participantes = Participante::all();
        $ambientes = Ambiente::all();

        return view('Evento.crearEvento', compact('categorias', 'fichas', 'fecha', 'calendario', 'anio', 'participantes', 'ambientes'));
    }

    public function store(Request $request)
    {
        try {

            // Validar los datos enviados al controlador

            Log::info('Datos para crear Evento: ', [
                'pla_amb_id' => $request->pla_amb_id,

            ]);
            Log::info('Datos para crear horario: ', [
                'pla_amb_id' => $request->pla_amb_id,
                'inicio' => $request->horarioEventoInicio,
                'fin' => $request->horarioEventoFin,
            ]);

            $participante = Participante::where('par_identificacion', $request->par_identificacion)->first();

            if ($participante) {
                // Agregar el nombre del participante al request para enviarlo como 'nomSolicitante'
                $request->merge([
                    'nomSolicitante' => $participante->par_nombres,
                ]);
            } else {
                // Si no se encuentra el participante
                return redirect()->back()->with('error', 'Participante no encontrado.');
            }

            // Crear el horario
            $horario = Horario::create([
                'pla_amb_id' => $request->pla_amb_id,
                'inicio' => $request->horarioEventoInicio,
                'fin' => $request->horarioEventoFin,
            ]);



            // Verificar si el horario se creó correctamente
            if (!$horario) {
                return redirect()->back()->with('error', 'Error al crear el horario.');
            }

            // Agregar el ID del horario al request para asociarlo al evento
            $request->merge([
                'idHorario' => $horario->idHora,
            ]);

            // Crear el evento utilizando los datos del request
            Evento::create($request->all());

            // Redirigir con un mensaje de éxito
            return redirect()->route('calendario.index')->with('success', 'Evento creado exitosamente.');
        } catch (\Exception $e) {
            // Registrar el error en los logs y devolver un mensaje
            Log::error('Error al crear evento: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }


    public function edit(Evento $evento)
    {
        // Cargar categorías y fichas para el formulario de edición
        $categorias = Categoria::all();
        $fichas = Ficha::all();
        return view('Evento.editarEvento', compact('evento', 'categorias', 'fichas'));
    }

    public function update(Request $request, Evento $evento)
    {
        $this->validateRequest($request);
        $evento->update($request->all());
        return redirect()->route('eventos.index')->with('success', 'Evento actualizado exitosamente.');
    }

    public function destroy(Evento $evento)
    {
        $evento->delete(); // Eliminar el evento
        return redirect()->route('eventos.index')->with('success', 'Evento eliminado exitosamente.');
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
            $eventos = Evento::whereDate('fechaEvento', $fecha)->get();
            $resultados = [];
            foreach ($eventos as $evento) {
                $idAmbiente = $evento->pla_amb_id;
                $idHorario = $evento->idHorario;
                $idCategoria = $evento->idCategoria;

                $ambiente = Ambiente::find($idAmbiente); // Busca por clave primaria
                $horario = Horario::find($idHorario);
                $categoria = Categoria::find($idCategoria);

                $resultados[] = [
                    'evento' => $evento,
                    'ambiente' => $ambiente,
                    'horario' => $horario,
                    'categoria' => $categoria,
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
            'publicidad' => 'nullable|blob',
            'estadoEvento' => 'required|boolean',
        ]);
    }
}
