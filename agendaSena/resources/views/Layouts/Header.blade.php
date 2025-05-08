<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;700&family=Calibri&display=swap"
        rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    {{-- Estilos BOOTSTRAP --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <title>Agenda CDTI-SENA</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #4caf50;">
        <div class="container-fluid">
            <div>
                <img src="{{ asset('images/inicio/logo.png') }}" alt="Logo" class="img-fluid"
                    style="width: 50px; height: 50px;">
            </div>
            <div class="ms-2">
                <a href="{{ route('calendario.index') }}" class="nav-link text-white">
                    <h1 class="h4">AgenSena</h1>
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    {{-- <li class="nav-item">
                        <a href="{{ route('evento.reportes.index') }}" class="nav-link text-white">Reportes</a>
                    </li>

                    <!-- Inicio me regresa  a la pagina pricipal eventos -->
                    <li class="nav-item">
                        <a href="{{ route('public.index') }}" class="nav-link text-white">Inicio</a>
                    </li> --}}

                </ul>
                <div class="d-flex align-items-center">
                    <div class="position-relative">
                        <a id="icono-notificacion">
                            <!-- Ícono de campana normal -->
                            <i id="icono-campana" class="bx bxs-bell" style="color: #ffffff;"></i>
                            <!-- Ícono de campana sonando (oculto inicialmente) -->
                            <i id="icono-notificacion-activa" class="bx bxs-bell-ring"
                                style="color: #ffffff; display: none;"></i>
                        </a>
                        <span id="cantidad-eventos"
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            0
                        </span>
                    </div>

                    <!-- Verificar si el usuario está autenticado -->
                    @auth

                        <div class="dropdown ms-4">
                            <button class="btn dropdown-toggle text-dark border-0" id="menuConfiguracion"
                                data-bs-toggle="dropdown" style="background-color: transparent; color: #fff;">
                                <i class="bx bx-cog fs-4"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="menuConfiguracion">
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalFondos">
                                        <i class="bx bx-image-alt"></i> Cambiar fondo de inicio
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Si el usuario está autenticado, mostrar el botón de cierre de sesión -->
                        <form method="POST" action="{{ route('login.logout') }}" class="ms-3">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <!-- Ícono de power -->
                                <i class="bx bx-power-off" style="color: #ffffff;"></i> Cerrar sesión
                            </button>
                        </form>
                    @else
                        <!-- Si el usuario no está autenticado, mostrar un botón o enlace para iniciar sesión -->
                        <a href="{{ route('login') }}" class="btn btn-primary ms-3">
                            <i class="bx bx-log-in" style="color: #ffffff;"></i> Iniciar sesión
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>


    <script>
        function cargarEventosSinResponder() {
            const ruta = "{{ route('eventos.porConfirmar') }}";
            fetch(ruta)
                .then(response => response.json())
                .then(data => {
                    const cantidadEventos = data.cantidadEventos;

                    // Actualizar el contenido del span con la cantidad de eventos
                    const cantidadEventosSpan = document.getElementById('cantidad-eventos');
                    const iconoCampana = document.getElementById('icono-campana');
                    const iconoNotificacionActiva = document.getElementById('icono-notificacion-activa');

                    cantidadEventosSpan.textContent = cantidadEventos;

                    if (cantidadEventos > 0) {
                        // Cambiar a icono de notificación activa
                        iconoCampana.style.display = 'none'; // Ocultar el icono de campana
                        iconoNotificacionActiva.style.display = 'block'; // Mostrar el icono de notificación activa
                    } else {
                        // Volver al icono de campana
                        iconoCampana.style.display = 'block'; // Mostrar el icono de campana
                        iconoNotificacionActiva.style.display = 'none'; // Ocultar el icono de notificación activa
                    }
                })
                .catch(error => {
                    console.error("Error al cargar eventos:", error);
                });
        }

        // Llama a la función para cargar los eventos al cargar la página
        document.addEventListener('DOMContentLoaded', cargarEventosSinResponder);

        document.getElementById('icono-notificacion').addEventListener('click', function (e) {
            e.preventDefault();
            eventosSinConfirmar();
        });


        function eventosSinConfirmar() {
            const modal = new bootstrap.Modal(document.getElementById('eventModal'));

            // Configurar título específico para eventos pendientes
            document.getElementById('eventModalLabel').textContent = 'Eventos Pendientes';
            document.getElementById('tituloEventos').textContent = 'Eventos sin confirmar';

            // Limpiar contenido previo
            const eventosList = document.getElementById('eventosList');
            eventosList.innerHTML = `
                <div class="col-12 text-center py-4">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
                `;
            modal.show();
            const ruta = "{{ route('eventos.porConfirmar') }}";
            fetch(ruta)
                .then(response => response.json())
                .then(data => {
                    const cantidadEventos = data.cantidadEventos;
                    console.log(data.ambiente);

                    if (cantidadEventos > 0) {
                        renderEventosPendientes(data.eventos, data.ambiente);
                        // Cambiar ícono a notificación activa
                        document.getElementById('icono-campana').style.display = 'none';
                        document.getElementById('icono-notificacion-activa').style.display = 'inline-block';
                    } else {
                        eventosList.innerHTML = `
                    <div class="col-12 text-center py-3">
                        <p class="text-muted">No hay eventos pendientes de confirmación</p>
                    </div>
                `;
                    }
                })
                .catch(error => {
                    console.error("Error al cargar eventos:", error);
                });





            function renderEventosPendientes(eventos, ambiente) {
                const eventosList = document.getElementById('eventosList');
                eventosList.innerHTML = ''; // Limpiar spinner

                eventos.forEach(evento => {
                    const eventoCol = document.createElement('div');
                    eventoCol.className = 'col-md-6 mb-3';
                    const imagenPublicidad = evento.publicidad;
                    const imagenURL = `/storage/${imagenPublicidad}`;

                    eventoCol.innerHTML = `
                <div class="card h-100">
                    <div class="card-body">
                        <img class="card-img-top" src="${imagenURL}" alt="Publicidad del evento" style="max-width: 100%; height: auto;">
                        <h5 class="card-title text-truncate">${evento.nomEvento}</h5>
                        <div class="card-text">
                            <p><strong>Fecha:</strong> ${evento.fechaEvento}</p>
                            <p><strong>Ambiente:</strong> ${ambiente.pla_amb_descripcion}</p>
                            <p><strong>Solicitante:</strong> ${evento.nomSolicitante}</p>
                        </div>
                    </div>
                                <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between">
                    <button class="btn btn-sm btn-success btn-confirmar" 
                            data-evento-id="${evento.idEvento}">
                        <i class="bx bx-check"></i> Confirmar
                    </button>
                    <button class="btn btn-sm btn-danger" 
                            data-action="rechazar-evento" 
                            data-evento-id="${evento.idEvento}">
                        <i class="bx bx-x"></i> Rechazar
                    </button>
                </div>
            </div>
                </div>
            `;

                    eventosList.appendChild(eventoCol);
                });
                const confirmarEventoBtns = document.querySelectorAll('.btn-confirmar');

                confirmarEventoBtns.forEach(btn => {
                    btn.addEventListener('click', function () {
                        const eventoId = this.getAttribute('data-evento-id');
                        console.log("Confirmando evento con ID: " + eventoId);
                        // Aquí puedes llamar a la función para confirmar el evento
                        confirmarEvento(eventoId);
                    });
                });
            }

            function confirmarEvento(id) {
                const baseRuta = "{{ route('eventos.confirmarEvento') }}";
                const ruta = `${baseRuta}`;

                const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
                if (!csrfTokenMeta) {
                    console.error("El elemento meta con el token CSRF no se encontró.");
                    return;
                }
                const csrfToken = csrfTokenMeta.getAttribute('content');

                fetch(ruta, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken // Usa el token CSRF aquí
                    },
                    body: JSON.stringify({ idEvento: id })
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la respuesta del servidor: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            const notyf = new Notyf();
                            notyf.success('Evento confirmado correctamente');
                            modal.hide();

                            // Retrasar la redirección
                            setTimeout(() => {
                                const ruta = "{{ route('calendario.index') }}";
                                window.location.href = ruta;
                            }, 2000); // 2000 milisegundos = 2 segundos
                        } else {
                            console.error("Error al confirmar el evento:", data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error al confirmar el evento:", error);
                    });
            }
        }
    </script>

    @yield('contentReportes')

    <footer class="agensena-footer">
        <div class="agensena-footer-content">
            SENA | CENTRO DE DISEÑO TECNOLÓGICO INDUSTRIAL &copy; {{ date('Y') }}
        </div>
    </footer>


</body>




</html>