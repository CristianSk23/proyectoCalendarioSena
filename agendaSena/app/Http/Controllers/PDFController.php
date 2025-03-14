<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento\Evento; // Asegúrate de que este modelo esté correctamente importado
use Barryvdh\DomPDF\Facade as PDF;

class PdfController extends Controller
{
    public function generarReporteMensual(Request $request)
    {
        // Validar la entrada
        $request->validate([
            'mes' => 'required|integer|min:1|max:12',
            'anio' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        // Obtener eventos del mes y año especificados
        $eventos = Evento::whereMonth('fechaEvento', $request->mes)
            ->whereYear('fechaEvento', $request->anio)
            ->get();

        // Pasar los datos a la vista
        $pdf = PDF::loadView('reportes.pdf.mensual', compact('eventos', 'request'));

        // Descargar el PDF
        return $pdf->download('reporte_mensual_' . $request->mes . '_' . $request->anio . '.pdf');
    }
}