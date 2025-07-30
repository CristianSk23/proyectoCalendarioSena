@php
    $ocultarBanner = true;
    $ocultarEventDetails = true;
     $ocultarPublicidad = true; 
     $ocultarBannerGuia = true;
@endphp



        {{-- ================================================================================================  --}}    
        {{--  ESTO es solo un apoyo visual para la ayuda guiada, para solicitar un evento desde pagina publica --}}
        {{-- ================================================================================================  --}}


                
@extends('layouts.public')

@section('content')




<h1 class="h2 mb-4" style="color: grey; text-shadow: -1px 0 green, 0 1px green, 1px 0 white, 0 -1px white;">
    📝 Solicitar Evento (Guía)
</h1>

<form class="bg-white p-4 rounded shadow">
    @csrf
<div id="formularioEvento">
    <h3>Formulario Simulado de Evento</h3>
    <!-- Encargado -->
    <div class="mb-3 position-relative" id="Formulario1">
        <label class="form-label">Encargado del Evento:</label>
        <input type="text" class="form-control" placeholder="Buscar participante...Pedro sandoval">
       
    </div>

    <!-- Espacio -->
    <div class="mb-3 position-relative">
        <label class="form-label">Espacio del Evento:</label>
        <input type="text" class="form-control" placeholder="Buscar ambiente...Biblioteca">
    </div>

    <!-- Fecha -->
    <div class="mb-3">
        <label class="form-label">Fecha:</label>
        <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
    </div>

    <!-- Horario -->
    <div class="mb-3">
        <label class="form-label">Horario del Evento:</label>
        <div class="row">
            <div class="col-md-6">
                <input type="time" class="form-control" value="08:00">
            </div>
            <div class="col-md-6">
                <input type="time" class="form-control" value="10:00">
            </div>
        </div>
    </div>

    <!-- Nombre -->
    <div class="mb-3">
        <label class="form-label">Nombre del Evento:</label>
        <input type="text" class="form-control" value="Taller interactivo">
    </div>

    <!-- Descripción -->
    <div class="mb-3">
        <label class="form-label">Descripción:</label>
        <textarea class="form-control">Ejemplo de Evento Te invitams a participar https://www.youtube.com/@CDTISENA</textarea>
    </div>

    <!-- Aforo -->
    <div class="mb-3">
        <label class="form-label">Aforo del Evento:</label>
        <input type="number" class="form-control" value="100">
    </div>

    <!-- Ficha -->
    <div class="mb-3 position-relative">
        <label class="form-label">Ficha:</label>
        <input type="text" class="form-control" placeholder="Buscar ficha...1234833" value="123456">
    </div>

    <!-- Categoría -->
    <div class="mb-3">
        <label class="form-label">Categoría:</label>
        <select class="form-select">
            <option>Conversatorio</option>
        </select>
    </div>

    <!-- Publicidad -->
    <div class="mb-3">
        <label class="form-label">Publicidad:</label>
        <input type="file" class="form-control">
    </div>

    <!-- Estado -->
    <div class="mb-3">
        <label class="form-label">Estado del Evento:</label>
        <select class="form-select">
            <option selected>Separado</option>
        </select>
    </div>

    <button type="button" class="btn btn-success" id="enviar_btn">
        Solicitar Evento
    </button>
</form>
</div>

@endsection
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tour = new Shepherd.Tour({
        defaultStepOptions: {
            cancelIcon: { enabled: true },
            classes: 'shadow bg-white rounded',
            scrollTo: { behavior: 'smooth', block: 'center' }
        }
    });

    // Paso 6: Formulario Mockup
    tour.addStep({
        title: 'Formulario de Evento',
        text: 'Aquí puedes diligenciar la información de tu evento',
        attachTo: { element: '#Formulario1', on: 'top' },
        buttons: [
            { text: 'Atrás', action: () => {
                // Si quisieras volver atrás al login real
                localStorage.setItem('tutorialStep', 5);
                window.history.back();
            }},
            { text: 'Siguiente', action: () => {
                localStorage.setItem('tutorialStep', 7);
                tour.show(1);
            }}
        ]
    });

// Paso 7: Enviar Solicitud
tour.addStep({
    title: 'Enviar Solicitud',
    text: 'Haz clic aquí para finalizar la guía.',
    attachTo: { element: '#enviar_btn', on: 'bottom' },
    buttons: [
        { 
            text: 'Atrás', 
            action: () => { 
                localStorage.setItem('tutorialStep', 5); 
                tour.show(5); 
            } 
        },
        { 
            text: 'Finalizar', 
            action: () => {
                localStorage.removeItem('tutorialStep');
                tour.complete(); // 🔹 Cierra el tour

                // Esperamos un poco para que cierre Shepherd antes de abrir SweetAlert
                setTimeout(() => {
                    Swal.fire({
                        title: '🎉 ¡Felicidades!',
                        text: 'Has completado la guía de solicitud de eventos.',
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#28a745',
                        background: '#f8f9fa',
                        color: '#212529',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    }).then(() => {
                        window.location.href = "{{ route('public.index') }}";
                    });
                }, 400); // pequeño retraso para que no se solapen
            } 
        }
    ],
    when: {
        show: () => {
            const btn = document.getElementById('btnCrearEvento');
            if (btn) btn.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
});


    // Retomar el tour en el paso guardado
    const currentStep = parseInt(localStorage.getItem('tutorialStep')) || 6;
    if (currentStep >= 6) {
        setTimeout(() => tour.start(), 500);
    }
});
</script>
