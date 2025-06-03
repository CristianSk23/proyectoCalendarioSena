<!DOCTYPE html>
<html lang="es">
<head>
@include('layouts.header') {{-- o tus estilos/scripts directamente --}}
<!-- <script src="{{ asset('js/app.js') }}"></script> -->

</head>

<body class="public-page">

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

                   <!-- Filtro por categoria -->    
                <div class="search-input-container">
                    <label for="categoria_id">Filtrar por categoría:</label>
                    <select class="form-select" name="categoria_id" id="categoria_id">
                        <option value="">-- Selecciona una categoría --</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->idCategoria }}">{{ $categoria->nomCategoria }}</option>
                        @endforeach
                    </select>
                </div>

                    

                <!-- Filtro por Fecha -->
                <div class="search-input-container">
                    <label for="date-search">Buscar por fecha:</label>
                    <input type="date" id="date-search" class="form-control" oninput="searchByDate()">
                </div>
              

                <!-- Filtro por Nombre del Evento -->
                <div class="search-input-container">
                    <label for="search-input">Buscar por nombre:</label>
                    <!-- <input type="text" id="search-input" class="form-control" placeholder="Buscar evento por nombre..." oninput="searchEvent()"> -->
                    <input type="text" id="search-input" class="form-control" placeholder="Buscar evento por nombre" oninput="searchEvent()">

                </div>
        

                <!-- boton mostar todos los eventos -->
                <div class="mt-3">
                    <button class="btn btn-outline-primary w-100" onclick="mostrarTodosEventos()">
                        Mostrar todos los eventos
                    </button>
                </div>

                <!-- boton Solicitud de eventos desde vista publica -->
                <div class="mt-3">                                   
                        <button id="abrirModalAgregar" class="btn btn-outline-primary w-100">
                            Agregar Evento
                        </button>
                    </div>
                 </div>  
                 
                <div class="mt-3">
                    <a href="{{ route('public.index') }}" class="btn btn-outline-secondary w-100">
                        INICIO
                    </a>
                </div>


    </div>

    

    <!-- Contenido Principal -->
    <div class="public-content-area">

    <!-- Bloque BANNER -->

     @if(!isset($ocultarBanner) || !$ocultarBanner)
        <!-- BANNER -->
        @if(isset($imagenesBanner) && $imagenesBanner->isNotEmpty())
            <div id="bannerCarousel" class="carousel slide mb-4" data-bs-ride="carousel" data-bs-interval="5000" data-bs-wrap="true">
                <div class="carousel-inner">
                    @foreach($imagenesBanner as $index => $banner)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            @php
                                $rutaImagen = public_path('storage/' . $banner->ruta);
                            @endphp

                            @if(file_exists($rutaImagen))
                                <img src="{{ asset('storage/' . $banner->ruta) }}" class="d-block w-100" alt="Foto de evento">
                            @else
                                <div class="d-flex align-items-center justify-content-center text-white w-100 h-100 bg-secondary" style="height: 400px;">
                                    <p class="m-0">Imagen no disponible</p>
                                </div>
                            @endif

                            <div class="carousel-caption d-none d-md-block">
                                <div class="banner-caption-bg">
                                    <h5 class="banner-caption-text">
                                        {{ $banner->evento->nomEvento ?? 'Evento sin nombre' }}
                                    </h5>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        @else
            <div class="mb-4" style="aspect-ratio: 14 / 10; background-color: #ccc; display: flex; align-items: center; justify-content: center;">
                <p class="text-muted">No hay imágenes disponibles por el momento.</p>
            </div>
        @endif
         @endif    
        <!-- FIN DE BANNER -->

        <!--INICIO CONTENIDO DE EVENTOS -->
        @if(!isset($ocultarEventDetails) || !$ocultarEventDetails)
        <div id="event-details" class="mt-4 card-container"></div> 
        @endif


        <!-- aqui me llevara a otras seciones -->
  
            @yield('content') <!-- secciones de contenido -->

        <!--FIN CONTENIDO DE EVENTOS -->



      <!-- Modal de Autenticación -->
