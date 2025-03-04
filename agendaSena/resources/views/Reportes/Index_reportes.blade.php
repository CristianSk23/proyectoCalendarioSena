@extends('Layouts.Header')
<!-- views/Reportes/Index_reportes -->
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}"> <!-- Incluir el CSS específico -->
@endsection

@section('contentReportes')


<div class="container">
<div class="flex flex-col items-center">
    <div class="chart-container" style="width: 250px; height: 150px;">
        <canvas id="eventosPorCategoriaChart" width="250" height="150"></canvas>
    </div>
    <div class="chart-container" style="width: 250px; height: 150px;">
        <canvas id="eventosMensualesChart" width="250" height="150"></canvas>
    </div>
    <div class="chart-container" style="width: 250px; height: 150px;">
        <canvas id="eventosAnualesChart" width="250" height="150"></canvas>
    </div>
</div>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Generar Reportes</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
     

    
    <!-- Formulario para Reporte Mensual -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Reporte Mensual</h2>
                <form action="{{ route('reportes.mensual') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="mes" class="block text-gray-700">Mes:</label>
                        <select name="mes" required class="border rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach (['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] as $index => $mes)
                                <option value="{{ $index + 1 }}">{{ $mes }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="anio" class="block text-gray-700">Año:</label>
                        <input type="number" name="anio" required class="border rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">Generar Reporte Mensual</button>
                </form>
            </div>

            <!-- Formulario para Reporte Anual -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Reporte Anual</h2>
                <form action="{{ route('reportes.anual') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="anio" class="block text-gray-700">Año:</label>
                        <input type="number" name="anio" required class="border rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-200">Generar Reporte Anual</button>
                </form>
            </div>
        </div>

        <h2 class="text-2xl font-semibold mb-4">Estadísticas de Eventos</h2>
        <canvas id="eventosPorCategoriaChart" width="400" height="200"></canvas>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx1 = document.getElementById('eventosPorCategoriaChart').getContext('2d');
    var myChart1 = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($estadisticas['eventosPorCategoria']->toArray())) !!},
            datasets: [{
                label: 'Eventos por Categoría',
                data: {!! json_encode(array_values($estadisticas['eventosPorCategoria']->toArray())) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                beginAtZero: true,
                min: 0, // Establece el valor mínimo
                max: 20 // Establece el valor máximo
            }
            }
        }
    });


    

    // Gráfica de eventos mensuales
    var ctx2 = document.getElementById('eventosMensualesChart').getContext('2d');
    var myChart2 = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Total Eventos Este Mes'],
            datasets: [{
                label: 'Eventos',
                data: [{{ $estadisticas['totalEventosMes'] }}],
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                title: {
                    display: true,
                    text: 'Mes' // Etiqueta del eje X
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Número de Eventos' // Etiqueta del eje Y
                },
                beginAtZero: true
            }
            }
        }
    });

    // Gráfica de eventos anuales
    var ctx3 = document.getElementById('eventosAnualesChart').getContext('2d');
    var myChart3 = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: ['Total Eventos Este Año'],
            datasets: [{
                label: 'Eventos',
                data: [{{ $estadisticas['totalEventosAnio'] }}],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                title: {
                    display: true,
                    text: 'Año' // Etiqueta del eje X
                }
            },
                y: {
                    title: {
                        display: true,
                        text: 'Número de Eventos' // Etiqueta del eje Y
                    },
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection