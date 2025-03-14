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

        // Obtener responsables que han realizado al menos un evento
        $participantes = Participante::whereIn('par_identificacion', function($query) {
            $query->select('par_identificacion')
                ->from('evento') // Asegúrate de que este sea el nombre correcto de tu tabla de eventos
                ->distinct();
        })->get();

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

        return view('reportes.index_reportes', compact('estadisticas', 'participantes'));
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

        // Calcular estadísticas
        $estadisticas = [
            'totalEventos' => $eventos->count(),
            'eventoConMasAforo' => $eventos->sortByDesc('aforo')->first(),
            'eventosPorCategoria' => $eventos->groupBy('idCategoria')->map->count(),
            'eventosPorResponsable' => $eventos->groupBy('responsable_id')->map->count(),
            'actividadesMasFrecuentes' => $eventos->groupBy('actividad')->map->count(),
        ];

        // Pasar los datos a la vista
        return view('Reportes.reporte_mensual', [
            'mes' => $request->mes, // Pasar la variable mes
            'anio' => $request->anio, // Pasar la variable anio
            'estadisticas' => $estadisticas,
        ]);
    }


    public function generarReporteAnual(Request $request)
    {
        // Validar la entrada
        $request->validate([
            'anio' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        // Obtener eventos del año especificado
        $eventos = Evento::whereYear('fechaEvento', $request->anio)->get();

        // Calcular estadísticas
        $estadisticas = [
            'totalEventos' => $eventos->count(),
            'eventoConMasAforo' => $eventos->sortByDesc('aforo')->first(),
            'eventosPorCategoria' => $eventos->groupBy('idCategoria')->map->count(),
            'eventosPorResponsable' => $eventos->groupBy('responsable_id')->map->count(),
        ];

        // Pasar los datos a la vista
        return view('Reportes.reporte_anual', [
            'anio' => $request->anio, // Pasar la variable anio
            'estadisticas' => $estadisticas,
        ]);
    }


 }