@extends('Layouts.Header') <!-- Asegúrate de que esta plantilla exista -->
<!-- views/Reportes/reporte_anual -->
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}"> <!-- Incluir el CSS específico -->
@endsection

@section('contentReportes')

    <title>Reporte Anual - {{ $anio }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1, h2, h3 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Reporte Anual</h1>
    <h2>Año: {{ $anio }}</h2>

    <h3>Total de Eventos: {{ $estadisticas['totalEventos'] }}</h3>

    <h3>Eventos por Categoría</h3>
    <table>
        <thead>
            <tr>
                <th>Categoría</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estadisticas['eventosPorCategoria'] as $idCategoria => $total)
                <tr>
                    <td>{{ $idCategoria }}</td>
                    <td>{{ $total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Eventos por Responsable</h3>
    <table>
        <thead>
            <tr>
                <th>Responsable</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estadisticas['eventosPorResponsable'] as $responsableId => $total)
                <tr>
                    <td>{{ $responsableId }}</td>
                    <td>{{ $total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Evento con Más Aforo</h3>
    <p>{{ $estadisticas['eventoConMasAforo']->nombreEvento ?? 'No hay eventos' }}</p>

@endsection