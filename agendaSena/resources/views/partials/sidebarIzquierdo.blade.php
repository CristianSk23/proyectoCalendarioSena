<nav class="col-12 col-md-3 p-1 border-end bg-white">

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
        noEventos.classList.remove('hidden');
    }



    let fechaActual = new Date();
    const calendarioTabla = document.getElementById('calendarioSideBarIzquierdo');


    //* Cristian Castaño


</script>
</nav>