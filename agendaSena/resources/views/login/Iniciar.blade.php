<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styleLogin.css') }}">
    <title>Iniciar Sesión</title>
</head>
<body>
    <div class="fondo" id="fondo"></div>
    <div class="login-container">
        <div class="header-container">
            <div class="logo-container">
                <img src="{{ asset('imgLogin/iconLogin/logoSena.png') }}" alt="Usuario" class="logo">
            </div>
            <h1>Agenda Sena</h1>
        </div>
        
       
        <h2>  Ingreso de Usuarios Registrados</h2>
        <form action="{{ route('login.ingresar') }}" method="POST">
        @csrf
        <div class="input-container">
            <img src="{{ asset('imgLogin/iconLogin/user.png') }}" alt="Usuario" class="icon">
            <input type="number" name="documento" placeholder="Numero de Documento" required>
        </div>
        <div class="input-container">
            <img src="{{ asset('imgLogin/iconLogin/password.png') }}" alt="password" class="icon">
            <input type="password" name="password" placeholder="Contraseña" required>
        </div>
            <button type="submit">Ingresar</button>
        </form>
    </div>
    <script>
        const imagenes = [
            "{{ asset('imgLogin/sena1.JPG') }}",
            "{{ asset('imgLogin/sena2.JPG') }}",
            "{{ asset('imgLogin/sena3.JPG') }}"
        ];
        let index = 0;
        function cambiarImagenes() {
            const fondo = document.getElementById("fondo");
            fondo.style.backgroundImage = `url(${imagenes[index]})`;
            index = (index + 1) % imagenes.length; 
        }
        setInterval(cambiarImagenes, 5000);
        cambiarImagenes();
    </script>
     </body>
</html>

