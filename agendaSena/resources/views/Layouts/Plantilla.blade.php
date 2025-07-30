<!DOCTYPE html>
<html lang="es">

<head>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shepherd.js@11.1.1/dist/css/shepherd.css"/>
<script src="https://cdn.jsdelivr.net/npm/shepherd.js@11.1.1/dist/shepherd.min.js"></script>

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


   <!-- Cargar Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
    <!-- En tu layout/base -->
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shepherd.js/dist/css/shepherd.css"/>
   <script src="https://cdn.jsdelivr.net/npm/shepherd.js/dist/js/shepherd.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shepherd.js@11.1.1/dist/css/shepherd.css"/>
<script src="https://cdn.jsdelivr.net/npm/shepherd.js@11.1.1/dist/shepherd.min.js"></script>

   


@stack('scripts')
    <script>
    </script>

</html>