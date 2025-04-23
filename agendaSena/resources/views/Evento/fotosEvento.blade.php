@extends('Layouts.Plantilla')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1 class="form-title">Vista para agregar las fotografías</h1>
        <form id="imageForm" action="{{route('eventos.agregarFotosBd', ['idEvento' => $idEvento])}}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <br>
            <br>
            <div class="image-container mb-3" id="imageContainer">
                <!-- Se insertan los cuadros para subir fotos -->
            </div>
            <br>
            <br>
            <button class="btn btn-success" type="submit">Enviar Fotografías</button>
        </form>
    </div>


    <script>
        const fotografias = @json($fotografiasEvento);
        const MAX_IMAGES = 5;
        const container = document.getElementById('imageContainer');

        function createImageBox(imageUrl, idFoto) {
            const box = document.createElement('div');
            box.className = 'upload-box';

            const img = document.createElement('img');
            img.src = imageUrl;
            box.appendChild(img);

            // Campo oculto con el path (opcional, por si quieres enviar info al backend)
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'imagenesExistentes[]';
            hiddenInput.value = imageUrl;
            box.appendChild(hiddenInput);

            // Botón para eliminar
            const removeBtn = document.createElement('button');
            removeBtn.className = 'remove-btn';
            removeBtn.type = 'button';
            removeBtn.title = 'Eliminar imagen';
            removeBtn.innerHTML = '<i class="bx bx-minus-circle"></i>';

            removeBtn.addEventListener('click', () => {
                if (idFoto) {
                    console.log("Id para eliminar la foto: ", idFoto);

                    eliminarFoto(idFoto)
                        .then(() => {
                            box.remove();
                            if (container.children.length < MAX_IMAGES && !hasUploadBox()) {
                                createUploadBox();
                            }
                        })
                        .catch(error => {
                            console.error('Error al eliminar la imagen:', error);
                        });
                } else {
                    // Imagen recién cargada, solo eliminar visualmente
                    box.remove();
                    if (container.children.length < MAX_IMAGES && !hasUploadBox()) {
                        createUploadBox();
                    }
                }
            });

            box.appendChild(removeBtn);
            container.appendChild(box);
        }

        function createUploadBox() {
            if (container.children.length >= MAX_IMAGES) return;

            const box = document.createElement('div');
            box.className = 'upload-box';

            const label = document.createElement('label');
            label.innerHTML = `
                                                    <div class="plus-icon">+</div>
                                                    <div>Agregar</div>
                                                `;

            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.name = 'imagenes[]';
            input.classList.add('d-none');

            input.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        const img = document.createElement('img');
                        img.src = event.target.result;

                        box.innerHTML = '';
                        box.appendChild(img);
                        box.appendChild(input);

                        const removeBtn = document.createElement('button');
                        removeBtn.className = 'remove-btn';
                        removeBtn.type = 'button';
                        removeBtn.title = 'Eliminar imagen';
                        removeBtn.innerHTML = '<i class="bx bx-minus-circle"></i>';

                        removeBtn.addEventListener('click', () => {
                            box.remove();
                            if (container.children.length < MAX_IMAGES && !hasUploadBox()) {
                                createUploadBox();
                            }
                        });

                        box.appendChild(removeBtn);

                        if (container.children.length < MAX_IMAGES) {
                            createUploadBox();
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });

            label.appendChild(input);
            box.appendChild(label);
            container.appendChild(box);
        }

        function hasUploadBox() {
            return [...container.children].some(child => child.querySelector('input[type="file"]'));
        }

        // 1. Cargar imágenes existentes desde el servidor
        fotografias.forEach(foto => {
            const fullUrl = `/storage/${foto.ruta}`; // Ajusta la propiedad según tu modelo
            const idFoto = foto.idFotografia;
            createImageBox(fullUrl, idFoto);
        });

        // 2. Si hay espacio disponible, crear el primer cuadro para cargar imagen
        if (container.children.length < MAX_IMAGES) {
            createUploadBox();
        }


        async function eliminarFoto(idFoto) {
            try {
                const response = await fetch(`/evento/agregarFotos/eliminar/${idFoto}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                });

                if (!response.ok) {
                    throw new Error('Error al eliminar imagen');
                }

                const data = await response.json();
                console.log('Imagen eliminada con éxito:', data.message);
                return data;

            } catch (error) {
                console.error('Error al eliminar la imagen:', error.message);
            }
        }
    </script>

@endsection