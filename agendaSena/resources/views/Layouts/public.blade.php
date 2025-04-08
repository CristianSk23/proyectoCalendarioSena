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
    



<!-- <meta charset="UTF-8"> -->
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
<!-- <link rel="stylesheet" href="{{ asset('css/estilo.css') }}"> -->
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



  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg" style="background-color: #4caf50;">
        <div class="container-fluid">
        <a class="navbar-brand text-white" href="#">
    <h1 class="h4">AgenSena</h1>
</a>
<a href="{{route('public.index')}}" class="nav-link text-white" aria-current="page">Inicio</a>

            
            
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
           <did class="text-calendar"> <h1> Calendario</h1>
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
                   
        <div>
         


                <!-- Filtro por Fecha -->
                <div class="search-input-container">
                    <label for="date-search">Buscar por fecha:</label>
                    <input type="date" id="date-search" class="form-control" oninput="searchByDate()">
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
function createEventCard(event) {
    // Aseguramos que la imagen de publicidad esté correctamente definida
    const imagenPublicidad = event.publicidad || 'https://via.placeholder.com/150';
    const imagenURL = `/storage/${imagenPublicidad}`;

    // Desestructuramos el horario, ambiente y categoría de los eventos
    const horario = event.horario || {};  // Si no existe, asignamos un objeto vacío
    const ambiente = event.ambiente || {};  // Lo mismo para ambiente
    const categoria = event.categoria || {};  // Lo mismo para categoria

    // Creamos el HTML para la tarjeta del evento
    return `
        <div class="card mb-3" style="max-width: 1000px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="${imagenURL}" class="img-fluid rounded-start" alt="Imagen del evento" style="object-fit: cover; width: 100%; height: 100%;">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <!-- Título del Evento -->
                        <h5 class="card-title">${event.nomEvento}</h5>
                        
                        <!-- Descripción del Evento -->
                        <p class="card-text">${event.descripcion}</p>

                        <!-- Fecha del Evento -->
                        <p class="card-text"><small class="text-muted">Fecha: ${new Date(event.fechaEvento).toLocaleDateString()}</small></p>

                        <!-- Mostrar hora de inicio y fin -->
                        ${horario && horario.inicio && horario.fin ? `
                            <p class="card-text">
                                <small class="text-muted">
                                    Hora: ${new Date(horario.inicio).toLocaleTimeString()} - ${new Date(horario.fin).toLocaleTimeString()}
                                </small>
                            </p>
                        ` : ''}

                        <!-- Mostrar ambiente -->
                        ${ambiente && ambiente.nombre ? `
                            <p class="card-text">
                                <small class="text-muted">Ambiente: ${ambiente.nombre}</small>
                            </p>
                        ` : ''}

                        <!-- Mostrar categoría -->
                        ${categoria && categoria.nombre ? `
                            <p class="card-text">
                                <small class="text-muted">Categoría: ${categoria.nombre}</small>
                            </p>
                        ` : ''}
                    </div>
                </div>
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
            <div class="card">
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
                       eventDetailsContainer.innerHTML += createEventCard(event);
                         
                });
            } else {
                //  Si no hay eventos para el día, mostrar el mensaje
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
            const cardHTML = createEventCard(event);  // Llamamos a la función createEventCard
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
        filteredEvents.forEach(event => {
            const cardHTML = createEventCard(event);  // Llamamos a la función createEventCard
            eventDetailsContainer.innerHTML += cardHTML;  // Insertamos la tarjeta generada
        });
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

// // Filtrar por categoria seleccionada
// function searchByCategory() {
//         const categoryInput = document.getElementById('category-search').value;  // Obtener la categoría seleccionada
//         console.log("Categoría seleccionada:", categoryInput);  // Verificar la categoría seleccionada

//         const eventDetailsContainer = document.getElementById('event-details');
//         eventDetailsContainer.innerHTML = ""; // Limpiar contenido previo

//         // Si no se seleccionó una categoría, no filtramos y mostramos todos los eventos
//         if (!categoryInput) {
//             displayAllEvents(); // Función que muestra todos los eventos sin filtro
//             return;
//         }

//         // Filtrar eventos por la categoría seleccionada
//         const filteredEvents = eventos.filter(event => {
//             return event.idCategoria == categoryInput;  // Comparar el ID de la categoría
//         });

//         // Mostrar los eventos filtrados
//         if (filteredEvents.length > 0) {
//             filteredEvents.forEach(event => {
//                 const cardHTML = createEventCard(event);  // Llamamos a la función createEventCard
//                 eventDetailsContainer.innerHTML += cardHTML;  // Insertamos la tarjeta generada
//             });
//         } else {
//             // Si no se encuentran eventos después del filtro por categoría
//             eventDetailsContainer.innerHTML = `
//                 <div class="card">
//                     <div class="card-body">
//                         <h5 class="card-title">No se encontraron eventos para la categoría seleccionada.</h5>
//                         <p class="card-text">No hay eventos programados para esta categoría.</p>
//                     </div>
//                 </div>
//             `;
//         }
//     }




// // Funcion para crear la tarjeta de cada evento
// function createEventCard(event) {
//     return `
//         <div class="card">
//             <div class="card-body">
//                 <h5 class="card-title">${event.nomEvento}</h5>
//                 <p class="card-text">Fecha: ${event.fechaEvento}</p>
//                 <p class="card-text">Categoria: ${event.categoria}</p>
//                 <p class="card-text">${event.descripcion}</p>
//             </div>
//         </div>
//     `;
// }









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

        










        // Cargar el calendario y eventos iniciales
        loadCalendar();
        showAllEvents();
    </script>
</body>
</html>

