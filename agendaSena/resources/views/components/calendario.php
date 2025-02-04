<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\View\Component;

class Calendario extends Component
{
    public $calendario;
    public $anio;
    public $mes;

    public function __construct($mes = null, $anio = null)
    {
        // Si no se proporciona mes o año, se utilizan los actuales
        $fechaActual = Carbon::now();
        $this->mes = $mes ?? $fechaActual->month;
        $this->anio = $anio ?? $fechaActual->year;

        $this->calendario = $this->generarCalendario();
    }

    private function generarCalendario()
    {
        // Crear una instancia de Carbon para el primer día del mes
        $primerDia_delMes = Carbon::createFromDate($this->anio, $this->mes, 1);
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

        echo("Sería la información del calendario ". $calendario);
        return $calendario; 
    }

    public function render()
    {
        return view('components.calendario');
    }
}