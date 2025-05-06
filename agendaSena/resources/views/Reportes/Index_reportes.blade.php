@extends('Layouts.plantilla')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800 text-center">Panel de Reportes</h1>

        <div class="d-flex justify-content-end mb-4">
            <button class="btn btn-success">Regresar</button>
        </div>
        <!-- Estadísticas -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Eventos del Día</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['eventosDelDia'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Eventos del Mes</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['totalEventosMes'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Eventos del Año</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['totalEventosAnio'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros y Gráficas -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Filtrar Por: <span id="filtro-actual">Ambiente</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item filtro-opcion active" data-filtro="ambiente">Ambiente</a></li>
                        <li><a class="dropdown-item filtro-opcion" data-filtro="encargado">Encargado</a></li>
                        <li><a class="dropdown-item filtro-opcion" data-filtro="categoria">Categoría</a></li>
                        <li><a class="dropdown-item filtro-opcion" data-filtro="mes">Mes</a></li>
                        <li><a class="dropdown-item filtro-opcion" data-filtro="anio">Año</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Contenedor de la gráfica -->
        <div class="row">
            <div class="col-lg-8 mx-auto mb-4">
                <div class="card shadow">
                    <div class="card-header" id="titulo-grafica">Eventos por Ambiente</div>
                    <div class="card-body">
                        <canvas id="grafica-principal"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

        <script>
            $(document).ready(function () {
                // Inicializar gráfica con datos de ambiente por defecto
                const ctx = document.getElementById('grafica-principal').getContext('2d');
                let graficaPrincipal = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($estadisticas['eventosPorAmbiente']->pluck('etiqueta')) !!},
                        datasets: [{
                            label: 'Eventos por Ambiente',
                            data: {!! json_encode($estadisticas['eventosPorAmbiente']->pluck('total')) !!},
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Manejar selección de filtros
                $('.filtro-opcion').click(function (e) {
                    e.preventDefault();

                    // Remover clase active de todos los items
                    $('.filtro-opcion').removeClass('active');
                    // Agregar clase active al seleccionado
                    $(this).addClass('active');

                    const filtro = $(this).data('filtro');
                    $('#filtro-actual').text(
                        filtro === 'ambiente' ? 'Ambiente' :
                            filtro === 'encargado' ? 'Encargado' :
                                filtro === 'categoria' ? 'Categoría' :
                                    filtro === 'mes' ? 'Mes' : 'Año'
                    );

                    // Hacer petición al backend
                    fetch(`/reportes/filtrar?filtro=${filtro}`)
                        .then(response => {
                            if (!response.ok) throw new Error('Error al cargar datos');
                            return response.json();
                        })
                        .then(data => {
                            console.log(data);
                            actualizarGrafica(data, filtro);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Mostrar notificación de error si es necesario
                        });
                });

                function actualizarGrafica(data, filtro) {
                    // Configurar título y tipo de gráfica según el filtro
                    console.log(data);
                    
                    let titulo = '';
                    let tipoGrafica = 'bar'; // Por defecto usamos barras
                    let color = 'rgba(54, 162, 235, 0.2)';
                    let borderColor = 'rgba(54, 162, 235, 1)';

                    switch (filtro) {
                        case 'ambiente':
                            titulo = 'Eventos por Ambiente';
                            break;
                        case 'encargado':
                            titulo = 'Eventos por Encargado';
                            break;
                        case 'categoria':
                            titulo = 'Eventos por Categoría';
                            break;
                        case 'mes':
                            titulo = 'Eventos Mensuales';
                            tipoGrafica = 'line'; // Para meses usamos gráfica de líneas
                            color = 'rgba(75, 192, 192, 0.2)';
                            borderColor = 'rgba(75, 192, 192, 1)';
                            break;
                        case 'anio':
                            titulo = 'Eventos Anuales';
                            break;
                    }

                    // Actualizar título
                    $('#titulo-grafica').text(titulo);

                    // Actualizar datos de la gráfica
                    graficaPrincipal.data.labels = data.map(item => item.etiqueta || item.nombre || item.mes);
                    graficaPrincipal.data.datasets[0].data = data.map(item => item.total);
                    graficaPrincipal.data.datasets[0].label = titulo;
                    graficaPrincipal.data.datasets[0].backgroundColor = color;
                    graficaPrincipal.data.datasets[0].borderColor = borderColor;
                    graficaPrincipal.type = tipoGrafica;

                    // Actualizar gráfica
                    graficaPrincipal.update();
                }
            });
        </script>
@endsection