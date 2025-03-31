<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos Públicos</title>
    <!-- Cargar Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    
    <head>


<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
<link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;700&family=Calibri&display=swap" rel="stylesheet">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

{{-- Estilos BOOTSTRAP --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<title>Agenda CDTI-SENA</title>

<style>
        /* Ajustes para que el navbar no se superponga al contenido */
        .navbar {
            position: fixed; /* Fijamos el navbar en la parte superior */
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1050; /* Aseguramos que esté por encima de otros elementos */
        }

        /* Añadir un margen superior para el contenido principal para que no quede debajo del navbar */
        .content-area {
            margin-top: 70px; /* Ajusta este valor según el tamaño de tu navbar */
        }
    </style>

</head>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg" style="background-color: #4caf50;">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">
                <h1 class="h4">AgenSena</h1>
            </a>
            
                    <a href="{{route('calendario.index')}}" class="nav-link text-white" aria-current="page">Eventos</a>
                
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="d-flex align-items-center">
                <div class="position-relative">
                    <a id="icono-notificacion" href="http://">
                        <box-icon id="icono-campana" name='bell' type='solid' color='#ffffff'></box-icon>
                        <box-icon id="icono-notificacion-activa" name='bell-ring' type='solid' color='#ffffff'
                            style="display: none;"></box-icon>
                    </a>
                    <span id="cantidad-eventos"
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        0
                    </span>
                </div>
                <form method="POST" action="{{ route('login.logout') }}" class="ms-3">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <box-icon name='power-off' color='#ffffff'></box-icon>
                    </button>
                </form>
            </div>
        </div>
    </nav>
    <!-- Sidebar con Calendario -->
    <div class="sidebar">
        <h4 class="text-center mb-4">Calendario</h4>

        <!-- Contenedor del calendario -->
        <div class="calendar-nav">
            <button id="prev-month" class="btn btn-outline-primary"><i class="bi bi-arrow-left"></i></button>
            <span id="month-name" class="h5"></span>
            <button id="next-month" class="btn btn-outline-primary"><i class="bi bi-arrow-right"></i></button>
        </div>

        <div class="calendar-container">
           <did class="text-calendar"> <h1> Calendario</h1>d
            <table class="table table-bordered calendar-table">
                <thead>
                    <tr>
                        <th>Dom</th>
                        <th>Lun</th>
                        <th>Mar</th>
                        <th>Mié</th>
                        <th>Jue</th>
                        <th>Vie</th>
                        <th>Sáb</th>
                    </tr>
                </thead>
                <tbody id="calendar-body">
                    <!-- Aquí se llenarán los días del calendario -->
                </tbody>
            </table>
        </div>
                    
         
         <!-- Filtro por Categoría -->
                <div class="search-input-container">
                    <label for="category-search">Buscar por categoría:</label>
                    <select id="category-search" class="form-control" oninput="searchEvent()">
                        <option value="">Seleccione una categoría</option>
                        <!-- Aquí puedes llenar las categorías dinámicamente desde la base de datos si es necesario -->
                        <option value="1">Categoría 1</option>
                        <option value="2">Categoría 2</option>
                        <option value="3">Categoría 3</option>
                    </select>
                </div>

                <!-- Filtro por Fecha -->
                <div class="search-input-container">
                    <label for="date-search">Buscar por fecha:</label>
                    <input type="date" id="date-search" class="form-control" oninput="searchEvent()">
                </div>

                <!-- Filtro por Nombre del Evento -->
                <div class="search-input-container">
                    <label for="search-input">Buscar por nombre:</label>
                    <input type="text" id="search-input" class="form-control" placeholder="Buscar evento por nombre..." oninput="searchEvent()">
                </div>


        </div>

    </div>

    <!-- Contenido Principal -->
    <div class="content-area">
        
      

        <div id="event-details" class="mt-4"></div> <!-- Contenedor para mostrar los eventos -->
    </div>

    <!-- Cargar Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        let currentDate = new Date();
        let eventos = @json($eventos); // Eventos pasados desde el backend a JavaScript

        // Función para cargar el calendario
        function loadCalendar() {
            const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
            const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
            const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();

            // Mostrar el nombre del mes
            document.getElementById('month-name').innerText = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

            // Crear el calendario
            let calendarBody = document.getElementById('calendar-body');
            calendarBody.innerHTML = "";

            let row = document.createElement('tr');
            for (let i = 0; i < firstDayOfMonth; i++) {
                row.appendChild(document.createElement('td'));  // Celdas vacías antes del primer día del mes
            }

            for (let day = 1; day <= daysInMonth; day++) {
                let cell = document.createElement('td');
                cell.innerText = day;

                // Verificar si hay eventos para ese día
                const eventForDay = eventos.filter(event => {
                    const eventDate = new Date(event.fechaEvento);
                    return eventDate.getDate() === day && eventDate.getMonth() === currentDate.getMonth() && eventDate.getFullYear() === currentDate.getFullYear();
                });

                // Marcar el día con eventos
                if (eventForDay.length > 0) {
                    cell.classList.add('event-day');
                }

                // Agregar evento de click para mostrar los eventos del día
                cell.addEventListener('click', function() {
                    showEventDetails(day);
                });

                row.appendChild(cell);

                if ((firstDayOfMonth + day) % 7 === 0) {
                    calendarBody.appendChild(row);
                    row = document.createElement('tr');
                }
            }

            if (row.children.length > 0) {
                calendarBody.appendChild(row);
            }
        }

        // Función para mostrar todos los eventos
   // Función para mostrar todos los eventos
function showAllEvents() {
    const eventDetailsContainer = document.getElementById('event-details');
    eventDetailsContainer.innerHTML = ""; // Limpiar contenido anterior

    if (eventos.length > 0) {
        // Si hay eventos, mostrar las tarjetas de eventos
        eventos.forEach(event => {
            const imagenPublicidad = event.publicidad || 'https://via.placeholder.com/150';
            const imagenURL = `/storage/${imagenPublicidad}`;

            eventDetailsContainer.innerHTML += `
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="${imagenURL}" class="img-fluid rounded-start" alt="Imagen del evento" style="object-fit: cover; width: 100%; height: 100%;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">${event.nomEvento}</h5>
                                <p class="card-text">${event.descripcion}</p>
                                <p class="card-text"><small class="text-muted">Fecha: ${new Date(event.fechaEvento).toLocaleDateString()}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
    } else {
        // Si no hay eventos, mostrar el mensaje
        eventDetailsContainer.innerHTML = `
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">No hay eventos disponibles.</h5>
                </div>
            </div>
        `;
    }
}


        // Función para mostrar los eventos del día seleccionado
        function showEventDetails(day) {
            const eventsForDay = eventos.filter(event => {
                const eventDate = new Date(event.fechaEvento);
                return eventDate.getDate() === day && eventDate.getMonth() === currentDate.getMonth() && eventDate.getFullYear() === currentDate.getFullYear();
            });

            const eventDetailsContainer = document.getElementById('event-details');
            eventDetailsContainer.innerHTML = ""; // Limpiar contenido anterior

            if (eventsForDay.length > 0) {
                // Si hay eventos, mostrar las tarjetas de eventos
                eventsForDay.forEach(event => {
                    const imagenPublicidad = event.publicidad;
                    const imagenURL = `/storage/${imagenPublicidad}`;
                    eventDetailsContainer.innerHTML += `
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="${imagenURL || 'https://via.placeholder.com/150'}" class="img-fluid rounded-start" alt="Imagen del evento">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">${event.nomEvento}</h5>
                                        <p class="card-text">${event.descripcion}</p>
                                        <p class="card-text"><small class="text-muted">Fecha: ${new Date(event.fechaEvento).toLocaleDateString()}</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
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

        // Función para cambiar al mes siguiente
        document.getElementById('next-month').addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            loadCalendar();
        });

        // Función para cambiar al mes anterior
        document.getElementById('prev-month').addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            loadCalendar();
        });

        // Función para buscar eventos por nombre
        // function searchEvent() {
        //     const searchInput = document.getElementById('search-input').value.toLowerCase();
        //     const filteredEvents = eventos.filter(event => event.nomEvento.toLowerCase().includes(searchInput));

        //     const eventDetailsContainer = document.getElementById('event-details');
        //     eventDetailsContainer.innerHTML = "";

        //     if (filteredEvents.length > 0) {
        //         filteredEvents.forEach(event => {
        //             const imagenPublicidad = event.publicidad;
        //             const imagenURL = `/storage/${imagenPublicidad}`;
        //             eventDetailsContainer.innerHTML += `
        //                 <div class="card mb-3" style="max-width: 540px;">
        //                                                 <div class="row g-0">
        //                         <div class="col-md-4">
        //                             <img src="${imagenURL || 'https://via.placeholder.com/150'}" class="img-fluid rounded-start" alt="Imagen del evento">
        //                         </div>
        //                         <div class="col-md-8">
        //                             <div class="card-body">
        //                                 <h5 class="card-title">${event.nomEvento}</h5>
        //                                 <p class="card-text">${event.descripcion}</p>
        //                                 <p class="card-text"><small class="text-muted">Fecha: ${new Date(event.fechaEvento).toLocaleDateString()}</small></p>
        //                             </div>
        //                         </div>
        //                     </div>
        //                 </div>
        //             `;
        //         });
        //     } else {
        //         // Si no se encuentran eventos después del filtro
        //         eventDetailsContainer.innerHTML = `
        //             <div class="card">
        //                 <div class="card-body">
        //                     <h5 class="card-title">No se encontraron eventos.</h5>
        //                     <p class="card-text">No se encontraron eventos que coincidan con tu búsqueda.</p>
        //                 </div>
        //             </div>
        //         `;
        //     }
        // }






        function searchEvent() {
    const categoryId = document.getElementById('category-search').value;
    const date = document.getElementById('date-search').value;
    const searchInput = document.getElementById('search-input').value.toLowerCase();

    // Filtrar eventos según categoría, fecha y nombre
    const filteredEvents = eventos.filter(event => {
        const matchesCategory = categoryId ? event.idCategoria == categoryId : true;
        const matchesDate = date ? new Date(event.fechaEvento).toLocaleDateString() === new Date(date).toLocaleDateString() : true;
        const matchesName = searchInput ? event.nomEvento.toLowerCase().includes(searchInput) : true;

        return matchesCategory && matchesDate && matchesName;
    });

    // Mostrar los eventos filtrados
    displayEvents(filteredEvents);
}
function displayEvents(events) {
    const eventDetailsContainer = document.getElementById('event-details');
    eventDetailsContainer.innerHTML = "";

    if (events.length > 0) {
        events.forEach(event => {
            const imagenURL = `/storage/${event.publicidad || 'default_image.jpg'}`;
            eventDetailsContainer.innerHTML += `
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="${imagenURL}" class="img-fluid rounded-start" alt="Imagen del evento" style="object-fit: cover; width: 100%; height: 100%;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">${event.nomEvento}</h5>
                                <p class="card-text">${event.descripcion}</p>
                                <p class="card-text"><small class="text-muted">Fecha: ${new Date(event.fechaEvento).toLocaleDateString()}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
    } else {
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









        // Cargar el calendario y eventos iniciales
        loadCalendar();
        showAllEvents();
    </script>
</body>
</html>

