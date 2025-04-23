@section('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda SENA</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <div class="bg-cover d-flex align-items-center justify-content-center min-vh-100">
        <div class="bg-white bg-opacity-90 p-5 rounded-4 shadow-lg" style="width: 100%; max-width: 600px;">
            <div class="text-center mb-4">
                <img src="{{ asset('images/inicio/logoverde.png') }}" alt="Logo SENA" class="mb-3" style="width: 80px;">
                <h1 class="display-6 fw-bold">AGENDA SENA</h1>
                <p class="fs-5 fw-semibold">Ingreso de Usuarios Registrados</p>
            </div>

            <form method="POST" action="{{ route('login.ingresar') }}">
                @csrf
                <div class="mb-4 input-group input-group-lg">
                    <span class="input-group-text"><i class='bx bx-id-card'></i></span>
                    <input type="number" class="form-control" name="par_identificacion"
                        placeholder="Número de Documento" required>
                </div>

                <div class="mb-4 input-group input-group-lg">
                    <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
                    <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                </div>

                <button type="submit" class="btn btn-success w-100 py-3 fs-5 fw-semibold">Ingresar</button>
            </form>
        </div>
    </div>

</body>

<script>
    const notyf = new Notyf({
        position: {
            x: 'center',
            y: 'top',
        },
    });


    @if(session('error'))
                notyf.error('{{ session('error') }}');
            @endif
</script>
{{-- @endsection --}}