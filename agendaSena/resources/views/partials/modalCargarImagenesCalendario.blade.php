<div class="modal fade" id="modalCalendarioMensual" tabindex="-1" aria-labelledby="modalCalendarioMensualLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCalendarioMensualLabel">Diseño mensual del calendario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="container calendario-subida">
                    <div class="row">
                        @php
                            $meses = [
                                'Enero', 'Febrero', 'Marzo', 'Abril',
                                'Mayo', 'Junio', 'Julio', 'Agosto',
                                'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                            ];
                        @endphp

                        @foreach ($meses as $mes)
                            @php 
                                $mesId = strtolower($mes); 
                                $rutaWeb = 'storage/calendario/' . $mesId . '.jpg'; // Ruta para mostrar en <img>
                                $rutaStorage = storage_path('app/public/calendario/' . $mesId . '.jpg'); // Ruta real para verificar existencia
                                $imagenExiste = file_exists($rutaStorage);
                            @endphp

                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="card h-100 shadow-sm text-center p-3 calendario-card-{{ $mesId }}"
                                    style="border: 2px dashed #ccc;">
                                    <!-- FORMULARIO PARA SUBIR IMAGEN -->
                                    <form enctype="multipart/form-data" id="form-{{ $mesId }}">
                                        @csrf
                                        <input type="hidden" name="mes" value="{{ $mes }}">

                                        <!-- SELECCIÓN DE IMAGEN -->
                                        <label for="input-{{ $mesId }}" style="display: block; cursor: pointer;">
                                            <input type="file" name="imagen_{{ $mesId }}" id="input-{{ $mesId }}"
                                                class="d-none" accept="image/*"
                                                onchange="previewImage(event, '{{ $mesId }}')">
                                            <div>
                                                <i class="bx bx-plus" style="font-size: 2rem; color: #999;"></i>
                                                <div class="text-muted">
                                                    {{ $imagenExiste ? 'Cambiar imagen de' : 'Agregar' }} {{ $mes }}
                                                </div>
                                            </div>
                                        </label>

                                        <!-- VISTA PREVIA DE LA IMAGEN -->
                                        <div id="preview-{{ $mesId }}" class="mt-2" style="display: {{ $imagenExiste ? 'block' : 'none' }};">
                                            <img src="{{ $imagenExiste ? asset($rutaWeb) : '' }}" alt="Vista previa" class="img-fluid rounded"
                                                id="preview-img-{{ $mesId }}">
                                        </div>

                                        <!-- BOTÓN DE ENVIAR -->
                                        <button type="submit" class="btn btn-primary mt-3" style="display: none;"
                                            id="submit-{{ $mesId }}">Guardar imagen</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event, mesId) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const previewImg = document.getElementById('preview-img-' + mesId);
                previewImg.src = e.target.result;

                document.getElementById('preview-' + mesId).style.display = 'block';
                document.getElementById('submit-' + mesId).style.display = 'inline-block';
            };
            reader.readAsDataURL(file);
        }
    }

  document.addEventListener('DOMContentLoaded', () => {
    const formularios = document.querySelectorAll('form[id^="form-"]');

    formularios.forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(form);

            // Buscar el botón de submit dentro del formulario actual
            const boton = form.querySelector('button[type="submit"]');

            try {
                const response = await fetch("{{ route('calendario.subirMes') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                if (response.ok) {
                    // Desactiva el botón tras éxito
                    boton.disabled = true;
                    notyf.success('✅ Imagen subida correctamente');
                } else {
                    notyf.error('❌ Error al subir la imagen');
                }

            } catch (error) {
                notyf.error('⚠️ Ocurrió un error inesperado');
            }
        });
    });
});

</script>
