<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos Públicos</title>
    <!-- Cargar Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Cargar tu archivo de estilos personalizado -->
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    <!-- iconos bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Eventos Públicos</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Eventos</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Barra lateral izquierda -->
    <div class="fixed-sidebar">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Barra Lateral</h5>
                <p class="card-text">Contenido de la barra lateral.</p>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
<div class="main-content" style="margin-left: 25%;">
    <div class="container">
        <h1 class="text-center my-4">Eventos Públicos</h1>

        <!-- Contenedor de eventos con scroll -->
        <div class="eventos-scroll-container">
            <div class="row">
                @foreach($eventos as $evento)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $evento->nomEvento }}</h5>
                                <p class="card-text">{{ $evento->descripcion }}</p>
                                <a href="{{ route('public.show', $evento->idEvento) }}" class="btn btn-primary">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>



<script>
    // Simulación de eventos agendados
    const eventos = [
        { fecha: '2025-02-12', nombre: 'Reunión de Proyecto' },
        { fecha: '2025-01-17', nombre: 'Taller de Desarrollo' }
    ];

    const hoy = new Date().toISOString().split('T')[0]; // Obtener la fecha de hoy en formato YYYY-MM-DD
    const listaEventos = document.getElementById('event-list');
    const noEventos = document.getElementById('no-events');

    const eventosHoy = eventos.filter(evento => evento.fecha === hoy);

    if (eventosHoy.length > 0) {
        eventosHoy.forEach(evento => {
            const li = document.createElement('li');
            li.textContent = evento.nombre;
            listaEventos.appendChild(li);
        });
    } else {
        noEventos.classList.remove('hidden');
    }
</script>
    <!-- Cargar Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>