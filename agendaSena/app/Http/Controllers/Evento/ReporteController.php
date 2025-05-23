<?php

namespace App\Http\Controllers\Evento;

use App\Http\Controllers\Controller;
use App\Models\Ambiente\Ambiente;
use Illuminate\Http\Request;
use App\Models\Evento\Evento;
use App\Models\Categoria\Categoria;
use App\Models\Participante\Participante; // Asegúrate de que este modelo esté correctamente importado
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use DateTime;
use Illuminate\Support\Facades\Log;

class ReporteController extends Controller
{


    public function index_report()
    {


        // Obtener ambientes con eventos
        $ambientes = Evento::with('ambiente')
            ->select('pla_amb_id', DB::raw('count(*) as total'))
            ->groupBy('pla_amb_id')
            ->get()
            ->map(function ($item) {
                return [
                    'etiqueta' => $item->ambiente->pla_amb_descripcion,
                    'total' => $item->total,
                ];
            });


        $estadisticas = [

            'eventosPorAmbiente' => $ambientes,

            // Tarjeta: Total eventos del mes actual
            'eventosDelMesActual' => Evento::whereMonth('fechaEvento', date('m'))
                ->whereYear('fechaEvento', date('Y'))
                ->select('nomEvento', 'fechaEvento', 'nomSolicitante', 'idCategoria')
                ->count(),

            // Gráfico: Total eventos por mes del año actual
            'totalEventosMes' => Evento::whereMonth('fechaEvento', date('m'))
                ->whereYear('fechaEvento', date('Y'))
                ->count(),


            // Obtener total de eventos del año actual
            'totalEventosAnio' => Evento::whereYear('fechaEvento', date('Y'))
                ->count(),


            // Tarjeta: Total eventos del día actual
            'eventosDelDia' => Evento::whereDate('fechaEvento', today())->count(),





        ];




        return view('reportes.index_reportes', compact('estadisticas'));
    }





    public function filtrarEventos(Request $request)
    {
        $filtro = $request->input('filtro');
        switch ($filtro) {
            case 'categoria':
                $eventos = DB::table('evento')
                    ->select('categoria.nomCategoria as etiqueta', DB::raw('count(*) as total'))
                    ->join('categoria', 'evento.idCategoria', '=', 'categoria.idCategoria')
                    ->groupBy('categoria.nomCategoria')
                    ->get();
                break;

            case 'encargado':
                $eventos = DB::table('evento')
                    ->join('sep_participante', 'evento.par_identificacion', '=', 'sep_participante.par_identificacion')
                    ->selectRaw("CONCAT(sep_participante.par_nombres, ' ', sep_participante.par_apellidos) as nombre, COUNT(*) as total")
                    ->groupBy('sep_participante.par_nombres', 'sep_participante.par_apellidos')
                    ->get();

                break;

            case 'ambiente':
                log::info('Ambiente');
                $eventos = Evento::with('ambiente')
                    ->select('pla_amb_id', DB::raw('count(*) as total'))
                    ->groupBy('pla_amb_id')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'etiqueta' => $item->ambiente->pla_amb_descripcion,
                            'total' => $item->total,
                        ];
                    });
                break;

            case 'mes':
                $eventos = DB::table('evento')
                    ->select(
                        DB::raw('MONTH(fechaEvento) as mes_numero'),
                        DB::raw('count(*) as total')
                    )
                    ->whereYear('fechaEvento', date('Y')) // Solo eventos del año actual
                    ->groupBy(DB::raw('MONTH(fechaEvento)'))
                    ->orderBy(DB::raw('MONTH(fechaEvento)'))
                    ->get();

                // Convertir número de mes a nombre
                $meses = [
                    1 => 'Enero',
                    2 => 'Febrero',
                    3 => 'Marzo',
                    4 => 'Abril',
                    5 => 'Mayo',
                    6 => 'Junio',
                    7 => 'Julio',
                    8 => 'Agosto',
                    9 => 'Septiembre',
                    10 => 'Octubre',
                    11 => 'Noviembre',
                    12 => 'Diciembre'
                ];

                // Agregar la etiqueta del nombre del mes
                foreach ($eventos as $evento) {
                    $evento->etiqueta = $meses[$evento->mes_numero] ?? 'Desconocido';
                }

                return response()->json($eventos);


            case 'anio':
                $eventos = DB::table('evento')
                    ->select(DB::raw('YEAR(fechaEvento) as etiqueta'), DB::raw('count(*) as total'))
                    ->groupBy(DB::raw('YEAR(fechaEvento)'))
                    ->orderBy(DB::raw('YEAR(fechaEvento)'))
                    ->get();

                break;


            default:
                $eventos = [];
                break;
        }
        Log::info($eventos);
        return response()->json($eventos);
    }


    public function eventosMesJson()
    {
        $eventos = Evento::with('categoria', 'ambiente')
            ->where('estadoEvento', '!=', '0')
            ->whereMonth('fechaEvento', date('m'))
            ->whereYear('fechaEvento', date('Y'))
            ->get()
            ->map(function ($evento) {
                return [
                    'nomEvento' => $evento->nomEvento,
                    'fechaEventoFormatted' => \Carbon\Carbon::parse($evento->fechaEvento)->format('d/m/Y'),
                    'nomSolicitante' => $evento->nomSolicitante,
                    'ambiente' => $evento->ambiente->pla_amb_descripcion ?? null,
                    'categoria' => $evento->categoria->nomCategoria ?? null,
                ];
            });

        return response()->json($eventos);
    }

    public function eventosAnioJson()
    {
        $eventos = Evento::with('categoria', 'ambiente')
            ->where('estadoEvento', '!=', '0')
            ->whereYear('fechaEvento', date('Y'))
            ->get()
            ->map(function ($evento) {
                return [
                    'nomEvento' => $evento->nomEvento,
                    'fechaEventoFormatted' => \Carbon\Carbon::parse($evento->fechaEvento)->format('d/m/Y'),
                    'nomSolicitante' => $evento->nomSolicitante,
                    'ambiente' => $evento->ambiente->pla_amb_descripcion ?? null,
                    'categoria' => $evento->categoria->nomCategoria ?? null,
                ];
            });

        return response()->json($eventos);
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
