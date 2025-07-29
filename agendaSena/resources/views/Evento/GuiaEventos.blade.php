<div class="modal fade" id="helpCenterModal" tabindex="-1" aria-labelledby="helpCenterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content" style="background-color: #f8f9fa;">
            <div class="modal-header border-0 position-absolute top-0 start-0" style="z-index: 10;">
                <h5 class="modal-title text-dark shadow-lg" id="helpCenterModalLabel">Centro de Ayuda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
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
    // --- Función para esperar elementos dinámicos
    // Se mantiene esta función ya que es crucial para los elementos que aparecen o se ocultan dinámicamente.
    function esperarElemento(selector, autoClick = false) {
        return new Promise((resolve) => {
            const checkExist = setInterval(() => {
                const elem = document.querySelector(selector);
                if (elem) {
                    clearInterval(checkExist);
                    elem.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    if (autoClick) elem.click();
                    resolve();
                }
            }, 300); // Revisa cada 300ms
        });
    }

    // --- Configuración de Shepherd Tour
    const tour = new Shepherd.Tour({
        defaultStepOptions: {
            cancelIcon: { enabled: true },
            classes: 'shadow bg-white rounded',
            scrollTo: { behavior: 'smooth', block: 'center' }
        },
        useModalOverlay: true
    });

    // Pasos del tour
    tour.addStep({
        title: '👋 Bienvenido',
        text: 'Este tutorial te mostrará cómo confirmar un evento desde la campana de notificaciones.',
        buttons: [
            { text: 'Cancelar', action: tour.cancel },
            { text: 'Comenzar', action: tour.next }
        ]
    });

    tour.addStep({
        title: 'Campana de Notificaciones',
        text: 'Haz clic en la campana para ver los eventos pendientes.',
        // CUIDADO: Este selector debe coincidir con el ID real de tu campana.
        // Si tu campana está en otro archivo, verifica su ID.
        // Si el ID de tu campana es 'icono-notificacion' como en el ejemplo anterior, entonces:
        attachTo: { element: '#icono-notificacion', on: 'bottom' },
        buttons: [
            { text: 'Atrás', action: tour.back },
            { text: 'Siguiente', action: tour.next }
        ],
        // Aquí también se corrige el selector para que coincida con el ID de la campana.
        beforeShowPromise: () => esperarElemento('#icono-notificacion', true)
    });

tour.addStep({
    title: 'Eventos Pendientes',
    text: 'Aquí verás los eventos que requieren confirmación.',
    attachTo: { element: '#eventosList', on: 'top' },
    buttons: [
        { text: 'Atrás', action: tour.back },
        { text: 'Siguiente', action: tour.next }
    ],
    beforeShowPromise: () => {
        return new Promise((resolve) => {
            const modal = document.getElementById('modalNotificaciones'); // ID real de tu modal
            if (!modal) {
                console.warn('⚠️ Modal de notificaciones no encontrado');
                resolve();
                return;
            }

            const esperar = () => {
                // Esperamos que #listaEventosPendientes exista dentro del modal
                const elem = document.querySelector('#eventosList');
                if (elem) {
                    elem.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    resolve();
                    modal.removeEventListener('shown.bs.modal', esperar);
                }
            };

            // Si el modal ya está visible
            if (modal.classList.contains('show')) {
                esperar();
            } else {
                modal.addEventListener('shown.bs.modal', esperar);
            }
        });
    }
});

tour.addStep({
    title: 'Confirmar Evento Pendiente',
    text: 'Haz clic en el botón <strong class="text-success">Confirmar</strong> para asignar este evento a tu calendario. También puedes <strong class="text-danger">Rechazar</strong> si no aplica.',
    // Target the specific class you've given to your confirm button
    attachTo: { element: '.btn-confirmar', on: 'top' }, 
    buttons: [
        { text: 'Atrás', action: tour.back },
        { text: 'Siguiente', action: tour.next }
    ],
    // Ensure the button is visible before the step appears.
    // autoClick: true could be used here if you want the tour to automatically click 'Confirmar'.
    beforeShowPromise: () => esperarElemento('.btn-confirmar') 
});


