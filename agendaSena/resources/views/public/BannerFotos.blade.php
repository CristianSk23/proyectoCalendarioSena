
  
  
  
  <!-- Bloque BANNER -->




    
    @if(!isset($ocultarBanner) || !$ocultarBanner)
    @if(isset($imagenesBanner) && $imagenesBanner->isNotEmpty())
        <div id="bannerCarousel" class="carousel slide mb-4 position-relative" data-bs-ride="carousel" data-bs-interval="5000" data-bs-wrap="true">

            <!-- Botón fullscreen (abre modal) -->
            <!-- Botón de pantalla completa -->
<button type="button" class="btn btn-sm btn-dark btn-fullscreen-banner" data-bs-toggle="modal" data-bs-target="#modalFullscreenBanner" title="Pantalla completa">
    <i class="bi bi-arrows-fullscreen"></i>
</button>


            <div class="carousel-inner">
                @foreach($imagenesBanner as $index => $banner)
                    @php
                        $ruta = $banner->ruta ?? $banner->publicidad ?? null;
                        $rutaImagen = $ruta ? public_path('storage/' . $ruta) : null;
                    @endphp

                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        @if($ruta && file_exists($rutaImagen))
                            <img src="{{ asset('storage/' . $ruta) }}" class="d-block bannerFotos-img-contain" alt="Foto de evento">
                        @else
                            <div class="d-flex align-items-center justify-content-center text-white w-100 h-100 bg-secondary" style="height: 400px;">
                                <p class="m-0">Imagen no disponible</p>
                            </div>
                        @endif

                        <div class="carousel-caption d-none d-md-block">
                            <div class="banner-caption-bg">
                                <h5 class="banner-caption-text">
                                    {{ $banner->evento->nomEvento ?? 'Evento sin nombre' }}
                                </h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    @else
        <div class="mb-4" style="aspect-ratio: 14 / 10; background-color: #ccc; display: flex; align-items: center; justify-content: center;">
            <p class="text-muted">No hay imágenes disponibles por el momento.</p>
        </div>
    @endif
@endif
  <!-- Modal fullscreen de banner -->
<div class="modal fade" id="modalFullscreenBanner" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content bg-black">
      <div class="modal-header border-0">
        <h5 class="modal-title text-white">Vista completa del banner</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body p-0">
        <div id="carouselFullscreen" class="carousel slide h-100" data-bs-ride="carousel">
          <div class="carousel-inner h-100">
            @foreach($imagenesBanner as $index => $banner)
              @php
                $ruta = $banner->ruta ?? $banner->publicidad ?? null;
                $rutaImagen = $ruta ? public_path('storage/' . $ruta) : null;
              @endphp
              <div class="carousel-item h-100 {{ $loop->first ? 'active' : '' }}">
                @if($ruta && file_exists($rutaImagen))
                  <img src="{{ asset('storage/' . $ruta) }}" class="d-block w-100 h-100 img-fullscreen-modal" alt="Evento">
                @else
                  <div class="d-flex justify-content-center align-items-center h-100 bg-secondary">
                    <p class="text-white">Imagen no disponible</p>
                  </div>
                @endif
              </div>
            @endforeach
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselFullscreen" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselFullscreen" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- BANNER FOTOS -->