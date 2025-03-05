@extends('Layouts.Header')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}"> <!-- Incluir el CSS específico -->
@endsection

@section('contentReportes')
<div class="container">
    <h1 class="text-3xl font-bold mb-4 text-center">Generar Reportes</h1>

     <!-- Tablero de Eventos -->
     <div class="bg-white p-6 rounded-lg shadow-md mb-4">
        <h2 class="text-xl font-semibold mb-4">Eventos hasta la Fecha</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-100 p-4 rounded-lg text-center">
                <h3 class="text-lg font-semibold">Eventos del Día</h3>
                <p class="text-2xl font-bold">{{ $estadisticas['eventosDelDia'] }}</p>
            </div>
            <div class="bg-green-100 p-4 rounded-lg text-center">
                <h3 class="text-lg font-semibold">Eventos del Mes</h3>
                <p class="text-2xl font-bold">{{ $estadisticas['totalEventosMes'] }}</p>
            </div>
            <div class="bg-yellow-100 p-4 rounded-lg text-center">
                <h3 class="text-lg font-semibold">Eventos del Año</h3>
                <p class="text-2xl font-bold">{{ $estadisticas['totalEventosAnio'] }}</p>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap justify-center mb-4">
        <div class="chart-container" style="width: 300px; height: 200px;">
            <canvas id="eventosPorCategoriaChart"></canvas>
        </div>
        <div class="chart-container" style="width: 300px; height: 200px;">
            <canvas id="eventosMensualesChart"></canvas>
        </div>
        <div class="chart-container" style="width: 300px; height: 200px;">
            <canvas id="eventosAnualesChart"></canvas>
        </div>
    </div>


    <div class="flex flex-wrap justify-center mb-4">
        <div class="chart-container" style="width: 300px; height: 200px;">
            <canvas id="eventosPorCategoriaChart"></canvas>
        </div>
        <div class="chart-container" style="width: 300px; height: 200px;">
            <canvas id="eventosMensualesChart"></canvas>
        </div>
        <div class="chart-container" style="width: 300px; height: 200px;">
            <canvas id="eventosAnualesChart"></canvas>
        </div>
    </div>

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

    <h2 class="text-2xl font-semibold mb-4 text-center">Estadísticas de Eventos</h2>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx1 = document.getElementById('eventosPorCategoriaChart').getContext('2d');
    var myChart1 = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: {!! json_encode($estadisticas['eventosPorCategoria']->pluck('nombre')) !!}, // Obtener los nombres de las categorías
            datasets: [{
                label: 'Eventos por Categoría',
                data: {!! json_encode($estadisticas['eventosPorCategoria']->pluck('total')) !!}, // Obtener los totales
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Categorías' // Título del eje X
                    }
                },
                y: {
                    beginAtZero: true,
                    min: 0, // Establece el valor mínimo
                    max: 20, // Establece el valor máximo
                    title: {
                        display: true,
                        text: 'Número de Eventos' // Título del eje Y
                    }
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
                    beginAtZero: true,
                    min: 0, // Establece el valor mínimo
                    max: 20, // Establece el valor máximo
                    title: {
                        display: true,
                        text: 'Número de Eventos' // Cambia este texto por el que desees
                    }
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
                    beginAtZero: true,
                    min: 0, // Establece el valor mínimo
                    max: 20, // Establece el valor máximo
                    title: {
                        display: true,
                        text: 'Número de Eventos' // Título del eje Y
                    }
                }
            }
        }
    });
</script>

@endsection