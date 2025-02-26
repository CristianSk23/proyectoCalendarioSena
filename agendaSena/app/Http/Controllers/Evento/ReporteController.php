<?php

namespace App\Http\Controllers\Evento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evento\Evento;
use App\Models\Categoria\Categoria;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use PDF;



class ReporteController extends Controller
{
    public function index_report()
    {
        {
            // Calcular estadísticas
            $estadisticas = [
                'eventosPorCategoria' => Evento::select('idCategoria', DB::raw('count(*) as total'))
                    ->groupBy('idCategoria')
                    ->get()
                    ->pluck('total', 'idCategoria'),
                // Puedes agregar más estadísticas aquí
            ];
    
            return view('reportes.index_reportes', compact('estadisticas'));
        }
    }

    public function generarReporteMensual(Request $request)
    {
        $mes = $request->input('mes');
        $anio = $request->input('anio');

        $eventos = Evento::whereMonth('fechaEvento', $mes)
                         ->whereYear('fechaEvento', $anio)
                         ->get();

        $estadisticas = [
            'totalEventos' => $eventos->count(),
            'eventosPorCategoria' => $eventos->groupBy('idCategoria')->map->count(),
            'eventosPorResponsable' => $eventos->groupBy('responsable_id')->map->count(),
            'eventoConMasAforo' => $eventos->sortByDesc('aforoEvento')->first(),
            'actividadesMasFrecuentes' => $eventos->groupBy('idCategoria')->map->count()->sortDesc(),
        ];

        $pdf = PDF::loadView('reportes.reporte_mensual', compact('estadisticas', 'mes', 'anio'));
        return $pdf->download('reporte_mensual.pdf');
    }

    
    public function generarReporteAnual(Request $request)
    {
        $anio = $request->input('anio');

        $eventos = Evento::whereYear('fechaEvento', $anio)->get();

        $estadisticas = [
            'totalEventos' => $eventos->count(),
            'eventosPorCategoria' => $eventos->groupBy('idCategoria')->map->count(),
            'eventosPorResponsable' => $eventos->groupBy('responsable_id')->map->count(),
            'eventoConMasAforo' => $eventos->sortByDesc('aforoEvento')->first(),
            'actividadesMasFrecuentes' => $eventos->groupBy('idCategoria')->map->count()->sortDesc(),
        ];

        $pdf = PDF::loadView('reportes.reporte_anual', compact('estadisticas', 'anio'));
        return $pdf->download('reporte_anual.pdf');
    }
}
