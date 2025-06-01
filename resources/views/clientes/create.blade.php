<!-- resources/views/clientes/create.blade.php -->
@extends('layouts.app')

@section('title', 'Nuevo Cliente')

@section('content')
<h2>Nuevo Cliente</h2>

<form method="POST" action="{{ route('clientes.store') }}">
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
        <label for="DNI">DNI:</label>
        <input type="text" id="DNI" name="DNI" value="{{ old('DNI') }}" required>
    </div>

    <div>
        <label for="Telefono">Teléfono:</label>
        <input type="text" id="Telefono" name="Telefono" value="{{ old('Telefono') }}" required>
    </div>

    <div>
        <label for="Correo">Correo:</label>
        <input type="email" id="Correo" name="Correo" value="{{ old('Correo') }}" required>
    </div>

    <div>
        <label for="Fecha_Registro">Fecha de Registro:</label>
        <input type="date" id="Fecha_Registro" name="Fecha_Registro" value="{{ old('Fecha_Registro', date('Y-m-d')) }}" required>
    </div>

    <div>
        <button type="submit">Guardar Cliente</button>
        <a href="{{ route('clientes.index') }}">Cancelar</a>
    </div>
</form>
@endsection