@extends('Layouts.Header')

@section('contentReportes')
<div class="container">
    <h1 class="text-3xl font-bold mb-4 text-center">Resultados Filtrados</h1>

    <div class="bg-white p-6 rounded-lg shadow-md mb-4">
        <h2 class="text-xl font-semibold mb-4">Estadísticas de Eventos</h2>
        <p>Total de Eventos: {{ $estadisticas['totalEventos'] }}</p>
    </div>

    <div class="flex flex-wrap justify-center mb-4">
        <div class="chart-container" style="width: 300px; height: 200px;">
            <canvas id="eventosPorCategoriaChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('eventosPorCategoriaChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($eventosPorCategoria->pluck('nombre')) !!}, // Obtener los nombres de las categorías
                datasets: [{
                    label: 'Eventos por Categoría',
                    data: {!! json_encode($eventosPorCategoria->pluck('total')) !!}, // Obtener los totales
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
                            text: 'Categorías'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Número de Eventos'
                        }
                    }
                }
            }
        });
    </script>
</div>
@endsection