@extends('Layouts.Plantilla')

@section('content')
    <h1>Editar Horario</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('horarios.update', $horario->idHora) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="pla_amb_id">ID Plan Ambiente:</label>
        <select name="pla_amb_id" required>
            @foreach ($ambientes as $ambiente)
                <option value="{{ $ambiente->pla_amb_id }}" {{ $ambiente->pla_amb_id == $horario->pla_amb_id ? 'selected' : '' }}>
                    {{ $ambiente->descripcion }}
                </option>
            @endforeach
        </select>

        <label for="inicio">Inicio:</label>
        <input type="text" name="inicio" value="{{ old('inicio', $horario->inicio) }}" required>

        <label for="fin">Fin:</label>
        <input type="text" name="fin" value="{{ old('fin', $horario->fin) }}" required>

        <label for="estadoHora">Estado:</label>
        <select name="estadoHora" required>
            <option value="1" {{ $horario->estadoHora ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ !$horario->estadoHora ? 'selected' : '' }}>Inactivo</option>
        </select>

        <button type="submit">Actualizar Horario</button>
    </form>
@endsection