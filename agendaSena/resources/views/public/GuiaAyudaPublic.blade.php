<!-- Modal de Centro de Ayuda -->
<div class="modal fade" id="helpCenterModal" tabindex="-1" aria-labelledby="helpCenterModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-fullscreen">
        <div class="modal-content" style="background-color: #f8f9fa;">
            <div class="modal-header border-0 position-absolute top-0 start-0" style="z-index: 10;">
                <h5 class="modal-title text-dark shadow-lg" id="helpCenterModalLabel">Centro de Ayuda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Cuerpo -->
            <div class="modal-body p-5">
                
                <!-- Menú principal -->
                <div id="helpMainMenu" class="container-fluid h-100 d-flex flex-column align-items-center justify-content-center text-center">
                    <h2 class="mb-5 fw-bold" style="font-size: 2rem;">¿En qué podemos ayudarte?</h2>
                    <div class="d-grid gap-4 col-8 mx-auto">
                        <button class="btn btn-lg btn-success py-3" id="showTutorialBtn" style="font-size:1.4rem;">
                            <i class="bi bi-book me-2"></i> Tutorial Paso a Paso
                        </button>
                        <button class="btn btn-lg btn-info py-3" id="showHelpCardsBtn" style="font-size:1.4rem;">
                            <i class="bi bi-question-circle me-2"></i> Tarjetas de Ayuda (FAQ)
                        </button>
                    </div>
                </div>

                <!-- Contenido: Tutorial -->
                <div id="tutorialDiapositivas" class="d-none h-100 position-absolute top-0 start-0 w-100 bg-light p-5 overflow-auto">
                    <button class="btn btn-secondary mb-4" id="backToHelpMenu" style="font-size:1.2rem;">
                        <i class="bi bi-arrow-left me-2"></i> Volver al Menú de Ayuda
                    </button>
                    <div id="tutorialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                        <div class="carousel-inner">
                            <!-- Diapositivas -->
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#tutorialCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#tutorialCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                </div>

                <!-- Contenido: FAQ -->
                <div id="helpCardsContent" class="d-none h-100 position-absolute top-0 start-0 w-100 bg-light p-5 overflow-auto">
                    <button class="btn btn-secondary mb-4" id="backToHelpMenuFromCards" style="font-size:1.2rem;">
                        <i class="bi bi-arrow-left me-2"></i> Volver al Menú de Ayuda
                    </button>
                    <h3 class="mb-4 fw-bold" style="font-size:1.8rem;">Tarjetas de Ayuda / Preguntas Frecuentes</h3>
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed fs-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    ¿Cómo solicito un evento nuevo?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse">
                                <div class="accordion-body fs-2">
                                    Para solicitar un evento, haz clic en el botón "Solicitar Evento" en la pantalla principal. Ingresa tus credenciales autorizadas, Luego, sigue los pasos llenando la información requerida como la persona que solicita, lugar, fecha y hora, etc.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapse fs-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    ¿Puedo editar un evento ya enviado?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse">
                                <div class="accordion-body fs-2">
                                    Actualmente, los eventos enviados quedan pendientes de confirmación. Para realizar cambios, por favor contacta al administrador del sistema.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /.modal-body -->
        </div>
    </div>
</div>


