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
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;700&family=Calibri&display=swap"
        rel="stylesheet">

</head>


<body>

    @include('Layouts.Header')
    <div class="flex flex-col h-screen">

        <!-- Header -->





        <div class="flex flex-1">




            <!-- Sidebar Izquierda -->
            @include ('partials.sidebarIzquierdo')

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
