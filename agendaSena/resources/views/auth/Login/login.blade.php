<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda SENA</title>

    <!-- Bootstrap, Boxicons y Notyf -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div id="fondo" class="bg-cover d-flex align-items-center justify-content-center min-vh-100">
        <div class="bg-glass p-5 rounded-4 shadow-lg w-100" style="max-width: 600px;">
            <div class="text-center mb-4">
                <img src="{{ asset('images/inicio/logoverde.png') }}" alt="Logo SENA" class="mb-3" style="width: 80px;">
                <h1 class="display-6 fw-bold">AGENDA SENA</h1>  
                <p class="text-success fs-5 fw-semibold">Utiliza tu cuenta de SetalPro.</p>
            </div>

            <form method="POST" action="{{ route('login.ingresar') }}">
                @csrf
                <div class="mb-4 input-group input-group-lg">
                    <span class="input-group-text"><i class='bx bx-id-card'></i></span>
                    <input type="number" class="form-control" name="par_identificacion" placeholder="Número de Documento" required>
                </div>

                <div class="mb-4 input-group input-group-lg">
                    <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
                    <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                </div>

                <button type="submit" class="btn btn-success w-100 py-3 fs-5 fw-semibold">Ingresar</button>
            </form>
        </div>
    </div>

    <!-- Mostrar errores con Notyf -->
    <div id="error-message" style="display: none;" data-error="{{ session('error') }}"></div>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
        const notyf = new Notyf({
            position: { x: 'center', y: 'top' }
        });

        const errorMessage = document.getElementById('error-message').getAttribute('data-error');
        if (errorMessage) {
            notyf.error(errorMessage);
        }
    </script>

    @php
        $imagenesSeleccionadas = [];
        if (Storage::disk('local')->exists('fondo_actual.txt')) {
            $contenido = Storage::disk('local')->get('fondo_actual.txt');
            $imagenesSeleccionadas = array_filter(array_map('trim', explode("\n", $contenido)));
            $imagenesSeleccionadas = array_map(fn($img) => asset("imgLogin/$img"), $imagenesSeleccionadas);
        }
    @endphp

    <script>
        const imagenes = {!! json_encode($imagenesSeleccionadas) !!};
        let index = 0;

        function cambiarImagenes() {
            if (imagenes.length === 0) return;
            const fondo = document.getElementById("fondo");
            fondo.style.backgroundImage = `url(${imagenes[index]})`;
            index = (index + 1) % imagenes.length;
        }

        setInterval(cambiarImagenes, 4000);
        cambiarImagenes();
    </script>
</body>
</html>




