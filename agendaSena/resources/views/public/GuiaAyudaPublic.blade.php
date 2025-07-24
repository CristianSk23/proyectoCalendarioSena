<div class="modal fade" id="helpCenterModal" tabindex="-1" aria-labelledby="helpCenterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content" style="background-color: #f8f9fa;"> {{-- Fondo claro para mejor lectura del tutorial --}}
            <div class="modal-header border-0 position-absolute top-0 start-0" style="z-index: 10;">
                <h5 class="modal-title text-dark shadow-lg" id="helpCenterModalLabel">
                    Centro de Ayuda
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                {{-- Contenido principal del Centro de Ayuda --}}
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

                {{-- Contenedor para el tutorial de diapositivas (inicialmente oculto) --}}
                <div id="tutorialDiapositivas" class="d-none h-100 position-absolute top-0 start-0 w-100 bg-light p-4 overflow-auto">
                    <button class="btn btn-secondary mb-3" id="backToHelpMenu">
                        <i class="bi bi-arrow-left me-2"></i> Volver al Menú de Ayuda
                    </button>
                    <div id="tutorialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false"> {{-- Intervalo false para control manual --}}
                        <div class="carousel-inner">
                            {{-- Aquí se generarán dinámicamente las diapositivas del tutorial --}}
                           {{-- Ver siguiente sección --}}
                            



                                        <h1>Guia para Agenda CDTI-SENA</h1><h3 class="step-title">1: Bienvenido</h3>
                                        <p class="step-description">Agenda de Eventos culturales CDTI </p>
                                        <p class="step-description">Repasemos como solicitar un evento.</p>
                                        <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_08bf6d3b-7880-400b-8d9c-9d7e2553d7c7.png">
                                        <p class="separator">&nbsp;<p>
                                            <h3 class="step-title">2: Clic Boton “Solicitar Evento”</h3>
                                        <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_59efd28a-ccfe-4978-abfe-1f802f70e405.png">
                                        <p class="separator">&nbsp;<p>
                                            <h3 class="step-title">3: Clic Boton “Validar”</h3>
                                            <p class="step-description">Se debe ingresar credenciales autorizadas</p>
                                            <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_96080e99-478e-4520-8606-8f2565644ca1.png">
                                            <p class="separator">&nbsp;<p><h3 class="step-title">4: Persona que solicita</h3>
                                            <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_5159fde7-ea45-4f3d-a691-7a9df38345b0.png">
                                            <p class="separator">&nbsp;<p>
                                                <h3 class="step-title">5: Lugar del evento</h3><img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_9bbdf7cb-ec55-4e4c-ab82-20cde0deba71.png">
                                            <p class="separator">&nbsp;<p>
                                                <h3 class="step-title">6: Ingresar fecha del evento</h3>
                                                <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_02d90320-c2ae-409a-810f-70bbc668baca.png">
                                            <p class="separator">&nbsp;<p>
                                                <h3 class="step-title">7: Hora</h3><p class="step-description">Ingresar hora inicio </p>
                                                <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_4f763454-329f-484f-844c-026990de712f.png">
                                            <p class="separator">&nbsp;<p>
                                                <h3 class="step-title">8: Hora</h3>
                                                <p class="step-description">Ingresar hora fin</p>
                                                <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_0748ed2e-4843-41e9-a301-f9621caabc43.png">
                                                <p class="separator">&nbsp;<p>
                                                    <h3 class="step-title">9: Define un nombre de evento</h3>
                                                <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_c9816869-4c10-4a9d-8a3b-b05d263ec2f6.png">
                                            <p class="separator">&nbsp;<p>
                                                <h3 class="step-title">10: Detalles</h3>
                                                <p class="step-description">Describe el Evento (motivo, dirigido a quien, celebración, agrega Link o enlaces )</p>
                                                <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_3a3153f3-059f-48a5-96c0-00df00df4493.png">
                                                <p class="separator">&nbsp;<p><h3 class="step-title">11: Aforo</h3><p class="step-description">Cantidad de personas esperadas aprox.</p>
                                                <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_ab1533d2-984f-4054-ab4a-5d3f68bf6529.png">
                                                    <p class="separator">&nbsp;<p><h3 class="step-title">12: Ficha</h3><p class="step-description">ingresa si asistirá alguna ficha en especifico</p>
                                                    <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_667df1d0-a567-4f62-84f0-bc70a1f4ac3f.png">
                                                        <p class="separator">&nbsp;<p><h3 class="step-title">13: Categoria</h3><p class="step-description">Selecciona una categoría que se identifique con tu evento.</p>
                                                        <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_71a0b25e-71b3-4575-a4a2-67cee887583e.png">
                                                            <p class="separator">&nbsp;<p><h3 class="step-title">14: Lista de categorias</h3><img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_3099c0f8-1e5c-4874-ae1b-a193a59734ba.png">
                                                            <p class="separator">&nbsp;<p><h3 class="step-title">15: Publicidad</h3>
                                                            <p class="step-description">Selecciona afiche  o publicidad que tengas para el evento (imagen)</p>
                                                            <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_112c730e-ac1f-499a-8a74-4549bc60d016.png">
                                                            <p class="separator">&nbsp;<p><h3 class="step-title">16: Clic Boton  “Solicitar Evento”</h3>
                                                            <p class="step-description">Una vez termines de diligenciar tu solicitud, verifica los datos sean correctos y presiona clic en solicitar Evento.</p><p class="step-description">Una vez Enviado quedara pendiente por confirmar</p>
                                                            <img class="step-screenshot" src="https://driveway-media-prd.s3.amazonaws.com/screenshots/abd3e711-c336-4610-b138-632e0aef2305/content_364b2f7b-ad71-4e4c-844a-35fcc01741fb.png">
                                            <p class="separator">&nbsp;<p>

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

                {{-- Contenedor para las Tarjetas de Ayuda (inicialmente oculto) --}}
                <div id="helpCardsContent" class="d-none h-100 position-absolute top-0 start-0 w-100 bg-light p-4 overflow-auto">
                    <button class="btn btn-secondary mb-3" id="backToHelpMenuFromCards">
                        <i class="bi bi-arrow-left me-2"></i> Volver al Menú de Ayuda
                    </button>
                    <h3 class="mb-4">Tarjetas de Ayuda / Preguntas Frecuentes</h3>
                    {{-- Aquí irían tus tarjetas de ayuda, por ejemplo: --}}
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    ¿Cómo solicito un evento nuevo?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Para solicitar un evento, haz clic en el botón **"Solicitar Evento"** en la pantalla principal. Luego, sigue los pasos llenando la información requerida como la persona que solicita, lugar, fecha y hora.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    ¿Puedo editar un evento ya enviado?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Actualmente, los eventos enviados quedan pendientes de confirmación. Para realizar cambios, por favor contacta al administrador del sistema.
                                </div>
                            </div>
                        </div>
                        {{-- Añade más tarjetas de ayuda aquí --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
 
document.addEventListener('DOMContentLoaded', function() {
    const toggleAyudaBtn = document.getElementById('toggleAyudaBtn');
    const helpCenterModal = new bootstrap.Modal(document.getElementById('helpCenterModal'));
    const showTutorialBtn = document.getElementById('showTutorialBtn');
    const showHelpCardsBtn = document.getElementById('showHelpCardsBtn');
    const tutorialDiapositivas = document.getElementById('tutorialDiapositivas');
    const helpCardsContent = document.getElementById('helpCardsContent');
    const backToHelpMenuBtn = document.getElementById('backToHelpMenu');
    const backToHelpMenuFromCardsBtn = document.getElementById('backToHelpMenuFromCards');
    const helpCenterMainContent = document.querySelector('#helpCenterModal .container-fluid'); // El contenido principal de los botones de Ayuda

    // Cuando se haga clic en el botón flotante de Ayuda
    toggleAyudaBtn.addEventListener('click', function() {
        helpCenterModal.show();
        // Asegúrate de que el menú principal de ayuda esté visible al abrir
        helpCenterMainContent.classList.remove('d-none');
        tutorialDiapositivas.classList.add('d-none');
        helpCardsContent.classList.add('d-none');
    });

    // Cuando se haga clic en "Tutorial Paso a Paso"
    showTutorialBtn.addEventListener('click', function() {
        helpCenterMainContent.classList.add('d-none'); // Oculta los botones principales
        tutorialDiapositivas.classList.remove('d-none'); // Muestra las diapositivas
        // Reinicia el carrusel a la primera diapositiva cada vez que se abre
        const tutorialCarousel = new bootstrap.Carousel(document.getElementById('tutorialCarousel'));
        tutorialCarousel.to(0);
    });

    // Cuando se haga clic en "Tarjetas de Ayuda (FAQ)"
    showHelpCardsBtn.addEventListener('click', function() {
        helpCenterMainContent.classList.add('d-none'); // Oculta los botones principales
        helpCardsContent.classList.remove('d-none'); // Muestra las tarjetas de ayuda
    });

    // Botón "Volver al Menú de Ayuda" desde el tutorial de diapositivas
    backToHelpMenuBtn.addEventListener('click', function() {
        tutorialDiapositivas.classList.add('d-none'); // Oculta las diapositivas
        helpCenterMainContent.classList.remove('d-none'); // Muestra los botones principales
    });

    // Botón "Volver al Menú de Ayuda" desde las tarjetas de ayuda
    backToHelpMenuFromCardsBtn.addEventListener('click', function() {
        helpCardsContent.classList.add('d-none'); // Oculta las tarjetas
        helpCenterMainContent.classList.remove('d-none'); // Muestra los botones principales
    });

    // Opcional: Para el walkthrough interactivo (Intro.js o Shepherd.js)
    // Si decides implementarlo, lo activarías aquí, por ejemplo:
    // const startWalkthroughBtn = document.getElementById('startWalkthroughBtn'); // Un botón que podrías añadir en la bienvenida
    // if (startWalkthroughBtn) {
    //     startWalkthroughBtn.addEventListener('click', function() {
    //         helpCenterModal.hide(); // Cierra el modal de ayuda
    //         // Inicia tu tour interactivo aquí (ej: introJs().start();)
    //         // Asegúrate de que este tour solo se muestre la primera vez para un usuario.
    //     });
    // }
});










 </script>
@endpush