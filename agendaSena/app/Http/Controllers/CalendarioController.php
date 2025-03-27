<?php

namespace App\Http\Controllers;

use App\Models\Evento\Evento;
use Illuminate\Http\Request;
use Carbon\Carbon;

use function Illuminate\Log\log;

class CalendarioController extends Controller
{

    public function generarCalendario(Request $request)
    {

        $fechaActual = Carbon::now();
        $vista = $request->query('vista');

        $mes = $request->query('mes', $fechaActual->month);
        $anio = $request->query('anio', $fechaActual->year);


        $primerDia_delMes = Carbon::createFromDate($anio, $mes, 1);
        $ultimoDia_delMes = $primerDia_delMes->copy()->endOfMonth();


        // Día de la semana en que comienza el mes (0=Domingo, 6=Sábado)
        $diaInicioSemana = $primerDia_delMes->dayOfWeek;


        // Total de días en el mes
        $diasEnElMes  = $ultimoDia_delMes->day;

        $calendario = [];
        $semana = [];

        // Añadir celdas vacías al inicio de la primera semana
        for ($i = 0; $i < $diaInicioSemana; $i++) {
            $semana[] = null;
        }

        // Rellenar los días del mes
        for ($i = 1; $i <= $diasEnElMes; $i++) {
            $semana[] = $i;

            // Completar una semana y agregarla al calendario
            if (count($semana) == 7) {
                $calendario[] = $semana;
                $semana = [];
            }
        }

        // Añadir celdas vacías al final de la última semana
        while (count($semana) < 7) {
            $semana[] = null;
        }
        $calendario[] = $semana;

        if ($vista) {
            return view($vista, compact('calendario', 'mes', 'anio'));
        } else {
            return view('index', compact('calendario', 'mes', 'anio'));
        }
    }


