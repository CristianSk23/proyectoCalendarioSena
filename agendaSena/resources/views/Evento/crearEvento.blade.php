@extends('Layouts.Plantilla')

@section('content')
    <h1 class="h2 font-weight-bold mb-4">Crear Evento</h1>

    <form action="{{ isset($evento) ? route('eventos.actualizarEvento', $evento->idEvento) : route('eventos.store') }}"
        method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow">
        @csrf

        <div class="mb-3">
            <label for="par_identificacion" class="form-label">Encargado del Evento:</label>
            <select name="par_identificacion" id="par_identificacion" class="form-select">
                <option value="">Seleccionar Encargado</option>
                @foreach ($participantes as $participante)
                    <option value="{{ $participante->par_identificacion }}" {{ isset($evento) && $evento->par_identificacion == $participante->par_identificacion ? 'selected' : '' }}>
                        {{ $participante->par_nombres }}
                    </option>
                @endforeach
            </select>
            <button type="button" class="btn btn-success mt-2" id="cargarMas">Cargar más participantes</button>
        </div>

        <div class="mb-3">
            <label for="pla_amb_id" class="form-label">Espacio del Evento:</label>
            <select name="pla_amb_id" class="form-select">
                <option value="">Seleccionar Espacio</option>
                <option value="153" {{ isset($evento) && $evento->pla_amb_id == 153 ? 'selected' : '' }}>Biblioteca</option>
                <option value="180" {{ isset($evento) && $evento->pla_amb_id == 180 ? 'selected' : '' }}>Auditorio</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="horarioEvento" class="form-label">Horario del Evento:</label>
            <label for="horarioEventoInicio" class="form-label">Inicio del Evento:</label>
            <input type="time" name="horarioEventoInicio" required class="form-control"
                value="{{ isset($evento) ? $inicioEvento : '' }}">
            <label for="horarioEventoFin" class="form-label">Fin del Evento:</label>
            <input type="time" name="horarioEventoFin" required class="form-control"
                value="{{ isset($evento) ? $finalEvento : '' }}">
        </div>

        <div class="mb-3">
            <label for="nomEvento" class="form-label">Nombre del Evento:</label>
            <input type="text" name="nomEvento" required class="form-control"
                value="{{ isset($evento) ? $evento->nomEvento : '' }}">
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea name="descripcion" required
                class="form-control">{{ isset($evento) ? $evento->descripcion : '' }}</textarea>
        </div>

        <div class="mb-3">
            <label for="fechaEvento" class="form-label">Fecha:</label>
            <input type="date" name="fechaEvento" required class="form-control"
                value="{{ isset($evento) ? $evento->fechaEvento : '' }}">
        </div>

        <div class="mb-3">
            <label for="aforoEvento" class="form-label">Aforo del Evento:</label>
            <input type="number" name="aforoEvento" required class="form-control"
                value="{{ isset($evento) ? $evento->aforoEvento : '' }}">
        </div>

        <div class="mb-3">
            <label for="idFicha" class="form-label">Ficha:</label>
            <select name="fic_numero" class="form-select">
                <option value="">Seleccionar Ficha</option>
                @foreach ($fichas as $ficha)
                    <option value="{{ $ficha->fic_numero }}" {{ isset($evento) && $evento->fic_numero == $ficha->fic_numero ? 'selected' : '' }}>
                        {{ $ficha->fic_numero }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="idCategoria" class="form-label">Categoría:</label>
            <select name="idCategoria" class="form-select">
                <option value="">Seleccionar Categoría</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->idCategoria }}" {{ isset($evento) && $evento->idCategoria == $categoria->idCategoria ? 'selected' : '' }}>
                        {{ $categoria->nomCategoria }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="publicidad" class="form-label">Publicidad:</label>
            <input type="file" name="publicidad" accept="image/*" class="form-control">
        </div>

        <div class="mb-3">
            <label for="estadoEvento" class="form-label">Estado del Evento:</label>
            <select name="estadoEvento" required class="form-select">
                <option value="1">Agendado</option>
                <option value="2">Separado</option>
                <option value="3">Completado</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">
            {{ isset($evento) ? 'Actualizar Evento' : 'Crear Evento' }}
        </button>
    </form>

    <script>
        let page = 1;

        function cargarParticipantes() {
            fetch(`/cargarParticipantes?page=${page}`)
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('par_identificacion');
                    data.items.forEach(participante => {
                        const option = document.createElement('option');
                        option.value = participante.par_identificacion;
                        option.textContent = participante.par_nombres;
                        select.appendChild(option);
                    });
                    page++;
                });
        }

        document.getElementById('cargarMas').addEventListener('click', cargarParticipantes);

        // Cargar la primera página al inicio
        cargarParticipantes();
    </script>
@endsection