// Paso 5: Evento Confirmado y Cierre del Modal (¡Paso clave!)
 tour.addStep({
        title: '¡Evento Confirmado! 🎉',
        text: 'Ahora que has confirmado el evento, el modal de notificaciones se cerrará y podrás ver que los **eventos confirmados** se representan con este color verde en el calendario.',
        // ¡IMPORTANTE! Asegúrate de haber añadido `id="legendContainer"` al `div` padre de tus alertas de leyenda en `index.blade.php`.
        attachTo: { element: '#legendContainer .alert-success', on: 'top' }, 
        buttons: [
            { text: 'Atrás', action: tour.back },
            { text: 'Finalizar', action: tour.complete }
        ],
        // ✨ LÓGICA REFORZADA PARA CERRAR EL MODAL Y LUEGO MOSTRAR EL PASO
        beforeShowPromise: () => {
            return new Promise((resolve) => {
                // *** CAMBIO CLAVE AQUÍ: Ahora buscamos '#eventModal' para cerrar ***
                const notificationModalEl = document.getElementById('eventModal'); 
                
                if (!notificationModalEl) {
                    console.warn('⚠️ El modal de eventos (eventModal) no fue encontrado para cerrarse.');
                    resolve(); // Si no existe el elemento, resolvemos y avanzamos.
                    return;
                }

                let notificationModal = bootstrap.Modal.getInstance(notificationModalEl);

                // Si no se encuentra una instancia de Bootstrap Modal, la creamos.
                // Esto es vital para asegurar que 'hide()' y los eventos funcionen.
                if (!notificationModal) {
                    notificationModal = new bootstrap.Modal(notificationModalEl);
                }

                // Definimos el manejador para el evento 'hidden.bs.modal'.
                // Se disparará cuando el modal esté completamente oculto.
                const modalHiddenHandler = () => {
                    notificationModalEl.removeEventListener('hidden.bs.modal', modalHiddenHandler); // Limpia el listener.
                    resolve(); // Resuelve la promesa, permitiendo que Shepherd.js muestre este paso.
                };

                // Añadimos el listener ANTES de intentar ocultar el modal.
                notificationModalEl.addEventListener('hidden.bs.modal', modalHiddenHandler);

                // Si el modal está actualmente visible, llamamos a hide().
                if (notificationModalEl.classList.contains('show')) {
                    console.log('Cerrando el modal eventModal...');
                    notificationModal.hide(); 
                } else {
                    // Si el modal ya no está visible (ej. el usuario lo cerró manualmente),
                    // resolvemos la promesa inmediatamente para que el tour no se detenga.
                    console.log('El modal de eventos (eventModal) ya estaba cerrado, continuando tour.');
                    resolve(); 
                }

            }).then(() => {
                // Una vez que la promesa del cierre del modal se resuelve (modal oculto),
                // esperamos a que el elemento de la leyenda esté presente para el 'attachTo'.
                return esperarElemento('#legendContainer .alert-success');
            });
        },
        when: {
            // Este hook 'show' se ejecuta DESPUÉS de que el paso del tour se muestra.
            // Aquí solo manejamos el efecto visual de resaltado.
            show: () => {
                const confirmedEventLegend = document.querySelector('#legendContainer .alert-success');
                if (confirmedEventLegend) {
                    confirmedEventLegend.style.transition = 'all 0.5s ease-in-out';
                    confirmedEventLegend.style.transform = 'scale(1.05)';
                    confirmedEventLegend.style.boxShadow = '0 0 15px rgba(25, 135, 84, 0.8)'; // Sombra verde para resaltar.
                }
            }
        }
    });

    // --- Limpieza de Resaltado al Finalizar/Cancelar el Tour ---
    // Esta función se asegura de que el resaltado visual se elimine cuando el tour termina o se cancela.
    const limpiarResaltado = () => {
        const confirmedEventLegend = document.querySelector('#legendContainer .alert-success');
        if (confirmedEventLegend) {
            confirmedEventLegend.style.transform = ''; // Elimina la escala.
            confirmedEventLegend.style.boxShadow = ''; // Elimina la sombra.
        }
    };
    tour.on('complete', limpiarResaltado); // Cuando el tour finaliza.
    tour.on('cancel', limpiarResaltado);   // Cuando el tour es cancelado.

    // --- Lógica para mostrar/ocultar secciones del Centro de Ayuda ---
    const helpCenterModalEl = document.getElementById('helpCenterModal');
    const tutorialDiapositivas = document.getElementById('tutorialDiapositivas');
    const helpCardsContent = document.getElementById('helpCardsContent');
    // Selecciona el contenedor principal del menú del centro de ayuda.
    const mainMenu = helpCenterModalEl.querySelector('.container-fluid.h-100.d-flex'); 

    // Inicialmente, oculta las secciones de tutorial y tarjetas, y muestra el menú principal.
    tutorialDiapositivas.classList.add('d-none');
    helpCardsContent.classList.add('d-none');
    mainMenu.classList.remove('d-none'); 

    // Botón para mostrar el Tutorial Paso a Paso y comenzar el tour de Shepherd.
    const showTutorialBtn = document.getElementById('showTutorialBtn');
    if (showTutorialBtn) {
        showTutorialBtn.addEventListener('click', function () {
            mainMenu.classList.add('d-none'); // Oculta el menú principal.
            tutorialDiapositivas.classList.remove('d-none'); // Muestra las diapositivas del tutorial.
            
            const helpModal = bootstrap.Modal.getInstance(helpCenterModalEl);
            if (helpModal) {
                // Define una función que iniciará el tour DESPUÉS de que el modal de ayuda se oculte.
                const startShepherdTourAfterModalClose = () => {
                    // Elimina el foco para evitar posibles advertencias de accesibilidad.
                    if (document.activeElement && helpCenterModalEl.contains(document.activeElement)) {
                        document.activeElement.blur();
                    }
                    tour.start(); // Inicia el tour de Shepherd.
                    // ¡Importante! Elimina el listener para evitar que se dispare múltiples veces.
                    helpCenterModalEl.removeEventListener('hidden.bs.modal', startShepherdTourAfterModalClose);
                };
                // Añade el listener para el evento 'hidden.bs.modal' al modal de ayuda.
                helpCenterModalEl.addEventListener('hidden.bs.modal', startShepherdTourAfterModalClose);
                helpModal.hide(); // Oculta el modal del centro de ayuda.
            } else {
                tour.start(); // Fallback: si no se puede obtener la instancia del modal, inicia el tour directamente.
            }
        });
    }

    // Botón para mostrar las Tarjetas de Ayuda (FAQ).
    const showHelpCardsBtn = document.getElementById('showHelpCardsBtn');
    if (showHelpCardsBtn) {
        showHelpCardsBtn.addEventListener('click', function () {
            mainMenu.classList.add('d-none'); // Oculta el menú principal.
            helpCardsContent.classList.remove('d-none'); // Muestra las tarjetas de ayuda.
        });
    }

    // Botón para volver al Menú de Ayuda desde el Tutorial.
    const backToHelpMenuBtn = document.getElementById('backToHelpMenu');
    if (backToHelpMenuBtn) {
        backToHelpMenuBtn.addEventListener('click', function () {
            tutorialDiapositivas.classList.add('d-none'); // Oculta las diapositivas del tutorial.
            mainMenu.classList.remove('d-none'); // Muestra el menú principal.
            // Reinicia el carrusel a la primera diapositiva al volver al menú.
            const carousel = bootstrap.Carousel.getInstance(document.getElementById('tutorialCarousel'));
            if (carousel) {
                carousel.to(0);
            }
        });
    }

    // Botón para volver al Menú de Ayuda desde las Tarjetas de Ayuda.
    const backToHelpMenuFromCardsBtn = document.getElementById('backToHelpMenuFromCards');
    if (backToHelpMenuFromCardsBtn) {
        backToHelpMenuFromCardsBtn.addEventListener('click', function () {
            helpCardsContent.classList.add('d-none'); // Oculta las tarjetas de ayuda.
            mainMenu.classList.remove('d-none'); // Muestra el menú principal.
        });
    }

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


    

    // --- Asignar la función eventosSinConfirmar a la campana de notificación ---
    // Esto es crucial para que la campana abra el modal de eventos.
    const iconoNotificacion = document.getElementById('icono-notificacion');
    if (iconoNotificacion) {
        iconoNotificacion.addEventListener('click', eventosSinConfirmar);
    }
    // Si tienes un icono de notificación activa, también podrías querer que abra el modal
    const iconoNotificacionActiva = document.getElementById('icono-notificacion-activa');
    if (iconoNotificacionActiva) {
        iconoNotificacionActiva.addEventListener('click', eventosSinConfirmar);
    }

    // Puedes llamar a eventosSinConfirmar al cargar la página si quieres que el modal se abra automáticamente con eventos pendientes.
    // eventosSinConfirmar(); 

