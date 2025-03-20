<nav class="col-12 col-md-3 p-1 border-end bg-white shadow-lg">

    <!-- Contenedor para el listado de eventos -->
    <div class="mt-4 border rounded-lg p-4 bg-light">
        <h3 class="font-weight-bold">
            Eventos del {{ now()->locale('es')->day }} de {{ now()->locale('es')->monthName }}
        </h3>
        <div id="event-list-sideBar" class="row" style="max-height: 200px; overflow-y: auto; padding-right: 10px;">
            <!-- Aquí se insertarán las cards dinámicamente -->

        </div>
        <p id="no-events" class="d-none">No hay nada agendado.</p>
    </div>

    <div class=" d-flex flex-column justify-content-end mt-6">
        <div class="card">
            <div class="card-body">
                <div class="bg-success text-white p-2 rounded w-75 mx-auto">
                    <h5 class="text-center">Buscar eventos por nombre.</h5>
                </div>
                <br>
                <form class="form-control-sm">
                    <div class="d-flex align-items-center ">
                        <div class="flex-grow-1">
                            <label for="eventName" class="form-label">Nombre del evento</label>
                            <input type="text" class="form-control form-control-sm " id="nombreEvento"
                                placeholder="Buscar Evento">
                        </div>
                        <button type="submit" class="btn btn-success ms-2 mt-4 btn-sm">
                            <box-icon name='search-alt-2' color='#ffffff'></box-icon>
                        </button>
                </form>
            </div>
            <br>

            <div class="card-body">
                <div class="bg-success text-white p-2 rounded w-75 mx-auto">
                    <h5 class="text-center">Buscar eventos por Fecha.</h5>
                </div>
                <br>
                <form class="form-control-sm">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <label for="eventName" class="form-label">Fecha del evento</label>
                            <input type="date" class="form-control" id="fechaEvento" placeholder="Buscar Evento">
                        </div>
                        <button type="submit" class="btn btn-success ms-2 mt-4 btn-sm">
                            <box-icon name='search-alt-2' color='#ffffff'></box-icon>
                        </button>
                </form>
            </div>
        </div>
    </div>

</nav>


<script>
    let fechaActual = new Date();


    function buscarEventoDia(fecha) {
        const anio = fecha.getFullYear();
        const mes = fecha.getMonth();
        const dia = fecha.getDate();

        const baseRuta = "{{ route('eventos.buscar') }}";
        fetch(`${baseRuta}?dia=${dia}&mes=${mes + 1}&anio=${anio}`)
            .then(response => response.json())
            .then(data => {
                const eventosBD = data.data;
                const eventList = document.getElementById('event-list-sideBar');
                const noEvents = document.getElementById('no-events');
                eventList.innerHTML = ''; // Limpiar el contenedor antes de agregar nuevas cards

                if (eventosBD.length > 0) {
                    eventosBD.forEach(evento => {

                        console.log(evento.ambiente.pla_amb_descripcion);

                        const col = document.createElement('div');
                        col.className = 'col-12 mb-3'; // Ajusta el tamaño de la columna según tus necesidades

                        const card = document.createElement('div');
                        card.className = 'card';

                        // Cuerpo de la tarjeta
                        const cardBody = document.createElement('div');
                        cardBody.className = 'card-body';

                        // Título de la tarjeta
                        const cardTitle = document.createElement('h5');
                        cardTitle.className = 'card-title';
                        cardTitle.textContent = evento.evento.nomEvento; // Nombre del evento

                        // Descripción del evento
                        const cardText = document.createElement('p');
                        cardText.className = 'card-text';
                        cardText.textContent = "Descripción: " + evento.evento.descripcion; // Descripción del evento

                        // Horario del evento
                        const cardHorario = document.createElement('p');
                        cardHorario.className = 'card-text';
                        cardHorario.textContent = "Horario: Inicio " + evento.horario.inicio + " - Fin: " + evento.horario.fin; // Horario del evento

                        const cardAmbiente = document.createElement('p');
                        cardAmbiente.className = 'card-text';
                        cardAmbiente.textContent = "Ambiente: " + evento.ambiente.pla_amb_descripcion;

                        const btnDetalle = document.createElement('button');
                        btnDetalle.className = 'btn btn-success';
                        btnDetalle.textContent = 'Ver Detalles';
                        // Agregar elementos al cuerpo de la tarjeta
                        cardBody.appendChild(cardTitle);
                        cardBody.appendChild(cardText);
                        cardBody.appendChild(cardHorario);
                        cardBody.appendChild(cardAmbiente);
                        cardBody.appendChild(btnDetalle);
                        // Agregar el cuerpo de la tarjeta a la tarjeta
                        card.appendChild(cardBody);

                        // Agregar la tarjeta a la columna
                        col.appendChild(card);

                        // Agregar la columna a la lista de eventos
                        eventList.appendChild(col);
                    });
                } else {
                    noEvents.classList.remove('d-none'); // Mostrar el mensaje si no hay eventos
                }
            });

    }



    const hoy = new Date()

    const listaEventos = document.getElementById('event-list-sideBar');
    const noEventos = document.getElementById('no-events');


    buscarEventoDia(hoy);
    /*  if (eventosHoy.length > 0) {
         eventosHoy.forEach(evento => {
             const li = document.createElement('li');
             li.textContent = evento.nombre;
             listaEventos.appendChild(li);
         });
     } else {
         noEventos.classList.remove('d-none');
     } */


</script>
</nav>