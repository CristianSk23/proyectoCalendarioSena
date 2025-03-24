@extends('layouts.public')

@section('content')
    <div class="container">
        <h1 class="text-center my-4">Eventos Públicos</h1>

        <!-- Contenedor de eventos con scroll -->
        <div class="eventos-scroll-container">
            <div class="row">
                @foreach($eventos as $evento)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $evento->nomEvento }}</h5>
                                <p class="card-text">{{ $evento->descripcion }}</p>
                                <a href="{{ route('public.show', $evento->idEvento) }}" class="btn btn-primary">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection