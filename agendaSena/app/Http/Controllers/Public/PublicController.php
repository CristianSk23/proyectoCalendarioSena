<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Evento\Evento; // Importa el modelo Evento
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\fotografiasEvento\FotografiaEvento;


class PublicController extends Controller
{
   
    
    public function index()
    {
       
        $eventos = Evento::with(['categoria', 'horario', 'ambiente', 'participante', 'ficha'])
            ->where('estadoEvento', 1)
            ->get();

        // Asumimos que quieres una imagen por evento como banner (sin nueva columna)
        // $imagenesBanner = collect();
         $eventosRealizados = Evento::where('estadoEvento', 3)->pluck('idEvento');
        // foreach ($eventos as $evento) {
        //     $foto = FotografiaEvento::where('idEvento', $evento->idEvento)->first();
        //     if ($foto) {
        //         $imagenesBanner->push($foto);
        //     }
        // }

        //  $imagenesBanner = FotografiaEvento::whereIn('idEvento', $eventosRealizados)->get();
         $imagenesBanner = FotografiaEvento::with('evento')
        ->whereIn('idEvento', Evento::where('estadoEvento', 3)->pluck('idEvento'))
        ->get();

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





}