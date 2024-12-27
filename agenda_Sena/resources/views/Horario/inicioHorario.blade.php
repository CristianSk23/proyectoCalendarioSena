@extends('Layouts.Plantilla')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/horarios.css') }}"> <!-- Si tienes un CSS específico -->
@endsection

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Lista de Horarios</h1>
    <a href="{{ route('horarios.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Crear Nuevo Horario</a>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">Descripción del Ambiente</th>
                <th class="py-3 px-6 text-left">Inicio</th>
                <th class="py-3 px-6 text-left">Fin</th>
                <th class="py-3 px-6 text-left">Estado</th>
                <th class="py-3 px-6 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach($horarios as $horario)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6">{{ $horario->idHora }}</td>
                    <td class="py-3 px-6">{{ $horario->ambiente->pla_amb_descripcion ?? 'N/A' }}</td> 
                    <td class="py-3 px-6">{{ $horario->inicio }}</td>
                    <td class="py-3 px-6">{{ $horario->fin }}</td>
                    <td class="py-3 px-6">{{ $horario->estadoHora ? 'Activo' : 'Inactivo' }}</td>
                    <td class="py-3 px-6">
                        <a href="{{ route('horarios.edit', $horario->idHora) }}" class="text-blue-500 hover:underline">Editar</a>
                        <form action="{{ route('horarios.destroy', $horario->idHora) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline ml-2">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Botón para regresar a la vista principal -->
    <div class="mt-4">
        <a href="{{ url('/') }}" class="inline-block bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Regresar a la Vista Principal</a>
    </div>
</div>
@endsection