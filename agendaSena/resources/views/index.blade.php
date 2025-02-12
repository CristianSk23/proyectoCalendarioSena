@extends('Layouts.Plantilla')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/estilo.css') }}"> <!-- Incluir el CSS específico -->
@endsection

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4 text-center">Calendario de Eventos</h1>

    <!-- Navegación entre meses -->
    <div class="flex justify-between items-center mb-6">
        <a href="javascript:void(0);"
            class="bg-lime-700 text-white px-3 py-2 rounded hover:bg-lime-900 transition duration-200" id="prevMonth">
            <box-icon name='left-arrow' type='solid' flip='vertical'></box-icon>
        </a>

        <h2 id="mesAnio" class="text-xl font-semibold text-gray-700"></h2>

        <a href="javascript:void(0);"
            class="bg-lime-700 text-white px-3 py-2 rounded hover:bg-lime-900 transition duration-200" id="nextMonth">
            <box-icon type='solid' name='right-arrow'></box-icon>
        </a>
        <div class="absolute top-20 right-20 p-4 text-xl font-semibold text-gray-700">
            {{ $anio }}
        </div>

    </div>

    <table id="calendario" class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md"></table>

</div>

        

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarioTabla = document.getElementById('calendario');
        const mesAnioElemento = document.getElementById('mesAnio');
        const prevMonthButton = document.getElementById('prevMonth');
        const nextMonthButton = document.getElementById('nextMonth');

        const obtenerNombresMeses = (idioma = 'es-ES') => {
            const formatter = new Intl.DateTimeFormat(idioma, {
                month: 'long'
            });
            return Array.from({
                length: 12
            }, (_, i) =>
                formatter.format(new Date(2000, i, 1)).charAt(0).toUpperCase() +
                formatter.format(new Date(2000, i, 1)).slice(1)
            );
        };
        const meses = obtenerNombresMeses();

        let fechaActual = new Date();

        function generarCalendario(fecha) {
            const anio = fecha.getFullYear();
            const mes = fecha.getMonth();

            // Actualizar título
            mesAnioElemento.textContent = `${meses[mes]} ${anio}`;

            // Obtener información del mes
            const primerDia = new Date(anio, mes, 1);
            const ultimoDia = new Date(anio, mes + 1, 0);
            const diasEnMes = ultimoDia.getDate();
            const diaInicioSemana = primerDia.getDay();

            // Limpiar tabla
            calendarioTabla.innerHTML = `
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-4 text-center border border-gray-300">Dom</th>
                    <th class="py-3 px-4 text-center border border-gray-300">Lun</th>
                    <th class="py-3 px-4 text-center border border-gray-300">Mar</th>
                    <th class="py-3 px-4 text-center border border-gray-300">Mié</th>
                    <th class="py-3 px-4 text-center border border-gray-300">Jue</th>
                    <th class="py-3 px-4 text-center border border-gray-300">Vie</th>
                    <th class="py-3 px-4 text-center border border-gray-300">Sáb</th>
                </tr>
            </thead>
            <tbody></tbody>
        `;

            const tbody = calendarioTabla.querySelector('tbody');
            let fila = document.createElement('tr');

            // Agregar celdas vacías para los días antes del inicio del mes
            for (let i = 0; i < diaInicioSemana; i++) {
                const celda = document.createElement('td');
                celda.className = 'py-4 px-4 text-center border border-gray-300';
                fila.appendChild(celda);
            }

            // Agregar días del mes
            for (let dia = 1; dia <= diasEnMes; dia++) {
                if (fila.children.length === 7) {
                    tbody.appendChild(fila);
                    fila = document.createElement('tr');
                }

                const celda = document.createElement('td');
                celda.className =
                    'py-4 px-4 text-center border border-gray-300 hover:bg-lime-700 hover:text-white transition-colors duration-200';
                celda.textContent = dia;

                celda.addEventListener('click', function () {
                    agregarEvento(dia, mes + 1, anio);
                });
                fila.appendChild(celda);
            }

            // Agregar celdas vacías para completar la última fila
            while (fila.children.length < 7) {
                const celda = document.createElement('td');
                celda.className = 'py-4 px-4 text-center border border-gray-300';
                fila.appendChild(celda);
            }
            tbody.appendChild(fila);
        }
        //* Trabajando
        function agregarEvento(dia, mes, anio) {
            // Construir la URL para la consulta
            const baseRuta = "{{ route('eventos.buscar') }}"; // Genera la base de la ruta
            const ruta = `${baseRuta}?dia=${dia}&mes=${mes}&anio=${anio}`;

            // Obtener el contenedor del sidebar
            const sidebar = document.querySelector('aside');

            // Mostrar un indicador de carga
            sidebar.innerHTML = `<p class="text-gray-500">Cargando...</p>`;

            // Realizar la petición al servidor
            fetch(ruta)
                .then(response => response.json())
                .then(data => {


                        // Limpiar el contenido del sidebar
                        const formatoMes = new Intl.DateTimeFormat('es-ES', {
                            month: 'long'
                        }); // 'es-ES' para español
                        const nuevoMes = mes - 1;
                        let nombreMes = formatoMes.format(new Date(anio, nuevoMes, dia));
                        nombreMes = nombreMes.charAt(0).toUpperCase() + nombreMes.slice(1).toLowerCase();
                        sidebar.innerHTML = '';

                        if (data.eventos && data.eventos.length > 0) {
                            // Si hay eventos, mostrarlos en el sidebar
                            const eventosHTML = data.eventos.map(evento => `
                    <div class="p-4 border-solid border-black bg-white rounded-md">
                        <div class="bg-blue-600 rounded-md"> <h3 class="font-bold text-lg text-center text-white">${evento.nomEvento}</h3> </div>
                        <p class="text-sm text-gray-700">Descripción del evento:${evento.descripcion}</p>
                        <p class="text-sm text-gray-500">Encargado del evento: ${evento.nomSolicitante}</p>
                    </div>
                `).join('');
                        sidebar.innerHTML = `
                            <h1 class="text-3xl font-bold">Bienvenido a la Gestión de Eventos</h1>
                            <br>
                    <h2 class="font-bold text-xl mb-4">Eventos para ${dia}-<b>${nombreMes}</b>-${anio}</h2>
                    ${eventosHTML}
                `;
                    } else {
                        // Si no hay eventos, mostrar botones para agregar un evento
                        sidebar.innerHTML = `
                            <h1 class="text-3xl font-bold">Bienvenido a la Gestión de Eventos</h1>
                            <Br>
                    <h2 class="font-bold text-xl mb-4">Sin eventos para ${dia}-${nombreMes}-${anio}</h2>
                    <button id="agregarEvento" class="bg-blue-500 text-white px-4 py-2 rounded">Agregar Evento</button>
                `;
                            const baseRutaCrearEvento = "{{ route('eventos.crearEvento') }}";
                            // Agregar evento al botón
                            const botonAgregar = document.getElementById('agregarEvento');
                            botonAgregar.addEventListener('click', () => {
                                window.location.href =
                                    `${baseRutaCrearEvento}?dia=${dia}&mes=${mes}&anio=${anio}"`;
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar los eventos:', error);
                        sidebar.innerHTML =
                            `<p class="text-red-500">Error al cargar los eventos. Intenta nuevamente.</p>`;
                    });
            }

        // Generar calendario inicial
        generarCalendario(fechaActual);

        // Manejadores de eventos
        prevMonthButton.addEventListener('click', function () {
            fechaActual.setMonth(fechaActual.getMonth() - 1);
            generarCalendario(fechaActual);
        });

            nextMonthButton.addEventListener('click', function() {
                fechaActual.setMonth(fechaActual.getMonth() + 1);
                generarCalendario(fechaActual);
            });
        });
    </script>

    <!-- Botón para redirigir a index_reportes -->
    <div class="text-center mb-4">
            <a href="{{ route('evento.reportes.index') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-200">
                Ver Reportes
            </a>
        </div>
@endsection