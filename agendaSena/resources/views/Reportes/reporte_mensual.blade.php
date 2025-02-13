@extends('Layouts.Header') <!-- Asegúrate de que esta plantilla exista -->

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}"> <!-- Incluir el CSS específico -->
@endsection

@section('content')
    <h1>Reporte Mensual - {{ $mes }}/{{ $anio }}</h1>
    <p>Total de Eventos: {{ $estadisticas['totalEventos'] }}</p>
    <p>Evento con más aforo: {{ $estadisticas['eventoConMasAforo']->nomEvento ?? 'N/A' }}</p>

    <h2>Eventos por Categoría</h2>
    <ul>
        @foreach($estadisticas['eventosPorCategoria'] as $categoria => $count)
            <li>{{ $categoria }}: {{ $count }}</li>
        @endforeach
    </ul>

    <h2>Eventos por Responsable</h2>
    <ul>
        @foreach($estadisticas['eventosPorResponsable'] as $responsable => $count)
            <li>{{ $responsable }}: {{ $count }}</li>
        @endforeach
    </ul>
@endsection