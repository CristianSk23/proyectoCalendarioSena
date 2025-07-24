
    
    
    
    <div class="modal fade" id="fullscreenBannerModal" tabindex="-1" aria-labelledby="fullscreenBannerModalLabel" aria-hidden="true">
        {{-- La clase clave es "modal-fullscreen" para que ocupe toda la pantalla --}}
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content" style="background-color: #000;">
                
                <div class="modal-header border-0 position-absolute top-0 start-0" style="z-index: 10;">
                    <h5 class="modal-title text-white shadow-lg" id="fullscreenBannerModalLabel">
                        {{-- Título dinámico según el contenido --}}
                        @if($imagenesPublicidad->isNotEmpty())
                            Próximos Eventos
                        @else
                            Eventos Recientes
                        @endif
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-0">
                    {{-- Lógica Principal: Muestra publicidad de eventos futuros --}}
                    @if($imagenesPublicidad->isNotEmpty())
                        
                        <div id="publicidadCarousel" class="carousel slide h-100" data-bs-ride="carousel" data-bs-interval="3000" data-bs-wrap="true">
                            <div class="carousel-inner h-100">
                                @foreach($imagenesPublicidad as $publicidad)
                                    <div class="carousel-item h-100 {{ $loop->first ? 'active' : '' }}">
                                        @php
                                            $rutaPublicidad = $publicidad->publicidad;
                                            $rutaCompleta = $rutaPublicidad ? public_path('storage/' . $rutaPublicidad) : null;
                                        @endphp
                                        @if($rutaCompleta && file_exists($rutaCompleta))
                                            
                                            <img src="{{ asset('storage/' . $rutaPublicidad) }}" class="d-block mx-auto" style="object-fit: contain; width: 100%; height: 100%; background-color: #000;" alt="Publicidad: {{ $publicidad->nomEvento }}">

                                            @else
                                            <div class="d-flex align-items-center justify-content-center h-100 text-white bg-dark">
                                                <p>Imagen no disponible</p>
                                            </div>
                                        @endif
                                        <div class="carousel-caption d-none d-md-block">
                                            <h3 class="banner-caption-text" style="background-color: rgba(0,0,0,0.5); padding: 0.5rem; border-radius: 5px;">{{ $publicidad->nomEvento }}</h3>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#publicidadCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Anterior</span></button>
                            <button class="carousel-control-next" type="button" data-bs-target="#publicidadCarousel" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Siguiente</span></button>
                        </div>

                    {{-- Lógica de Respaldo: Si no hay publicidad, muestra fotos de eventos realizados --}}
                    @elseif($imagenesBanner->isNotEmpty())

                        <div id="fotosEventosCarousel" class="carousel slide h-100" data-bs-ride="carousel" data-bs-interval="3000" data-bs-wrap="true">
                            <div class="carousel-inner h-100">
                                @foreach($imagenesBanner as $banner)
                                    <div class="carousel-item h-100 {{ $loop->first ? 'active' : '' }}">
                                        @php
                                            $ruta = $banner->ruta ?? null;
                                            $rutaImagen = $ruta ? public_path('storage/' . $ruta) : null;
                                        @endphp
                                        @if($ruta && file_exists($rutaImagen))
                                            <img src="{{ asset('storage/' . $ruta) }}" class="d-block bannerPublicidad-img-cover" alt="Foto evento: {{ $banner->evento->nomEvento ?? '' }}">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100 text-white bg-dark">
                                                <p>Imagen no disponible</p>
                                            </div>
                                        @endif
                                        <div class="carousel-caption d-none d-md-block">
                                            <h3 class="banner-caption-text" style="background-color: rgba(0,0,0,0.5); padding: 0.5rem; border-radius: 5px;">{{ $banner->evento->nomEvento ?? 'Evento sin nombre' }}</h3>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#fotosEventosCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Anterior</span></button>
                            <button class="carousel-control-next" type="button" data-bs-target="#fotosEventosCarousel" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Siguiente</span></button>
                        </div>

                    {{-- Mensaje final si no hay ninguna imagen --}}
                    @else
                        <div class="d-flex vh-100 align-items-center justify-content-center text-center text-white">
                            <div>
                                <i class="bi bi-camera-reels fs-1"></i>
                                <h3 class="mt-3">No hay imágenes para mostrar</h3>
                                <p class="text-white-50">Vuelve a visitarnos pronto.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>