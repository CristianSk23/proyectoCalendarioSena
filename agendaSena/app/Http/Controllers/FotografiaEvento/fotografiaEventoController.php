<?php

namespace App\Http\Controllers\FotografiaEvento;

use App\Http\Controllers\Controller;
use App\Models\fotografiasEvento\FotografiaEvento;
use App\Models\Evento\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Log;



class FotografiaEventoController extends Controller
{
    public function paginaPrincinpal($idEvento)
    {
        $fotografiasEvento = FotografiaEvento::where('idEvento', $idEvento)->get(); // Obtener las fotografías del evento

        return view('Evento.fotosEvento', compact('idEvento', 'fotografiasEvento'));
    }

    public function create(Request $request)
    {


        $request->validate([
            'imagenes.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validar imágenes
        ]);

        $idEvento = $request->route('idEvento'); // Obtener el idEvento desde la URL
        $imagenes = $request->file('imagenes'); // Obtener las imágenes del request

        foreach ($imagenes as $imagen) {
            // Guardar la imagen en la carpeta local
            if ($imagen->isValid()) {
                $rutaImagen = $imagen->store('fotosEvento', 'public'); // Guardar la imagen en la carpeta 'fotosEvento' dentro de 'storage/app/public'
            } else {
            }

            // Guardar la información en la base de datos
            FotografiaEvento::create([
                'idEvento' => $idEvento,
                'ruta' => $rutaImagen,
            ]);
        }



        return redirect()->route('calendario.index')
            ->with('success', 'Las imágenes se han subido correctamente.');
    }


    public function delete(Request $request, $idFotografia)
    {
        $fotografia = FotografiaEvento::findOrFail($idFotografia); // Buscar la fotografía por su ID

        // Eliminar el archivo de la carpeta local
        Storage::disk('public')->delete($fotografia->ruta);
        // Eliminar la entrada de la base de datos
        $fotografia->delete();
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Fotografía eliminada correctamente.']);
        }
        return redirect()->back()->with('success', 'La fotografía se ha eliminado correctamente.');
    }
}