<div class="modal fade" id="authModalAgregarEvento" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="authFormAgregar" class="w-100">
            <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                
                <!-- Encabezado limpio y elegante -->
                <div class="modal-header" style="background: linear-gradient(135deg, #38b000, #aacc00); color: white;">
                    <h5 class="modal-title fw-bold" id="authModalLabel">🔐 Acceso Seguro</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <!-- Cuerpo del formulario -->
                <div class="modal-body bg-white px-4 py-4">
                    <p class="text-muted text-center mb-4">Introduce tus datos de acceso para continuar con la solicitud del evento.</p>

                    <div class="mb-3">
                        <label for="auth_identificacion" class="form-label">📇 Identificación</label>
                        <input type="text" class="form-control form-control-lg" id="auth_identificacion" placeholder="Ej. 1098765432" required>
                    </div>

                    <div class="mb-3">
                        <label for="auth_password" class="form-label">🔑 Contraseña</label>
                        <input type="password" class="form-control form-control-lg" id="auth_password" placeholder="Tu contraseña" required>
                    </div>

                    <div id="auth_error_modal" class="text-danger mt-2 text-center small"></div>
                </div>

                <!-- Footer con botones -->
                <div class="modal-footer bg-light justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" id="submitAuthForm" class="btn btn-success px-4">Validar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- fin modal autenticacion -->



         <!-- Pie de pagina -->
        <footer class="public-footer">
            <div class="public-footer-content">
                SENA CDTI  | CENTRO DE DISEÑO TECNOLÓGICO INDUSTRIAL &copy; {{ date('Y') }}
            </div>
        </footer>

    </div>

    

</body>
    

    <!-- Cargar Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
   

   <script>



    // -- Manejo de formulario publico para agregar eventos 
    
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("authFormAgregar");

        form.addEventListener("submit", function(e) {
            e.preventDefault(); // Evita el envío tradicional del formulario

            const identificacion = document.getElementById("auth_identificacion").value;
            const password = document.getElementById("auth_password").value;

            // Llamar a una función que use estas credenciales para validar o continuar el flujo
            validarCredenciales(identificacion, password);
        });

        function validarCredenciales(identificacion, password) {
            fetch("/evento/storeExterno", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    auth_identificacion: identificacion,
                    auth_password: password,
                    // Aquí puedes incluir también los datos del evento si ya los tienes
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Éxito: continuar con el proceso
                    console.log("Autenticación válida. ID del evento:", data.evento_id);
                    // Puedes cerrar el modal si deseas
                    const modal = bootstrap.Modal.getInstance(document.getElementById('authModalAgregarEvento'));
                    modal.hide();
                } else {
                    // Mostrar error
                    document.getElementById("auth_error_modal").textContent = data.message;
                }
            })
            .catch(error => {
                console.error("Error en la solicitud:", error);
            });
        }
    });
    // -- FIN Manejo de formulario publico para agregar eventos -ok








    let currentDate = new Date();
      let eventos = @json($eventos);
    

    // funcionamiento  calendario y sus fechas
    function loadCalendar() {
        const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
        const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();

        if (!Array.isArray(eventos)) {
            eventos = [];
        }

        document.getElementById('month-name').innerText = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
        let calendarBody = document.getElementById('calendar-body');
        calendarBody.innerHTML = "";

        let row = document.createElement('tr');
        for (let i = 0; i < firstDayOfMonth; i++) {
            row.appendChild(document.createElement('td'));
        }

        for (let day = 1; day <= daysInMonth; day++) {
            let cell = document.createElement('td');
            cell.innerText = day;

            const eventForDay = eventos.filter(event => {
                const [year, month, dayStr] = event.fechaEvento.split('-');
                const eventDate = new Date(parseInt(year), parseInt(month) - 1, parseInt(dayStr));
                return eventDate.getDate() === day &&
                    eventDate.getMonth() === currentDate.getMonth() &&
                    eventDate.getFullYear() === currentDate.getFullYear();
                (event.estadoEvento === 1 || event.estadoEvento === 3); 
            });

            if (eventForDay.length > 0) {
                cell.classList.add('event-day');
            }

            cell.addEventListener('click', function () {
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

    // Cargar funcion del calendario y sus eventos
    document.addEventListener('DOMContentLoaded', function () {
        loadCalendar();
        document.getElementById('categoria_id').addEventListener('change', searchByCategory);
    });


    // Cambiar al mes anterior
    document.getElementById('prev-month').addEventListener('click', function () {
        currentDate.setMonth(currentDate.getMonth() - 1);
        loadCalendar();
    });

    // Cambiar al mes siguiente
    document.getElementById('next-month').addEventListener('click', function () {
        currentDate.setMonth(currentDate.getMonth() + 1);
        loadCalendar();
});





// Manejo de datos de autenticador 
//  para el ingreso al formulario solicitud de eventos

document.addEventListener('DOMContentLoaded', function () {
    const modal = new bootstrap.Modal(document.getElementById('authModalAgregarEvento'));
    const eventoForm = document.getElementById('eventoForm');
    const btnAbrir = document.getElementById('btnAbrirAutenticacion') || document.getElementById('abrirModalAgregar');
    const errorBox = document.getElementById('auth_error_modal');
    const btnValidar = document.getElementById('btnValidar');
    const inputHiddenIdentificacion = document.getElementById('par_identificacion_autenticado');
    const authForm = document.getElementById('authFormAgregar');

    // Mostrar modal al hacer clic en el botón
    if (btnAbrir) {
        btnAbrir.addEventListener('click', () => {
            modal.show();
        });
    }

    // Validar formulario de autenticación
    if (authForm) {
        authForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const identificacion = document.getElementById('auth_identificacion').value;
            const password = document.getElementById('auth_password').value;

            errorBox.textContent = '';
            if (btnValidar) {
                btnValidar.disabled = true;
                btnValidar.textContent = 'Validando...';
            }

            fetch("{{ route('validar.credenciales.publicas') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    par_identificacion: identificacion,
                    password: password
                })
            })
            .then(response => response.json())
            .then(data => {
                if (btnValidar) {
                    btnValidar.disabled = false;
                    btnValidar.textContent = 'Validar';
                }

                if (data.success) {
                    modal.hide();
                    authForm.reset();
                    if (inputHiddenIdentificacion) {
                        inputHiddenIdentificacion.value = identificacion;
                    }

                    if (eventoForm) {
                        eventoForm.style.display = 'block';
                        eventoForm.scrollIntoView({ behavior: 'smooth' });
                    } else {
                        // Alternativamente redireccionar si no hay formulario
                        window.location.href = "{{ route('evento.solicitud') }}";
                    }
                } else {
                    errorBox.textContent = data.message || 'Credenciales incorrectas.';
                }
            })
            .catch(() => {
                if (btnValidar) {
                    btnValidar.disabled = false;
                    btnValidar.textContent = 'Validar';
                }
                errorBox.textContent = 'Error en la solicitud. Intenta nuevamente.';
            });
        });
    }
});

