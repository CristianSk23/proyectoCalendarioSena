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

    <script>
        
    </script>

<!-- Bootstrap -->
<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body> -->

</html>