// Eliminar overlay manualmente cuando termine o se cancele el tour
tour.on('complete', () => {
    document.querySelectorAll('.shepherd-modal-overlay-container').forEach(el => el.remove());
});

tour.on('cancel', () => {
    document.querySelectorAll('.shepherd-modal-overlay-container').forEach(el => el.remove());
});
const limpiarBootstrapBackdrop = () => {
    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    document.body.classList.remove('modal-open'); // quita el bloqueo de scroll
    document.body.style.overflow = ''; 
};
beforeShowPromise: () => {
    return new Promise((resolve) => {
        const modalEl = document.getElementById('modalNotificaciones'); // 👈 usa tu ID real
        if (!modalEl) {
            resolve();
            return;
        }

        let modal = bootstrap.Modal.getInstance(modalEl);
        if (!modal) modal = new bootstrap.Modal(modalEl);

        const onHidden = () => {
            modalEl.removeEventListener('hidden.bs.modal', onHidden);
            resolve();
        };

        if (modalEl.classList.contains('show')) {
            modalEl.addEventListener('hidden.bs.modal', onHidden);
            modal.hide();
        } else {
            resolve();
        }
    }).then(() => esperarElemento('#legendContainer .alert-success'));
}


tour.on('complete', limpiarBootstrapBackdrop);
tour.on('cancel', limpiarBootstrapBackdrop);


});



</script>
@endpush