//FIN Manejo de datos de autenticador  para el ingreso al formulario solicitud de eventos


let eventosOriginales = [...eventos];  
// visualizacion de eventos en el contenido
function showEventDetails(day) {
    const eventosDelDia = eventos.filter(event => {
        const [year, month, dayStr] = event.fechaEvento.split('-');
        const eventDate = new Date(parseInt(year), parseInt(month) - 1, parseInt(dayStr));
        return eventDate.getDate() === day &&
            eventDate.getMonth() === currentDate.getMonth() &&
            eventDate.getFullYear() === currentDate.getFullYear();
    });

    const container = document.getElementById("event-details");
    container.innerHTML = ""; // Limpiar contenido anterior

    if (eventosDelDia.length === 0) {
        container.innerHTML = `
            <div class="card mt-3">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">No hay eventos para este día.</h5>
                    <p class="text-muted">¡Pero no te preocupes! Vuelve más tarde para descubrir nuevos eventos.</p>
                </div>
            </div>
        `;
        return;
    }

    eventosDelDia.forEach(evento => {
        container.innerHTML += createEventCard(evento);
    });
}





///filtros  ignorar tildes
function quitarTildes(texto) {
    return texto.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
}


// FILTRAR POR NOMBRE
function searchEvent() {
    const searchInput = quitarTildes(document.getElementById('search-input').value.toLowerCase());
    
    const eventDetailsContainer = document.getElementById('event-details');
    eventDetailsContainer.innerHTML = ""; // Limpiar contenido previo

    // Filtrar los eventos que coincidan con cualquier palabra en los campos relevantes
    const filteredEvents = eventos.filter(event => {
        // Concatenar los campos relevantes para la búsqueda
        const eventText = `        
        ${event.nomEvento} 
        ${event.descripcion} 
        ${event.categoria && event.categoria.nomCategoria ? event.categoria.nomCategoria : ''}
         ${event.ambiente && event.ambiente.pla_amb_descripcion ? event.ambiente.pla_amb_descripcion : ''}
        `.toLowerCase();
        return quitarTildes(eventText).includes(searchInput);
// Verificar si la entrada de búsqueda está en el texto concatenado
    });

    if (filteredEvents.length > 0) {
        // Si se encuentran eventos, generamos las tarjetas usando createEventCard
        filteredEvents.forEach(event => {
            const cardHTML = createEventCard(event); // Generar la tarjeta para cada evento
            eventDetailsContainer.innerHTML += cardHTML;  // Insertamos la tarjeta generada
        });
    } else {
        // Si no se encuentran eventos después del filtro, llamar a la función mostrarMensajeSinEventos
        mostrarMensajeSinEventos("No se encontraron eventos que coincidan con tu búsqueda.");
    }
}


