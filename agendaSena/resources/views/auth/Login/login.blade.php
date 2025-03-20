{{-- @extends('Layouts.Plantilla')

@section('content') --}}

<head>
    @vite('resources/css/app.css')
</head>

<div class="bg-dark vh-100">
    <div class="row h-100">
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <img src="{{ asset('css/loginResources/login_sena2.jpg') }}" class="img-fluid" alt="login-image" />
        </div>

        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <form class="w-75" method="POST" action="{{ route('login.ingresar') }}">
                @csrf
                <div class="mb-4">
                    <h3 class="text-dark display-4">Ingresar</h3>
                    <p class="text-dark small mt-4">¿No tienes una cuenta?
                        <a href="javascript:void(0);" class="text-primary font-weight-bold">Registrar</a>
                    </p>
                </div>

                <div class="mb-4">
                    <label class="text-dark small">Correo Electrónico</label>
                    <div class="input-group">
                        <input name="email" type="text" required class="form-control border-bottom border-dark"
                            placeholder="Ingresar correo" />
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent border-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-4 h-4"
                                    viewBox="0 0 682.667 682.667">
                                    <g clip-path="url(#a)" transform="matrix(1.33 0 0 -1.33 0 682.667)">
                                        <path fill="none" stroke-miterlimit="10" stroke-width="40"
                                            d="M452 444H60c-22.091 0-40-17.909-40-40v-39.446l212.127-157.782c14.17-10.54 33.576-10.54 47.746 0L492 364.554V404c0 22.091-17.909 40-40 40Z">
                                        </path>
                                        <path
                                            d="M472 274.9V107.999c0-11.027-8.972-20-20-20H60c-11.028 0-20 8.973-20 20V274.9L0 304.652V107.999c0-33.084 26.916-60 60-60h392c33.084 0 60 26.916 60 60v196.653Z">
                                        </path>
                                    </g>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="text-dark small">Contraseña</label>
                    <div class="input-group">
                        <input name="password" type="password" required class="form-control border-bottom border-dark"
                            placeholder="Ingresar Contraseña" />
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent border-0 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-4 h-4"
                                    viewBox="0 0 128 128">
                                    <path
                                        d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24- 24 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z">
                                    </path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <button type="submit" class="btn btn-dark btn-block">
                        Ingresar
                    </button>
                </div>

                <div class="my-4 d-flex align-items-center">
                    <hr class="flex-grow-1 border-dark" />
                    <span class="mx-2">o</span>
                    <hr class="flex-grow-1 border-dark" />
                </div>
            </form>
        </div>
    </div>
</div>
{{-- @endsection --}}