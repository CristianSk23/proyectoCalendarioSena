

@extends('Layouts.Plantilla')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/eventos.css') }}"> <!-- Si tienes un CSS específico -->
@endsection

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Lista de Eventos</h1>
        
        <a href="#" @click="openModal = true" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Crear Nuevo Evento</a>

        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white border border-gray-300 mt-4">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Nombre del Evento</th>
                    <th class="py-2 px-4 border-b">Descripción</th>
                    <th class="py-2 px-4 border-b">Estado</th>
                    <th class="py-2 px-4 border-b">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($eventos as $evento)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $evento->idEvento }}</td>
                        <td class="py-2 px-4 border-b">{{ $evento->nomEvento }}</td>
                        <td class="py-2 px-4 border-b">{{ $evento->descripcion }}</td>
                        <td class="py-2 px-4 border-b">{{ $evento->estadoEvento ? 'Activo' : 'Inactivo' }}</td>
                        <td class="py-2 px-4 border-b">
                            <a href="#" @click="openModal = true; editEvento({{ $evento }})" class="text-blue-500">Editar</a>
                            <form action="{{ route('eventos.destroy', $evento->idEvento) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal para Crear/Editar Evento -->
        <div x-data="{ openModal: false, evento: {} }" x-show="openModal" class="fixed inset-0 flex items-center justify-center z-50" style="display: none;">
            <div class="modal-overlay absolute inset-0 bg-gray-900 opacity-50"></div>
            <div class="modal-container bg-white w-11/12 md:w-1/3 mx-auto rounded shadow-lg z-50 overflow-y-auto">
                <div class="modal-content py-4 text-left px-6">
                    <h2 class="text-2xl font-bold" x-text="evento.idEvento ? 'Editar Evento' : 'Crear Evento'"></h2>
                    <form action="{{ route('eventos.store') }}" method="POST" id="eventoForm">
                        @csrf
                        <input type="hidden" name="idEvento" x-model="evento.idEvento">
                        <div class="mt-4">
                            <label class="block text-sm">Nombre del Evento</label>
                            <input type="text" name="nomEvento" x-model="evento.nomEvento" class="border rounded w-full py-2 px-3" required>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm">Descripción</label>
                            <textarea name="descripcion" x-model="evento.descripcion" class="border rounded w-full py-2 px-3" required></textarea>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm">Fecha</label>
                            <input type="date" name="fecha" x-model="evento.fecha" class="border rounded w-full py-2 px-3" required>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm">Estado</label>
                            <select name="estadoEvento" x-model="evento.estadoEvento" class="border rounded w-full py-2 px-3">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm">Estado</label>
                            <select name="estadoEvento" x-model="evento.estadoEvento" class="border rounded w-full py-2 px-3">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                        <div class="flex justify-end mt-4">
                            <button type="button" @click="openModal = false" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancelar</button>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
                        </div>

                       
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
     <!-- Botón para regresar a la vista principal -->
     <div class="mt-4">
                        <a href="{{ url('/') }}" class="inline-block bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Regresar a la Vista Principal</a>
                    </div>
@endsection