    public function buscarEventosPorMes(Request $request)
    {
        if ($request->query("mes") != null && $request->query("anio") != null) {
            $mesActual = Carbon::now()->month;
            $mesConvertir = $request->query('mes');
            $mes = $mesConvertir + 1;
            $anio = $request->query('anio');
            $primerDia_delMes = Carbon::createFromDate($anio, $mes, 1);
            $ultimoDia_delMes = $primerDia_delMes->copy()->endOfMonth();
            //dd($primerDia_delMes, $ultimoDia_delMes);
        } else {

            $mesActual = Carbon::now()->month;
            $anioActual = Carbon::now()->year;

            $primerDia_delMes = Carbon::createFromDate($anioActual, $mesActual, 1);
            $ultimoDia_delMes = $primerDia_delMes->copy()->endOfMonth();
        }
        try {


            $eventosConfirmados = Evento::whereBetween('fechaEvento', [$primerDia_delMes, $ultimoDia_delMes])
                ->where('estadoEvento', 1)
                ->orderBy('fechaEvento', 'asc')
                ->get();
            $eventosReservados = Evento::whereBetween('fechaEvento', [$primerDia_delMes, $ultimoDia_delMes])
                ->where('estadoEvento', 2)
                ->orderBy('fechaEvento', 'asc')
                ->get();


            $eventosEncontradosConfirmados = $eventosConfirmados->map(function ($evento) {
                return [
                    'id' => $evento->idEvento,
                    'nombre' => $evento->nomEvento,
                    'fecha' => $evento->fechaEvento,
                ];
            });
            $eventosEncontradosReservados = $eventosReservados->map(function ($evento) {
                return [
                    'id' => $evento->idEvento,
                    'nombre' => $evento->nomEvento,
                    'fecha' => $evento->fechaEvento,
                ];
            });

            return response()->json([
                'success' => true,
                'eventosConfirmados' => $eventosEncontradosConfirmados,
                'eventosReservados' => $eventosEncontradosReservados,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al buscar los eventos.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }




    // yaque se esta adicionando busquedas 
    // por nombre - por dia y por nombre 
    // para poder llamaro a la vista apublica
    public function buscarEventosPorLugar(Request $request)
    {
        try {
            // Validar que se proporcione el lugar
            $lugar = $request->query('lugar');
            if (!$lugar) {
                return response()->json([
                    'success' => false,
                    'message' => 'El parámetro "lugar" es requerido.',
                ], 400);
            }

            // Buscar eventos en la base de datos que coincidan con el lugar
            $eventos = Evento::where('lugarEvento', 'like', '%' . $lugar . '%')
                ->where('estadoEvento', 1)
                ->orderBy('fechaEvento', 'asc')
                ->get();

            // Mapear los eventos encontrados
            $eventosEncontrados = $eventos->map(function ($evento) {
                return [
                    'id' => $evento->idEvento,
                    'nombre' => $evento->nomEvento,
                    'fecha' => $evento->fechaEvento,
                    'lugar' => $evento->lugarEvento, // Incluir el lugar en la respuesta
                ];
            });

            // Devolver la respuesta JSON
            return response()->json([
                'success' => true,
                'data' => $eventosEncontrados,
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
        try {
            // Validar que se proporcione el nombre
            $nombre = $request->query('nombre');
            if (!$nombre) {
                return response()->json([
                    'success' => false,
                    'message' => 'El parámetro "nombre" es requerido.',
                ], 400);
            }

            // Buscar eventos en la base de datos que coincidan con el nombre
            $eventos = Evento::where('nomEvento', 'like', '%' . $nombre . '%')
                ->where('estadoEvento', 1)
                ->orderBy('fechaEvento', 'asc')
                ->get();

            // Mapear los eventos encontrados
            $eventosEncontrados = $eventos->map(function ($evento) {
                return [
                    'id' => $evento->idEvento,
                    'nombre' => $evento->nomEvento,
                    'fecha' => $evento->fechaEvento,
                ];
            });

            // Devolver la respuesta JSON
            return response()->json([
                'success' => true,
                'data' => $eventosEncontrados,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al buscar los eventos.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }





    public function buscarEventosPorDia(Request $request)
    {
        try {
            // Validar que se proporcione la fecha
            $fecha = $request->query('fecha');
            if (!$fecha) {
                return response()->json([
                    'success' => false,
                    'message' => 'El parámetro "fecha" es requerido.',
                ], 400);
            }

            // Formatear la fecha usando Carbon
            $fechaFormateada = Carbon::parse($fecha)->toDateString();

            // Buscar eventos en la base de datos para la fecha específica
            $eventos = Evento::whereDate('fechaEvento', $fechaFormateada)
                ->where('estadoEvento', 1)
                ->orderBy('fechaEvento', 'asc')
                ->get();

            // Mapear los eventos encontrados
            $eventosEncontrados = $eventos->map(function ($evento) {
                return [
                    'id' => $evento->idEvento,
                    'nombre' => $evento->nomEvento,
                    'fecha' => $evento->fechaEvento,
                ];
            });

            // Devolver la respuesta JSON
            return response()->json([
                'success' => true,
                'data' => $eventosEncontrados,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al buscar los eventos.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    private function generarMatrizCalendario($mes, $anio)
    {
        $primerDiaDelMes = Carbon::createFromDate($anio, $mes, 1);
        $ultimoDiaDelMes = $primerDiaDelMes->copy()->endOfMonth();
        $diaInicioSemana = $primerDiaDelMes->dayOfWeek; // 0=Domingo, 6=Sábado
        $diasEnElMes = $ultimoDiaDelMes->day;

        $calendario = [];
        $semana = [];

        // Añadir celdas vacías al inicio de la primera semana
        for ($i = 0; $i < $diaInicioSemana; $i++) {
            $semana[] = null;
        }

        // Rellenar los días del mes
        for ($i = 1; $i <= $diasEnElMes; $i++) {
            $semana[] = $i;

            // Completar una semana y agregarla al calendario
            if (count($semana) == 7) {
                $calendario[] = $semana;
                $semana = [];
            }
        }

        // Añadir celdas vacías al final de la última semana
        while (count($semana) < 7) {
            $semana[] = null;
        }
        $calendario[] = $semana;

        return $calendario;
    }

    public function generarCalendarioPublico(Request $request)
    {
        // Obtener el mes y año actuales o proporcionados por el usuario
        $fechaActual = Carbon::now();
        $mes = $request->query('mes', $fechaActual->month); // Mes actual o el proporcionado por el usuario
        $anio = $request->query('anio', $fechaActual->year); // Año actual o el proporcionado por el usuario

        // Validar mes y año
        if ($mes < 1 || $mes > 12 || $anio < 1) {
            return redirect()->back()->withErrors(['error' => 'Mes o año no válidos.']);
        }

        // Generar la matriz del calendario
        $calendario = $this->generarMatrizCalendario($mes, $anio);

        // Obtener eventos para el mes actual
        $primerDiaDelMes = Carbon::createFromDate($anio, $mes, 1);
        $ultimoDiaDelMes = $primerDiaDelMes->copy()->endOfMonth();

        $eventos = Evento::whereBetween('fechaEvento', [$primerDiaDelMes, $ultimoDiaDelMes])
            ->where('estadoEvento', 1) // Solo eventos activos
            ->orderBy('fechaEvento', 'asc')
            ->get();


        // Pasar los datos del calendario y eventos a la vista
        return view('public.index', compact('calendario', 'mes', 'anio', 'eventos'));
    }



    // aqui termina la adicion por busquedas de yaqueline para la vista publica



}
