@extends('Layouts.Plantilla')

@section('content')
    <h1 class="h2 font-weight-bold mb-4">Crear Evento</h1>

    <form action="{{ isset($evento) ? route('eventos.actualizarEvento', $evento->idEvento) : route('eventos.store') }}"
        method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow" id="formularioEvento">
        @csrf

        <div class="mb-3 position-relative" style="z-index: 9999;">
            <label for="par_nombre" class="form-label">Encargado(s) del Evento:</label>

            <!-- Mostrar encargados seleccionados -->
            <div id="encargadosSeleccionados" class="mb-2 d-flex flex-wrap gap-2">
                @isset($evento->encargados)
                    @foreach ($evento->encargados as $encargado)
                        <span class="badge bg-primary d-flex align-items-center mb-1">
                            {{ $encargado->par_nombres }} {{ $encargado->par_apellidos }}
                            <button type="button" class="btn-close btn-close-white btn-sm ms-2" aria-label="Eliminar"
                                onclick="eliminarEncargado('{{ $encargado->par_identificacion }}')"></button>
                        </span>
                    @endforeach
                @endisset
            </div>

            <input type="text" id="par_nombre" class="form-control" placeholder="Buscar participante..." autocomplete="off">

            <!-- Campo para IDs de encargados -->
            <input type="hidden" name="idEvento" value="{{ isset($evento) ? $evento->idEvento : '' }}">
            <input type="hidden" name="par_identificacion" id="par_identificacion"
                value="{{ isset($encargados) ? implode(',', $encargados->pluck('par_identificacion')->toArray()) : '' }}"
                required>

            <!-- Lista de resultados -->
            <ul id="resultados" class="list-group position-absolute w-100" style="max-height: 200px; overflow-y: auto;">
            </ul>

            <!-- Este id es clave para que la validación funcione -->
            <div id="errorEncargados" class="invalid-feedback" style="display: none;">Por favor selecciona al menos un
                encargado</div>
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
                        value="{{ isset($evento) ? $inicioEvento : '' }}" min="06:00" max="21:00">
                    <div class="invalid-feedback">Hora inválida (6:00 AM - 9:00 PM)</div>
                </div>
                <div class="col-md-6">
                    <label for="horarioEventoFin" class="form-label">Fin:</label>
                    <input type="time" name="horarioEventoFin" required class="form-control"
                        value="{{ isset($evento) ? $finalEvento : '' }}" min="06:00" max="21:00">
                    <div class="invalid-feedback">Hora inválida (6:00 AM - 9:00 PM)</div>
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

        <div class="mb-3 position-relative" style="z-index: 9999;">
            <label for="ficha_numero" class="form-label">Fichas del Evento:</label>

            <!-- Mostrar fichas seleccionadas -->
            <div id="fichasSeleccionadas" class="mb-2 d-flex flex-wrap gap-2">
                @isset($evento->fichas)
                    @foreach ($evento->fichas as $ficha)
                        <span class="badge bg-secondary d-flex align-items-center mb-1">
                            {{ $ficha->fic_numero }} - {{ $ficha->nombreFicha }}
                            <button type="button" class="btn-close btn-close-white btn-sm ms-2" aria-label="Eliminar"
                                onclick="eliminarFicha('{{ $ficha->fic_numero }}')"></button>
                        </span>
                    @endforeach
                @endisset
            </div>

            <!-- Inputs manuales -->
            <div class="row g-2">
                <div class="col-md-5">
                    <input type="number" id="ficha_numero" class="form-control" placeholder="Número de Ficha">
                </div>
                <div class="col-md-5">
                    <input type="text" id="ficha_nombre" class="form-control" placeholder="Nombre de Ficha">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success w-100" onclick="agregarFicha()">Agregar</button>
                </div>
            </div>

            <!-- Campo oculto para enviar IDs de fichas -->
            <input type="hidden" name="fichas" id="fichas"
                value="{{ isset($evento->fichas) ? implode('|', $evento->fichas->map(fn($f) => $f->fic_numero . ':' . $f->nombreFicha)->toArray()) : '' }}">

            <div class="invalid-feedback">Por favor selecciona al menos una ficha</div>
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
            <label for="publicidad">Publicidad:</label>
            <input type="file" name="publicidad" accept="image/*" class="form-control">
        </div>

        <div class="mb-3">
            <label for="estadoEvento" class="form-label">Estado del Evento:</label>
            <select name="estadoEvento" required class="form-select">
                <option value="">Seleccionar estado para el Evento</option>
                <option value="1" {{isset($evento) && $evento->estadoEvento == 1 ? 'selected' : ''}}>Agendado</option>
                <option value="2" {{isset($evento) && $evento->estadoEvento == 2 ? 'selected' : ''}}>Separado</option>
                <option value="3" {{isset($evento) && $evento->estadoEvento == 3 ? 'selected' : ''}}>Completado</option>
                <option value="4" {{isset($evento) && $evento->estadoEvento == 4 ? 'selected' : ''}}>Cancelado</option>

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


            const fechaEvento = formulario.querySelector('[name="fechaEvento"]');
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
        const contenedorEncargados = document.getElementById('encargadosSeleccionados');

        // Precargar encargados desde el backend
        let encargados = [];

        @if(isset($evento))
            // Pasamos el array de PHP a JS usando JSON
            encargados = @json($evento->encargados->map(function ($encargado) {
                return [
                    'id' => $encargado->par_identificacion,
                    'nombre' => $encargado->par_nombres . ' ' . $encargado->par_apellidos,
                    'correo' => $encargado->par_correo
                ];
            }));
        @endif
        actualizarEncargados();



        // Escuchar cuando el usuario escribe en el input
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
                        console.log(`Agregando participante: ${p.nombre} ${p.apellido} (ID: ${p.id}) ${p.correo} `);
                        
                        resultados.appendChild(li);
                    });
                });
        });

        // Escuchar cuando se selecciona un encargado de la lista
        resultados.addEventListener('click', e => {
            if (e.target.matches('li')) {
                const id = e.target.dataset.id;
                const nombre = e.target.dataset.nombre;

                // Si no está seleccionado aún, lo agregamos
                if (!encargados.some(enc => enc.id === id)) {
                    encargados.push({ id, nombre });
                    actualizarEncargados();
                }

                // Limpiar input y resultados
                input.value = '';
                resultados.innerHTML = '';
            }
        });

        // Cerrar la lista si se hace click fuera
        document.addEventListener('click', e => {
            if (!e.target.closest('.mb-3')) {
                resultados.innerHTML = '';
            }
        });


        // Actualizar visualmente los encargados seleccionados y el input oculto
        function actualizarEncargados() {


            contenedorEncargados.innerHTML = encargados.map(enc => `
                                                                                                                                                        <span class="badge bg-primary d-flex align-items-center mb-1">
                                                                                                                                                            ${enc.nombre}
                                                                                                                                                            <button type="button" class="btn-close btn-close-white btn-sm ms-2" aria-label="Eliminar" onclick="eliminarEncargado('${enc.id}')"></button>
                                                                                                                                                        </span>
                                                                                                                                                    `).join('');

            // Guardar los IDs separados por coma
            inputHidden.value = encargados.map(enc => enc.id).join(',');
            console.log(`IDs de encargados: ${inputHidden.value}`);
                                                                                                                                                        
        }

        // Eliminar encargado de la selección
        function eliminarEncargado(id) {
            encargados = encargados.filter(enc => String(enc.id) !== String(id));
            console.log(`Eliminando encargado con ID: ${id}`);
            console.log(encargados);
            actualizarEncargados();
        }



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

        let fichas = [];


        @if (isset($fichas))
            fichas = @json($fichas);
            console.log('Fichas precargadas:', fichas);
            
            actualizarFichas();
        @endif


            // Función para actualizar visualmente las fichas
            function actualizarFichas() {
                const contenedorFichas = document.getElementById('fichasSeleccionadas');
                const inputHiddenFichas = document.getElementById('fichas');

                contenedorFichas.innerHTML = fichas.map(f => `
                    <span class="badge bg-secondary d-flex align-items-center mb-1">
                        ${f.numero} - ${f.nombre}
                        <button type="button" class="btn-close btn-close-white btn-sm ms-2" aria-label="Eliminar"
                            onclick="eliminarFicha('${f.numero}')"></button>
                    </span>
                `).join('');

                // Guardar las fichas en formato "numero:nombre|numero:nombre"
                inputHiddenFichas.value = fichas.map(f => `${f.numero}:${f.nombre}`).join('|');

                console.log('Fichas actuales:', fichas);
            }

        // Agregar ficha
        function agregarFicha() {
            const numeroInput = document.getElementById('ficha_numero');
            const nombreInput = document.getElementById('ficha_nombre');

            const numero = numeroInput.value.trim();
            const nombre = nombreInput.value.trim();

            if (numero && nombre) {
                // Verificar que no esté duplicada
                if (fichas.some(f => f.numero === numero)) {
                    notyf.error('Esta ficha ya ha sido agregada.');
                    return;
                }

                fichas.push({ numero, nombre });
                actualizarFichas();

                // Limpiar inputs
                numeroInput.value = '';
                nombreInput.value = '';
            } else {
                notyf.error('Debe ingresar el número y el nombre de la ficha.');
            }
        }

        // Eliminar ficha
        function eliminarFicha(numero) {
            fichas = fichas.filter(f => f.numero !== numero);
            actualizarFichas();
        }



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
            const ambienteId = document.getElementById('pla_amb_id').value;
            const fechaEvento = document.querySelector('[name="fechaEvento"]').value;
            const horarioInicio = document.querySelector('[name="horarioEventoInicio"]').value;
            const horarioFin = document.querySelector('[name="horarioEventoFin"]').value;
            let idEvento = null;

            @if(isset($evento))
                idEvento = @json($evento->idEvento);
            @endif


            let bodyData;

            if (idEvento) {
                bodyData = {
                    idEvento: idEvento,
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

            // Obtener campo oculto de encargados
            const inputEncargados = document.getElementById('par_identificacion');
            const errorEncargados = document.getElementById('errorEncargados');

            // Validar que al menos un encargado esté seleccionado
            const encargadosSeleccionados = inputEncargados.value.trim();

            if (encargadosSeleccionados === '') {
                todosLlenos = false;

                // Mostrar el mensaje de error
                inputEncargados.classList.add('is-invalid');
                errorEncargados.style.display = 'block';
            } else {
                // Ocultar el mensaje de error si ya hay encargados
                inputEncargados.classList.remove('is-invalid');
                errorEncargados.style.display = 'none';
            }

            // Validar también si el ambiente está disponible
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