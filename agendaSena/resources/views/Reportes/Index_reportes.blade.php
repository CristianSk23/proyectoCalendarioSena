@extends('Layouts.Header')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}"> <!-- Incluir el CSS específico -->
@endsection

@section('contentReportes')
    <!-- index_reportes.blade.php -->

    <h1>Reportes</h1>

    <form action="{{ route('reportes.mensual') }}" method="POST">
        @csrf
        <label for="mes">Mes:</label>
        <input type="number" name="mes" min="1" max="12" required>
        <label for="anio">Año:</label>
        <input type="number" name="anio" required>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Generar Reporte Mensual</button>
    </form>
    <h1 class="text-2xl font-bold mb-4">Generar Reportes</h1>

    <form action="{{ route('reportes.mensual') }}" method="POST" class="mb-4">
        @csrf
        <label for="mes">Mes:</label>
        <input type="number" name="mes" min="1" max="12" required>
        <label for="anio">Año:</label>
        <input type="number" name="anio" required>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Generar Reporte Mensual</button>
    </form>

    <form action="{{ route('reportes.anual') }}" method="POST">
        @csrf
        <label for="anio">Año:</label>
        <input type="number" name="anio" required>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Generar Reporte Anual</button>
    </form>

    <canvas id="myChart" width="400" height="200"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Categoría 1', 'Categoría 2', 'Categoría 3'],
                datasets: [{
                    label: 'Eventos por Categoría',
                    data: [12, 19, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
