<nav class="col-12 col-md-3 p-1 border-end bg-white shadow-lg">

    <!-- Contenedor para el listado de eventos -->
    <div class="mt-4 border rounded-lg p-4 bg-light">
        <h3 class="font-weight-bold">Eventos del {{ \Carbon\Carbon::now()->locale('es')->day }} de
            {{ \Carbon\Carbon::now()->locale('es')->monthName }}
        </h3>
        <ul id="event-list" class="list-unstyled">
            <!-- Aquí se llenarán los eventos -->
        </ul>
        <p id="no-events" class="d-none">No hay nada agendado.</p>
    </div>

    <div class=" d-flex flex-column justify-content-end mt-6">
        <div class="card">
            <div class="card-body">
                <div class="bg-success text-white p-2 rounded w-75 mx-auto">
                    <h5 class="text-center">Buscar eventos por nombre.</h5>
                </div>
                <br>
                <form class="form-control-sm">
                    <div class="d-flex align-items-center ">
                        <div class="flex-grow-1">
                            <label for="eventName" class="form-label">Nombre del evento</label>
                            <input type="text" class="form-control form-control-sm " id="nombreEvento"
                                placeholder="Buscar Evento">
                        </div>
                        <button type="submit" class="btn btn-success ms-2 mt-4 btn-sm">
                            <box-icon name='search-alt-2' color='#ffffff'></box-icon>
                        </button>
                </form>
            </div>
            <br>

            <div class="card-body">
                <div class="bg-success text-white p-2 rounded w-75 mx-auto">
                    <h5 class="text-center">Buscar eventos por Fecha.</h5>
                </div>
                <br>
                <form class="form-control-sm">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <label for="eventName" class="form-label">Fecha del evento</label>
                            <input type="date" class="form-control" id="fechaEvento" placeholder="Buscar Evento">
                        </div>
                        <button type="submit" class="btn btn-success ms-2 mt-4 btn-sm">
                            <box-icon name='search-alt-2' color='#ffffff'></box-icon>
                        </button>
                </form>
            </div>
        </div>
    </div>

</nav>


<script>
    // Simulación de eventos agendados
    const eventos = [
        { fecha: '2025-02-12', nombre: 'Reunión de Proyecto' },
        { fecha: '2025-03-13', nombre: 'Taller de Desarrollo' }
    ];

    const hoy = new Date().toISOString().split('T')[0]; // Obtener la fecha de hoy en formato YYYY-MM-DD
    const listaEventos = document.getElementById('event-list');
    const noEventos = document.getElementById('no-events');

    const eventosHoy = eventos.filter(evento => evento.fecha === hoy);

    if (eventosHoy.length > 0) {
        eventosHoy.forEach(evento => {
            const li = document.createElement('li');
            li.textContent = evento.nombre;
            listaEventos.appendChild(li);
        });
    } else {
        noEventos.classList.remove('d-none');
    }



    let fechaActual = new Date();
    const calendarioTabla = document.getElementById('calendarioSideBarIzquierdo');


    //* Cristian Castaño


</script>
</nav>