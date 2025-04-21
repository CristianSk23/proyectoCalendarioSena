
<!DOCTYPE html>
<html lang="es">
<head>
@include('layouts.header') {{-- o tus estilos/scripts directamente --}}

</head>



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
    <!-- fin modal -->




<body class="public-page">

    <!-- Sidebar con Calendario -->
    <div class="sidebar">
        <h4 class="text-center mb-4">Calendario</h3>

        <!-- Contenedor del calendario -->
        <div class="calendar-nav">
            <button id="prev-month" class="btn btn-outline-primary"><i class="bi bi-arrow-left"></i></button>
            <span id="month-name" class="h5"></span>
            <button id="next-month" class="btn btn-outline-primary"><i class="bi bi-arrow-right"></i></button>
        </div>

        <div class="calendar-container">
           <!-- <did class="text-calendar"> <h1> Calendario</h1> -->
            <table class="table calendar-table">
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
                   
        <div>

                         <!-- Filtro por Categorias -->
                    <!-- <div class="search-input-container">
                            <label for="category-search">Buscar por categoría:</label>
                            <select id="category-search" class="form-control" oninput="searchEvent()">
                                <option value="">Seleccione una categoría</option> -->
                                <!-- Las categorías se llenan dinámicamente con JavaScript o PHP -->
                            <!-- </select>
                        </div> -->

                    <!--  -->
                    <?php
                        $categorias = DB::table('categoria')->where('estadoCategoria', 1)->get();
                    ?>

                    <div class="search-input-container">
                        <label for="category-search">Buscar por categorías:</label>
                        <select id="category-search" class="form-control" onchange="searchByCategory()">
                            <option value="">Seleccione una categoría</option>  <!-- Opción por defecto -->
                            
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->idCategoria }}">{{ $categoria->nomCategoria }}</option>
                            @endforeach
                        </select>
                    </div>
         

                <!-- Filtro por Fecha -->
                <div class="search-input-container">
                    <label for="date-search">Buscar por fecha:</label>
                    <input type="date" id="date-search" class="form-control" oninput="searchByDate()">
                </div>
                    <!-- Aquí se mostrarán los resultados de los eventos filtrados -->
