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

        <!-- Modal de Confirmación -->
        <div id="confirmModal" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                                    <svg class="size-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" aria-hidden="true" data-slot="icon">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-base font-semibold text-gray-900" id="modal-title">Eliminar Evento</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500" id="modalMessage">¿Está seguro que desea eliminar
                                            este evento?</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button id="confirmDelete" type="button"
                                class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto">Eliminar</button>
                            <button id="cancelDelete" type="button"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>






    <script>
        document.addEventListener('DOMContentLoaded', function () {


            const calendarioTabla = document.getElementById('calendario');
            const mesAnioElemento = document.getElementById('mesAnio');
            const anteriorMesBtn = document.getElementById('prevMonth');
            const siguienteMesBtn = document.getElementById('nextMonth');

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
                                //* Si hay un evento, resaltar el día
                                console.log("Dia con evento " + eventoEnEsteDia);
                                
                                celda.classList.add('bg-lime-900', 'text-white'); 
                                let icon = document.createElement('box-icon');
                                icon.setAttribute('name', 'calendar-check');
                                icon.setAttribute('type', 'solid');
                                icon.setAttribute('color', '#ffffff');
                                celda.classList.add('celda-con-icono');
                                icon.classList.add('icono-ajustado');
                                celda.appendChild(icon);
                            } else {
                                
                                celda.classList.remove('bg-lime-900', 'text-white', 'celda-con-icono'); 
                                celda.classList.add('bg-white', 'text-black'); 

                             
                                const iconoExistente = celda.querySelector('box-icon');
                                if (iconoExistente) {
                                    celda.removeChild(iconoExistente); // Eliminar el icono si existe
                                }
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
       
            function agregarEvento(dia, mes, anio) {
              
                const baseRuta = "{{ route('eventos.buscar') }}"; // Genero la base de la ruta
                const ruta = `${baseRuta}?dia=${dia}&mes=${mes}&anio=${anio}`;

                // Obtener el contenedor del sidebar
                const sidebar = document.querySelector('aside');

             
                sidebar.innerHTML = `<p class="text-gray-500">Cargando...</p>`;

                // Realizo la petición al servidor
                fetch(ruta)
                    .then(response => response.json())
                    .then(data => {


                        // Limpio el contenido del sidebar
                        const formatoMes = new Intl.DateTimeFormat('es-ES', {
                            month: 'long'
                        }); 
                        const nuevoMes = mes - 1;
                        let nombreMes = formatoMes.format(new Date(anio, nuevoMes, dia));
                        nombreMes = nombreMes.charAt(0).toUpperCase() + nombreMes.slice(1).toUpperCase();
                        sidebar.innerHTML = '';

                        const contenedorEventos = `
                                                                                                                                                                                    <div class="container bg-lime-700 mx-auto mt-10 h-[70vh] rounded-lg px-6 py-4">
                                                                                                                                                                                        <h1 class="text-3xl font-bold  text-white text-center">Bienvenido a la Gestión de Eventos</h1>
                                                                                                                                                                                        <br>
                                                                                                                                                                                        <h2 class="font-bold text-xl mb-4" id="tituloEventos"></h2>
                                                                                                                                                                                        <div id="eventosList"></div>
                                                                                                                                                                                        <button id="agregarEvento" class="bg-lime-500 text-white px-4 py-2 rounded mt-4 ">Agregar Evento</button>
                                                                                                                                                                                    </div>
                                                                                                                                                                                `;

                        sidebar.innerHTML = contenedorEventos;

                        // Obtengo referenci de los elementos
                        const tituloEventos = document.getElementById('tituloEventos');
                        const eventosList = document.getElementById('eventosList');
                        const botonAgregar = document.getElementById('agregarEvento');

                        if (data.data.length > 0) {
                            const eventosHTML = data.data.map(item => {
                                const evento = item.evento;
                                const categoria = item.categoria;
                                const horario = item.horario;
                                const ambiente = item.ambiente;
                                const encargado = item.encargado;
                                const imagenPublicidad = evento.publicidad;
                                const imagenURL = `/storage/${imagenPublicidad}`;

                                return `
                                                                                                                                                                                    <div class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-sm md:flex-row md:max-w-xl hover:bg-white mb-4">
                                                                                                                                                                                        <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg" src="${imagenURL}" alt="Publicidad del evento">
                                                                                                                                                                                        <div class="flex flex-col justify-between p-4 leading-normal">
                                                                                                                                                                                            <div class="bg-lime-500 rounded-lg p-3 mb-4 -ml-4">
                                                                                                                                                                                                <h3 class="font-bold text-lg text-center text-white">${evento.nomEvento}</h3>
                                                                                                                                                                                            </div>
                                                                                                                                                                                            <p class="mb-3 font-calibri text-gray-700 dark:text-black"><b>Descripción del evento:</b><br>${evento.descripcion}</p>
                                                                                                                                                                                            <p class="text-sm font-calibri text-gray-600"><b>Ambiente:</b><br>${ambiente.pla_amb_descripcion}</p>
                                                                                                                                                                                            <p class="text-sm font-calibri text-gray-600"><b>Categoría:</b><br>${categoria.nomCategoria}</p>
                                                                                                                                                                                            <p class="text-sm font-calibri text-gray-600"><b>Horario:</b><br>${horario.inicio} - ${horario.fin}</p>
                                                                                                                                                                                            <p class="text-sm font-calibri text-gray-600"><b>Encargado:</b><br> ${encargado.par_nombres}</p>
                                                                                                                                                                                            <div class="flex items-stretch -ml-4">
                                                                                                                                                                                               <button id="actualizarEvento" class="bg-lime-500 text-white text-sm px-2 py-1 rounded mt-2 flex items-center">
                                                                                                                                                                                                    <box-icon name='calendar-plus' type='solid' color='#ffffff'></box-icon>
                                                                                                                                                                                                    <a href="{{ route('eventos.editarEvento', '') }}/${evento.idEvento}"class="ml-1">Actualizar</a>
                                                                                                                                                                                                </button>
                                                                                                                                                                                                <button id="eliminarEvento" class="bg-lime-500 text-white text-sm px-2 py-1 rounded mt-2 flex items-center" data-nombre-evento="${evento.nomEvento}" data-id-evento="${evento.idEvento}">
                                                                                                                                                                                                    <box-icon name='calendar-x' type='solid' color='#ffffff'></box-icon>
                                                                                                                                                                                                    Eliminar
                                                                                                                                                                                                </button>
                                                                                                                                                                                            </div>
                                                                                                                                                                                        </div>

                                                                                                                                                                                    </div>
                                                                                                                                                                                `;
                            }).join('');

                            tituloEventos.className = "text-white px-4 text-center";
                            tituloEventos.innerHTML = `Eventos para: <b>${dia}-${nombreMes}-${anio}</b>`;
                            eventosList.innerHTML = eventosHTML;

                            const eliminarEventoBtn = document.getElementById('eliminarEvento');
                            const nombreEvento = eliminarEventoBtn.getAttribute('data-nombre-evento');
                            const idEvento = eliminarEventoBtn.getAttribute('data-id-evento');

                            const confirmModal = document.getElementById('confirmModal');
                            const modalMessage = document.getElementById('modalMessage');
                            const confirmDelete = document.getElementById('confirmDelete');
                            const cancelDelete = document.getElementById('cancelDelete');

                            eliminarEventoBtn.addEventListener('click', function () {
                              
                                modalMessage.innerHTML = 'Está seguro que desea eliminar el evento de: <strong>' + "<br>" + nombreEvento + '</strong>?';
                                confirmModal.classList.remove('hidden'); 
                            });

                         
                            confirmDelete.addEventListener('click', function () {
                                eliminarEvento(idEvento);
                                confirmModal.classList.add('hidden');
                            });

                           
                            cancelDelete.addEventListener('click', function () {
                                confirmModal.classList.add('hidden'); 
                                notyf.info('Eliminación cancelada.'); // Notificación de cancelación
                            });


                        } else {
                            tituloEventos.className = "text-white px-4 text-center";
                            tituloEventos.innerHTML = `Sin eventos para ${dia}-${nombreMes}-${anio}`;
                        }


                        const baseRutaCrearEvento = "{{ route('eventos.crearEvento') }}";
                        botonAgregar.addEventListener('click', () => {
                            window.location.href = `${baseRutaCrearEvento}?dia=${dia}&mes=${mes}&anio=${anio}`;
                        });



                    })
                    .catch(error => {
                        console.error('Error al cargar los eventos:', error);
                        sidebar.innerHTML =
                            `<p class="text-red-500">Error al cargar los eventos. Intenta nuevamente.</p>`;
                    });


            }

            const notyf = new Notyf({
                position: {
                    x: 'center',
                    y: 'top',
                },
            });
            // Generar calendario inicial
            generarCalendario(fechaActual);

            anteriorMesBtn.addEventListener('click', function () {
                fechaActual.setMonth(fechaActual.getMonth() - 1);
                generarCalendario(fechaActual);
            });

            siguienteMesBtn.addEventListener('click', function () {
                fechaActual.setMonth(fechaActual.getMonth() + 1);
                generarCalendario(fechaActual);
            });

            function eliminarEvento(idEvento) {
                console.log("Tendría que eliminar el evento");
                const baseRutaEliminarEvento = "{{ route('eventos.eliminarEvento', '') }}"; // Ruta base
                const urlEliminar = `${baseRutaEliminarEvento}/${idEvento}`;

               
                window.location.href = urlEliminar; 
                generarCalendario(fechaActual);
            }

            // Verificar si hay un mensaje de éxito en la sesión
            @if(session('success'))
                notyf.success('{{ session('success') }}');
            @endif
        });
    </script>

    {{-- <!-- Botón para redirigir a index_reportes -->
    <div class="text-center mb-4">
        <a href="{{ route('evento.reportes.index') }}"
            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-200">
            Ver Reportes
        </a>
    </div> --}}
@endsection