@extends('Layouts.Header')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}"> <!-- Incluir el CSS específico -->
@endsection

@section('contentReportes')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Generar Reportes</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- Formulario para Reporte Mensual -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-2">Reporte Mensual</h2>
                <form action="{{ route('reportes.mensual') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="mes" class="block">Mes:</label>
                        <input type="number" name="mes" min="1" max="12" required class="border rounded px-2 py-1 w-full">
                    </div>
                    <div class="mb-4">
                        <label for="anio" class="block">Año:</label>
                        <input type="number" name="anio" required class="border rounded px-2 py-1 w-full">
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Generar Reporte Mensual</button>
                </form>
            </div>

            <!-- Formulario para Reporte Anual -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-2">Reporte Anual</h2>
                <form action="{{ route('reportes.anual') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="anio" class="block">Año:</label>
                        <input type="number" name="anio" required class="border rounded px-2 py-1 w-full">
                    </div>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Generar Reporte Anual</button>
                </form>
            </div>
        </div>

        <h2 class="text-2xl font-semibold mb-4">Estadísticas de Eventos</h2>
        <canvas id="eventosPorCategoriaChart" width="400" height="200"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('eventosPorCategoriaChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($estadisticas['eventosPorCategoria']->toArray())) !!}, // Asegúrate de pasar las categorías desde el controlador
                datasets: [{
                    label: 'Eventos por Categoría',
                    data: {!! json_encode(array_values($estadisticas['eventosPorCategoria']->toArray())) !!}, // Asegúrate de pasar los datos desde el controlador
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