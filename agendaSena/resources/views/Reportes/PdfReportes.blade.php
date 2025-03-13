<!DOCTYPE html>
<html>
<head>
    <title>Reporte Mensual</title>
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
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Reporte Mensual</h1>
    <h2>Año: {{ $request->anio }} - Mes: {{ $request->mes }}</h2>

    <h3>Total de Eventos: {{ $eventos->count() }}</h3>

    <h3>Eventos</h3>
    <table>
        <thead>
            <tr>
                <th>Nombre del Evento</th>
                <th>Fecha</th>
                <th>Responsable</th>
            </tr>
        </thead>
        <tbody>
            @foreach($eventos as $evento)
                <tr>
                    <td>{{ $evento->nombreEvento }}</td>
                    <td>{{ $evento->fechaEvento->format('d/m/Y') }}</td>
                    <td>{{ $evento->responsable->nombre }}</td> <!-- Asegúrate de que el modelo Evento tenga la relación con Responsable -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>