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
</head>
<body class="custom-body">

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <!-- Título centrado en el navbar -->
            <a class="navbar-brand mx-auto" href="#">AGEN SENA - CDTI</a>
            <div class="d-flex">
                <a href="#" id="home-button" class="btn btn-outline-primary me-2">Inicio</a>
                <!-- <a href="#" class="btn btn-outline-secondary">Sesión</a> -->
                <a href="{{ route('login') }}" class="btn btn-outline-secondary">Sesión</a>
            </div>
        </div>
    </nav>

    <div class="sidebar">
    <div class="calendar-nav">
        <button id="prev-month" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-chevron-left"></i>
        </button>
        <h5 id="month-name"></h5>
        <button id="next-month" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>

    <div class="calendar-container">
        <table class="calendar-table">
            <thead>
                <tr>
                    <th>D</th>
                    <th>L</th>
                    <th>M</th>
                    <th>M</th>
                    <th>J</th>
                    <th>V</th>
                    <th>S</th>
                </tr>
            </thead>
            <tbody id="calendar-body"></tbody>
        </table>
    </div>
</div>

    <!-- Contenido Principal -->
    <div class="content-area">
        <!-- Buscador -->
        <div class="search-container">
            <input type="text" id="search-input" class="form-control" placeholder="Buscar evento..." oninput="searchEvent()">
        </div>

        <div id="event-details" class="mt-4"></div> <!-- Contenedor para mostrar los eventos -->
    </div>


<!-- Pie de página -->
<footer class="footer">
        <div class="container text-center">
            <p>&copy; 2025 Los derechos de autor reservados | Centro de Aprendizaje Industrial | SENA - CALI</p>
        </div>
    </footer>





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
        function showAllEvents() {
    const eventDetailsContainer = document.getElementById('event-details');
    eventDetailsContainer.innerHTML = '<div class="events-grid"></div>';
    
    const gridContainer = eventDetailsContainer.querySelector('.events-grid');
    
    if (eventos.length > 0) {
        eventos.forEach(event => {
            gridContainer.innerHTML += `
                <div class="card event-card">
                    <img src="${event.imagen || 'https://via.placeholder.com/150'}" class="card-img-top" alt="Imagen del evento">
                    <div class="card-body">
                        <h5 class="card-title">${event.nomEvento}</h5>
                        <p class="card-text">${event.descripcion}</p>
                        <p class="card-text"><small class="text-muted">Fecha: ${new Date(event.fechaEvento).toLocaleDateString()}</small></p>
                    </div>
                </div>
            `;
        });
    } else {
        gridContainer.innerHTML = `
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">No hay eventos disponibles.</h5>
                </div>
            </div>
        `;
    }
}

// Aplica el mismo patrón para showEventDetails y searchEvent

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
                    eventDetailsContainer.innerHTML += `
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="${event.imagen || 'https://via.placeholder.com/150'}" class="img-fluid rounded-start" alt="Imagen del evento">
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
        function searchEvent() {
            const searchInput = document.getElementById('search-input').value.toLowerCase();
            const filteredEvents = eventos.filter(event => event.nomEvento.toLowerCase().includes(searchInput));

            const eventDetailsContainer = document.getElementById('event-details');
            eventDetailsContainer.innerHTML = "";

            if (filteredEvents.length > 0) {
                filteredEvents.forEach(event => {
                    eventDetailsContainer.innerHTML += `
                        <div class="card mb-3" style="max-width: 540px;">
                             <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="${event.imagen || 'https://via.placeholder.com/150'}" class="img-fluid rounded-start" alt="Imagen del evento">
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

        // Función para mostrar todos los eventos cuando se haga clic en "Inicio"
        document.getElementById('home-button').addEventListener('click', function() {
            // Mostrar los eventos sin ocultar el calendario
            showAllEvents();
        });

        // Cargar el calendario y eventos iniciales
        loadCalendar();
        showAllEvents();

        










    </script>



        




</body>
</html>
