<?php

namespace App\Http\Controllers;

use App\Models\Categoria\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all(); // Obtener todas las categorías
        return view('categoria.index', compact('categorias')); // Retornar la vista con las categorías
    }

    public function create()
    {
        return view('categoria.create'); // Retornar la vista para crear una nueva categoría
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomCategoria' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'estadoCategoria' => 'required|boolean',
        ]);

        Categoria::create($request->all()); // Crear una nueva categoría
        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function edit(Categoria $categoria)
    {
        return view('categoria.edit', compact('categoria')); // Retornar la vista para editar la categoría
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nomCategoria' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'estadoCategoria' => 'required|boolean',
        ]);

        $categoria->update($request->all()); // Actualizar la categoría
        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete(); // Eliminar la categoría
        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}
