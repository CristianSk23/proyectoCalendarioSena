@php
    $ocultarBanner = true;
    $ocultarEventDetails = true;
     $ocultarPublicidad = true; 
@endphp

@extends('layouts.public')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>


<h1 class="h2 mb-4" style="color: grey; text-shadow: -1px 0 green, 0 1px green, 1px 0 white, 0 -1px white;">
    📝 Solicitar Evento
</h1>

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
               value="{{ isset($evento) ? $nombreAmbiente : '' }}" required>
        <input type="hidden" name="pla_amb_id" id="pla_amb_id"
               value="{{ isset($evento) ? $evento['pla_amb_id'] : '' }}">
        <ul id="resultadosAmbientes" class="list-group position-absolute w-100" style="z-index: 1000;"></ul>
        <div class="invalid-feedback">Por favor selecciona un espacio</div>
    </div>

    <div class="mb-3">
        <label for="fechaEvento" class="form-label">Fecha:</label>
        <input type="date" name="fechaEvento" required class="form-control"
               value="{{ isset($evento) ? $evento->fechaEvento : '' }}" min="{{ date('Y-m-d') }}" id="fechaEvento">
        <div class="invalid-feedback">La fecha no puede ser anterior a hoy</div>
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
                <div class="invalid-feedback">La hora de fin debe ser posterior a la de inicio.</div>
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
        <label for="aforoEvento" class="form-label">Aforo del Evento:</label>
        <input type="number" name="aforoEvento"  class="form-control" min="1" max="500"
               value="{{ isset($evento) ? $evento->aforoEvento : '' }}">
        <div class="invalid-feedback">El aforo debe ser entre 1 y 500 personas</div>
    </div>

        <!-- ficha -->
    <div class="mb-3 position-relative">
        <label for="fic_numero" class="form-label">Ficha:</label>
        <input type="text" id="fic_numero_input" class="form-control" placeholder="Buscar ficha..." autocomplete="off"
            value="{{ isset($evento) ? $evento->fic_numero : '' }}">
        <input type="hidden" name="fic_numero" id="fic_numero">
        <ul id="resultadosFichas" class="list-group position-absolute w-100" style="z-index: 1000;"></ul>
        <div class="invalid-feedback">Por favor selecciona una ficha válida</div>
    </div>

        <!-- fin ficha -->

    <div class="mb-3">
        <label for="idCategoria" class="form-label">Categoría:</label>
        <select name="idCategoria" class="form-select" >
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
            <option value="2" selected>Separado</option>
        </select>
        <div class="invalid-feedback">El evento debe tener un estado.</div>
    </div>

    <button type="submit" class="btn btn-success" id="btnCrearEvento" disabled>
        {{ isset($evento) ? 'Actualizar Evento' : 'Solicitar Evento' }}
    </button>
