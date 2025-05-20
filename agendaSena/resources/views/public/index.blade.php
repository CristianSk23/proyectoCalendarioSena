@extends('layouts.public')

@section('content')

    <!-- Modal -->

<div class="modal fade" id="showPublicModal" tabindex="-1" aria-labelledby="publicModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Cabecera del modal -->
            <div class="modal-header custom-modal-header">
                <h5 id="publicModalTitle" class="modal-title">Detalle del Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
        </div>
    </div>
</div>


    <!-- fin modal -->






    <div class="container">
        <h1 class="text-center my-4">Eventos Públicos</h1>

        

        <!-- Sección de eventos -->
        <div id="event-details" class="row mt-4">
            <!-- Aquí se cargarán los eventos -->
            @foreach($eventos as $evento)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($evento->publicidad)
                            <img src="{{ asset('storage/' . $evento->publicidad) }}" class="card-img-top" alt="Imagen del evento" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Sin imagen">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $evento->nomEvento }}</h5>
                            <p class="card-text">{{ Str::limit($evento->descripcion, 100) }}</p>
                            <p class="card-text"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($evento->fechaEvento)->format('d/m/Y') }}</p>

                            @if($evento->horario)
                                <p class="card-text">
                                    <strong>Hora:</strong>
                                    {{ \Carbon\Carbon::parse($evento->horario->inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($evento->horario->fin)->format('H:i') }}
                                </p>
                            @endif

                            @if($evento->ambiente)
                                <p class="card-text"><strong>Ambiente:</strong> {{ $evento->ambiente->nombre }}</p>
                            @endif

                            <button class="btn btn-primary mt-auto" onclick='verEvento({{ json_encode($evento) }})'>
                                Ver más
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

       
   

    <!-- Modal -->
    <div class="modal fade" id="showPublicModal" tabindex="-1" aria-labelledby="publicModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="publicModalTitle" class="modal-title">Detalle del Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" id="publicModalBody">
                    <!-- Aquí se carga el contenido del evento con JS -->
                </div>
            </div>
        </div>
    </div>

    </div>
    
    <!-- Aquí va el HTML para mostrar la lista de eventos y el modal -->


<!-- Modal para mostrar detalles del evento -->
<div class="modal fade" id="showPublicModal" tabindex="-1" aria-labelledby="showPublicModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showPublicModalLabel">Detalles del evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modal-event-details">
                    <!-- Aquí se mostrarán los detalles del evento -->
                </div>
            </div>
        </div>
    </div>
</div>



 @push('scripts')
<script>
    // Obtener los eventos desde Laravel (o el backend) y almacenarlos en la variable `eventos`
    // let eventos = @json($eventos);

    // Función para mostrar los eventos en la interfaz

    function createEventCard(event) {
        const imagenPublicidad = event.publicidad || 'https://via.placeholder.com/150';
        const imagenURL = `/storage/${imagenPublicidad}`;
        
        const horario = event.horario || {};
        const ambiente = event.ambiente || {};
        const categoria = event.categoria || {};
         const participante = event.participante || {};
    const ficha = event.ficha || {};const fechaEvento = new Date(event.fechaEvento + 'T00:00:00').toLocaleDateString(); // Solo para mostrar la fecha si es necesario

    const horaInicio = horario.inicio || '';  // Hora de inicio directamente desde el evento
    const horaFin = horario.fin || '';  // Hora de fin directamente desde el evento

   const descripcionCorta = event.descripcion.length > 100 
            ? event.descripcion.substring(0, 100) + "..." 
            : event.descripcion;

        return `
            <div class="card mb-3 shadow-sm">
                <img src="${imagenURL}" class="card-img-top" alt="Imagen del evento" style="height: 180px; object-fit: cover;">
                <div class="card-body d-flex flex-column" style="min-height: 200px;">
                    <h5 class="card-title mb-2">${event.nomEvento}</h5>
                    <p class="card-text text-muted mb-2" style="font-size: 0.95rem;">${descripcionCorta}</p>
                    <p class="mb-1"><strong>Fecha:</strong> ${new Date(event.fechaEvento+ 'T00:00:00').toLocaleDateString()}</p>
                  ${horaInicio && horaFin ? `<p class="mb-1"><strong>Hora:</strong> ${horaInicio} - ${horaFin}</p>` : ''}
                   
                   ${ambiente.pla_amb_descripcion ? `<p class="mb-1"><strong>Ambiente:</strong> ${ambiente.pla_amb_descripcion}</p>` : ''}
                    ${categoria.nomCategoria ? `<p class="mb-3"><strong>Categoría:</strong> ${categoria.nomCategoria}</p>` : ''}
                    ${event.participante?.par_nombres ? `<p class="mb-1"><strong>Solicitante:</strong> ${event.participante.par_nombres} ${event.participante.par_apellidos}</p>` : ''}
                    <button class="btn btn-primary mt-auto w-100" onclick='openModal(${JSON.stringify(event)})'>Ver más</button>                    

                    </div>
            </div>
        `;
    }



    function mostrarEventos(eventos) {
        const eventDetailsContainer = document.getElementById('event-details');
        eventDetailsContainer.innerHTML = ''; // Limpiar contenido previo

        if (eventos.length === 0) {
            eventDetailsContainer.innerHTML = `
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">No se encontraron eventos.</h5>
                        <p class="card-text">No hay eventos programados en este momento.</p>
                    </div>
                </div>
            `;
        } else {
            eventos.forEach(evento => {
                const eventoCard = document.createElement('div');
                eventoCard.classList.add('card', 'mb-3');

                eventoCard.innerHTML = `
                    <div class="card-body">
                        <h5 class="card-title">${evento.nomEvento}</h5>
                        <p class="card-text">${evento.descripcion}</p>
                        <p class="card-text"><strong>Fecha:</strong> ${evento.fecha}</p>
                        <button class="btn btn-primary" onclick="openModal(${evento.id})">Ver detalles</button>
                    </div>
                `;

                eventDetailsContainer.appendChild(eventoCard);
            });
        }
    }

    // Función para abrir el modal y mostrar los detalles del evento
    function openModal(eventId) {
        const evento = eventos.find(evento => evento.id === eventId);
        if (evento) {
            const modalDetails = document.getElementById('modal-event-details');
            modalDetails.innerHTML = `
                <h5>${evento.nomEvento}</h5>
                <p><strong>Descripción:</strong> ${evento.descripcion}</p>
                <p><strong>Fecha:</strong> ${evento.fecha}</p>
                <p><strong>Ubicación:</strong> ${evento.ubicacion}</p>
                <p><strong>Categoría:</strong> ${evento.categoria}</p>
            `;

            // Mostrar el modal de Bootstrap
            const modal = new bootstrap.Modal(document.getElementById('showPublicModal'));
            modal.show();
        }
    }

    // Cargar las categorías en el filtro
    function cargarCategorias() {
        fetch('/categorias')
            .then(response => response.json())
            .then(categorias => {
                const select = document.getElementById('category-search');
                categorias.forEach(cat => {
                    const option = document.createElement('option');
                    option.value = cat.id;
                    option.textContent = cat.nomCategoria;
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error al cargar categorías:', error);
            });
    }

    // Filtrar eventos por fecha
    function searchByDate() {
        const fechaSeleccionada = document.getElementById('date-search').value;
        const eventosFiltrados = eventos.filter(evento => {
            const fechaEvento = new Date(evento.fecha);
            const fechaBusqueda = new Date(fechaSeleccionada);
            return fechaEvento.toDateString() === fechaBusqueda.toDateString();
        });
        mostrarEventos(eventosFiltrados);
    }

    // Filtrar eventos por categoría
    function searchByCategory() {
        const categoriaSeleccionada = document.getElementById('category-search').value;
        const eventosFiltrados = eventos.filter(evento => {
            return evento.idCategoria == categoriaSeleccionada || categoriaSeleccionada === '';
        });
        mostrarEventos(eventosFiltrados);
    }

    // Cargar los eventos inicialmente y configurar los filtros
    window.onload = () => {
        cargarCategorias();
        mostrarEventos(eventos);

        // Configurar filtros
        document.getElementById('date-search').addEventListener('change', searchByDate);
        document.getElementById('category-search').addEventListener('change', searchByCategory);
    };



    function showEventDetails(day) {
            console.log("Día seleccionado:", day);
            const eventsForDay = eventos.filter(event => {
                const [year, month, dayStr] = event.fechaEvento.split('-');
                const eventDay = parseInt(dayStr, 10);
                const eventMonth = parseInt(month, 10) - 1; // Mes en JS: 0-11
                const eventYear = parseInt(year, 10);

                return (
                    eventDay === day &&
                    eventMonth === currentDate.getMonth() &&
                    eventYear === currentDate.getFullYear()
                );
            });

            console.log("Eventos encontrados:", eventsForDay);

            const eventDetailsContainer = document.getElementById('event-details');
            eventDetailsContainer.innerHTML = ""; // Limpiar contenido anterior

            if (eventsForDay.length > 0) {
                // Si hay eventos, mostrar las tarjetas de eventos
                eventsForDay.forEach(event => {
                    eventDetailsContainer.innerHTML += createEventCard(event);
                });
            } else {
                // Si no hay eventos para el día, mostrar el mensaje
                eventDetailsContainer.innerHTML = `
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">No hay eventos para este día.</h5>
                            <p class="card-text">No se encuentran eventos programados para el ${day}.</p>
                        </div>
                    </div>
                `;
            }
        }
function showAllEvents() {
    const eventDetailsContainer = document.getElementById('event-details');
    eventDetailsContainer.innerHTML = ""; // Limpiar contenido anterior

    eventos.sort((a, b) => new Date(a.fechaEvento) - new Date(b.fechaEvento));
    // Obtener el mes y año actual
    const currentMonth = new Date().getMonth();  // El mes actual (0-11)
    const currentYear = new Date().getFullYear();  // El año actual

    // Filtrar los eventos del mes actual
    const eventsCurrentMonth = eventos.filter(event => {
        const eventDate = new Date(event.fechaEvento);
        return eventDate.getMonth() === currentMonth && eventDate.getFullYear() === currentYear;
    });

    // Filtrar los eventos del mes siguiente
    const eventsNextMonth = eventos.filter(event => {
        const eventDate = new Date(event.fechaEvento);
        return eventDate.getMonth() === currentMonth + 1 && eventDate.getFullYear() === currentYear;
    });

    // Mostrar los eventos del mes actual
    if (eventsCurrentMonth.length > 0) {
        

        eventDetailsContainer.innerHTML += `
            <h4 class="mb-3">Eventos del Mes Actual (${new Date().toLocaleString('default', { month: 'long' })})</h4>
        `;
        eventsCurrentMonth.forEach(event => {
            eventDetailsContainer.innerHTML += createEventCard(event);
        });
    } else {
        eventDetailsContainer.innerHTML += `
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">No hay eventos para el siguiente mes.</h5>
                </div>
            </div>
        `;
    }

    if (eventsNextMonth.length > 0) {
        // Si hay eventos, mostrar las tarjetas de eventos
        eventsNextMonth.forEach(event => {
            
            eventDetailsContainer.innerHTML += `
                 <div class="card">
                <div class="card-body">
                    <h5 class="card-title">No hay eventos disponibles.</h5>
                </div>
            </div>
            `;
        });
    } else {
        // Si no hay eventos, mostrar el mensaje
        eventDetailsContainer.innerHTML += `
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">No hay eventos para el sigueinte mes.</h5>
                </div>
            </div>
        `;
    }

    // Si no hay eventos en ambos meses, mostrar un mensaje
    if (eventsCurrentMonth.length === 0 && eventsNextMonth.length === 0) {
        eventDetailsContainer.innerHTML = `
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">No hay eventos disponibles.</h5>
                </div>
            </div>
        `;
    }

}





    </script>
    @endpush
@endsection
