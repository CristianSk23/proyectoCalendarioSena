<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FondoController extends Controller
{
    public function subir(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagen = $request->file('imagen');
        $nombre = 'img' . time() . '.' . $imagen->getClientOriginalExtension();
        $imagen->move(public_path('imgLogin'), $nombre);

        return back()->with('success', 'Imagen subida correctamente.');
    }

    public function seleccionar(Request $request)
    {
        $imagenes = $request->input('imagenes', []);
    
        if (empty($imagenes)) {
            return back()->with('error', 'No se seleccionaron imágenes.');
        }
    
        // Guardar los nombres separados por saltos de línea
        $contenido = implode("\n", $imagenes);
    
        // Guardar en storage/app/fondo_actual.txt
        Storage::put('fondo_actual.txt', $contenido);
    
        return back()->with('success', 'Imágenes de fondo actualizadas correctamente.');
    }
}
