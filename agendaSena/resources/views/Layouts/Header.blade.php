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
                    <li class="nav-item">
                    <a href="{{ route('evento.reportes.index') }}" class="nav-link text-white">Reportes</a>
                    </li>

                    <!-- Inicio me regresa  a la pagina pricipal eventos -->
                    <li class="nav-item">
                    <a href="{{ route('public.index') }}" class="nav-link text-white">Inicio</a>
                    </li>

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
        // Tu código de JavaScript para la gestión de eventos y notificaciones aquí
    </script>

    @yield('contentReportes')

</body>

</html>
