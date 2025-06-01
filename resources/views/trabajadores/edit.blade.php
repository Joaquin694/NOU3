@extends('layouts.app')

@section('title', 'Editar Trabajador')

@section('content')
<h2>Editar Trabajador</h2>

<form method="POST" action="{{ route('trabajadores.update', $trabajador) }}">
    @csrf
    @method('PUT')
    
    <div>
        <label for="Nombres">Nombres:</label>
        <input type="text" id="Nombres" name="Nombres" value="{{ old('Nombres', $trabajador->Nombres) }}" required>
    </div>

    <div>
        <label for="Apellidos">Apellidos:</label>
        <input type="text" id="Apellidos" name="Apellidos" value="{{ old('Apellidos', $trabajador->Apellidos) }}" required>
    </div>

    <div>
        <label for="Cargo">Cargo:</label>
        <select id="Cargo" name="Cargo" required>
            <option value="">Seleccione un cargo</option>
            <option value="Estilista" {{ old('Cargo', $trabajador->Cargo) == 'Estilista' ? 'selected' : '' }}>Estilista</option>
            <option value="Manicurista" {{ old('Cargo', $trabajador->Cargo) == 'Manicurista' ? 'selected' : '' }}>Manicurista</option>
            <option value="Pedicurista" {{ old('Cargo', $trabajador->Cargo) == 'Pedicurista' ? 'selected' : '' }}>Pedicurista</option>
            <option value="Recepcionista" {{ old('Cargo', $trabajador->Cargo) == 'Recepcionista' ? 'selected' : '' }}>Recepcionista</option>
            <option value="Cosmetóloga" {{ old('Cargo', $trabajador->Cargo) == 'Cosmetóloga' ? 'selected' : '' }}>Cosmetóloga</option>
        </select>
    </div>

    <div>
        <label for="Estado">Estado:</label>
        <select id="Estado" name="Estado" required>
            <option value="Activo" {{ old('Estado', $trabajador->Estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
            <option value="Inactivo" {{ old('Estado', $trabajador->Estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

    <div>
        <button type="submit">Actualizar Trabajador</button>
        <a href="{{ route('trabajadores.index') }}">Cancelar</a>
    </div>
</form>
@endsection