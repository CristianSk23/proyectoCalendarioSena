<!DOCTYPE html>
<html lang="es">

<head>

    <!-- Bootstrap -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->

</head>


<body>

    @include('Layouts.Header')
    <div class="d-flex flex-column vh-100 bg-textureFondo">

        <!-- Header -->

        <div class="d-flex flex-fill">

            <!-- Sidebar Izquierda -->
            @include('partials.sideBarIzquierdo')

            <!-- Contenido Principal -->
            <main class="flex-fill p-4">
                @yield('content')
            </main>

            <!-- Aside Derecho -->
            @include('partials.modalEventos')

        </div>
    </div>

    @include ('Evento/GuiaEventos')
     <!-- Boton de ayuda GUIA  -->
    <button id="toggleAyudaBtn2" class="btn btn-primary position-fixed bottom-0 end-0 translate-middle-y me-3 mb-3 z-3 rounded-circle shadow" style="width: 60px; height: 60px;">
    <i class="bi bi-question-lg fs-3"></i>
    </button>

    

    
</body> 

@stack('scripts')
<!-- Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
        

    <script>
    </script>

</html>