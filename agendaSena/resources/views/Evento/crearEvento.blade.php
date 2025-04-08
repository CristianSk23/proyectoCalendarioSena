@extends('Layouts.Plantilla')

@section('content')
    <h1 class="h2 font-weight-bold mb-4">Crear Evento</h1>

    <form action="{{ isset($evento) ? route('eventos.actualizarEvento', $evento->idEvento) : route('eventos.store') }}"
        method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow" id="forularioEvento">
        @csrf

        <div class="mb-3">
            <label for="par_identificacion" class="form-label">Encargado del Evento:</label>
            <select name="par_identificacion" id="par_identificacion" class="form-select" required>
                <option value="">Seleccionar Encargado</option>
                @foreach ($participantes as $participante)
                    <option value="{{ $participante->par_identificacion }}" {{ isset($evento) && $evento->par_identificacion == $participante->par_identificacion ? 'selected' : '' }}>
                        {{ $participante->par_nombres }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">Por favor selecciona un encargado</div>
            <button type="button" class="btn btn-success mt-2" id="cargarMas">Cargar más participantes</button>
        </div>

        <div class="mb-3">
            <label for="pla_amb_id" class="form-label">Espacio del Evento:</label>
            <select name="pla_amb_id" class="form-select" required>
                <option value="">Seleccionar Espacio</option>
                <option value="153" {{ isset($evento) && $evento->pla_amb_id == 153 ? 'selected' : '' }}>Biblioteca</option>
                <option value="180" {{ isset($evento) && $evento->pla_amb_id == 180 ? 'selected' : '' }}>Auditorio</option>
            </select>
            <div class="invalid-feedback">Por favor selecciona un espacio</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Horario del Evento:</label>
            <div class="row">
                <div class="col-md-6">
                    <label for="horarioEventoInicio" class="form-label">Inicio:</label>
                    <input type="time" name="horarioEventoInicio" required class="form-control"
                        value="{{ isset($evento) ? $inicioEvento : '' }}" min="07:00" max="20:00">
                    <div class="invalid-feedback">Hora inválida (7:00 AM - 8:00 PM)</div>
                </div>
                <div class="col-md-6">
                    <label for="horarioEventoFin" class="form-label">Fin:</label>
                    <input type="time" name="horarioEventoFin" required class="form-control"
                        value="{{ isset($evento) ? $finalEvento : '' }}" min="07:00" max="20:00">
                    <div class="invalid-feedback">Hora inválida (7:00 AM - 8:00 PM)</div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="nomEvento" class="form-label">Nombre del Evento:</label>
            <input type="text" name="nomEvento" required class="form-control" minlength="5" maxlength="100"
                value="{{ isset($evento) ? $evento->nomEvento : '' }}">
            <div class="invalid-feedback">El nombre debe tener entre 5 y 100 caracteres</div>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea name="descripcion" required class="form-control" minlength="5"
                maxlength="500">{{ isset($evento) ? $evento->descripcion : '' }}</textarea>
            <div class="invalid-feedback">La descripción debe tener entre 10 y 500 caracteres</div>
        </div>

        <div class="mb-3">
            <label for="fechaEvento" class="form-label">Fecha:</label>
            <input type="date" name="fechaEvento" required class="form-control"
                value="{{ isset($evento) ? $evento->fechaEvento : '' }}" min="{{ date('Y-m-d') }}" id="fechaEvento">
            <div class="invalid-feedback">La fecha no puede ser anterior a hoy</div>
        </div>

        <div class="mb-3">
            <label for="aforoEvento" class="form-label">Aforo del Evento:</label>
            <input type="number" name="aforoEvento" required class="form-control" min="1" max="500"
                value="{{ isset($evento) ? $evento->aforoEvento : '' }}">
            <div class="invalid-feedback">El aforo debe ser entre 1 y 500 personas</div>
        </div>

        <div class="mb-3">
            <label for="idFicha" class="form-label">Ficha:</label>
            <select name="idFicha" id="idFicha" class="form-select" required>
                <option value="">Seleccionar Ficha</option>
                @foreach ($fichas as $ficha)
                    < <option value="{{ $ficha->fic_numero }}" {{ isset($evento) && $evento->fic_numero == $ficha->fic_numero ? 'selected' : '' }}>
                        {{ $ficha->fic_numero }}
                        </option>
                @endforeach
            </select>
            <div class="invalid-feedback">Por favor selecciona una ficha válida</div>
        </div>

        <div class="mb-3">
            <label for="idCategoria" class="form-label">Categoría:</label>
            <select name="idCategoria" class="form-select" required>
                <option value="">Seleccionar Categoría</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->idCategoria }}" {{ isset($evento) && $evento->idCategoria == $categoria->idCategoria ? 'selected' : '' }}>
                        {{ $categoria->nomCategoria }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">El evento debe tener una Categoría</div>
        </div>

        <div class="mb-3">
            <label for="publicidad" class="form-label">Publicidad:</label>
            <input type="file" name="publicidad" accept="image/*" class="form-control">
        </div>

        <div class="mb-3">
            <label for="estadoEvento" class="form-label">Estado del Evento:</label>
            <select name="estadoEvento" required class="form-select">
                <option value="">Seleccionar estado para el Evento</option>
                <option value="1" {{isset($evento) && $evento->estadoEvento == 1 ? 'selected' : ''}}>Agendado</option>
                <option value="2" {{isset($evento) && $evento->estadoEvento == 2 ? 'selected' : ''}}>Separado</option>
                <option value="3" {{isset($evento) && $evento->estadoEvento == 3 ? 'selected' : ''}}>Completado</option>
            </select>
            <div class="invalid-feedback">El evento debe tener un estado.</div>
        </div>

        <button type="submit" class="btn btn-success">
            {{ isset($evento) ? 'Actualizar Evento' : 'Crear Evento' }}
        </button>
    </form>





    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const formulario = document.getElementById('forularioEvento');

            // Validación en tiempo real
            formulario.addEventListener('input', function (e) {
                const input = e.target;
                validadorInputs(input);
            });

            // Validación al enviar
            formulario.addEventListener('submit', function (e) {
                if (!formulario.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();

                    // Mostrar todos los errores
                    const inputs = formulario.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => validadorInputs(input));
                }

                formulario.classList.add('was-validated');
            });

            // Validación personalizada para horarios
            const horaInicio = formulario.querySelector('[name="horarioEventoInicio"]');
            const horaFin = formulario.querySelector('[name="horarioEventoFin"]');

            [horaInicio, horaFin].forEach(input => {
                input.addEventListener('change', function () {
                    if (horaInicio.value && horaFin.value && horaInicio.value >= horaFin.value) {
                        horaFin.setCustomValidity('La hora de fin debe ser posterior a la de inicio');
                        horaFin.classList.add('is-invalid');
                    } else {
                        horaFin.setCustomValidity('');
                        horaFin.classList.remove('is-invalid');
                    }
                });
            });
        });


        function validadorInputs(input) {
            if (input.checkValidity()) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            } else {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
            }
        }

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