</form>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const formulario = document.getElementById('formularioEvento');
    const btnGuardar = document.getElementById('btnCrearEvento');
    const notyf = new Notyf({ duration: 5000, position: { x: 'right', y: 'top' } });

    let validando = false;
    let ambienteDisponible = false; // Inicia en false para forzar la validación

    // --- VALIDACIÓN GENERAL Y DE FORMULARIO ---

    // Función unificada para verificar si el botón de guardar debe estar activo
    function verificarFormulario() {
        const camposRequeridos = formulario.querySelectorAll('input[required], select[required], textarea[required]');
        let todosLlenos = true;
        camposRequeridos.forEach(campo => {
            if (!campo.value || campo.value.trim() === '') {
                todosLlenos = false;
            }
        });
        
        // El botón solo se habilita si todos los campos están llenos Y el ambiente está disponible
        btnGuardar.disabled = !(todosLlenos && ambienteDisponible && formulario.checkValidity());
    }

    // Función para mostrar feedback visual en los inputs
    function validadorInputs(input) {
        if (input.checkValidity()) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
        } else {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
        }
    }

    // Validación en tiempo real de cada campo
    formulario.addEventListener('input', function (e) {
        validadorInputs(e.target);
        verificarFormulario(); // Verifica todo el formulario con cada cambio
    });

    // Validación de horas
    const horaInicio = formulario.querySelector('[name="horarioEventoInicio"]');
    const horaFin = formulario.querySelector('[name="horarioEventoFin"]');

    [horaInicio, horaFin].forEach(input => {
        input.addEventListener('change', function () {
            if (horaInicio.value && horaFin.value && horaInicio.value >= horaFin.value) {
                horaFin.setCustomValidity('La hora de fin debe ser posterior a la de inicio');
            } else {
                horaFin.setCustomValidity('');
            }
            validadorInputs(horaFin);
        });
    });

    // --- LÓGICA DE AUTOCOMPLETADO ---

    // Autocompletado para Participantes
    const inputParticipante = document.getElementById('par_nombre');
    const inputParticipanteId = document.getElementById('par_identificacion');
    const resultadosParticipantes = document.getElementById('resultados');

    inputParticipante.addEventListener('input', () => {
        const termino = inputParticipante.value.trim();
        if (termino.length < 2) {
            resultadosParticipantes.innerHTML = '';
            inputParticipanteId.value = '';
            verificarFormulario();
            return;
        }
        const ruta = `{{ route('eventos.buscarParticipantes') }}?term=${encodeURIComponent(termino)}`;
        fetch(ruta)
            .then(res => res.json())
            .then(data => {
                resultadosParticipantes.innerHTML = '';
                data.forEach(p => {
                    const li = document.createElement('li');
                    li.classList.add('list-group-item', 'list-group-item-action');
                    li.textContent = `${p.nombre} ${p.apellido}`;
                    li.dataset.id = p.id;
                    li.dataset.nombre = `${p.nombre} ${p.apellido}`;
                    resultadosParticipantes.appendChild(li);
                });
            });
    });

    resultadosParticipantes.addEventListener('click', e => {
        if (e.target.matches('li')) {
            inputParticipante.value = e.target.dataset.nombre;
            inputParticipanteId.value = e.target.dataset.id;
            resultadosParticipantes.innerHTML = '';
            validadorInputs(inputParticipante);
            verificarFormulario();
        }
    });

    // Autocompletado para Ambientes
    const inputAmbiente = document.getElementById('pla_amb_nombre');
    const inputAmbienteId = document.getElementById('pla_amb_id');
    const resultadosAmbientes = document.getElementById('resultadosAmbientes');

    inputAmbiente.addEventListener('input', () => {
        const termino = inputAmbiente.value.trim();
        ambienteDisponible = false; // Resetea la disponibilidad si se cambia el texto
        if (termino.length < 2) {
            resultadosAmbientes.innerHTML = '';
            inputAmbienteId.value = '';
            verificarFormulario();
            return;
        }
        const ruta = `{{ route('eventos.buscarAmbientes') }}?term=${encodeURIComponent(termino)}`;
        fetch(ruta)
            .then(res => res.json())
            .then(data => {
                resultadosAmbientes.innerHTML = '';
                data.forEach(a => {
                    const li = document.createElement('li');
                    li.classList.add('list-group-item', 'list-group-item-action');
                    li.textContent = a.nombre;
                    li.dataset.id = a.id;
                    li.dataset.nombre = a.nombre;
                    resultadosAmbientes.appendChild(li);
                });
            });
    });

    resultadosAmbientes.addEventListener('click', function (e) {
        if (e.target.matches('li')) {
            inputAmbiente.value = e.target.dataset.nombre;
            inputAmbienteId.value = e.target.dataset.id;
            resultadosAmbientes.innerHTML = '';
            validadorInputs(inputAmbiente);
            // Dispara la validación de disponibilidad después de seleccionar
            validarDisponibilidad();
        }
    });

    // Cerrar listas de autocompletado si se hace clic fuera
    document.addEventListener('click', e => {
        if (!e.target.closest('.position-relative')) {
            resultadosParticipantes.innerHTML = '';
            resultadosAmbientes.innerHTML = '';
        }
    });


    // --- VALIDACIÓN DE DISPONIBILIDAD (ASÍNCRONA) ---

    function validarDisponibilidad() {
        const ambienteId = inputAmbienteId.value;
        const fechaEvento = document.querySelector('[name="fechaEvento"]').value;
        const horarioInicio = horaInicio.value;
        const horarioFin = horaFin.value;

        if (!ambienteId || !fechaEvento || !horarioInicio || !horarioFin || validando) {
            ambienteDisponible = false;
            verificarFormulario();
            return;
        }
        
        validando = true;
        btnGuardar.disabled = true; // Deshabilita mientras valida

        const rutaValidar = "{{ route('eventos.validarDisponibilidad') }}";
        fetch(rutaValidar, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                pla_amb_id: ambienteId,
                fecha: fechaEvento,
                hora_inicio: horarioInicio,
                hora_fin: horarioFin
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.disponible) {
                notyf.error(data.message || "El ambiente no está disponible en este horario.");
                ambienteDisponible = false;
            } else {
                notyf.success("Ambiente disponible.");
                ambienteDisponible = true;
            }
        })
        .catch(() => {
            notyf.error("Error al validar la disponibilidad. Intente de nuevo.");
            ambienteDisponible = false;
        })
        .finally(() => {
            validando = false;
            verificarFormulario(); // Vuelve a verificar el estado del formulario y el botón
        });
    }

    // Eventos que disparan la validación de disponibilidad
    ['change', 'blur'].forEach(evento => {
        document.getElementById('pla_amb_id').addEventListener(evento, validarDisponibilidad);
        document.querySelector('[name="fechaEvento"]').addEventListener(evento, validarDisponibilidad);
        horaInicio.addEventListener(evento, validarDisponibilidad);
        horaFin.addEventListener(evento, validarDisponibilidad);
    });


    // --- SUBMIT DEL FORMULARIO ---

    formulario.addEventListener('submit', function (e) {
        if (!formulario.checkValidity() || !ambienteDisponible) {
            e.preventDefault();
            e.stopPropagation();

            if (!ambienteDisponible) {
                notyf.error("No se puede guardar: el ambiente no está disponible en la fecha y hora seleccionadas.");
            }
            
            // Muestra todos los errores en los campos
            const inputs = formulario.querySelectorAll('input, select, textarea');
            inputs.forEach(input => validadorInputs(input));
            
            formulario.classList.add('was-validated');
        } else {
            btnGuardar.disabled = true; // Evita doble envío
        }
    });

    // --- NOTIFICACIONES FLASH DE LARAVEL ---
    @if(session('error'))
        notyf.error('{{ session('error') }}');
    @endif

    @if(session('success'))
        notyf.success('{{ session('success') }}');
    @endif
    
    // Verificación inicial al cargar la página (por si hay datos precargados)
    verificarFormulario(); 
});



