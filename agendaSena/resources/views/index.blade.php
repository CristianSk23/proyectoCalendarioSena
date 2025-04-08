@extends('Layouts.Plantilla')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
@endsection

@section('content')

    <div class="container mx-auto p-4">
        <h1 class="display-4 text-center mb-4">Calendario de Eventos</h1>

        <!-- Navegación entre meses -->
        <div class="d-flex justify-content-between align-items-center mb-6">
            <a href="javascript:void(0);" class="btn btn-success" id="prevMonth">
                <i class="bx bxs-left-arrow" style="transform: scaleY(-1);"></i>
            </a>

            <h2 id="mesAnio" class="h5 font-weight-bold"></h2>

            <a href="javascript:void(0);" class="btn btn-success" id="nextMonth">
                <i class="bx bxs-right-arrow" style="transform: scaleY(-1);"></i>
            </a>
        </div>

        <table id="calendario" class="table table-bordered table-responsive"></table>

        <!-- Modal de Confirmación -->
        <div id="confirmModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-title"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Eliminar Evento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-sm text-gray-500" id="modalMessage">¿Está seguro que desea eliminar este evento?</p>
                    </div>
                    <div class="modal-footer">
                        <button id="confirmDelete" type="button" class="btn btn-danger">Eliminar</button>
                        <button id="cancelDelete" type="button" class="btn btn-secondary"
                            data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarioTabla = document.getElementById('calendario');
            const mesAnioElemento = document.getElementById('mesAnio');
            const anteriorMesBtn = document.getElementById('prevMonth');
            const siguienteMesBtn = document.getElementById('nextMonth');

            const obtenerNombresMeses = (idioma = 'es-ES') => {
                const formatter = new Intl.DateTimeFormat(idioma, {
                    month: 'long'
                });
                return Array.from({
                    length: 12
                }, (_, i) =>
                    formatter.format(new Date(2000, i, 1)).charAt(0).toUpperCase() +
                    formatter.format(new Date(2000, i, 1)).slice(1)
                );
            };
            const meses = obtenerNombresMeses();

            let fechaActual = new Date();

            function generarCalendario(fecha) {
                const anio = fecha.getFullYear();
                const mes = fecha.getMonth();

                // Actualizar título
                mesAnioElemento.textContent = `${meses[mes]} ${anio}`;

                // Obtener información del mes
                const primerDia = new Date(anio, mes, 1);
                const ultimoDia = new Date(anio, mes + 1, 0);
                const diasEnMes = ultimoDia.getDate();
                const diaInicioSemana = primerDia.getDay();

                // Limpiar tabla
                calendarioTabla.innerHTML = `
                                                                                                                                    <thead>
                                                                                                                                        <tr class="table-light table-bordered">
                                                                                                                                            <th class="text-center">Dom</th>
                                                                                                                                            <th class="text-center">Lun</th>
                                                                                                                                            <th class="text-center">Mar</th>
                                                                                                                                            <th class="text-center">Mié</th>
                                                                                                                                            <th class="text-center">Jue</th>
                                                                                                                                            <th class="text-center">Vie</th>
                                                                                                                                            <th class="text-center">Sáb</th>
                                                                                                                                        </tr>
                                                                                                                                    </thead>
                                                                                                                                    <tbody></tbody>
                                                                                                                                `;

                const tbody = calendarioTabla.querySelector('tbody');
                let fila = document.createElement('tr');

                //* Agregar celdas vacías para los días antes del inicio del mes
                for (let i = 0; i < diaInicioSemana; i++) {
                    const celda = document.createElement('td');
                    celda.className = 'text-center';
                    fila.appendChild(celda);
                }

                const baseRuta = "{{route('calendario.buscarEventos')}}";
                const ruta = `${baseRuta}?mes=${mes}&anio=${anio}`;

                fetch(ruta)
                    .then(response => response.json())
                    .then(data => {
                       
                        for (let dia = 1; dia <= diasEnMes; dia++) {
                            if (fila.children.length === 7) {
                                tbody.appendChild(fila);
                                fila = document.createElement('tr');
                            }

                            const celda = document.createElement('td');
                            celda.className = 'text-center hover-cell';
                            celda.textContent = dia;

                            //* Verificar si hay eventos Confirmados en este día
                            const eventosConfirmados = data.eventosConfirmados.some(evento => {

                                const fechaEvento = new Date(evento.fecha + "T00:00:00Z");
                                fechaEvento.setMinutes(fechaEvento.getMinutes() + fechaEvento.getTimezoneOffset());
                                let diaConv = fechaEvento.getDate();
                                return (
                                    fechaEvento.getFullYear() === anio &&
                                    fechaEvento.getMonth() === mes &&
                                    diaConv === dia
                                );
                            });
                            const eventoSeparados = data.eventosReservados.some(evento => {
                                const fechaEvento = new Date(evento.fecha + "T00:00:00Z");
                                fechaEvento.setMinutes(fechaEvento.getMinutes() + fechaEvento.getTimezoneOffset());
                                let diaConv = fechaEvento.getDate();
                                return (
                                    fechaEvento.getFullYear() === anio &&
                                    fechaEvento.getMonth() === mes &&
                                    diaConv === dia
                                );
                            });

                            const eventoRealizados = data.eventosRealizados.some(evento => {
                                const fechaEvento = new Date(evento.fecha + "T00:00:00Z");
                                fechaEvento.setMinutes(fechaEvento.getMinutes() + fechaEvento.getTimezoneOffset());
                                let diaConv = fechaEvento.getDate();
                                return (
                                    fechaEvento.getFullYear() === anio &&
                                    fechaEvento.getMonth() === mes &&
                                    diaConv === dia
                                );
                            });
                           


                            if (eventosConfirmados) {
                                celda.classList.add('bg-success', 'text-white');
                                let icon = document.createElement('i');
                                icon.classList.add('bx', 'bxs-calendar-event');
                                icon.style.color = '#ffffff';
                                celda.appendChild(icon);

                                celda.addEventListener('click', function () {
                                    agregarEvento(dia, mes + 1, anio);
                                });
                            }
                            else if (eventoSeparados) {
                                celda.classList.add('bg-warning', 'text-white');
                                let icon = document.createElement('i');
                                icon.classList.add('bx', 'bxs-calendar-exclamation');
                                icon.style.color = '#ffffff';
                                celda.appendChild(icon);

                                celda.addEventListener('click', function () {
                                    agregarEvento(dia, mes + 1, anio);
                                });


                            }
                            else if (eventoRealizados) {
                                celda.classList.add('bg-info', 'text-white');
                                let icon = document.createElement('i');
                                icon.classList.add('bx', 'bxs-calendar-check');
                                icon.style.color = '#ffffff';
                                celda.appendChild(icon);

                                celda.addEventListener('click', function () {
                                    agregarEvento(dia, mes + 1, anio);
                                });


                            }
                            fila.appendChild(celda);
                        }

                        // Agregar celdas vacías para completar la última fila
                        while (fila.children.length < 7) {
                            const celda = document.createElement('td');
                            celda.className = 'text-center';
                            fila.appendChild(celda);
                        }
                        tbody.appendChild(fila);
                    })
                    .catch(error => {
                        console.error("Error al obtener los eventos:", error);
                    });
            }

            function agregarEvento(dia, mes, anio) {
                const baseRuta = "{{ route('eventos.buscar') }}";
                const ruta = `${baseRuta}?dia=${dia}&mes=${mes}&anio=${anio}`;

                // Mostrar el modal
                const modal = new bootstrap.Modal(document.getElementById('eventModal'));
                modal.show();

                const modalBody = document.querySelector('#eventModal .modal-body');
                modalBody.innerHTML = `<p class="text-gray-500">Cargando...</p>`;

                fetch(ruta)
                    .then(response => response.json())
                    .then(data => {
                        const formatoMes = new Intl.DateTimeFormat('es-ES', {
                            month: 'long'
                        });
                        const nuevoMes = mes - 1;
                        let nombreMes = formatoMes.format(new Date(anio, nuevoMes, dia));
                        nombreMes = nombreMes.charAt(0).toUpperCase() + nombreMes.slice(1).toUpperCase();

                        const contenedorEventos = `
                                                                                                <h2 class="font-weight-bold text-center" id="tituloEventos"></h2>
                                                                                                <div id="eventosList"></div>
                                                                                            `;

                        modalBody.innerHTML = contenedorEventos;

                        const tituloEventos = document.getElementById('tituloEventos');
                        const eventosList = document.getElementById('eventosList');

                        if (data.data.length > 0) {
                            const eventosHTML = data.data.map(item => {
                                const evento = item.evento;
                                const categoria = item.categoria;
                                const horario = item.horario;
                                const ambiente = item.ambiente;
                                const encargado = item.encargado;
                                const imagenPublicidad = evento.publicidad;
                                const imagenURL = `/storage/${imagenPublicidad}`;
                                console.log(evento.publicidad);

                                return `
                                                                    <div class="col-6 mb-4"> 
                                                                        <div class="card col-6" style="width: 100%;">
                                                                            <img class="card-img-top" src="${imagenURL}" alt="Publicidad del evento" style="max-width: 100%; height: auto;">
                                                                            <div class="card-body">
                                                                                <h5 class="card-title text-success">${evento.nomEvento}</h5>
                                                                                <p class="card-text"><b>Descripción:</b> ${evento.descripcion}</p>
                                                                                <p class="card-text"><b>Ambiente:</b> ${ambiente.pla_amb_descripcion}</p>
                                                                                <p class="card-text"><b>Categoría:</b> ${categoria.nomCategoria}</p>
                                                                                <p class="card-text"><b>Horario:</b> ${horario.inicio} - ${horario.fin}</p>
                                                                                <p class="card-text"><b>Encargado:</b> ${encargado.par_nombres}</p>
                                                                                <div class="d-flex justify-content-between">
                                                                                    <a href="{{ route('eventos.editarEvento', '') }}/${evento.idEvento}" class="btn btn-warning">Actualizar</a>
                                                                                    <button class="btn btn-danger" data-nombre-evento="${evento.nomEvento}" data-id-evento="${evento.idEvento}">Eliminar</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                `;
                            }).join('');
                            tituloEventos.className = "text-center";
                            tituloEventos.innerHTML = `Eventos para: <b>${dia}-${nombreMes}-${anio}</b>`;
                            eventosList.innerHTML = eventosHTML;

                            const eliminarEventoBtn = document.querySelectorAll('[data-id-evento]');
                            eliminarEventoBtn.forEach(btn => {
                                btn.addEventListener('click', function () {
                                    modal.hide();
                                    const nombreEvento = this.getAttribute('data-nombre-evento');
                                    const idEvento = this.getAttribute('data-id-evento');
                                    const modalMessage = document.getElementById('modalMessage');
                                    modalMessage.innerHTML = 'Está seguro que desea eliminar el evento de: <strong>' + "<br>" + nombreEvento + '</strong>?';

                                    // Mostrar el modal de confirmación
                                    const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
                                    confirmModal.show();

                                    document.getElementById('confirmDelete').onclick = function () {
                                        eliminarEvento(idEvento);
                                        confirmModal.hide();
                                    };

                                    document.getElementById('cancelDelete').onclick = function () {
                                        confirmModal.hide();
                                    };
                                });
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar los eventos:', error);
                        modalBody.innerHTML = `<p class="text-danger">Error al cargar los eventos. Intenta nuevamente.</p>`;
                    });
            }

            const notyf = new Notyf({
                position: {
                    x: 'center',
                    y: 'top',
                },
            });
            // Generar calendario inicial
            generarCalendario(fechaActual);

            anteriorMesBtn.addEventListener('click', function () {
                fechaActual.setMonth(fechaActual.getMonth() - 1);
                generarCalendario(fechaActual);
            });

            siguienteMesBtn.addEventListener('click', function () {
                fechaActual.setMonth(fechaActual.getMonth() + 1);
                generarCalendario(fechaActual);
            });

            function eliminarEvento(idEvento) {
                const baseRutaEliminarEvento = "{{ route('eventos.eliminarEvento', '') }}";
                const urlEliminar = `${baseRutaEliminarEvento}/${idEvento}`;
                window.location.href = urlEliminar;
                generarCalendario(fechaActual);
            }

            @if(session('success'))
                notyf.success('{{ session('success') }}');
            @endif
                                                                });
    </script>

@endsection