<!DOCTYPE html>
<html lang="es">

<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;700&family=Calibri&display=swap"
        rel="stylesheet">
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

</head>



<nav class="navbar navbar-expand-lg navbar-custom">

    



    <div class="container-fluid">
        <!-- Marca -->
        <a class="navbar-brand text-white" href="{{ auth()->check() ? route('calendario.index') : route('public.index') }}">
            <h1 class="h4">AgenSena</h1>
        </a>

        <!-- Botón de menú en dispositivos pequeños -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Enlaces -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                {{-- Enlaces para usuarios autenticados --}}
                @auth
                    <li class="nav-item">
                        <a href="{{ route('calendario.index') }}" class="nav-link text-white">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('evento.reportes.index') }}" class="nav-link text-white">Reportes</a>
                    </li>
                @endauth

                {{-- Enlaces para usuarios no autenticados --}}
                @guest
                    <li class="nav-item">
                        <a href="{{ route('public.index') }}" class="nav-link text-white">Inicio</a>
                    </li>

                    <!-- quitar el eventos -->
                    <li class="nav-item">
                        <a href="{{ route('calendario.index') }}" class="nav-link text-white">Eventos</a>
                    </li>
                @endguest
            </ul>

            {{-- Icono de notificaciones + Logout solo para autenticados --}}
            @auth
                <div class="d-flex align-items-center">
                    <div class="position-relative">
                        <a id="icono-notificacion" href="#">
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
            @endauth

        </div>
    </div>
</nav>

{{-- Script para cargar notificaciones solo si el usuario está logueado --}}
@auth
<script>
    function cargarEventosSinResponder() {
        const ruta = "{{ route('eventos.porConfirmar') }}";

        fetch(ruta)
            .then(response => response.json())
            .then(data => {
                const cantidadEventos = data.cantidadEventos;
                const cantidadEventosSpan = document.getElementById('cantidad-eventos');
                const iconoCampana = document.getElementById('icono-campana');
                const iconoNotificacionActiva = document.getElementById('icono-notificacion-activa');

                cantidadEventosSpan.textContent = cantidadEventos;

                if (cantidadEventos > 0) {
                    iconoCampana.style.display = 'none';
                    iconoNotificacionActiva.style.display = 'block';
                } else {
                    iconoCampana.style.display = 'block';
                    iconoNotificacionActiva.style.display = 'none';
                }
            })
            .catch(error => {
                console.error("Error al cargar eventos:", error);
            });
    }

    document.addEventListener('DOMContentLoaded', cargarEventosSinResponder);
</script>
@endauth






@yield('contentReportes')

</html>