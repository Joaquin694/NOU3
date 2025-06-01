@extends('layouts.app')

@section('title', 'Nuevo Trabajador')

@section('content')
<h2>Nuevo Trabajador</h2>

<form method="POST" action="{{ route('trabajadores.store') }}">
    @csrf
    
    <div>
        <label for="Nombres">Nombres:</label>
        <input type="text" id="Nombres" name="Nombres" value="{{ old('Nombres') }}" required>
    </div>

    <div>
        <label for="Apellidos">Apellidos:</label>
        <input type="text" id="Apellidos" name="Apellidos" value="{{ old('Apellidos') }}" required>
    </div>

    <div>
        <label for="Cargo">Cargo:</label>
        <select id="Cargo" name="Cargo" required>
            <option value="">Seleccione un cargo</option>
            <option value="Estilista" {{ old('Cargo') == 'Estilista' ? 'selected' : '' }}>Estilista</option>
            <option value="Manicurista" {{ old('Cargo') == 'Manicurista' ? 'selected' : '' }}>Manicurista</option>
            <option value="Pedicurista" {{ old('Cargo') == 'Pedicurista' ? 'selected' : '' }}>Pedicurista</option>
            <option value="Recepcionista" {{ old('Cargo') == 'Recepcionista' ? 'selected' : '' }}>Recepcionista</option>
            <option value="Cosmetóloga" {{ old('Cargo') == 'Cosmetóloga' ? 'selected' : '' }}>Cosmetóloga</option>
        </select>
    </div>

    <div>
        <label for="Estado">Estado:</label>
        <select id="Estado" name="Estado" required>
            <option value="Activo" {{ old('Estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
            <option value="Inactivo" {{ old('Estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

    <div>
        <button type="submit">Guardar Trabajador</button>
        <a href="{{ route('trabajadores.index') }}">Cancelar</a>
    </div>
</form>
@endsection