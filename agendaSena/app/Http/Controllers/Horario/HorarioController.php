<?php

namespace App\Http\Controllers\Horario;

use App\Http\Controllers\Controller;
use App\Models\Horario\Horario;
use Illuminate\Http\Request;
use App\Models\Ambiente\Ambiente;

class HorarioController extends Controller
{
    public function index()
    {
        // $horarios = Horario::all(); // Esto buscará en la tabla 'hoarrio'
        // return view('Horario.inicioHorario', compact('horarios'));
        $horarios = Horario::with('ambiente')->get(); // carga lo relacionado mediante la llave foranea
        return view('Horario.inicioHorario', compact('horarios'));
    }

    public function create()
    {
        return view('Horario.crearHorario');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pla_amb_id' => 'required|integer',
            'inicio' => 'required|string|max:255',
            'fin' => 'required|string|max:255',
            'estadoHora' => 'required|boolean',
        ]);

        Horario::create($request->all()); 
        return redirect()->route('horarios.index')->with('success', 'Horario creado exitosamente.');
    }

    // public function edit($id)
    // {
    //     $horario = Horario::findOrFail($id); // buscar en la tabla agendasena
    //     //return view('Horario.editarHorario', compact('horario'));
       

    // $ambientes = Ambiente::all(); 

    // return view('horarios.edit', compact('horario', 'ambientes'));
    // }

    public function edit(Horario $horario)
    {
        $ambientes = Ambiente::all(); // Cargar ambientes para el select
        return view('Horario.editarHorario', compact('horario', 'ambientes'));
        
    }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'pla_amb_id' => 'required|integer',
    //         'inicio' => 'required|string|max:255',
    //         'fin' => 'required|string|max:255',
    //         'estadoHora' => 'required|boolean',
    //     ]);

    //     $horario = Horario::findOrFail($id); // Esto buscará en la tabla 'hoarrio'
    //     $horario->update($request->all()); // Esto actualizará en la tabla 'hoarrio'
    //     return redirect()->route('horarios.index')->with('success', 'Horario actualizado exitosamente.');
    // }

    public function update(Request $request, Horario $horario)
{
    $this->validateRequest($request);
    $horario->update($request->all());
    return redirect()->route('horarios.index')->with('success', 'Horario actualizado exitosamente.');
}

    public function destroy($id)
    {
        $horario = Horario::findOrFail($id);// busca
        $horario->delete(); // eliminar
        return redirect()->route('horarios.index')->with('success', 'Horario eliminado exitosamente.');// redirecciona
    }

    private function validateRequest(Request $request)
{
    return $request->validate([
        'pla_amb_id' => 'required|integer',
        'inicio' => 'required|string|max:255',
        'fin' => 'required|string|max:255',
        'estadoHora' => 'required|boolean',
    ]);
}
    

}