<nav class="col-6 col-md-3 p-1 border-end bg-white shadow-lg">

    <!-- Contenedor para el listado de eventos -->
    <div class="mt-4 border rounded-lg p-4 bg-light">
        <h3 class="font-weight-bold">
            Eventos del {{ now()->day }} de {{ now()->locale('es')->monthName }}
        </h3>
        <div id="event-list-sideBar" class="row" style="max-height: 200px; overflow-y: auto; padding-right: 10px;">
            <!-- Aquí se insertan las cards dinámicamente -->

        </div>
        <p id="no-events" class="d-none">No hay nada agendado.</p>
    </div>

    <div class="d-flex flex-column justify-content-end mt-3">
        <div class="card">
            <div class="card-body">
                <div class="bg-success text-white p-2 rounded w-75 mx-auto">
                    <h5 class="text-center">Buscar eventos por nombre.</h5>
                </div>
                <br>
                <form onsubmit="event.preventDefault(); buscarEventoPorNombre()">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <label for="eventName" class="form-label">Nombre del evento</label>
                            <input type="text" class="form-control form-control-sm" id="nombreEvento"
                                placeholder="Buscar Evento">
                        </div>
                        <button type="submit" class="btn btn-success ms-2 mt-4 btn-sm">
                            <i class="bx bx-search-alt-2" style="color: #ffffff;"></i>
                        </button>
                </form>
            </div>
            <br>

            <div class="card-body">
                <div class="bg-success text-white p-2 rounded w-75 mx-auto">
                    <h5 class="text-center">Buscar eventos por Fecha.</h5>
                </div>
                <br>
                <form class="form-control-sm" onsubmit="event.preventDefault(); buscarEventoPorFecha()">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <label for="eventName" class="form-label">Fecha del evento</label>
                            <input type="date" class="form-control" id="fechaEvento" placeholder="Buscar Evento">
                        </div>
                        <button type="submit" class="btn btn-success ms-2 mt-4 btn-sm">
                            <i class="bx bx-search-alt-2" style="color: #ffffff;"></i>
                        </button>
                </form>
            </div>
        </div>

        <div class="card">
            <button type="submit" class="btn btn-success ms-2 mt-4 btn-sm" id="agregarEvento">
                <i class="bx bxs-add-to-queue" style="color: #ffffff;"></i>
                Agregar Evento
            </button>

            <button type="submit" class="btn btn-success ms-2 mt-4 btn-sm" id="reportes">
                <i class='bx bxs-report' style="color: #ffffff;"></i>
                Reportes
            </button>

            <button type="submit" class="btn btn-success ms-2 mt-4 btn-sm" data-bs-toggle="modal"
                data-bs-target="#modalCalendarioMensual">
                <i class='bx bxs-calendar-edit' style='color:#ffffff'></i>
                Diseño Calendario
            </button>

        </div>
    </div>

</nav>


