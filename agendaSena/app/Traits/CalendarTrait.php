<?php

namespace App\Traits;

use Carbon\Carbon;

trait CalendarTrait
{
    public function calendarioGenerado()
    {
        $fechaActual = Carbon::now();


        $mes =  $fechaActual->month;
        $anio = $fechaActual->year;

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

        return $calendario;
    }
}
