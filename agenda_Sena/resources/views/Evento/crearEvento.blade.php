@extends('Layouts.Plantilla')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Crear Evento</h1>
    <form action="{{ route('eventos.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf

        <div class="mb-4">
            <label for="nomEvento" class="block text-sm font-medium text-gray-700">Nombre del Evento:</label>
            <input type="text" name="nomEvento" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
        </div>

        <div class="mb-4">
            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción:</label>
            <textarea name="descripcion" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"></textarea>
        </div>

        <div class="mb-4">
            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha:</label>
            <input type="date" name="fecha" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
        </div>

        <div class="mb-4">
            <label for="aforoEvento" class="block text-sm font-medium text-gray-700">Aforo del Evento:</label>
            <input type="number" name="aforoEvento" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
        </div>

        <div class="mb-4">
            <label for="nomSolicitante" class="block text-sm font-medium text-gray-700">Nombre del Solicitante:</label>
            <input type="text" name="nomSolicitante" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
        </div>

        <div class="mb-4">
            <label for="idCategoria" class="block text-sm font-medium text-gray-700">Categoría:</label>
            <select name="idCategoria" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                <option value="">Seleccionar Categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->idCategoria }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="publicidad" class="block text-sm font-medium text-gray-700">Publicidad:</label>
            <input type="file" name="publicidad" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
        </div>

        <div class="mb-4">
            <label for="estadoEvento" class="block text-sm font-medium text-gray-700">Estado del Evento:</label>
            <select name="estadoEvento" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Crear Evento</button>
    </form>

    <div x-data="{ open: false }" class="mt-4">
        <button @click="open = true" class="bg-gray-300 px-4 py-2 rounded">Show More...</button>
        <ul x-show="open" @click.outside="open = false" class="mt-2 bg-gray-100 p-2 rounded shadow-md">
            <li><button wire:click="archive" class="text-blue-600">Archive</button></li>
            <li><button wire:click="delete" class="text-red-600">Delete</button></li>
        </ul>
    </div>
@endsection