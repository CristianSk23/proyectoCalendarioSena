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

                            <!-- Botón para abrir modal -->
                            <button class="btn btn-primary mt-auto" onclick='verEvento({{ json_encode($evento) }})'>
                                Ver más
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal para ver detalles -->
    <div class="modal fade" id="eventoModal" tabindex="-1" aria-labelledby="eventoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="eventoModalLabel" class="modal-title">Detalles del Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" id="modalBody">
                    <!-- Aquí se llenará con JS -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function verEvento(evento) {
        const imagen = evento.publicidad ? `/storage/${evento.publicidad}` : 'https://via.placeholder.com/300x200';

        let html = `
            <div class="row">
                <div class="col-md-5">
                    <img src="${imagen}" class="img-fluid rounded mb-3" alt="Imagen del evento">
                </div>
                <div class="col-md-7">
                    <h5>${evento.nomEvento}</h5>
                    <p>${evento.descripcion}</p>
                    <p><strong>Fecha:</strong> ${new Date(evento.fechaEvento).toLocaleDateString()}</p>
        `;

        if (evento.horario) {
            const inicio = new Date(evento.horario.inicio).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            const fin = new Date(evento.horario.fin).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            html += `<p><strong>Hora:</strong> ${inicio} - ${fin}</p>`;
        }

        if (evento.ambiente) {
            html += `<p><strong>Ambiente:</strong> ${evento.ambiente.nombre}</p>`;
        }

        if (evento.categoria) {
            html += `<p><strong>Categoría:</strong> ${evento.categoria.nombre}</p>`;
        }

        html += `</div></div>`;

        document.getElementById('modalBody').innerHTML = html;
        const modal = new bootstrap.Modal(document.getElementById('eventoModal'));
        modal.show();
    }
</script>
@endpush
