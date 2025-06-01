@extends('layouts.app')

@section('title', 'Nuevo Servicio')

@section('content')
<h2>Nuevo Servicio</h2>

<form method="POST" action="{{ route('servicios.store') }}">
    @csrf
    
    <div>
        <label for="Nombre">Nombre del Servicio:</label>
        <input type="text" id="Nombre" name="Nombre" value="{{ old('Nombre') }}" required>
    </div>

    <div>
        <label for="Precio">Precio:</label>
        <input type="number" id="Precio" name="Precio" value="{{ old('Precio') }}" step="0.01" min="0" required>
    </div>

    <div>
        <label for="Duracion">Duración (minutos):</label>
        <input type="number" id="Duracion" name="Duracion" value="{{ old('Duracion') }}" min="1" required>
    </div>

    <div>
        <button type="submit">Guardar Servicio</button>
        <a href="{{ route('servicios.index') }}">Cancelar</a>
    </div>
</form>
@endsection