<script>
    let fechaActual = new Date();
    const notyf = new Notyf({
        duration: 4000,
        position: {
            x: 'center',
            y: 'top',
        }
    });

    // Función para crear cards de evento reutilizable
    function crearCardEvento(evento, tipo = 'sidebar') {
        // Configuración según el tipo de vista
        const config = {
            'sidebar': {
                containerClass: 'col-12 mb-3',
                cardClass: 'card',
                titleClass: 'card-title',
                showImage: false,
                showFullInfo: false,
                showActions: true,
                actionBtnClass: 'btn btn-success',
                actionBtnText: 'Ver Detalles'
            },
            'modal': {
                containerClass: 'col-12 mb-4',
                cardClass: 'card',
                titleClass: 'card-title text-success',
                showImage: false,
                showFullInfo: false,
                showActions: true,
                actionBtnClass: 'btn btn-primary mt-2',
                actionBtnText: 'Ver detalles'
            },
            'detalle': {
                containerClass: 'col-6 mb-4',
                cardClass: 'card',
                titleClass: 'card-title text-success',
                showImage: true,
                showFullInfo: true,
                showActions: true
            }
        }[tipo];

        // Crear elementos contenedores
        const container = document.createElement('div');
        container.className = config.containerClass;

        const card = document.createElement('div');
        card.className = config.cardClass;
        card.style.width = '100%';

        // Agregar imagen si corresponde
        if (config.showImage && evento.evento.publicidad) {
            const cardImg = document.createElement('img');
            cardImg.className = 'card-img-top';
            cardImg.src = `/storage/${evento.evento.publicidad}`;
            cardImg.alt = 'Publicidad del evento';
            cardImg.style.maxWidth = '100%';
            cardImg.style.height = 'auto';
            card.appendChild(cardImg);
        }

        // Crear cuerpo de la card
        const cardBody = document.createElement('div');
        cardBody.className = 'card-body';

        // Título del evento
        const cardTitle = document.createElement('h5');
        cardTitle.className = config.titleClass;
        cardTitle.textContent = evento.evento.nomEvento;
        cardBody.appendChild(cardTitle);

        // Descripción del evento
        const cardDescripcion = document.createElement('p');
        cardDescripcion.className = 'card-text';
        cardDescripcion.innerHTML = `<b>Descripción:</b> ${evento.evento.descripcion}`;
        cardBody.appendChild(cardDescripcion);

        // Información adicional común
        const cardAmbiente = document.createElement('p');
        cardAmbiente.className = 'card-text';
        cardAmbiente.innerHTML = `<b>Ambiente:</b> ${evento.ambiente.pla_amb_descripcion}`;
        cardBody.appendChild(cardAmbiente);

        const cardHorario = document.createElement('p');
        cardHorario.className = 'card-text';
        cardHorario.innerHTML = `<b>Horario:</b> ${evento.horario.inicio} - ${evento.horario.fin}`;
        cardBody.appendChild(cardHorario);

        // Información detallada solo para vista de detalle
        if (config.showFullInfo) {
            const cardCategoria = document.createElement('p');
            cardCategoria.className = 'card-text';
            cardCategoria.innerHTML = `<b>Categoría:</b> ${evento.categoria.nomCategoria}`;
            cardBody.appendChild(cardCategoria);

            const cardEncargado = document.createElement('p');
            cardEncargado.className = 'card-text';
            cardEncargado.innerHTML = `<b>Encargado:</b> ${evento.encargado.par_nombres}`;
            cardBody.appendChild(cardEncargado);
        }

        // Botones de acción
        if (config.showActions) {
            const cardActions = document.createElement('div');
            cardActions.className = 'd-flex justify-content-between mt-3';

            if (tipo !== 'detalle') {
                // Botón para ver detalles (solo en sidebar y modal)
                const btnDetalles = document.createElement('button');
                btnDetalles.className = config.actionBtnClass;
                btnDetalles.textContent = config.actionBtnText;
                btnDetalles.addEventListener('click', () => {
                    if (tipo === 'modal') {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('eventModal'));
                        if (modal) modal.hide();
                    }
                    verDetalleEventos(evento);
                });
                cardActions.appendChild(btnDetalles);
            } else {
                // Botones para vista de detalle (actualizar y eliminar)
                const btnActualizar = document.createElement('a');
                btnActualizar.className = 'btn btn-warning';
                btnActualizar.href = `{{ route('eventos.editarEvento', '') }}/${evento.evento.idEvento}`;
                btnActualizar.textContent = 'Actualizar';

                const btnEliminar = document.createElement('button');
                btnEliminar.className = 'btn btn-danger';
                btnEliminar.setAttribute('data-nombre-evento', evento.evento.nomEvento);
                btnEliminar.setAttribute('data-id-evento', evento.evento.idEvento);
                btnEliminar.textContent = 'Eliminar';

                cardActions.appendChild(btnActualizar);
                cardActions.appendChild(btnEliminar);
            }

            cardBody.appendChild(cardActions);
        }

        // Ensamblar la card
        card.appendChild(cardBody);
        container.appendChild(card);

        return container;
    }

    // Función para mostrar eventos en la sidebar
    function mostrarEventosEnSidebar(eventos) {
        const eventList = document.getElementById('event-list-sideBar');
        const noEvents = document.getElementById('no-events');

        eventList.innerHTML = '';
        noEvents.classList.add('d-none');

        if (eventos && eventos.length > 0) {
            eventos.forEach(evento => {
                if (evento.evento.estadoEvento == 1) {
                    const card = crearCardEvento(evento, 'sidebar');
                    eventList.appendChild(card);
                }
            });
        } else {
            noEvents.classList.remove('d-none');
        }
    }

    // Función para mostrar eventos en el modal
    function mostrarEventosEnModal(eventos, titulo = 'Resultados de búsqueda') {
        const eventModal = document.getElementById('eventModal');
        const tituloEventos = document.getElementById('tituloEventos');
        const eventosList = document.getElementById('eventosList');

        tituloEventos.textContent = titulo;
        eventosList.innerHTML = '';

        if (eventos && eventos.length > 0) {
            eventos.forEach(evento => {
                if (evento.evento.estadoEvento != 2) {
                    const card = crearCardEvento(evento, 'modal');
                    eventosList.appendChild(card);
                }
            });

            const modal = new bootstrap.Modal(eventModal);
            modal.show();
        } else {
            notyf.error('No se encontraron eventos');
        }
    }

    // Función para buscar eventos por día
    function buscarEventoDia(fecha) {
        const anio = fecha.getFullYear();
        const mes = fecha.getMonth() + 1;
        const dia = fecha.getDate();

        const baseRuta = "{{ route('eventos.buscar') }}";
        fetch(`${baseRuta}?dia=${dia}&mes=${mes}&anio=${anio}`)
            .then(response => response.json())
            .then(data => {
                mostrarEventosEnSidebar(data.data);
            })
            .catch(error => {
                notyf.error('Error al buscar eventos');
            });
    }

    // Función para buscar eventos por nombre
    function buscarEventoPorNombre() {
        const nombreInput = document.getElementById('nombreEvento');
        const nombre = nombreInput.value;
        const baseRuta = "{{ route('eventos.buscarEventoPorNombre') }}";

        fetch(`${baseRuta}?nombre=${nombre}`)
            .then(response => response.json())
            .then(data => {
                console.log(data.evento);

                const titulo = `Resultados de búsqueda: "${nombre}"`;
                mostrarEventosEnModal(data.evento, titulo);
                nombreInput.value = '';
            })
            .catch(error => {
                nombreInput.value = '';
                notyf.error('No se encontraron eventos con ese nombre');
            });
    }

    // Función para buscar eventos por fecha
    function buscarEventoPorFecha() {
        const fechaInput = document.getElementById('fechaEvento');
        const fecha = fechaInput.value;
        const fechaFormateada = new Date(fecha);

        const anio = fechaFormateada.getFullYear();
        const mes = fechaFormateada.getMonth() + 1;
        const dia = fechaFormateada.getDate() + 1;

        const baseRuta = "{{ route('eventos.buscar') }}";
        fetch(`${baseRuta}?dia=${dia}&mes=${mes}&anio=${anio}`)
            .then(response => response.json())
            .then(data => {
                const eventosDb = data.data;
                if (eventosDb.length === 0) {
                    notyf.error('No se encontraron eventos para la fecha seleccionada');
                    return;
                }
                eventosDb.forEach(evento => {
                    mostrarEventosEnModal(eventosDb, `Resultados de búsqueda: ${evento.evento.fechaEvento}`);
                });
            })
            .catch(error => {
                notyf.error('No se encontraron eventos para la fecha seleccionada');
            });
    }

    // Función para ver detalles de un evento
    function verDetalleEventos(evento) {
        const tituloEventos = document.getElementById('tituloEventos');
        const eventosList = document.getElementById('eventosList');

        tituloEventos.textContent = evento.evento.nomEvento;
        eventosList.innerHTML = '';

        const card = crearCardEvento(evento, 'detalle');
        eventosList.appendChild(card);

        const eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
        eventModal.show();
    }

    // Inicialización - Mostrar eventos del día actual
    const listaEventos = document.getElementById('event-list-sideBar');
    const noEventos = document.getElementById('no-events');
    buscarEventoDia(fechaActual);


    const btnAgregarEvento = document.getElementById('agregarEvento');
    const btnReportes = document.getElementById('reportes');
    const btnDisenoCalendario = document.getElementById('disenoCalendario');

    btnAgregarEvento.addEventListener('click', function () {
        const baseRutaCrearEvento = "{{ route('eventos.crearEvento') }}";
        // Redirigir a la ruta de creación de eventos
        window.location.href = `${baseRutaCrearEvento}`;
    });

    btnReportes.addEventListener('click', function () {
        const baseRutaCrearEvento = "{{ route('evento.reportes.index') }}";
        // Redirigir a la ruta de reportes
        window.location.href = `${baseRutaCrearEvento}`;
    });



</script>
@include('partials.modalCargarImagenesCalendario');

</nav>