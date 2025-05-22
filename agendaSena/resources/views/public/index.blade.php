@extends('layouts.public')

@section('content')
    <div class="container" id="future-events"></div>
        
        

   
    <!-- Modal de Detalle de Evento -->
        <div class="modal fade" id="showPublicModal" tabindex="-1" aria-labelledby="publicModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="publicModalTitle" class="modal-title">Detalle del Evento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body" id="publicModalBody"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    <!-- FIN MODAL DETALLE EVENTO -->

   @endsection
    @push('scripts')
<script>
    const todosLosEventos = @json($eventos);

    function createEventCard(event) {
        const imagenURL = event.publicidad ? `/storage/${event.publicidad}` : 'https://via.placeholder.com/300x200';
        const fechaEvento = new Date(event.fechaEvento + 'T00:00:00').toLocaleDateString('es-ES');
        const horario = event.horario || {};
        const ambiente = event.ambiente || {};
        const categoria = event.categoria || {};
        const descripcionCorta = event.descripcion.length > 100
            ? event.descripcion.substring(0, 100) + "..."
            : event.descripcion;

        return `
            <div class="card h-100 shadow-sm">
                <img src="${imagenURL}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Imagen del evento">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">${event.nomEvento}</h5>
                    <p class="card-text">${descripcionCorta}</p>
                    <p><strong>Fecha:</strong> ${fechaEvento}</p>
                    ${horario.inicio && horario.fin ? `<p><strong>Hora:</strong> ${horario.inicio} - ${horario.fin}</p>` : ''}
                    ${ambiente.pla_amb_descripcion ? `<p><strong>Ambiente:</strong> ${ambiente.pla_amb_descripcion}</p>` : ''}
                    ${categoria.nomCategoria ? `<p><strong>Categoría:</strong> ${categoria.nomCategoria}</p>` : ''}
                    <button class="btn btn-primary mt-auto" onclick='openModal(${JSON.stringify(event)})'>Ver más</button>
                </div>
            </div>
        `;
    }

    function openModal(event) {
        const imagenURL = event.publicidad ? `/storage/${event.publicidad}` : 'https://via.placeholder.com/300x200';
        const fecha = new Date(event.fechaEvento).toLocaleDateString('es-ES');
        const horario = event.horario || {};
        const ambiente = event.ambiente || {};
        const categoria = event.categoria || {};
        const participante = event.participante || {};
        const ficha = event.ficha || {};

        const contenido = `
            <div class="row">
                <div class="col-md-5">
                    <img src="${imagenURL}" class="img-fluid rounded mb-3" alt="Imagen del evento">
                </div>
                <div class="col-md-7">
                    <h4>${event.nomEvento}</h4>
                    <p>${event.descripcion}</p>
                    <ul class="list-unstyled">
                        <li><strong>Fecha:</strong> ${fecha}</li>
                        ${horario.inicio && horario.fin ? `<li><strong>Hora:</strong> ${horario.inicio} - ${horario.fin}</li>` : ''}
                        ${ambiente.pla_amb_descripcion ? `<li><strong>Ambiente:</strong> ${ambiente.pla_amb_descripcion}</li>` : ''}
                        ${categoria.nomCategoria ? `<li><strong>Categoría:</strong> ${categoria.nomCategoria}</li>` : ''}
                        ${participante.par_nombres ? `<li><strong>Solicitante:</strong> ${participante.par_nombres} ${participante.par_apellidos}</li>` : ''}
                        ${ficha.fic_numero ? `<li><strong>Ficha:</strong> ${ficha.fic_numero}</li>` : ''}
                    </ul>
                </div>
            </div>
        `;

        document.getElementById('publicModalBody').innerHTML = contenido;
        document.getElementById('publicModalTitle').textContent = event.nomEvento;

        new bootstrap.Modal(document.getElementById('showPublicModal')).show();
    }

    document.addEventListener('DOMContentLoaded', mostrarTodosEventos);
</script>
@endpush