// ficha manejo de busqueda 
// Autocompletado para Fichas
const inputFicha = document.getElementById('fic_numero_input');
const inputFichaHidden = document.getElementById('fic_numero');
const resultadosFichas = document.getElementById('resultadosFichas');

inputFicha.addEventListener('input', () => {
    const termino = inputFicha.value.trim();
    if (termino.length < 0) {
        resultadosFichas.innerHTML = '';
        inputFichaHidden.value = '';
        verificarFormulario();
        return;
    }
    const ruta = `{{ route('eventos.buscarFichas') }}?term=${encodeURIComponent(termino)}`;
    fetch(ruta)
        .then(res => res.json())
        .then(data => {
            resultadosFichas.innerHTML = '';
            data.forEach(f => {
                const li = document.createElement('li');
                li.classList.add('list-group-item', 'list-group-item-action');
                li.textContent = f.fic_numero;
                li.dataset.numero = f.fic_numero;
                resultadosFichas.appendChild(li);
            });
        });
});

resultadosFichas.addEventListener('click', e => {
    if (e.target.matches('li')) {
        inputFicha.value = e.target.dataset.numero;
        inputFichaHidden.value = e.target.dataset.numero;
        resultadosFichas.innerHTML = '';
        verificarFormulario();
    }
});




</script>
@endpush