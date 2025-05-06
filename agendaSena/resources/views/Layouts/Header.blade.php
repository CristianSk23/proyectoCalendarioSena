<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;700&family=Calibri&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <title>Agenda CDTI-SENA</title>

</head>

<body>
<nav class="navbar navbar-expand-lg" style="background-color: #4caf50;">
    <div class="container-fluid">
        <div>
            <img src="{{ asset('images/inicio/logo.png') }}" alt="Logo" class="img-fluid" style="width: 50px; height: 50px;">
        </div>
        <div class="ms-2">
            <a href="{{ route('calendario.index') }}" class="nav-link text-white">
                <h1 class="h4">AgenSena</h1>
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="{{ route('evento.reportes.index') }}" class="nav-link text-white">Reportes</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('public.index') }}" class="nav-link text-white">Inicio</a>
                </li>
            </ul>
            <div class="d-flex align-items-center">
                <div class="position-relative">
                    <a id="icono-notificacion">
                        <i id="icono-campana" class="bx bxs-bell" style="color: #ffffff;"></i>
                        <i id="icono-notificacion-activa" class="bx bxs-bell-ring" style="color: #ffffff; display: none;"></i>
                    </a>
                    <span id="cantidad-eventos" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
                </div>

                @auth
                <div class="dropdown ms-4">
                    <button class="btn dropdown-toggle text-dark border-0" id="menuConfiguracion" data-bs-toggle="dropdown" style="background-color: transparent; color: #fff;">
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
                @endauth

                @auth
                <form method="POST" action="{{ route('login.logout') }}" class="ms-3">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="bx bx-power-off" style="color: #ffffff;"></i> Cerrar sesión
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="btn btn-primary ms-3">
                    <i class="bx bx-log-in" style="color: #ffffff;"></i> Iniciar sesión
                </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

@yield('contentReportes')

<footer class="agensena-footer">
    <div class="agensena-footer-content">
        SENA | CENTRO DE DISEÑO TECNOLÓGICO INDUSTRIAL &copy; {{ date('Y') }}
    </div>
</footer>

<!-- Modal para seleccionar fondo -->
<div class="modal fade" id="modalFondos" tabindex="-1" aria-labelledby="modalFondosLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFondosLabel">Selecciona o sube una imagen de fondo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">

                <!-- Formulario para subir imagen -->
                <form action="{{ route('fondos.subir') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                    @csrf
                    <div class="input-group">
                        <input type="file" name="imagen" class="form-control" accept="image/*" required>
                        <button type="submit" class="btn btn-success">Subir imagen</button>
                    </div>
                </form>

                <!--  con este formulario seleccionamos el fondo -->
                <form action="{{ route('fondos.seleccionar') }}" method="POST">
                    @csrf
                    <div class="row">
                        @foreach (File::files(public_path('imgLogin')) as $file)
                            @php $nombre = basename($file); @endphp
                            <div class="col-md-3 mb-3 text-center">
                                <label class="imagen-checkbox" style="cursor: pointer; display: inline-block;">
                                    <input type="checkbox" name="imagenes[]" value="{{ $nombre }}" class="d-none">
                                    <img src="{{ asset('imgLogin/' . $nombre) }}" class="img-fluid rounded shadow-sm">
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">Guardar fondo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.imagen-checkbox').forEach(label => {
            const checkbox = label.querySelector('input[type="checkbox"]');
            const img = label.querySelector('img');

            label.addEventListener('click', (e) => {
               
                if (e.target.tagName !== 'INPUT') {
                    e.preventDefault(); // vitamos que el label active el checkbox por defecto
                    checkbox.checked = !checkbox.checked;
                    label.classList.toggle('seleccionada', checkbox.checked);
                }
            });

            // Asegura que la clase 'seleccionada' se aplique al cargar si ya está marcado
            if (checkbox.checked) {
                label.classList.add('seleccionada');
            }
        });
    });
</script>


</body>
</html>