@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function() {
    const helpMainMenu = document.getElementById('helpMainMenu');
    const tutorialDiapositivas = document.getElementById('tutorialDiapositivas');
    const helpCardsContent = document.getElementById('helpCardsContent');

    // Mostrar Tarjetas de Ayuda
    document.getElementById('showHelpCardsBtn').addEventListener('click', function() {
        helpMainMenu.classList.add('d-none');
        tutorialDiapositivas.classList.add('d-none');
        helpCardsContent.classList.remove('d-none');
    });

    // Volver desde FAQ
    document.getElementById('backToHelpMenuFromCards').addEventListener('click', function() {
        helpCardsContent.classList.add('d-none');
        helpMainMenu.classList.remove('d-none');
    });

    // Mostrar Tutorial
    document.getElementById('showTutorialBtn').addEventListener('click', function() {
        helpMainMenu.classList.add('d-none');
        helpCardsContent.classList.add('d-none');
        tutorialDiapositivas.classList.remove('d-none');
    });

    // Volver desde Tutorial
    document.getElementById('backToHelpMenu').addEventListener('click', function() {
        tutorialDiapositivas.classList.add('d-none');
        helpMainMenu.classList.remove('d-none');
    });
});


    // Botón flotante que abre el Centro de Ayuda (si existe en tu HTML principal).
    const toggleHelpBtn = document.getElementById('toggleAyudaBtn2'); // ¡Verifica que este ID sea el correcto en tu HTML!
    if (toggleHelpBtn) {
        toggleHelpBtn.addEventListener('click', function () {
            const helpModal = new bootstrap.Modal(helpCenterModalEl);
            helpModal.show(); // Abre el modal del centro de ayuda.
            // Restablece el estado del modal al abrirlo, mostrando el menú principal.
            mainMenu.classList.remove('d-none');
            tutorialDiapositivas.classList.add('d-none');
            helpCardsContent.classList.add('d-none');
        });
    }


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
        text: 'Usa estas credenciales:<br><strong>Usuario:</strong> 12345678',
        attachTo: { element: '#auth_identificacion', on: 'bottom' },
        buttons: [
            { text: 'Atrás', action: tour.back },
            { text: 'Siguiente', action: tour.next }
        ],
        when: {
            show: () => {
                const input = document.getElementById('auth_identificacion');
                if (input) input.value = '12345678';
            }
        }
    });

    // Paso 4: Ingresar Contraseña
    tour.addStep({
        title: 'Contraseña',
        text: 'Introduce la contraseña:<br><strong>123****</strong>',
        attachTo: { element: '#auth_password', on: 'bottom' },
        buttons: [
            { text: 'Atrás', action: tour.back },
            { text: 'Siguiente', action: tour.next }
        ],
        when: {
            show: () => {
                const input = document.getElementById('auth_password');
                if (input) input.value = '12345678';
            }
        }
    });
// Paso 5: Validar credenciales (redirige a mockup)
tour.addStep({
    title: 'Validar Acceso',
    text: 'Haz clic en <strong>Validar</strong> para continuar',
    attachTo: { element: '#submitAuthForm', on: 'bottom' },
    buttons: [
        { text: 'Atrás', action: tour.back },
        { 
            text: 'Siguiente',
            action: () => {
                // Guardamos el paso y redirigimos a la vista mockup
                localStorage.setItem('tutorialStep', 6);
                window.location.href = "{{ route('public.apoyoGuiaSolicitud') }}";
            }
        }
    ]
});


    // // Paso 6: Formulario de Evento
    // tour.addStep({
    //     title: 'Formulario de Evento',
    //     text: 'Aquí puedes diligenciar la información de tu evento.',
    //     attachTo: { element: '#formularioEvento', on: 'top' },
    //     buttons: [
    //         { text: 'Atrás', action: tour.back },
    //         { text: 'Siguiente', action: tour.next }
    //     ]
    // });

    // // Paso 7: Enviar Solicitud
    // tour.addStep({
    //     title: 'Enviar Solicitud',
    //     text: 'Cuando completes todos los campos, haz clic aquí para enviar la solicitud.',
    //     attachTo: { element: '#btnCrearEvento', on: 'bottom' },
    //     buttons: [
    //         { text: 'Atrás', action: tour.back },
    //         { text: 'Finalizar', action: tour.complete }
    //     ]
    // });

    // --- BOTÓN FLOTANTE DE AYUDA ---
   
    const toggleAyudaBtn = document.getElementById('toggleAyudaBtn');
    if (toggleAyudaBtn) {
        toggleAyudaBtn.addEventListener('click', function () {
            const helpModalEl = document.getElementById('helpCenterModal');
            const helpModal = bootstrap.Modal.getOrCreateInstance(helpModalEl);
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


    document.getElementById('helpCenterModal').addEventListener('hidden.bs.modal', function () {
        document.body.classList.remove('modal-open');
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(el => el.remove());
    });

    document.getElementById('toggleAyudaBtn').addEventListener('click', function () {
        // Mostrar el modal de la guía de ayuda
        const modal = new bootstrap.Modal(document.getElementById('helpCenterModal'));
        modal.show();
    });
    

});

</script>




@endpush
