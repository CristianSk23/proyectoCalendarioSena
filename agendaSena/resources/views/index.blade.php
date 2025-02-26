@extends('Layouts.Plantilla')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
@endsection

@section('content')



    <div class="container mx-auto p-4 ">
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

                const baseRuta = "{{route('calendario.buscarEventos')}}";
                const ruta = `${baseRuta}?mes=${mes}&anio=${anio}`;

                fetch(ruta)
                    .then(response => response.json())
                    .then(data => {
                        for (let dia = 1; dia <= diasEnMes; dia++) {
                            if (fila.children.length === 7) {
                                tbody.appendChild(fila);
                                fila = document.createElement('tr');
                            }

                            const celda = document.createElement('td');
                            celda.className = 'py-4 px-4 text-center border border-gray-300 hover:bg-lime-700 hover:text-white transition-colors duration-200';
                            celda.textContent = dia;

                            // Verificar si hay eventos en este día
                            const eventoEnEsteDia = data.data.some(evento => {
                                const fechaEvento = new Date(evento.fecha);
                                const diaConv = fechaEvento.getDate() + 1;
                                // Comparar año, mes y día
                                return (
                                    fechaEvento.getFullYear() === anio &&
                                    fechaEvento.getMonth() === mes &&
                                    diaConv === dia
                                );
                            });

                            if (eventoEnEsteDia) {
                                celda.classList.add('bg-lime-900', 'text-white'); // Resaltar el día con evento
                                let icon = document.createElement('box-icon');
                                icon.setAttribute('name', 'calendar-check');
                                icon.setAttribute('type', 'solid');
                                icon.setAttribute('color', '#ffffff');
                                celda.classList.add('celda-con-icono');
                                icon.classList.add('icono-ajustado');
                                celda.appendChild(icon);
                            } else {
                                celda.classList.add('bg-white', 'text-black');
                            }

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
                    })
                    .catch(error => {
                        console.error("Error al obtener los eventos:", error);
                    });
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

                        if (data.data.length > 0) {
                            const eventosHTML = data.data.map(item => {
                                // Acceder a las propiedades anidadas
                                const evento = item.evento;
                                const categoria = item.categoria;
                                const horario = item.horario;
                                const ambiente = item.ambiente;
                                const encargado = item.encargado;
                                const imagenPublicidad = evento.publicidad;
                                const imagenURL = `/storage/${imagenPublicidad}`;


                                return `
                                                                                                                            <div class="container bg-lime-700 mx-auto mt-10 h-[70vh] rounded-lg px-6 py-4 ">
                                                                                                                                <div class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-sm md:flex-row md:max-w-xl hover:bg-white">
                                                                                                                                    <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg" src="${imagenURL}" alt="Publicidad del evento">
                                                                                                                                    <div class="flex flex-col justify-between p-4 leading-normal">
                                                                                                                                        <div class="bg-lime-500 rounded-lg p-3 mb-4">
                                                                                                                                            <h3 class="font-bold text-lg text-center text-white">${evento.nomEvento}</h3>
                                                                                                                                        </div>
                                                                                                                                         <p class="mb-3 font-calibri text-gray-700 dark:text-black"><b>Descripción del evento:</b><br>${evento.descripcion}</p>
                                                                                                                                         <p class="text-sm font-calibri text-gray-600"><b>Ambiente:</b><br>${ambiente.pla_amb_descripcion}</p>
                                                                                                                                         <p class="text-sm font-calibri text-gray-600"><b>Categoría:</b><br>${categoria.nomCategoria}</p>
                                                                                                                                         <p class="text-sm font-calibri text-gray-600"><b>Horario:</b><br>${horario.inicio} - ${horario.fin}</p>
                                                                                                                                         <p class="text-sm font-calibri text-gray-600"><b>Encargado:</b><br> ${encargado.par_nombres}</p>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                        `;
                            }).join('');
                            sidebar.innerHTML = `
                                                                                                                            <h1 class="text-3xl font-bold">Bienvenido a la Gestión de Eventos</h1>
                                                                                                                            <br>
                                                                                                                    <h2 class="font-bold text-xl mb-4">Eventos para ${dia}-<b>${nombreMes}</b>-${anio}</h2>
                                                                                                                    ${eventosHTML} `;
                        } else {
                            // Si no hay eventos, mostrar botones para agregar un evento
                            sidebar.innerHTML = `
                                                                                                                            <h1 class="text-3xl font-bold">Bienvenido a la Gestión de Eventos</h1>
                                                                                                                            <Br>
                                                                                                                    <h2 class="font-bold text-xl mb-4">Sin eventos para ${dia}-${nombreMes}-${anio}</h2>
                                                                                                                    <button id="agregarEvento" class="bg-lime-500 text-white px-4 py-2 rounded">Agregar Evento</button>
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

            nextMonthButton.addEventListener('click', function () {
                fechaActual.setMonth(fechaActual.getMonth() + 1);

                generarCalendario(fechaActual);
            });
        });
    </script>

    <!-- Botón para redirigir a index_reportes -->
    <div class="text-center mb-4">
        <a href="{{ route('evento.reportes.index') }}"
            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-200">
            Ver Reportes
        </a>
    </div>
@endsection