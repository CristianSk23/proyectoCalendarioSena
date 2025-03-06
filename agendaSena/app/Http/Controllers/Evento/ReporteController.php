<?php

namespace App\Http\Controllers\Evento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evento\Evento;
use App\Models\Categoria\Categoria;
use App\Models\Participante\Participante; // Asegúrate de que este modelo esté correctamente importado
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class ReporteController extends Controller
{
    public function index_report()
    {
        // Obtener todas las categorías
        $categorias = Categoria::pluck('nomCategoria', 'idCategoria');

        // Obtener todos los participantes
        $participantes = Participante::all(); // Cambia esto para obtener los participantes

        // Calcular estadísticas
        $estadisticas = [
            'eventosPorCategoria' => Evento::select('idCategoria', DB::raw('count(*) as total'))
                ->groupBy('idCategoria')
                ->get()
                ->map(function ($item) use ($categorias) {
                    return [
                        'nombre' => $categorias[$item->idCategoria],
                        'total' => $item->total,
                    ];
                }),

            // Obtener total de eventos del mes actual
            'totalEventosMes' => Evento::whereMonth('fechaEvento', date('m'))
                ->whereYear('fechaEvento', date('Y'))
                ->count(),

            // Obtener total de eventos del año actual
            'totalEventosAnio' => Evento::whereYear('fechaEvento', date('Y'))
                ->count(),

            // Obtener eventos del día actual
            'eventosDelDia' => Evento::whereDate('fechaEvento', today())->count(),

            // Obtener eventos por día del mes actual
            'eventosPorDia' => Evento::select(DB::raw('DAY(fechaEvento) as dia'), DB::raw('count(*) as total'))
                ->whereMonth('fechaEvento', date('m'))
                ->whereYear('fechaEvento', date('Y'))
                ->groupBy('dia')
                ->orderBy('dia')
                ->get()
                ->pluck('total', 'dia'),
        ];

        return view('reportes.index_reportes', compact('estadisticas', 'participantes')); // Cambia 'usuarios' por 'participantes'
    }

    public function generarReporteMensual(Request $request)
    {
        $request->validate([
            'mes' => 'required|integer|min:1|max:12',
            'anio' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

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
        $request->validate([
            'anio' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        $anio = $request->input('anio');

        // Obtener eventos del año especificado
        $eventos = Evento::whereYear('fechaEvento', $anio)->get();

        // Calcular estadísticas
        $estadisticas = [
            'totalEventos' => $eventos->count(),
            'eventosPorCategoria' => $eventos->groupBy('idCategoria')->map->count(),
            'eventosPorResponsable' => $eventos->groupBy('responsable_id')->map->count(),
            'eventoConMasAforo' => $eventos->sortByDesc('aforoEvento')->first(),
            'actividadesMasFrecuentes' => $eventos->groupBy('idCategoria')->map->count()->sortDesc(),
        ];

            // Generar el PDF
                $pdf = PDF::loadView('reportes.reporte_anual', compact('estadisticas', 'anio'));
                return $pdf->download('reporte_anual.pdf');
            }
        
            public function filtrarReportes(Request $request)
            {
                $request->validate([
                    'mes' => 'nullable|integer|min:1|max:12',
                    'anio' => 'nullable|integer|min:2000|max:' . date('Y'),
                    'dia' => 'nullable|integer|min:1|max:31',
                    'responsable_id' => 'nullable|exists:participantes,par_identificacion', // Asegúrate de que el ID del responsable exista en la tabla de participantes
                ]);
        
                $query = Evento::query();
        
                if ($request->filled('mes')) {
                    $query->whereMonth('fechaEvento', $request->input('mes'));
                }
        
                if ($request->filled('anio')) {
                    $query->whereYear('fechaEvento', $request->input('anio'));
                }
        
                if ($request->filled('dia')) {
                    $query->whereDay('fechaEvento', $request->input('dia'));
                }
        
                if ($request->filled('responsable_id')) {
                    $query->where('responsable_id', $request->input('responsable_id'));
                }
        
                $eventos = $query->get();
        
                // Calcular estadísticas
                $estadisticas = [
                    'totalEventos' => $eventos->count(),
                    'eventosPorCategoria' => $eventos->groupBy('idCategoria')->map->count(),
                    'eventosPorResponsable' => $eventos->groupBy('responsable_id')->map->count(),
                ];
        
                // Datos para las gráficas
                $eventosPorCategoria = $estadisticas['eventosPorCategoria']->map(function ($count, $idCategoria) {
                    return [
                        'nombre' => Categoria::find($idCategoria)->nomCategoria,
                        'total' => $count,
                    ];
                });
        
                return view('reportes.resultados', compact('estadisticas', 'eventos', 'eventosPorCategoria'));
            }
 }