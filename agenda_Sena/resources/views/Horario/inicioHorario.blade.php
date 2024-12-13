@extends('Layouts.Plantilla')

@section('content')
    <h1>Lista de Horarios</h1>
    <a href="{{ route('horarios.create') }}">Crear Nuevo Horario</a>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción del Ambiente</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($horarios as $horario)
                <tr>
                    <td>{{ $horario->idHora }}</td>
                    <td>{{ $horario->ambiente->pla_amb_descripcion ?? 'N/A' }}</td> 
                    <td>{{ $horario->inicio }}</td>
                    <td>{{ $horario->fin }}</td>
                    <td>{{ $horario->estadoHora ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        <a href="{{ route('horarios.edit', $horario->idHora) }}">Editar</a>
                        <form action="{{ route('horarios.destroy', $horario->idHora) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection