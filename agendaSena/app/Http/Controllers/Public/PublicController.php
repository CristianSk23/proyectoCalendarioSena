<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Evento\Evento; // Importa el modelo Evento
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\fotografiasEvento\FotografiaEvento;


class PublicController extends Controller
{
   
    
    public function index()
    {
        $hoy = Carbon::today();

        $eventos = Evento::with(['categoria', 'horario', 'ambiente', 'participante', 'ficha'])
            ->whereIn('estadoEvento',[1,3])
            ->whereDate('fechaEvento', '>=', $hoy)
            ->get();

            
//   $eventosRealizados = Evento::whereIn('estadoEvento',[1,3])->pluck('idEvento');
        //  $imagenesBanner = FotografiaEvento::with('evento:idEvento,nomEvento')
        $imagenesBanner = $this->obtenerImagenesBannerPorMes();
        // ->whereIn('idEvento', Evento::where('estadoEvento', 3)->pluck('idEvento'))
        // ->get();

        $categorias = \App\Models\Categoria\Categoria::all();

        return view('public.index', compact('eventos', 'imagenesBanner', 'categorias'));
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



    public function obtenerImagenesBannerPorMes()
{
    $fechaActual = Carbon::now();
    $mesActual = $fechaActual->month;
    $anioActual = $fechaActual->year;

    $eventosMesActual = Evento::where('estadoEvento', 3)
                            ->whereYear('fechaEvento', $anioActual)
                            ->whereMonth('fechaEvento', $mesActual)
                            ->pluck('idEvento');

    $imagenes = FotografiaEvento::with('evento:idEvento,nomEvento,fechaEvento')
                ->whereIn('idEvento', $eventosMesActual)
                ->get()
                ->sortByDesc(function($foto){
                    return $foto->evento->fechaEvento ?? null;
                })
                ->values();

    if ($imagenes->isEmpty()) {
        $fechaMesAnterior = $fechaActual->copy()->subMonth();
        $mesAnterior = $fechaMesAnterior->month;
        $anioMesAnterior = $fechaMesAnterior->year;

        $eventosMesAnterior = Evento::where('estadoEvento', 3)
                                ->whereYear('fechaEvento', $anioMesAnterior)
                                ->whereMonth('fechaEvento', $mesAnterior)
                                ->pluck('idEvento');

        $imagenes = FotografiaEvento::with('evento:idEvento,nomEvento,fechaEvento')
                    ->whereIn('idEvento', $eventosMesAnterior)
                    ->get()
                    ->sortByDesc(function($foto){
                        return $foto->evento->fechaEvento ?? null;
                    })
                    ->values();
    }

    return $imagenes;
}



}