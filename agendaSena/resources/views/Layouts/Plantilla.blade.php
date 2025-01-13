<!DOCTYPE html>
<html lang="es">

<head>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <title>Agenda CDTI-SENA</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>
</head>

<body>

    <div class="flex flex-col h-screen">
        <!-- Header -->
        <header class="bg-gray-800 text-white p-4">
            <h1 class="text-2xl font-bold">Agenda SENA CDTI</h1>
            <form method="POST" action="{{ route('login.logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                    Cerrar Sesión
                </button>
            </form>
        </header>




        <div class="flex flex-1">




            <!-- Sidebar Izquierda -->
            @include ('partials.sidebarIzquierdo', ['calendario' => $calendario, 'anio'=>$anio])

            <!-- Contenido Principal -->
            <main class="flex-1 p-4">
                @yield('content')
            </main>



            <!-- Aside Derecho -->
         @include ('partials.sidebarDerecho')

        </div>
    </div>




    <script>
        const calendarEl = document.getElementById('calendar');
        let currentDate = new Date();

        function renderCalendar() {
            // Limpiar el contenido anterior
            calendarEl.innerHTML = '';

            // Crear el encabezado
            const header = document.createElement('div');
            header.classList.add('flex', 'justify-between', 'items-center', 'mb-4');
            header.innerHTML = `
            <button id="prev" class="bg-blue-500 text-white px-2 py-1 rounded">Prev</button>
            <h2 class="text-lg font-bold">${currentDate.toLocaleDateString()}</h2>
            <button id="next" class="bg-blue-500 text-white px-2 py-1 rounded">Next</button>
        `;
            calendarEl.appendChild(header);

            // Mostrar la fecha actual
            const dateDisplay = document.createElement('div');
            dateDisplay.classList.add('text-xl', 'font-bold', 'my-4');
            dateDisplay.innerText = currentDate.toLocaleDateString();
            calendarEl.appendChild(dateDisplay);
        }

        document.getElementById('calendar').addEventListener('click', (e) => {
            if (e.target.id === 'prev') {
                currentDate.setDate(currentDate.getDate() - 1);
                renderCalendar();
            } else if (e.target.id === 'next') {
                currentDate.setDate(currentDate.getDate() + 1);
                renderCalendar();
            }
        });

        renderCalendar(); // Renderizar el calendario al cargar
    </script>
</body>

</html>
