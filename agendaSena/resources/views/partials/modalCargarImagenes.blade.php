<div class="modal fade" id="modalFondos" tabindex="-1" aria-labelledby="modalFondosLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFondosLabel">Selecciona o sube una imagen de fondo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">

                    <!-- Formulario para subir imagen -->
                    <form action="{{ route('fondos.subir') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                        @csrf
                        <div class="input-group">
                            <input type="file" name="imagen" class="form-control" accept="image/*" required>
                            <button type="submit" class="btn btn-success">Subir imagen</button>
                        </div>
                    </form>

                    <!--  con este formulario seleccionamos el fondo -->
                    <form action="{{ route('fondos.seleccionar') }}" method="POST">
                        @csrf
                        <div class="row">
                            @foreach (File::files(public_path('imgLogin')) as $file)
                                @php $nombre = basename($file); @endphp
                                <div class="col-md-3 mb-3 text-center">
                                    <label class="imagen-checkbox" style="cursor: pointer; display: inline-block;">
                                        <input type="checkbox" name="imagenes[]" value="{{ $nombre }}" class="d-none">
                                        <img src="{{ asset('imgLogin/' . $nombre) }}" class="img-fluid rounded shadow-sm">
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Guardar fondo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>