<!-- <div id="eventosResultados"></div> -->

                <!-- Filtro por Nombre del Evento -->
                <div class="search-input-container">
                    <label for="search-input">Buscar por nombre:</label>
                    <input type="text" id="search-input" class="form-control" placeholder="Buscar evento por nombre..." oninput="searchEvent()">
                </div>

        </div>


        <!-- boton mostar todos los eventos -->
        <div class="mt-3">
            <button class="btn btn-outline-primary w-100" onclick="mostrarTodosEventos()">
                Mostrar todos los eventos
            </button>
        </div>


    </div>

    <!-- Contenido Principal -->
    <div class="content-area">
        <div id="event-details" class="mt-4"></div> <!-- Contenedor para mostrar los eventos -->
    </div>




    </body>


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
                    const [year, month, dayStr] = event.fechaEvento.split('-');
                    const eventDate = new Date(parseInt(year), parseInt(month) - 1, parseInt(dayStr)); // ← construcción local
                    return eventDate.getDate() === day &&
                        eventDate.getMonth() === currentDate.getMonth() &&
                        eventDate.getFullYear() === currentDate.getFullYear();
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

        function createEventCard(event) {
    const imagenPublicidad = event.publicidad || 'https://via.placeholder.com/150';
    const imagenURL = `/storage/${imagenPublicidad}`;

    const horario = event.horario || {};
    const ambiente = event.ambiente || {};
    const categoria = event.categoria || {};

    // Formatear hora inicio y fin
    const horaInicio = horario.inicio ? new Date(horario.inicio).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : '';
    const horaFin = horario.fin ? new Date(horario.fin).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : '';

    const descripcionCorta = event.descripcion.length > 100 
        ? event.descripcion.substring(0, 100) + "..." 
        : event.descripcion;

    return `
        <div class="card mb-3 shadow-sm">
            <img src="${imagenURL}" class="card-img-top" alt="Imagen del evento" style="height: 180px; object-fit: cover;">
            <div class="card-body d-flex flex-column" style="min-height: 200px;">
                <h5 class="card-title mb-2">${event.nomEvento}</h5>
                <p class="card-text text-muted mb-2" style="font-size: 0.95rem;">${descripcionCorta}</p>
                <p class="mb-1"><strong>Fecha:</strong> ${new Date(event.fechaEvento).toLocaleDateString()}</p>
                ${horaInicio && horaFin ? `<p class="mb-1"><strong>Hora:</strong> ${horaInicio} - ${horaFin}</p>` : ''}
                ${ambiente.nombre ? `<p class="mb-1"><strong>Ambiente:</strong> ${ambiente.nombre}</p>` : ''}
                ${categoria.nombre ? `<p class="mb-3"><strong>Categoría:</strong> ${categoria.nombre}</p>` : ''}
                <button class="btn btn-primary mt-auto w-100" onclick='openModal(${JSON.stringify(event)})'>Ver más</button>
            </div>
        </div>
    `;
}




   



   function showAllEvents() {
    const eventDetailsContainer = document.getElementById('event-details');
    eventDetailsContainer.innerHTML = ""; // Limpiar contenido anterior

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

       


        // FUNCION REAL DONDE RECIBE LOS DATOS PARA EVALUAR LOS EVENTOS EXISTENTES!!!!!!!!!!!!!!!!!
        function showEventDetails(day) {
    console.log("Día seleccionado:", day);

    const eventsForDay = eventos.filter(event => {
        const [year, month, dayStr] = event.fechaEvento.split('-');
        const eventDay = parseInt(dayStr, 10);
        const eventMonth = parseInt(month, 10) - 1;
        const eventYear = parseInt(year, 10);

        return (
            eventDay === day &&
            eventMonth === currentDate.getMonth() &&
            eventYear === currentDate.getFullYear()
        );
    });

    console.log("Eventos encontrados:", eventsForDay);

    const eventDetailsContainer = document.getElementById('event-details');
    eventDetailsContainer.innerHTML = ""; // Limpiar

    if (eventsForDay.length > 0) {
        displayEventsInGrid(eventsForDay);  // 🟢 Tarjetas en filas de 3
    } else {
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
        eventDetailsContainer.innerHTML = `
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">No se encontraron eventos para la fecha seleccionada.</h5>
                    <p class="card-text">No hay eventos programados para esta fecha.</p>
                </div>
            </div>
        `;
    }
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







        // Cargar el calendario y eventos iniciales
        loadCalendar();
        showAllEvents();






    function openModal(event) {
        const horario = event.horario || {};
        const ambiente = event.ambiente || {};
        const categoria = event.categoria || {};
        const imagenURL = `/storage/${event.publicidad || 'https://via.placeholder.com/150'}`;

        let contenido = `
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-5">
                        <img src="${imagenURL}" class="img-fluid mb-3" alt="Imagen del evento">
                    </div>
                    <div class="col-md-7">
                        <h5>${event.nomEvento}</h5>
                        <p>${event.descripcion}</p>
                        <p><strong>Fecha:</strong> ${new Date(event.fechaEvento).toLocaleDateString()}</p>
                        ${horario.inicio && horario.fin ? `<p><strong>Hora:</strong> ${new Date(horario.inicio).toLocaleTimeString()} - ${new Date(horario.fin).toLocaleTimeString()}</p>` : ''}
                        ${ambiente.nombre ? `<p><strong>Ambiente:</strong> ${ambiente.nombre}</p>` : ''}
                        ${categoria.nombre ? `<p><strong>Categoría:</strong> ${categoria.nombre}</p>` : ''}
                    </div>
                </div>
            </div>
        `;

        document.getElementById('publicModalTitle').innerText = event.nomEvento;
        document.getElementById('publicModalBody').innerHTML = contenido;

        // Mostrar el modal con Bootstrap 5
        const modal = new bootstrap.Modal(document.getElementById('showPublicModal'));
        modal.show();
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


    
    </script>
</body>
</html>


















