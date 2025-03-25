<!DOCTYPE html>
<html lang="es">

<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

<nav class="navbar navbar-expand-lg" style="background-color: #4caf50;">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="#">
            <h1 class="h4">AgenSena</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="{{route('calendario.index')}}" class="nav-link text-white" aria-current="page">Inicio</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('evento.reportes.index') }}" class="nav-link text-white">Reportes</a>
                </li>
            </ul>
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
                        <!--agrege provisional  yaque-->
                        <a href="{{ route('public.index') }}" class="btn btn-danger ms-3">
                            <box-icon name='power-off' color='#ffffff'></box-icon>
                        </a>
                    </button>
                </form>
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
</script>


@yield('contentReportes')

</html>