// Filtrar por categoria seleccionada
function searchByCategory() {
    const categoryInput = document.getElementById('categoria_id').value;  // Obtener la categoría seleccionada

    const eventDetailsContainer = document.getElementById('event-details');
    eventDetailsContainer.innerHTML = ""; // Limpiar contenido previo

    
    
    // Si no se seleccionó una categoría, no filtramos y mostramos todos los eventos
    if (!categoryInput) {
        displayAllEvents(); // Función que muestra todos los eventos sin filtro
        return;
    }

    // Filtrar eventos por la categoría seleccionada
    
    const filteredEvents = eventos.filter(event => {
        // return event.idCategoria == categoryInput;  // Comparar el ID de la categoría
        return event.categoria && event.categoria.idCategoria == categoryInput;
        
        
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



//  Buscar por fecha
function searchByDate() {
    const date = document.getElementById('date-search').value;
    limpiarOtrosFiltros('fecha');

    if (!date) {
        mostrarTodosEventos();
        return;
    }

    const filtrados = eventos.filter(evento => {
        const fechaEvento = new Date(evento.fechaEvento).toISOString().split('T')[0];
        return fechaEvento === date;
    });

    displayEventsInGrid(filtrados);
}






// 🧹 Limpiar los filtros que no se están usando
function limpiarOtrosFiltros(excepto) {
    if (excepto !== 'nombre') document.getElementById('search-input').value = '';
    if (excepto !== 'fecha') document.getElementById('date-search').value = '';
    if (excepto !== 'categoria') document.getElementById('categoria_id').value = '';
}



// 🗂 Mostrar todos los eventos sin filtro
function mostrarTodosEventos() {
    // Limpiar filtros
    document.getElementById('search-input').value = '';
    document.getElementById('date-search').value = '';
    document.getElementById('categoria_id').value = '';

    // Mostrar todos los eventos sin filtro
    displayEventsInGrid(eventos);
}



//  Mostrar eventos actual o siguiente
function filtrarEventosDiaOMesSiguiente(eventos) {
    const hoy = new Date();
    const finMesActual = new Date(hoy.getFullYear(), hoy.getMonth() + 1, 0); // último día del mes actual
    const mesSiguiente = hoy.getMonth() + 1;
    const añoSiguiente = hoy.getMonth() === 11 ? hoy.getFullYear() + 1 : hoy.getFullYear();

    return eventos.filter(event => {
        const eventDate = new Date(event.fechaEvento);

        // Evento desde hoy hasta fin de mes actual
        const enMesActualDesdeHoy = eventDate >= hoy && eventDate <= finMesActual;

        // Evento en cualquier día del mes siguiente
        const enMesSiguiente = eventDate.getMonth() === mesSiguiente &&
                              eventDate.getFullYear() === añoSiguiente;

        return enMesActualDesdeHoy || enMesSiguiente;
    });
}



// Muestra los eventos en el contenido
function displayEventsInGrid(listaEventos) {
    const container = document.getElementById("event-details");
    container.innerHTML = "";

    if (!listaEventos.length) {
        mostrarMensajeSinEventos("No se encontraron eventos.");
        return;
    }

    listaEventos.forEach(evento => {
        container.innerHTML += createEventCard(evento);
    });
}


//  Mostrar mensaje si no hay eventos
function mostrarMensajeSinEventos(mensaje) {
    const container = document.getElementById("event-details");
    container.innerHTML = `
        <div class="card mt-3">
            <div class="card-body text-center">
                <h5 class="card-title">${mensaje}</h5>
            </div>
        </div>
    `;
}



function mostrarEventosDesdeHoy() {
    const hoy = new Date();
    hoy.setHours(0, 0, 0, 0); // Ignora hora para que solo compare por fecha

    const eventosFuturos = eventos.filter(evento => {
        const fechaEvento = new Date(evento.fechaEvento);
        fechaEvento.setHours(0, 0, 0, 0);
        return fechaEvento >= hoy;
    });

    displayEventsInGrid(eventosFuturos);
}





</script>

@stack('scripts')
</body>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: false
            });
        @elseif(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                timer: 3500,
                showConfirmButton: false
            });
        @endif
    });





</script>


</html>

