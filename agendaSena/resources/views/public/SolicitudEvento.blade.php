
@php
    $ocultarBanner = true;
@endphp

@php
    $ocultarEventDetails = true;
@endphp

@extends('layouts.public')

@section('content')

<!-- Bootstrap CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<!-- Titulo formulario -->

<!-- Titulo formulario -->
<h1 class="h2 mb-4" style="color: grey; text-shadow: -1px 0 green, 0 1px green, 1px 0 white, 0 -1px white;">
    Solicitar Evento </h1>






<!--Fin Modal  autenticar -->


<!-- FORMULARIO de Solicitar evento (oculto inicialmente) -->

<form action="{{ route('eventos.storeExterno') }}"
      method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow" id="formularioEvento">
    @csrf

        <div class="mb-3 position-relative" style="z-index: 9999;">
            <label for="par_nombre" class="form-label">Encargado del Evento:</label>
            <input type="text" id="par_nombre" class="form-control" placeholder="Buscar participante..." autocomplete="off"
                value="{{ isset($evento) ? $nombreParticipante : '' }}" required>
            <input type="hidden" name="par_identificacion" id="par_identificacion"
                value="{{ isset($evento) ? $evento['par_identificacion'] : '' }}">
            <ul id="resultados" class="list-group position-absolute w-100" style="max-height: 200px; overflow-y: auto;">
            </ul>
            <div class="invalid-feedback">Por favor selecciona un encargado</div>
        </div>


        <div class="mb-3 position-relative">
            <label for="pla_amb_nombre" class="form-label">Espacio del Evento:</label>
            <input type="text" id="pla_amb_nombre" class="form-control" placeholder="Buscar ambiente..." autocomplete="off"
                value="{{ isset($evento) ? $nombreAmbiente : '' }}">
            <input type="hidden" name="pla_amb_id" id="pla_amb_id"
                value="{{ isset($evento) ? $evento['pla_amb_id'] : '' }}">
            <ul id="resultadosAmbientes" class="list-group position-absolute w-100" style="z-index: 1000;"></ul>
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
            <select name="fic_numero" id="idFicha" class="form-select" required>
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
                <!-- <option value="1" {{isset($evento) && $evento->estadoEvento == 1 ? 'selected' : ''}}>Agendado</option> -->
                <option value="2" {{isset($evento) && $evento->estadoEvento == 2 ? 'selected' : ''}}>Separado</option>
                <!-- <option value="3" {{isset($evento) && $evento->estadoEvento == 3 ? 'selected' : ''}}>Completado</option> -->
            </select>
            <div class="invalid-feedback">El evento debe tener un estado.</div>
        </div>

        <button type="submit" class="btn btn-success" id="btnCrearEvento">
            {{ isset($evento) ? 'Actualizar Evento' : 'Solicitar Evento' }}
        </button>
    </form>


<!-- MENSAJE de éxito -->
<div id="successMessage" class="alert alert-success mt-3" style="display:none;">
    Evento creado exitosamente como pendiente.
</div>

@endsection

@push('scripts')
<script>

    

// envio de evento 
document.addEventListener('DOMContentLoaded', function () {
    const formulario = document.getElementById('formularioEvento');

    // Validación en tiempo real
    formulario.addEventListener('input', function (e) {
        const input = e.target;
        validadorInputs(input);
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

            validadorInputs(horaFin); // Vuelve a validar visualmente
        });
    });

    // Validación al enviar el formulario
    formulario.addEventListener('submit', function (e) {
        if (!formulario.checkValidity()) {
            e.preventDefault(); // 🚫 Detiene el envío si no es válido
            e.stopPropagation();

            // ✅ Mostrar todos los errores en los campos
            const inputs = formulario.querySelectorAll('input, select, textarea');
            inputs.forEach(input => validadorInputs(input));
        } else {
            // 🛠️ Opcional: Mostrar en consola los datos antes de enviar
            const formData = new FormData(formulario);
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }

            // El formulario se envia normalmente si todo está correcto
        }

        formulario.classList.add('was-validated');
    });
});

// Función para validar individualmente inputs
function validadorInputs(input) {
    if (input.checkValidity()) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
    } else {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
    }
}


document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('par_nombre');
    const inputHidden = document.getElementById('par_identificacion');
    const resultados = document.getElementById('resultados');

    input.addEventListener('input', () => {
        const termino = input.value.trim();

        if (termino.length < 2) {
            resultados.innerHTML = '';
            inputHidden.value = '';
            return;
        }

        
        const baseRuta = "{{ route('eventos.buscarParticipantes') }}";
        const ruta = `${baseRuta}?term=${encodeURIComponent(termino)}`;

        fetch(ruta)
            .then(res => res.json())
            .then(data => {
                resultados.innerHTML = '';
                data.forEach(p => {
                    const li = document.createElement('li');
                    li.classList.add('list-group-item', 'list-group-item-action');
                    li.textContent = `${p.nombre} ${p.apellido}`;
                    li.dataset.id = p.id;
                    li.dataset.nombre = `${p.nombre} ${p.apellido}`;
                    resultados.appendChild(li);
                });
            })
            .catch(() => {
                resultados.innerHTML = '';
            });
    });

    resultados.addEventListener('click', e => {
        if (e.target && e.target.matches('li')) {
            input.value = e.target.dataset.nombre;
            inputHidden.value = e.target.dataset.id;
            resultados.innerHTML = '';
        }
    });

    // Opcional: Si cambias manualmente el texto sin seleccionar un participante
    input.addEventListener('blur', () => {
        setTimeout(() => { resultados.innerHTML = ''; }, 100);
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const inputAmb = document.getElementById('pla_amb_nombre');
    const inputAmbId = document.getElementById('pla_amb_id');
    const resultadosAmb = document.getElementById('resultadosAmbientes');

    inputAmb.addEventListener('input', () => {
        const termino = inputAmb.value.trim();

        if (termino.length < 2) {
            resultadosAmb.innerHTML = '';
            inputAmbId.value = '';
            return;
        }

        const baseRutaAmb = "{{ route('eventos.buscarAmbientes') }}";
        const rutaAmb = `${baseRutaAmb}?term=${encodeURIComponent(termino)}`;

        fetch(rutaAmb)
            .then(res => res.json())
            .then(data => {
                resultadosAmb.innerHTML = '';
                data.forEach(a => {
                    const li = document.createElement('li');
                    li.classList.add('list-group-item', 'list-group-item-action');
                    li.textContent = a.nombre;
                    li.dataset.id = a.id;
                    li.dataset.nombre = a.nombre;
                    resultadosAmb.appendChild(li);
                });
            })
            .catch(() => {
                resultadosAmb.innerHTML = '';
            });
    });

    resultadosAmb.addEventListener('click', e => {
        if (e.target && e.target.matches('li')) {
            inputAmb.value = e.target.dataset.nombre;
            inputAmbId.value = e.target.dataset.id;
            resultadosAmb.innerHTML = '';
        }
    });

    inputAmb.addEventListener('blur', () => {
        setTimeout(() => { resultadosAmb.innerHTML = ''; }, 100);
    });
});






</script>
@endpush
                        