@extends('Layouts.Plantilla')

@section('content')
    <h1>Eliminar Horario</h1>
    <p>¿Estás seguro de que deseas eliminar el horario {{ $horario->idHora }}?</p>
    <form action="{{ route('horarios.destroy', $horario->idHora) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Eliminar</button>
        <a href="{{ route('horarios.index') }}">Cancelar</a>
    </form>
@endsection