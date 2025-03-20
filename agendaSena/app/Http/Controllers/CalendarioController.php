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
        // Obtener el mes y año actuales o proporcionados por el usuario
        $fechaActual = Carbon::now();
        $vista = $request->query('vista');

        $mes = $request->query('mes', $fechaActual->month);
        $anio = $request->query('anio', $fechaActual->year);

        // Crear una instancia de Carbon para el primer día del mes
        $primerDia_delMes = Carbon::createFromDate($anio, $mes, 1);
        $ultimoDia_delMes = $primerDia_delMes->copy()->endOfMonth();


        // Día de la semana en que comienza el mes (0=Domingo, 6=Sábado)
        $diaInicioSemana = $primerDia_delMes->dayOfWeek;


        // Total de días en el mes
        $diasEnElMes  = $ultimoDia_delMes->day;

        // Construir la matriz del calendario
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

        // Pasar los datos del calendario a la vista
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
}
