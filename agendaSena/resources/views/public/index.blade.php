@extends('layouts.public')

@section('content')
    <div class="container">
        <h1 class="text-center my-4">Eventos Públicos</h1>

        <div class="row">
            @foreach($eventos as $evento)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($evento->publicidad)
                            <img src="{{ asset('storage/' . $evento->publicidad) }}" class="card-img-top" alt="Imagen del evento" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Sin imagen">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $evento->nomEvento }}</h5>
                            <p class="card-text">{{ Str::limit($evento->descripcion, 100) }}</p>
                            <p class="card-text"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($evento->fechaEvento)->format('d/m/Y') }}</p>

                            @if($evento->horario)
                                <p class="card-text">
                                    <strong>Hora:</strong>
                                    {{ \Carbon\Carbon::parse($evento->horario->inicio)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($evento->horario->fin)->format('H:i') }}
                                </p>
                            @endif

                            @if($evento->ambiente)
                                <p class="card-text"><strong>Ambiente:</strong> {{ $evento->ambiente->nombre }}</p>
                            @endif

                            @if($evento->categoria)
                                <p class="card-text"><strong>Categoría:</strong> {{ $evento->categoria->nombre }}</p>
                            @endif

                            <button class="btn btn-primary mt-auto" onclick='verEvento({{ json_encode($evento) }})'>
                                Ver más
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button class="btn btn-secondary mt-4" onclick="mostrarTodosEventos()">Mostrar Todos los Eventos</button>
    </div>


    <!-- Modal -->
<div class="modal fade" id="eventoModal" tabindex="-1" aria-labelledby="eventoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventoModalLabel">Detalles del Evento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="modalBody">
        <!-- Contenido se llena por JS -->
      </div>
    </div>
  </div>
</div>

    @push('scripts')
    <script>
        // Suponiendo que tienes una lista de eventos
        let todosLosEventos = [
            // Aquí puedes agregar los eventos que deseas mostrar
            // Ejemplo: { id: 1, nombre: "Evento 1", ... }
        ];

        function mostrarTodosEventos() {
            // Lógica para mostrar todos los eventos
            console.log(todosLosEventos); // Asegúrate de que esta variable esté definida
            // Aquí puedes agregar el código para mostrar los eventos en la interfaz
        }

        function verEvento(evento) {
    const imagen = evento.publicidad ? `/storage/${evento.publicidad}` : 'https://via.placeholder.com/300x200';
    const fecha = new Date(evento.fechaEvento + 'T00:00:00').toLocaleDateString();

    let html = `
        <div class="row">
            <div class="col-md-5">
                <img src="${imagen}" class="img-fluid rounded mb-3" alt="Imagen del evento">
            </div>
            <div class="col-md-7">
                <h4>${evento.nomEvento}</h4>
                <p class="text-muted">${evento.descripcion}</p>
                <ul class="list-unstyled">
                    <li><strong>Fecha:</strong> ${fecha}</li>
    `;

    if (evento.horario) {
        const inicio = new Date(evento.horario.inicio).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const fin = new Date(evento.horario.fin).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        html += `<li><strong>Hora:</strong> ${inicio} - ${fin}</li>`;
    }

    if (evento.ambiente?.nombre) {
        html += `<li><strong>Ambiente:</strong> ${evento.ambiente.nombre}</li>`;
    }

    if (evento.categoria?.nombre) {
        html += `<li><strong>Categoría:</strong> ${evento.categoria.nombre}</li>`;
    }

    if (evento.participante) {
        html += `<li><strong>Solicitante:</strong> ${evento.participante.par_nombres ?? ''} ${evento.participante.par_apellidos ?? ''}</li>`;
    }

    if (evento.ficha?.fic_numero) {
        html += `<li><strong>Ficha:</strong> ${evento.ficha.fic_numero}</li>`;
    }

    html += `</ul></div></div>`;

    document.getElementById('modalBody').innerHTML = html;
    const modal = new bootstrap.Modal(document.getElementById('eventoModal'));
    modal.show();
}
       </script>
       @endpush







   @endsection