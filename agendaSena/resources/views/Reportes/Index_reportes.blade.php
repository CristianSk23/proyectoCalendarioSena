@extends('Layouts.plantilla')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800 text-center">Panel de Reportes</h1>
        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('calendario.index') }}" class="btn btn-success me-2">Regresar</a>

        </div>
        <!-- Estadísticas -->
        <div class="row justify-content-center">
            <div class="col-md-4 mb-4">
                <a href="#" class="btn-modal-eventos" data-tipo="mes" data-bs-toggle="modal" data-bs-target="#modalEventos"
                    style="text-decoration: none;">
                    <div class="card border-left-success shadow h-100 py-2" id="card-eventos-mes">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Eventos del Mes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['totalEventosMes'] }}</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-4">
                <a href="#" class="btn-modal-eventos" data-tipo="anio" data-bs-toggle="modal" data-bs-target="#modalEventos"
                    style="text-decoration: none;">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Eventos del Año</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['totalEventosAnio'] }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>


        <!-- Filtros y Gráficas -->
        <div class="row mb-4">
            <div class="col-md-12 d-flex justify-content-end">
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



        <!-- Modal Detalles Eventos -->
        <div class="modal fade" id="modalEventos" tabindex="-1" aria-labelledby="modalEventosLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEventosLabel">Eventos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body" id="modalEventosBody">
                        <!-- Aquí se cargará dinámicamente la lista de eventos -->
                        <p>Cargando eventos...</p>
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




                $('.btn-modal-eventos').click(function () {
                    const tipo = $(this).data('tipo'); // "mes" o "anio"
                    const modalTitle = tipo === 'mes' ? 'Eventos del Mes' : 'Eventos del Año';
                    $('#modalEventosLabel').text(modalTitle);
                    $('#modalEventosBody').html('<p>Cargando eventos...</p>');

                    // Petición para obtener eventos según tipo
                    fetch(`/reportes/eventos/${tipo}`)
                        .then(response => {
                            if (!response.ok) throw new Error('Error al cargar eventos');
                            return response.json();
                        })
                        .then(eventos => {
                            if (eventos.length === 0) {
                                $('#modalEventosBody').html('<p>No hay eventos registrados para este periodo.</p>');
                                return;
                            }

                            let html = '<div class="row">';
                            eventos.forEach(evento => {
                                html += `
                                        <div class="col-md-4 mb-3">
                                            <div class="card h-100 shadow-sm border-left-primary">
                                                <div class="card-body">
                                                    <h6 class="card-title text-success">${evento.nomEvento}</h6>
                                                    <p class="mb-1"><strong>Fecha:</strong> ${evento.fechaEventoFormatted}</p>
                                                    <p class="mb-1"><strong>Solicitante:</strong> ${evento.nomSolicitante}</p>
                                                    <p class="mb-0"><strong>Ambiente:</strong> ${evento.ambiente ?? 'Sin Ambiente'}</p>
                                                    <p class="mb-0"><strong>Categoría:</strong> ${evento.categoria ?? 'Sin categoría'}</p>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                            });
                            html += '</div>';

                            $('#modalEventosBody').html(html);
                        })
                        .catch(error => {
                            $('#modalEventosBody').html('<p>Error cargando los eventos.</p>');
                            console.error(error);
                        });
                });








            });
        </script>
@endsection


    {{-- @foreach ($estadisticas['detalleEventosDelMes'] as $evento)
    <tr>
        <td>{{ $evento->nomEvento }}</td>
        <td>{{ $evento->fechaEvento }}</td>
        <td>{{ $evento->nomSolicitante }}</td>
        <td>{{ $evento->categoria->nombreCategoria ?? 'Sin categoría' }}</td>
    </tr>
    @endforeach --}}