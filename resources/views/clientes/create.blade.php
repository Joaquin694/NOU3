@extends('layouts.app')

@section('title', 'Nuevo Cliente')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-user-plus"></i> Nuevo Cliente</h2>
    <p>Registra un nuevo cliente en el sistema</p>
</div>

<div class="card">
    <form method="POST" action="{{ route('clientes.store') }}">
        @csrf
        
        <div class="form-grid">
            <div class="form-group">
                <label for="Nombres" class="form-label">
                    <i class="fas fa-user"></i> Nombres
                </label>
                <input type="text" 
                       id="Nombres" 
                       name="Nombres" 
                       class="form-control" 
                       value="{{ old('Nombres') }}" 
                       placeholder="Ingrese los nombres"
                       required>
            </div>

            <div class="form-group">
                <label for="Apellidos" class="form-label">
                    <i class="fas fa-user"></i> Apellidos
                </label>
                <input type="text" 
                       id="Apellidos" 
                       name="Apellidos" 
                       class="form-control" 
                       value="{{ old('Apellidos') }}" 
                       placeholder="Ingrese los apellidos"
                       required>
            </div>

            <div class="form-group">
                <label for="DNI" class="form-label">
                    <i class="fas fa-id-card"></i> DNI
                </label>
                <input type="text" 
                       id="DNI" 
                       name="DNI" 
                       class="form-control" 
                       value="{{ old('DNI') }}" 
                       placeholder="Ingrese el DNI"
                       maxlength="8"
                       pattern="[0-9]{8}"
                       title="El DNI debe tener 8 dígitos"
                       required>
            </div>

            <div class="form-group">
                <label for="Telefono" class="form-label">
                    <i class="fas fa-phone"></i> Teléfono
                </label>
                <input type="tel" 
                       id="Telefono" 
                       name="Telefono" 
                       class="form-control" 
                       value="{{ old('Telefono') }}" 
                       placeholder="Ingrese el teléfono"
                       pattern="[0-9]{9}"
                       title="El teléfono debe tener 9 dígitos"
                       required>
            </div>

            <div class="form-group">
                <label for="Correo" class="form-label">
                    <i class="fas fa-envelope"></i> Correo Electrónico
                </label>
                <input type="email" 
                       id="Correo" 
                       name="Correo" 
                       class="form-control" 
                       value="{{ old('Correo') }}" 
                       placeholder="ejemplo@correo.com"
                       required>
            </div>

            <div class="form-group">
                <label for="Fecha_Registro" class="form-label">
                    <i class="fas fa-calendar"></i> Fecha de Registro
                </label>
                <input type="date" 
                       id="Fecha_Registro" 
                       name="Fecha_Registro" 
                       class="form-control" 
                       value="{{ old('Fecha_Registro', date('Y-m-d')) }}" 
                       max="{{ date('Y-m-d') }}"
                       required>
            </div>
        </div>

        <div style="text-align: center; margin-top: 2rem;">
            <a href="{{ route('clientes.index') }}" class="btn btn-danger">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar Cliente
            </button>
        </div>
    </form>
</div>

<script>
    // Validación en tiempo real del DNI
    document.getElementById('DNI').addEventListener('input', function(e) {
        this.value = this.value.replace(/\D/g, '').substring(0, 8);
    });

    // Validación en tiempo real del teléfono
    document.getElementById('Telefono').addEventListener('input', function(e) {
        this.value = this.value.replace(/\D/g, '').substring(0, 9);
    });

    // Convertir nombres y apellidos a mayúsculas
    document.getElementById('Nombres').addEventListener('blur', function(e) {
        this.value = this.value.toUpperCase();
    });

    document.getElementById('Apellidos').addEventListener('blur', function(e) {
        this.value = this.value.toUpperCase();
    });

    // Validación del formulario antes de enviar
    document.querySelector('form').addEventListener('submit', function(e) {
        const btn = e.target.querySelector('button[type="submit"]');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        btn.disabled = true;
    });
</script>
@endsection