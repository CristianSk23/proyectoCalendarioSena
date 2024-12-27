<?php

namespace App\Http\Controllers\Evento;

use App\Http\Controllers\Controller;
use App\Models\Evento\Evento;
use App\Models\Categoria\Categoria; 
use App\Models\Ficha\Ficha; 
use App\Models\sep_participante\Participante; 
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index()
    {
        // Carga eventos nuevos 
        $eventos = Evento::with(['categoria', 'horario', 'ambiente', 'participante', 'ficha'])->get();
        return view('Evento.inicioEvento', compact('eventos'));
    }

    public function create()
    {
        // Cargar categorías y fichas para el formulario
        $categorias = Categoria::all();
        $fichas = Ficha::all();
        return view('Evento.crearEvento', compact('categorias', 'fichas'));
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);

        Evento::create($request->all());
        return redirect()->route('eventos.index')->with('success', 'Evento creado exitosamente.');
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

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'par_identificacion' => 'required|string|max:30',
            'pla_amb_id' => 'required|integer',
            'idHorario' => 'nullable|integer',
            'aforoEvento' => 'required|integer',
            'nomEvento' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'fic_numero' => 'nullable|string|max:20',
            'nomSolicitante' => 'required|string|max:255',
            'idCategoria' => 'nullable|integer',
            'publicidad' => 'nullable|blob',
            'estadoEvento' => 'required|boolean',
        ]);
    }
}