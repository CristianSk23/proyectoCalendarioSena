@extends('Layouts.Header') <!-- Asegúrate de que esta plantilla exista -->
<!-- views/Reportes/reporte_mensual -->
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}"> <!-- Incluir el CSS específico -->
@endsection

@section('contentReportes')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Reporte Mensual - {{ $mes }}/{{ $anio }}</h1>
        <p class="mb-4">Total de Eventos: <strong>{{ $estadisticas['totalEventos'] }}</strong></p>
        <p class="mb-4">Evento con más aforo: <strong>{{ $estadisticas['eventoConMasAforo']->nomEvento ?? 'N/A' }}</strong></p>

        <h2 class="text-2xl font-semibold mb-2">Eventos por Categoría</h2>
        <ul class="list-disc pl-5 mb-4">
            @foreach($estadisticas['eventosPorCategoria'] as $categoria => $count)
                <li>{{ $categoria }}: <strong>{{ $count }}</strong></li>
            @endforeach
        </ul>

        <h2 class="text-2xl font-semibold mb-2">Eventos por Responsable</h2>
        <ul class="list-disc pl-5 mb-4">
            @foreach($estadisticas['eventosPorResponsable'] as $responsable => $count)
                <li>{{ $responsable }}: <strong>{{ $count }}</strong></li>
            @endforeach
        </ul>

        <h2 class="text-2xl font-semibold mb-2">Actividades Más Frecuentes</h2>
        <ul class="list-disc pl-5 mb-4">
            @foreach($estadisticas['actividadesMasFrecuentes'] as $categoria => $count)
                <li>{{ $categoria }}: <strong>{{ $count }}</strong></li>
            @endforeach
        </ul>
    </div>



    
@endsection