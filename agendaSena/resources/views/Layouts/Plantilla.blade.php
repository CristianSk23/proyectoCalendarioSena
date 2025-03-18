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
            @include('partials.sidebarIzquierdo')

            <!-- Contenido Principal -->
            <main class="flex-fill p-4">
                @yield('content')
            </main>

            <!-- Aside Derecho -->
            @include('partials.sidebarDerecho')

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
            header.classList.add('d-flex', 'justify-content-between', 'align-items-center', 'mb-4');
            header.innerHTML = `
            <button id="prev" class="btn btn-primary">Prev</button>
            <h2 class="h5 font-weight-bold">${currentDate.toLocaleDateString()}</h2>
            <button id="next" class="btn btn-primary">Next</button>
        `;
            calendarEl.appendChild(header);

            // Mostrar la fecha actual
            const dateDisplay = document.createElement('div');
            dateDisplay.classList.add('h5', 'font-weight-bold', 'my-4');
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

<!-- Bootstrap -->
<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body> -->

</html>