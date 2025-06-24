@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-user-edit"></i> Editar Cliente</h2>
    <p>Actualiza la información del cliente seleccionado</p>
</div>

<div class="card">
    <h3><i class="fas fa-user"></i> Información del Cliente</h3>
    
    <form method="POST" action="{{ route('clientes.update', $cliente) }}">
        @csrf
        @method('PUT')
        
        <div class="form-grid">
            <div class="form-group">
                <label for="Nombres" class="form-label">Nombres:</label>
                <input type="text" id="Nombres" name="Nombres" class="form-control" value="{{ old('Nombres', $cliente->Nombres) }}" required>
            </div>

            <div class="form-group">
                <label for="Apellidos" class="form-label">Apellidos:</label>
                <input type="text" id="Apellidos" name="Apellidos" class="form-control" value="{{ old('Apellidos', $cliente->Apellidos) }}" required>
            </div>

            <div class="form-group">
                <label for="DNI" class="form-label">DNI:</label>
                <input type="text" id="DNI" name="DNI" class="form-control" value="{{ old('DNI', $cliente->DNI) }}" required>
            </div>

            <div class="form-group">
                <label for="Telefono" class="form-label">Teléfono:</label>
                <input type="text" id="Telefono" name="Telefono" class="form-control" value="{{ old('Telefono', $cliente->Telefono) }}" required>
            </div>

            <div class="form-group">
                <label for="Correo" class="form-label">Correo:</label>
                <input type="email" id="Correo" name="Correo" class="form-control" value="{{ old('Correo', $cliente->Correo) }}" required>
            </div>

            <div class="form-group">
                <label for="Fecha_Registro" class="form-label">Fecha de Registro:</label>
                <input type="date" id="Fecha_Registro" name="Fecha_Registro" class="form-control" value="{{ old('Fecha_Registro', $cliente->Fecha_Registro->format('Y-m-d')) }}" required>
            </div>
        </div>

        <div style="text-align: center; margin-top: 2rem;">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Actualizar Cliente
            </button>
            <a href="{{ route('clientes.index') }}" class="btn btn-danger">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection