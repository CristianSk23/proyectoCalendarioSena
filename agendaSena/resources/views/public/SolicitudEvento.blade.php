@extends('layouts.public')

@section('content')

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS (antes de cerrar body) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<!-- Solicitud para quien  -->

<h1 class="h2 font-weight-bold mb-4" style="color: grey; text-shadow: -1px 0 green, 0 1px green, 1px 0 white, 0 -1px white;">
    Solicitar Evento
</h1>


   
   
    <form id="formularioEvento" action="{{ route('eventos.storeExterno') }}" method="POST" enctype="multipart/form-data">

        @csrf
        <!-- campos del formulario -->
    


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
                     <option value="{{ $ficha->fic_numero }}" {{ isset($evento) && $evento->fic_numero == $ficha->fic_numero ? 'selected' : '' }}>
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

        
  

   


   <!-- Modal de Validación de Usuario -->
  


   <button type="button" class="btn btn-success" id="btnEnviarEvento">Enviar Evento</button>
   



</form>
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    
        <div class="modal-dialog">
            <form id="authForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="authModalLabel">Verifica tu identidad</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="auth_identificacion" class="form-label">Identificación</label>
                            <input type="text" class="form-control" id="auth_identificacion" name="auth_identificacion" required>
                        </div>
                        <div class="mb-3">
                            <label for="auth_password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="auth_password" name="auth_password" required>
                        </div>
                        <div id="auth_error_modal" class="text-danger"></div>
                    </div>
                    <!-- Modifica el footer del modal -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="submitAuthForm">Validar y Enviar Evento</button>
                    </div>
    
                </div>
            </form>
        </div>
    </div>


    <div id="successMessage" style="display:none;" class="alert alert-success mt-3">
    Evento creado exitosamente como pendiente
</div>


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<script>
document.addEventListener('DOMContentLoaded', function () {
    // Referencias a elementos
    const btnEnviarEvento = document.getElementById('btnEnviarEvento');
    const authModal = document.getElementById('authModal');
    const authForm = document.getElementById('authForm');
    const formularioEvento = document.getElementById('formularioEvento');
    const successMessage = document.getElementById('successMessage');
    
    // Variable para almacenar la instancia del modal
    let modalInstance = null;

    // Mostrar modal al hacer clic en "Enviar Evento"
    btnEnviarEvento.addEventListener('click', function() {
        // Validar formulario primero
        if (!formularioEvento.checkValidity()) {
            formularioEvento.classList.add('was-validated');
            return;
        }
        
        // Crear instancia del modal si no existe
        if (!modalInstance) {
            modalInstance = new bootstrap.Modal(authModal);
        }
        
        // Mostrar modal
        modalInstance.show();
    });

    // Manejar envío del formulario de autenticación
    authForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const identificacion = document.getElementById('auth_identificacion').value;
        const password = document.getElementById('auth_password').value;
        
        // Mostrar spinner o indicador de carga
        const submitBtn = document.getElementById('submitAuthForm');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Validando...';
        submitBtn.disabled = true;
        
        // Validar credenciales
        fetch('{{ route("verificar-credenciales") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                par_identificacion: identificacion,
                password: password
            })
        })
        .then(response => {
            if (!response.ok) throw new Error('Error en la respuesta del servidor');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Crear inputs ocultos con las credenciales
                const authIdInput = document.createElement('input');
                authIdInput.type = 'hidden';
                authIdInput.name = 'auth_identificacion';
                authIdInput.value = identificacion;
                
                const authPassInput = document.createElement('input');
                authPassInput.type = 'hidden';
                authPassInput.name = 'auth_password';
                authPassInput.value = password;
                
                formularioEvento.appendChild(authIdInput);
                formularioEvento.appendChild(authPassInput);
                
                // Ocultar modal
                modalInstance.hide();
                
                // Enviar formulario principal
                enviarFormularioEvento();
            } else {
                throw new Error(data.message || 'Credenciales inválidas');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('auth_error_modal').innerText = error.message;
        })
        .finally(() => {
            // Restaurar botón
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
        });
    });

    // Función para enviar el formulario del evento
    function enviarFormularioEvento() {
        const formData = new FormData(formularioEvento);
        
        // Mostrar indicador de carga en el botón principal
        const originalBtnText = btnEnviarEvento.innerHTML;
        btnEnviarEvento.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando...';
        btnEnviarEvento.disabled = true;
        
        fetch(formularioEvento.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Error en la respuesta del servidor');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                successMessage.style.display = 'block';
                formularioEvento.reset();
                
                // Ocultar mensaje después de 5 segundos
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 5000);
            } else {
                throw new Error(data.message || 'Error al crear el evento');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        })
        .finally(() => {
            // Restaurar botón principal
            btnEnviarEvento.innerHTML = originalBtnText;
            btnEnviarEvento.disabled = false;
        });
    }

    // Validación en tiempo real
    formularioEvento.addEventListener('input', function(e) {
        const input = e.target;
        validadorInputs(input);
    });

    // Validación personalizada para horarios
    const horaInicio = formularioEvento.querySelector('[name="horarioEventoInicio"]');
    const horaFin = formularioEvento.querySelector('[name="horarioEventoFin"]');

    [horaInicio, horaFin].forEach(input => {
        input.addEventListener('change', function() {
            if (horaInicio.value && horaFin.value && horaInicio.value >= horaFin.value) {
                horaFin.setCustomValidity('La hora de fin debe ser posterior a la de inicio');
                horaFin.classList.add('is-invalid');
            } else {
                horaFin.setCustomValidity('');
                horaFin.classList.remove('is-invalid');
            }
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
});

    // Hacer la función global para que pueda usarse en el onclick del botón
    window.abrirModalAutenticacion = function () {
        const modal = document.getElementById('authModal');
        
        if (modal) {
            const modalInstance = new bootstrap.Modal(modal);
            modalInstance.show();
        } else {
            console.error('Modal no encontrado');
        }
    };

    document.getElementById('authForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitAuthForm');
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Validando...';
    submitBtn.disabled = true;
    
    const errorElement = document.getElementById('auth_error_modal');
    errorElement.textContent = '';
    
    const identificacion = document.getElementById('auth_identificacion').value;
    const password = document.getElementById('auth_password').value;

    fetch('{{ route("verificar-credenciales") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            par_identificacion: identificacion,
            password: password
        })
    })
    .then(response => {
        if (!response.ok) {
            // Si el servidor devuelve un error 401 u otro
            return response.json().then(err => {
                throw new Error(err.message || 'Error en la autenticación');
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Resto de tu lógica para éxito
        } else {
            throw new Error(data.message || 'Credenciales incorrectas');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        errorElement.textContent = error.message;
        // Muestra el error de forma más amigable
        alert('Error: ' + error.message);
    })
    .finally(() => {
        submitBtn.innerHTML = originalBtnText;
        submitBtn.disabled = false;
    });
});



// Manejar la respuesta del formulario
document.getElementById('formularioEvento').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('successMessage').style.display = 'block';
            document.getElementById('formularioEvento').reset();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurrió un error al enviar el formulario');
    });
});

</script>
@endsection
