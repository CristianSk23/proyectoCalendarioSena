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
        

        $eventos = Evento::with(['categoria', 'horario', 'ambiente', 'ficha'])
            ->whereIn('estadoEvento',[1,3])
            ->get();

            

        $imagenesPublicidad = $this->obtenerImagenesPublicidad();
        $imagenesBanner = $this->obtenerImagenesBannerPorMes();
       

        $categorias = \App\Models\Categoria\Categoria::all();

      
        return view('public.index', compact('eventos', 'imagenesBanner', 'imagenesPublicidad', 'categorias'));
    }



    public function show($id)
    {
        // Obtener un evento específico
        $evento = Evento::with(['categoria', 'horario', 'ambiente', 'ficha'])
            ->where('idEvento', $id)
            ->where('estadoEvento', 1)
            ->firstOrFail();

         $imagenesPublicidad = $this->obtenerImagenesPublicidad(); 
         $imagenesBanner = $this->obtenerImagenesBannerPorMes();      
        // Pasar los datos a la vista
        return view('public.show', compact('evento', 'imagenesPublicidad','imagenesBanner'));
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


    public function obtenerImagenesPublicidad()
    {
        $hoy = Carbon::today();

        return Evento::where('estadoEvento', 1) // Suponiendo que '1' es 'Programado'
            ->whereNotNull('publicidad')
            ->where('publicidad', '!=', '')
            ->whereDate('fechaEvento', '>=', $hoy)
            ->orderBy('fechaEvento', 'asc') // Ordena por fecha de evento
            ->get(['publicidad', 'nomEvento', 'idEvento']); // Selecciona solo los campos necesarios
    }



}
