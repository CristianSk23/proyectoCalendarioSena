@extends('layouts.public')

@section('content')
    <div class="container">
        <h1 class="text-center my-4">Eventos Públicos</h1>

        

        <div class="row">
            @foreach($eventos as $evento)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($evento->publicidad)
                            <img src="{{ asset('storage/' . $evento->publicidad) }}" class="card-img-top" alt="Imagen del evento" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Sin imagen">
                        @endif
<!-- 
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $evento->nomEvento }}</h5>
                            <p class="card-text">{{ Str::limit($evento->descripcion, 100) }}</p>
                            <p class="card-text"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($evento->fechaEvento)->format('d/m/Y') }}</p> -->

                            @if($evento->horario)
                                <p class="card-text">
                                    <strong>Hora:</strong>
                                    {{ \Carbon\Carbon::parse($evento->horario->inicio)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($evento->horario->fin)->format('H:i') }}
                                </p>
                            @endif

                            @if($evento->ambiente)
                                <p class="card-text"><strong>Ambiente:</strong> {{ $evento->ambiente->nombre }}</p>
                            @endif

                            @if($evento->categoria)
                                <p class="card-text"><strong>Categoría:</strong> {{ $evento->categoria->nombre }}</p>
                            @endif

                            <button class="btn btn-primary mt-auto" onclick='verEvento({{ json_encode($evento) }})'>
                                Ver más
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- <button class="btn btn-secondary mt-4" onclick="mostrarTodosEventos()">Mostrar Todos los Eventos</button> -->
    </div>


    <!-- Modal Detalle Evento-->
    <!-- <div class="modal fade" id="showPublicModal" tabindex="-1" aria-labelledby="publicModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="publicModalTitle" class="modal-title">Detalle del Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div> -->
                <!-- Cuerpo del modal -->
                <!-- <div class="modal-body" id="publicModalBody"> -->
                    <!-- Aquí se carga el contenido del evento con JS -->
                 <!-- </div>   -->
                     <!-- Pie de modal -->
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div> -->
    <!-- FIN MODAL DETALLE EVENTO -->
    
   @endsection

    @push('scripts')
    <script>
        // Suponiendo que tienes una lista de eventos
        // let todosLosEventos = [
        // //     // Aquí puedes agregar los eventos que deseas mostrar
        // //     // Ejemplo: { id: 1, nombre: "Evento 1", ... }
        // ];

        // function mostrarTodosEventos() {
        //     // Lógica para mostrar todos los eventos
        //     console.log(todosLosEventos); // Asegúrate de que esta variable esté definida
        // //     // Aquí puedes agregar el código para mostrar los eventos en la interfaz
        // }

        function verEvento(evento) {
    const imagen = evento.publicidad ? `/storage/${evento.publicidad}` : 'https://via.placeholder.com/300x200';
    const fecha = new Date(evento.fechaEvento + 'T00:00:00').toLocaleDateString();

    let html = `
        <div class="row">
            <div class="col-md-5">
                <img src="${imagen}" class="img-fluid rounded mb-3" alt="Imagen del evento">
            </div>
            <div class="col-md-7">
                <h4>${evento.nomEvento}</h4>
                <p class="text-muted">${evento.descripcion}</p>
                <ul class="list-unstyled">
                    <li><strong>Fecha:</strong> ${fecha}</li>
    `;

    if (evento.horario) {
        const inicio = new Date(evento.horario.inicio).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const fin = new Date(evento.horario.fin).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        html += `<li><strong>Hora:</strong> ${inicio} - ${fin}</li>`;
    }

    if (evento.ambiente?.nombre) {
        html += `<li><strong>Ambiente:</strong> ${evento.ambiente.nombre}</li>`;
    }

    if (evento.categoria?.nombre) {
        html += `<li><strong>Categoría:</strong> ${evento.categoria.nombre}</li>`;
    }

    if (evento.participante) {
        html += `<li><strong>Solicitante:</strong> ${evento.participante.par_nombres ?? ''} ${evento.participante.par_apellidos ?? ''}</li>`;
    }

    if (evento.ficha?.fic_numero) {
        html += `<li><strong>Ficha:</strong> ${evento.ficha.fic_numero}</li>`;
    }

    html += `</ul></div></div>`;

    document.getElementById('modalBody').innerHTML = html;
    const modal = new bootstrap.Modal(document.getElementById('eventoModal'));
    modal.show();





    // Manejod eventos visualizacion




    



// agregra mostrarTodo      

        function searchEvent() {
    const searchInput = document.getElementById('search-input').value.toLowerCase();
    
    const eventDetailsContainer = document.getElementById('event-details');
    eventDetailsContainer.innerHTML = ""; // Limpiar contenido previo

    // Filtrar los eventos que coincidan con el nombre
    const filteredEvents = eventos.filter(event => event.nomEvento.toLowerCase().includes(searchInput));

    if (filteredEvents.length > 0) {
        
        // Si se encuentran eventos, generamos las tarjetas usando createEventCard
        filteredEvents.forEach(event => {
            displayEventsInGrid(filteredEvents);
              // Llamamos a la función createEventCard
            eventDetailsContainer.innerHTML += cardHTML;  // Insertamos la tarjeta generada
        });
    } else {
        // Si no se encuentran eventos después del filtro
        eventDetailsContainer.innerHTML = `
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">No se encontraron eventos.</h5>
                    <p class="card-text">No se encontraron eventos que coincidan con tu búsqueda.</p>
                </div>
            </div>
        `;
    }
}

    //****BUSQUEDA POR FECHA***
// Filtrar por fecha seleccionada

function searchByDate() {
    const dateInput = document.getElementById('date-search').value;  // Obtener la fecha seleccionada
    
    console.log("Fecha seleccionada:", dateInput); // Verificar la fecha seleccionada

    const eventDetailsContainer = document.getElementById('event-details');
    eventDetailsContainer.innerHTML = ""; // Limpiar contenido previo

    // Si no se seleccionó una fecha, no filtramos y mostramos todos los eventos
    if (!dateInput) {
        displayAllEvents(); // Función que muestra todos los eventos sin filtro
        return;
    }

    // Convertir la fecha seleccionada al formato UTC para evitar el desfase por zona horaria
    const selectedDate = new Date(dateInput + "T00:00:00Z");  // Añadir hora UTC (00:00:00) para hacer la comparación en UTC

    // Filtrar eventos por la fecha seleccionada
    const filteredEvents = eventos.filter(event => {
        // Convertir la fecha del evento y extraer solo la parte de la fecha (sin hora), en UTC
        const eventDate = new Date(event.fechaEvento);  // Asumimos que la fecha del evento ya es en UTC
        const formattedEventDate = eventDate.toISOString().split('T')[0]; // Formato 'YYYY-MM-DD'

        // Mostrar la fecha del evento y la fecha seleccionada en la consola
        console.log("Fecha del evento:", formattedEventDate);
        console.log("Fecha seleccionada (UTC):", selectedDate.toISOString().split('T')[0]);

        // Comparar solo la fecha (sin la hora)
        return formattedEventDate === selectedDate.toISOString().split('T')[0];
    });

    // Mostrar los eventos filtrados
    if (filteredEvents.length > 0) {
        displayEventsInGrid(filteredEvents);
    } else {
        // Si no se encuentran eventos después del filtro por fecha
        mostrarMensajeSinEventos("No hay eventos para esta categoría.");
        
    }
}

function mostrarMensajeSinEventos(mensaje) {
    const container = document.getElementById('event-details');
    container.innerHTML = `
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">${mensaje}</h5>
            </div>
        </div>
    `;
}

  //++++ CATEGORIA++++

// Filtrar por categoria seleccionada
function searchByCategory() {
        const categoryInput = document.getElementById('category-search').value;  // Obtener la categoría seleccionada
        console.log("Categoría seleccionada:", categoryInput);  // Verificar la categoría seleccionada

        const eventDetailsContainer = document.getElementById('event-details');
        eventDetailsContainer.innerHTML = ""; // Limpiar contenido previo

        console.log(categoryInput);
        

        // Si no se seleccionó una categoría, no filtramos y mostramos todos los eventos
        if (!categoryInput) {
            displayAllEvents(); // Función que muestra todos los eventos sin filtro
            return;
        }

        // Filtrar eventos por la categoría seleccionada
        const filteredEvents = eventos.filter(event => {
            return event.idCategoria == categoryInput;  // Comparar el ID de la categoría
        });

        // Mostrar los eventos filtrados
        if (filteredEvents.length > 0) {
            displayEventsInGrid(filteredEvents);
        } else {
            // Si no se encuentran eventos después del filtro por categoría
            eventDetailsContainer.innerHTML = `
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">No se encontraron eventos para la categoría seleccionada.</h5>
                        <p class="card-text">No hay eventos programados para esta categoría.</p>
                    </div>
                </div>
            `;
        }
    }






        // Función para mostrar todos los eventos (en caso de no haber filtrado por fecha)
        function displayAllEvents() {
            const eventDetailsContainer = document.getElementById('event-details');
            eventDetailsContainer.innerHTML = ""; // Limpiar contenido previo

            if (eventos.length > 0) {
                eventos.forEach(event => {
                    const cardHTML = createEventCard(event);  // Llamamos a la función createEventCard
                    eventDetailsContainer.innerHTML += cardHTML;  // Insertamos la tarjeta generada
                });
            } else {
                eventDetailsContainer.innerHTML = `
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">No se encontraron eventos.</h5>
                            <p class="card-text">No hay eventos programados en este momento.</p>
                        </div>
                    </div>
                `;
            }
        }

        // para la cuadricula de  eventos
    function displayEventsInGrid(events) {
        const eventDetailsContainer = document.getElementById('event-details');
        eventDetailsContainer.innerHTML = ''; // Limpiar

        for (let i = 0; i < events.length; i += 3) {
            let rowHTML = '<div class="row mb-4">';
            const chunk = events.slice(i, i + 3);

            chunk.forEach(event => {
                rowHTML += `
                    <div class="col-md-4">
                        ${createEventCard(event)}
                    </div>
                `;
            });

            rowHTML += '</div>';
            eventDetailsContainer.innerHTML += rowHTML;
        }
    }






    const todosLosEventos = @json($eventos);

    function mostrarTodosEventos() {
        const eventDetailsContainer = document.getElementById('event-details');
        eventDetailsContainer.innerHTML = ""; // Limpiar

        if (todosLosEventos.length > 0) {
            
            displayEventsInGrid(todosLosEventos);  // ← Aquí usas tu función que los muestra en cuadrícula
        } else {
            eventDetailsContainer.innerHTML = `
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">No se encontraron eventos.</h5>
                        <p class="card-text">No hay eventos programados en este momento.</p>
                    </div>
                </div>
            `;
        }

        document.getElementById('search-input').value = '';
    document.getElementById('date-search').value = '';
    document.getElementById('category-search').value = '';
    }


document.addEventListener('DOMContentLoaded', function () {
    mostrarTodosEventos();
});







}
       </script>
       @endpush






