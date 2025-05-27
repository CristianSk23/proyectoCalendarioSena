@extends('Layouts.Plantilla')

@section('content')
    <h1 class="h2 font-weight-bold mb-4">Crear Evento</h1>

    <form action="{{ isset($evento) ? route('eventos.actualizarEvento', $evento->idEvento) : route('eventos.store') }}"
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
            <input type="date" name="fechaEvento" required class="form-control" id="fechaEvento"
                value="{{ isset($evento) ? $evento->fechaEvento : '' }}" min="{{ date('Y-m-d') }}">
            <div class="invalid-feedback">La fecha no puede ser anterior a hoy</div>
        </div>

        <div class="mb-3">
            <label for="aforoEvento" class="form-label">Aforo del Evento:</label>
            <input type="number" name="aforoEvento" required class="form-control" min="1" max="500"
                value="{{ isset($evento) ? $evento->aforoEvento : '' }}" id="aforoEvento">
            <div class="invalid-feedback">El aforo debe ser entre 1 y 500 personas</div>
        </div>

        <div class="mb-3">
            <label for="fic_numero" class="form-label">Ficha:</label>
            <select name="fic_numero" id="fic_numero" class="form-select" required>
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

        <button type="submit" class="btn btn-success" id="btnGuardar" disabled>
            {{ isset($evento) ? 'Actualizar Evento' : 'Crear Evento' }}
        </button>
    </form>





    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const formulario = document.getElementById('formularioEvento');

            // Validación en tiempo real
            formulario.addEventListener('input', function (e) {
                validadorInputs(e.target);
            });

            // Validación al enviar
            formulario.addEventListener('submit', function (e) {
                if (!formulario.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();

                    const inputs = formulario.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => validadorInputs(input));
                }

                formulario.classList.add('was-validated');
            });

            formulario.querySelectorAll('input, select, textarea').forEach(input => {
                input.addEventListener('input', verificarFormulario);
            });




            // Eventos que afectan la disponibilidad
            ['pla_amb_id'].forEach(id => {
                document.getElementById(id).addEventListener("change", () => {
                    validarDisponibilidad();
                    verificarFormulario();
                });
            });

            ['horarioEventoInicio', 'horarioEventoFin', 'fechaEvento'].forEach(name => {
                document.querySelector(`input[name='${name}']`).addEventListener("change", () => {
                    validarDisponibilidad();
                    verificarFormulario();
                });
            });

            // Validación personalizada de horarios
            const fechaEvento = formulario.querySelector('[name="fechaEvento"]');
            console.log(fechaEvento);

            const horaInicio = formulario.querySelector('[name="horarioEventoInicio"]');
            const horaFin = formulario.querySelector('[name="horarioEventoFin"]');

            [horaInicio, horaFin].forEach(input => {
                input.addEventListener('change', function () {
                    if (horaInicio.value && horaFin.value && horaInicio.value >= horaFin.value) {
                        horaFin.setCustomValidity('La hora de fin debe ser posterior a la de inicio');
                        horaFin.classList.add('is-invalid');
                        horaFin.classList.remove('is-valid');
                    } else {
                        horaFin.setCustomValidity('');
                        horaFin.classList.remove('is-invalid');
                        horaFin.classList.add('is-valid');
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

        // Autocompletado Participantes
        const input = document.getElementById('par_nombre');
        const inputHidden = document.getElementById('par_identificacion');
        const resultados = document.getElementById('resultados');

        input.addEventListener('input', () => {
            const termino = input.value.trim();
            if (termino.length < 2) {
                resultados.innerHTML = '';
                return;
            }

            const ruta = "{{ route('eventos.buscarParticipantes') }}" + `?term=${encodeURIComponent(termino)}`;
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
                });
        });

        resultados.addEventListener('click', e => {
            if (e.target.matches('li')) {
                input.value = e.target.dataset.nombre;
                inputHidden.value = e.target.dataset.id;
                resultados.innerHTML = '';
            }
        });

        document.addEventListener('click', e => {
            if (!e.target.closest('.mb-3')) {
                resultados.innerHTML = '';
            }
        });

        // Autocompletado Ambientes
        const inputAmbiente = document.getElementById('pla_amb_nombre');
        const inputAmbienteId = document.getElementById('pla_amb_id');
        const resultadosAmbientes = document.getElementById('resultadosAmbientes');

        let timeout;
        inputAmbiente.addEventListener('input', function () {
            const valor = this.value.trim();
            resultadosAmbientes.innerHTML = '';
            clearTimeout(timeout);

            if (valor.length >= 2) {
                const ruta = "{{ route('eventos.buscarAmbientes') }}" + `?term=${encodeURIComponent(valor)}`;
                timeout = setTimeout(() => {
                    fetch(ruta)
                        .then(response => response.json())
                        .then(data => {
                            resultadosAmbientes.innerHTML = '';
                            data.forEach(a => {
                                const li = document.createElement('li');
                                li.classList.add('list-group-item', 'list-group-item-action');
                                li.textContent = `${a.nombre}`;
                                li.dataset.id = a.id;
                                li.dataset.nombre = a.nombre;
                                resultadosAmbientes.appendChild(li);
                            });
                        });
                }, 300);
            }
        });

        resultadosAmbientes.addEventListener('click', function (e) {
            if (e.target.matches('li')) {
                inputAmbiente.value = e.target.dataset.nombre;
                inputAmbienteId.value = e.target.dataset.id;
                resultadosAmbientes.innerHTML = '';
            }
        });

        document.addEventListener('click', function (e) {
            if (!resultadosAmbientes.contains(e.target) && e.target !== inputAmbiente) {
                resultadosAmbientes.innerHTML = '';
            }
        });

        let validando = false;
        let ambienteDisponible = true;

        function validarDisponibilidad() {
            console.log("Validando disponibilidad...");

            const ambienteId = document.getElementById('pla_amb_id').value;
            const fechaEvento = document.querySelector('[name="fechaEvento"]').value;
            const horarioInicio = document.querySelector('[name="horarioEventoInicio"]').value;
            const horarioFin = document.querySelector('[name="horarioEventoFin"]').value;
            let idEvento = null;

            @if(isset($evento))
                idEvento = @json($evento->idEvento);
                console.log("Existe el evento, idEvento:", idEvento);
            @endif


            let bodyData;

            if (idEvento) {
                bodyData = {
                    idEvento: idEvento, // o 'evento_id', lo que uses en el backend
                    pla_amb_id: ambienteId,
                    fecha: fechaEvento,
                    hora_inicio: horarioInicio,
                    hora_fin: horarioFin
                };
            } else {
                bodyData = {
                    pla_amb_id: ambienteId,
                    fecha: fechaEvento,
                    hora_inicio: horarioInicio,
                    hora_fin: horarioFin
                };
            }



            console.log(`Validando disponibilidad para ambiente ${ambienteId} en la fecha ${fechaEvento} de ${horarioInicio} a ${horarioFin}`);
            if (!ambienteId || !fechaEvento || !horarioInicio || !horarioFin) return;
            if (validando) return;
            validando = true;

            const rutaValidar = "{{ route('eventos.validarDisponibilidad') }}";
            fetch(rutaValidar, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },

                body: JSON.stringify(bodyData)
            })
                .then(response => response.json())
                .then(data => {
                    console.log(`Respuesta de disponibilidad: ${JSON.stringify(data)}`);

                    if (!data.disponible) {
                        notyf.error(data.message || "El ambiente no está disponible.");
                        ambienteDisponible = false;
                    } else {
                        notyf.success("Ambiente disponible.");
                        ambienteDisponible = true;
                    }
                    verificarFormulario();
                })
                .finally(() => {
                    validando = false;
                });
        }

        // Validar al enviar formulario si el ambiente no está disponible
        document.querySelector("form").addEventListener("submit", function (e) {
            if (!ambienteDisponible) {
                e.preventDefault();
                notyf.error("No se puede guardar: el ambiente no está disponible.");
            }
        });

        function verificarFormulario() {
            const formulario = document.getElementById('formularioEvento');
            const btnGuardar = document.getElementById('btnGuardar');
            const camposRequeridos = formulario.querySelectorAll('input[required], select[required], textarea[required]');

            let todosLlenos = true;
            camposRequeridos.forEach(campo => {
                const valor = campo.value;
                if (!valor || valor.trim() === '') {
                    todosLlenos = false;
                }
            });

            btnGuardar.disabled = !(todosLlenos && ambienteDisponible);
        }


        // Notificaciones Laravel
        @if(session('error'))
            notyf.error('{{ session('error') }}');
        @endif

        @if(session('success'))
            notyf.success('{{ session('success') }}');
        @endif
    </script>

@endsection