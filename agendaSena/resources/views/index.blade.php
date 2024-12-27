@extends('Layouts.Plantilla')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}"> <!-- Incluir el CSS específico -->
@endsection

@section('content')
    <!-- <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold">Bienvenido a la Gestión de Eventos</h1>
        <p class="mt-4">Selecciona una opción para continuar:</p>

        <div class="mt-6">
            <a href="{{ route('eventos.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded mr-4">Ver Eventos</a>
            <a href="{{ route('horarios.index') }}" class="bg-green-500 text-white px-4 py-2 rounded">Ver Horarios</a>
        </div>
    </div> -->



    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Calendario de Eventos</h1>

        <div id="calendar" class="border rounded-lg p-4">
            <!-- Encabezado del calendario -->
            <div class="flex justify-between items-center mb-4">
                <button id="prev" class="bg-blue-500 text-white px-2 py-1 rounded">Prev</button>
                <h2 id="monthYear" class="text-lg font-bold"></h2>
                <button id="next" class="bg-blue-500 text-white px-2 py-1 rounded">Next</button>
            </div>

            <!-- Tabla del calendario -->
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Dom</th>
                        <th class="py-3 px-6 text-left">Lun</th>
                        <th class="py-3 px-6 text-left">Mar</th>
                        <th class="py-3 px-6 text-left">Mié</th>
                        <th class="py-3 px-6 text-left">Jue</th>
                        <th class="py-3 px-6 text-left">Vie</th>
                        <th class="py-3 px-6 text-left">Sáb</th>
                    </tr>
                </thead>
                <tbody id="calendarBody" class="text-gray-600 text-sm font-light">
                    <!-- Las celdas del calendario se generarán aquí -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        let currentDate = new Date();

        function renderCalendar() {
            const monthYear = document.getElementById('monthYear');
            const calendarBody = document.getElementById('calendarBody');

            // Limpiar el contenido anterior
            calendarBody.innerHTML = '';

            // Establecer el mes y el año en el encabezado
            monthYear.innerText = currentDate.toLocaleString('default', { month: 'long', year: 'numeric' });

            // Obtener el primer día del mes y el número de días en el mes
            const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
            const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
            const totalDays = lastDay.getDate();
            const startDay = firstDay.getDay();

            // Crear las filas del calendario
            let row = document.createElement('tr');

            // Agregar celdas vacías para los días antes del primer día del mes
            for (let i = 0; i < startDay; i++) {
                const cell = document.createElement('td');
                cell.innerHTML = '';
                row.appendChild(cell);
            }

            // Agregar los días del mes
            for (let day = 1; day <= totalDays; day++) {
                const cell = document.createElement('td');
                cell.innerHTML = day;
                row.appendChild(cell);

                // Si es sábado, agregar la fila al cuerpo del calendario
                if ((day + startDay) % 7 === 0) {
                    calendarBody.appendChild(row);
                    row = document.createElement('tr');
                }
            }

            // Agregar la última fila si hay días restantes
            if (row.children.length > 0) {
                calendarBody.appendChild(row);
            }
        }

        document.getElementById('prev').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        document.getElementById('next').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });

        // Renderizar el calendario al cargar
        renderCalendar();
    </script>
@endsection