<!DOCTYPE html>
<html lang="es">

<head>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <title>Agenda CDTI-SENA</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>


<header class="bg-lime-500 text-white p-4">
    <h1 class="text-2xl font-bold">Agenda SENA CDTI</h1>
    <form method="POST" action="{{ route('login.logout') }}">
        @csrf
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
            Cerrar Sesión
        </button>
    </form>
</header>

    @yield('contentReportes')

</html>
