@extends('layouts.public')

@section('content')
    <div class="container">
        <h1 class="text-center my-4">Eventos Públicos</h1>

        <!-- Contenedor de eventos con scroll -->
        <div style="max-height: 80vh; overflow-y: auto;">
            <div class="row">
                @foreach($eventos as $evento)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <!-- Nombre del evento -->
                            <h5 class="card-title p-3">{{ $evento->nomEvento }}</h5>

                            <!-- Imagen de publicidad (placeholder si no hay imagen) -->
                            @if($evento->publicidad)
                                <img src="https://via.placeholder.com/400x150" class="card-img-top" alt="Publicidad" style="height: 150px; object-fit: cover;">
                            @endif

                            <div class="card-body">
                                <!-- Categoría (etiqueta) -->
                                <span class="badge bg-primary mb-2">
                                    <i class="bi bi-tag"></i> {{ $evento->categoria }}
                                </span>

                                <!-- Descripción con icono -->
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-card-text me-2"></i>
                                    <p class="card-text mb-0">{{ $evento->descripcion }}</p>
                                </div>

                                <!-- Fecha del evento con icono -->
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-calendar-event me-2"></i>
                                    <p class="card-text mb-0">{{ $evento->fecha }}</p>
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection