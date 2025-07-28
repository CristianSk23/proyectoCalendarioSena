
<!-- Modal de Centro de Ayuda -->
<div class="modal fade" id="helpCenterModal" tabindex="-1" aria-labelledby="helpCenterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content" style="background-color: #f8f9fa;">
            <div class="modal-header border-0 position-absolute top-0 start-0" style="z-index: 10;">
                <h5 class="modal-title text-dark shadow-lg" id="helpCenterModalLabel">Centro de Ayuda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <!-- Menú principal del centro de ayuda -->
                <div class="container-fluid h-100 d-flex flex-column align-items-center justify-content-center">
                    <h2 class="mb-4">¿En qué podemos ayudarte?</h2>
                    <div class="d-grid gap-3 col-6 mx-auto">
                        <button class="btn btn-lg btn-success" id="showTutorialBtn">
                            <i class="bi bi-book me-2"></i> Tutorial Paso a Paso
                        </button>
                        <button class="btn btn-lg btn-info" id="showHelpCardsBtn">
                            <i class="bi bi-question-circle me-2"></i> Tarjetas de Ayuda (FAQ)
                        </button>
                    </div>
                </div>

                <!-- Contenido del tutorial (diapositivas) -->
                <div id="tutorialDiapositivas" class="d-none h-100 position-absolute top-0 start-0 w-100 bg-light p-4 overflow-auto">
                    <button class="btn btn-secondary mb-3" id="backToHelpMenu">
                        <i class="bi bi-arrow-left me-2"></i> Volver al Menú de Ayuda
                    </button>
                    <div id="tutorialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                        <div class="carousel-inner">
    <div class="carousel-item active">
        <h1>Guide for Agenda CDTI-SENA</h1>
        <h3 class="step-title">1: Click Botón “Iniciar sesión”</h3>
        <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_562a4f12-62db-4e82-90f0-3671b102927d.png">
    </div>

    <div class="carousel-item">
        <h3 class="step-title">2: Ingresar</h3>
        <p class="step-description">Ingresa las credenciales autorizadas</p>
        <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_fcb6221b-7d4a-4119-a77e-bd16062c3d76.png">
    </div>

    <div class="carousel-item">
        <h3 class="step-title">3: Campana de notificaciones</h3>
        <p class="step-description">Clic en campana de notificaciones</p>
        <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_5dca0ff0-0000-4092-808f-ac16215751ba.png">
    </div>

    <div class="carousel-item">
        <h3 class="step-title">4: Confirmaciones PTE</h3>
        <p class="step-description">Pestaña de Eventos Pendientes por confirmación. Se da clic en "Confirmar" para asignar evento.</p>
        <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_dbba8f07-48ee-4c2c-8256-c2ac27db39f8.png">
    </div>

    <div class="carousel-item">
        <h3 class="step-title">5: Click here</h3>
        <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_adf282f5-7cbf-418a-8750-fa3f743408ed.png">
    </div>

    <div class="carousel-item">
        <h3 class="step-title">6: Fecha asignada</h3>
        <p class="step-description">Verificamos que esté asignada</p>
        <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_873e97f8-a7bb-499b-af54-eb5f8fda0fdf.png">
    </div>

    <div class="carousel-item">
        <h3 class="step-title">7: Click el botón “Cerrar”</h3>
        <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_d70743cf-c2ff-47b9-bec4-923274c78fed.png">
    </div>
