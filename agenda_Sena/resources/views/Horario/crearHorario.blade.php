@extends('Layouts.Plantilla')

@section('content')
    <h1>Crear Horario</h1>
    <form action="{{ route('horarios.store') }}" method="POST">
        @csrf
        <label for="pla_amb_id">ID Plan Ambiente:</label>
        <input type="number" name="pla_amb_id" required>
        
        <label for="inicio">Inicio:</label>
        <input type="time" name="inicio" required>
        
        <label for="fin">Fin:</label>
        <input type="time" name="fin" required>
        
        <label for="estadoHora">Estado:</label>
        <select name="estadoHora" required>
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
        </select>
        
        <button type="submit">Crear Horario</button>
    </form>

    <div x-data="{ open: false }">

<button @click="open = true">Show More...</button>



<ul x-show="open" @click.outside="open = false">

    <li><button wire:click="archive">Archive</button></li>

    <li><button wire:click="delete">Delete</button></li>

</ul>

</div>


@endsection