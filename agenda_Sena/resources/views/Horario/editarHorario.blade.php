@extends('Layouts.Plantilla')

@section('content')
    <h1>Editar Horario</h1>
    <form action="{{ route('horarios.update', $horario->idHora) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- <label for="pla_amb_id">ID Plan Ambiente:</label>
        <input type="number" name="pla_amb_id" value="{{ $horario->pla_amb_id }}" required>
         -->
         <label for="pla_amb_id">ID Plan Ambiente:</label>
            <select name="pla_amb_id" required>
                @foreach ($ambientes as $ambiente)
                    <option value="{{ $ambiente->id }}" {{ $ambiente->id == $horario->pla_amb_id ? 'selected' : '' }}>
                        {{ $ambiente->descripcion }}
                    </option>
                @endforeach
            </select>

        <label for="inicio">Inicio:</label>
        <input type="text" name="inicio" value="{{ $horario->inicio }}" required>
        
        <label for="fin">Fin:</label>
        <input type="text" name="fin" value="{{ $horario->fin }}" required>
        
        <label for="estadoHora">Estado:</label>
        <select name="estadoHora" required>
            <option value="1" {{ $horario->estadoHora ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ !$horario->estadoHora ? 'selected' : '' }}>Inactivo</option>
        </select>
        
        <button type="submit">Actualizar Horario</button>
    </form>
@endsection