</div>


                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#tutorialCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#tutorialCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                </div>

                <!-- Contenido de tarjetas de ayuda (FAQ) -->
                <div id="helpCardsContent" class="d-none h-100 position-absolute top-0 start-0 w-100 bg-light p-4 overflow-auto">
                    <button class="btn btn-secondary mb-3" id="backToHelpMenuFromCards">
                        <i class="bi bi-arrow-left me-2"></i> Volver al Menú de Ayuda
                    </button>
                    <h3 class="mb-4">Tarjetas de Ayuda / Preguntas Frecuentes</h3>
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    ¿Cómo solicito un evento nuevo?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    Para solicitar un evento, haz clic en el botón "Solicitar Evento" en la pantalla principal. Luego, sigue los pasos llenando la información requerida como la persona que solicita, lugar, fecha y hora.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    ¿Puedo editar un evento ya enviado?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    Actualmente, los eventos enviados quedan pendientes de confirmación. Para realizar cambios, por favor contacta al administrador del sistema.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Inicializar Shepherd
    const tour = new Shepherd.Tour({
        defaultStepOptions: {
            cancelIcon: { enabled: true },
            classes: 'shadow bg-white rounded',
            scrollTo: { behavior: 'smooth', block: 'center' }
        }
    });

    // Paso 1: Bienvenida
    tour.addStep({
        title: '👋 Bienvenido',
        text: 'Este tutorial te guiará para solicitar un evento paso a paso.',
        buttons: [
            { text: 'Cancelar', action: tour.cancel },
            { text: 'Comenzar', action: tour.next }
        ]
    });

    // Paso 2: Botón "Solicitar Evento"
    tour.addStep({
        title: 'Solicitar Evento',
        text: 'Haz clic en este botón para iniciar la solicitud de tu evento.',
        attachTo: { element: '#abrirModalAgregar', on: 'bottom' },
        buttons: [
            { text: 'Atrás', action: tour.back },
            { text: 'Siguiente', action: tour.next }
        ],
        when: {
            show: () => {
                const btn = document.getElementById('abrirModalAgregar');
                if (btn) btn.click(); // abre el modal de autenticación
            }
        }
    });

    // Paso 3: Ingresar Identificación
    tour.addStep({
        title: 'Identificación',
        text: 'Usa estas credenciales:<br><strong>Usuario:</strong> 1111111111',
        attachTo: { element: '#auth_identificacion', on: 'bottom' },
        buttons: [
            { text: 'Atrás', action: tour.back },
            { text: 'Siguiente', action: tour.next }
        ],
        when: {
            show: () => {
                const input = document.getElementById('auth_identificacion');
                if (input) input.value = '1112498616';
            }
        }
    });

    // Paso 4: Ingresar Contraseña
    tour.addStep({
        title: 'Contraseña',
        text: 'Introduce la contraseña:<br><strong>1111111111</strong>',
        attachTo: { element: '#auth_password', on: 'bottom' },
        buttons: [
            { text: 'Atrás', action: tour.back },
            { text: 'Siguiente', action: tour.next }
        ],
        when: {
            show: () => {
                const input = document.getElementById('auth_password');
                if (input) input.value = '1112498616';
            }
        }
    });

    // Paso 5: Validar credenciales
    tour.addStep({
        title: 'Validar Acceso',
        text: 'Haz clic en el botón <strong>Validar</strong> para continuar.',
        attachTo: { element: '#submitAuthForm', on: 'bottom' },
        buttons: [
            { text: 'Atrás', action: tour.back },
            { text: 'Siguiente', action: tour.next }
        ],
        when: {
            show: () => {
                const btn = document.getElementById('submitAuthForm');
                if (btn) {
                    setTimeout(() => btn.click(), 800); // simula el clic después de 0.8s
                }
            }
        }
    });

    // Paso 6: Formulario de Evento
    tour.addStep({
        title: 'Formulario de Evento',
        text: 'Aquí puedes diligenciar la información de tu evento.',
        attachTo: { element: '#formularioEvento', on: 'top' },
        buttons: [
            { text: 'Atrás', action: tour.back },
            { text: 'Siguiente', action: tour.next }
        ]
    });

    // Paso 7: Enviar Solicitud
    tour.addStep({
        title: 'Enviar Solicitud',
        text: 'Cuando completes todos los campos, haz clic aquí para enviar la solicitud.',
        attachTo: { element: '#btnCrearEvento', on: 'bottom' },
        buttons: [
            { text: 'Atrás', action: tour.back },
            { text: 'Finalizar', action: tour.complete }
        ]
    });

    // --- BOTÓN FLOTANTE DE AYUDA ---
    const toggleAyudaBtn = document.getElementById('toggleAyudaBtn');
    if (toggleAyudaBtn) {
        toggleAyudaBtn.addEventListener('click', function () {
            const helpModal = new bootstrap.Modal(document.getElementById('helpCenterModal'));
            helpModal.show();
        });
    }

    // --- BOTÓN "Tutorial Paso a Paso" dentro del modal ---
    const showTutorialBtn = document.getElementById('showTutorialBtn');
    if (showTutorialBtn) {
        showTutorialBtn.addEventListener('click', function () {
            const helpModalEl = document.getElementById('helpCenterModal');
            const helpModal = bootstrap.Modal.getInstance(helpModalEl);
            if (helpModal) helpModal.hide();
            setTimeout(() => tour.start(), 500); // inicia el tour después de cerrar el modal
        });
    }
});



// Boton de ingresa ingres al modal de ayuda

document.addEventListener('DOMContentLoaded', function () {
    // Capturar el clic en el botón de ayuda
    document.getElementById('toggleAyudaBtn').addEventListener('click', function () {
        // Mostrar el modal de la guía de ayuda
        const modal = new bootstrap.Modal(document.getElementById('helpCenterModal'));
        modal.show();
    });
});
</script>




@endpush
