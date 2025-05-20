

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
                    <input type="text" id="search-input" class="form-control" placeholder="Buscar evento por nombre..." oninput="searchEvent()">
                </div>
        

                <!-- boton mostar todos los eventos -->
                <div class="mt-3">
                    <button class="btn btn-outline-primary w-100" onclick="mostrarTodosEventos()">
                        Mostrar todos los eventos
                    </button>
                </div>


                <!-- boton Solicitud de eventos desde vista publica -->
                <div class="mt-3">
                    <!-- <a href="{{ route('evento.solicitud') }}" class="btn btn-outline-primary w-100">
                        Agregar Evento
                    </a>                     -->

                    <button id="abrirModalAgregar" class="btn btn-outline-primary w-100">
                        Agregar Evento
                    </button>
                </div>
        </div>        


    </div>

    

    <!-- Contenido Principal -->
    <div class="public-content-area">


    <!-- Bloque BANNER -->



<!-- YULI BANNER -->
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
                        <h5 class="text-white m-0">{{ $banner->evento->nombreEvento ?? 'Evento sin nombre' }}</h5>
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




            <div id="event-details" class="mt-4"></div> <!-- Contenedor para mostrar los eventos -->
    

    
            @yield('content') <!-- Aquí se mostrará las secciones de contenido -->




        <!-- Modal para autenticación antes de agregar evento -->
        <div class="modal fade" id="authModalAgregarEvento" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="authFormAgregar">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title">Verifica tu identidadaaaa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                        <div class="mb-3">
                            <label for="auth_identificacion" class="form-label">Identificación</label>
                            <input type="text" class="form-control" id="auth_identificacion" required>
                        </div>
                        <div class="mb-3">
                            <label for="auth_password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="auth_password" required>
                        </div>
                        <div id="auth_error_modal" class="text-danger mt-1"></div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="submitAuthForm" class="btn btn-primary">ValidarEsta si</button>
                        </div>
                    </div>
                    </form>
                </div>
        </div>




         <!-- Pie de pagina -->
        <footer class="public-footer">
            <div class="public-footer-content">
                SENA CDTI  | CENTRO DE DISEÑO TECNOLÓGICO INDUSTRIAL &copy; {{ date('Y') }}
            </div>
        </footer>

    </div>

    

    
    

    <!-- Cargar Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

   <script>

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
        fetch("/ruta-de-tu-api/storeExterno", {
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






    // VALIDAR FORMULARIO DE EVENTOS EXTERNO yuli
    //  document.addEventListener('DOMContentLoaded', function () {
    //     const modal = new bootstrap.Modal(document.getElementById('authModalAgregarEvento'));
    //     const eventoForm = document.getElementById('eventoForm');
    //     const btnAbrir = document.getElementById('btnAbrirAutenticacion');
    //     const errorBox = document.getElementById('auth_error_modal');
    //     const btnValidar = document.getElementById('btnValidar');
    //     const inputHiddenIdentificacion = document.getElementById('par_identificacion_autenticado');

    //     // Abrir modal de autenticación
    //     btnAbrir.addEventListener('click', () => {
    //         modal.show();
    //     });

    //     // Validar credenciales
    //     document.getElementById('authFormAgregar').addEventListener('submit', function (e) {
    //         e.preventDefault();

    //         const identificacion = document.getElementById('auth_identificacion').value;
    //         const password = document.getElementById('auth_password').value;

    //         errorBox.textContent = '';
    //         btnValidar.disabled = true;
    //         btnValidar.textContent = 'Validando...';

    //         fetch("{{ route('validar.credenciales.publicas') }}", {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json',
    //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //             },
    //             body: JSON.stringify({
    //                 par_identificacion: identificacion,
    //                 password: password
    //             })
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             btnValidar.disabled = false;
    //             btnValidar.textContent = 'Validar';

    //             if (data.success) {
    //                 modal.hide();
    //                 document.getElementById('authFormAgregar').reset();
    //                 inputHiddenIdentificacion.value = identificacion;

    //                 eventoForm.style.display = 'block';
    //                 eventoForm.scrollIntoView({ behavior: 'smooth' });
    //             } else {
    //                 errorBox.textContent = data.message;
    //             }
    //         })
    //         .catch(() => {
    //             btnValidar.disabled = false;
    //             btnValidar.textContent = 'Validar';
    //             errorBox.textContent = 'Error en la solicitud. Intenta nuevamente.';
    //         });
    //     });
    // });

    //fin








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
        showAllEvents();
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




// modal para agregar evento por solicitud publica
// document.addEventListener('DOMContentLoaded', function () {
//     const modal = new bootstrap.Modal(document.getElementById('authModalAgregarEvento'));

//     document.getElementById('abrirModalAgregar').addEventListener('click', () => {
//         modal.show();
//     });

//     document.getElementById('authFormAgregar').addEventListener('submit', function (e) {
//         e.preventDefault();

//         const identificacion = document.getElementById('auth_identificacion').value;
//         const password = document.getElementById('auth_password').value;

//         fetch('{{ route("verificar-credenciales") }}', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
//             },
//             body: JSON.stringify({ par_identificacion: identificacion, password: password })
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 window.location.href = "{{ route('evento.solicitud') }}";
//             } else {
//                 document.getElementById('auth_error_modal').innerText = data.message || 'Credenciales incorrectas.';
//             }
//         })
//         .catch(error => {
//             console.error(error);
//             document.getElementById('auth_error_modal').innerText = 'Error en la autenticación.';
//         });
//     });
// });



// NUEVO REAL XD 

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






</script>
<!-- relacion de -->
@stack('scripts')
</body>

 <!-- yaque 12 am alerta "bonita" -->

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
 <!-- fin yaque 12 am alerta "bonita" -->


</html>























