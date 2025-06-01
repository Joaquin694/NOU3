@extends('layouts.app')

@section('title', 'Nuevo Trabajador')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-user-plus"></i> Nuevo Trabajador</h2>
    <p>Registra un nuevo trabajador en el sistema</p>
</div>

<div class="card">
    <form method="POST" action="{{ route('trabajadores.store') }}">
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
                <label for="Cargo" class="form-label">
                    <i class="fas fa-briefcase"></i> Cargo
                </label>
                <select id="Cargo" 
                        name="Cargo" 
                        class="form-control" 
                        required>
                    <option value="">Seleccione un cargo</option>
                    <option value="Estilista" {{ old('Cargo') == 'Estilista' ? 'selected' : '' }}>
                        Estilista
                    </option>
                    <option value="Manicurista" {{ old('Cargo') == 'Manicurista' ? 'selected' : '' }}>
                        Manicurista
                    </option>
                    <option value="Pedicurista" {{ old('Cargo') == 'Pedicurista' ? 'selected' : '' }}>
                        Pedicurista
                    </option>
                    <option value="Recepcionista" {{ old('Cargo') == 'Recepcionista' ? 'selected' : '' }}>
                        Recepcionista
                    </option>
                    <option value="Cosmetóloga" {{ old('Cargo') == 'Cosmetóloga' ? 'selected' : '' }}>
                        Cosmetóloga
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="Estado" class="form-label">
                    <i class="fas fa-toggle-on"></i> Estado
                </label>
                <select id="Estado" 
                        name="Estado" 
                        class="form-control" 
                        required>
                    <option value="Activo" {{ old('Estado', 'Activo') == 'Activo' ? 'selected' : '' }}>
                        Activo
                    </option>
                    <option value="Inactivo" {{ old('Estado') == 'Inactivo' ? 'selected' : '' }}>
                        Inactivo
                    </option>
                </select>
            </div>
        </div>

        <!-- Vista previa del trabajador -->
        <div class="card" style="background: rgba(255,255,255,0.05); margin-top: 2rem;">
            <h4 style="color: white; font-size: 1.1rem; margin-bottom: 1rem;">
                <i class="fas fa-eye"></i> Vista Previa del Trabajador
            </h4>
            <div style="text-align: center; padding: 2rem;">
                <div id="preview-icon" style="font-size: 4rem; margin-bottom: 1rem;">
                    <i class="fas fa-user-circle" style="color: #667eea;"></i>
                </div>
                <h3 style="color: white; margin-bottom: 0.5rem;">
                    <span id="preview-nombre">Nombre del Trabajador</span>
                </h3>
                <p style="color: rgba(255,255,255,0.8); margin-bottom: 0.5rem;">
                    <i class="fas fa-briefcase"></i> <span id="preview-cargo">Cargo</span>
                </p>
                <span id="preview-estado" class="status-badge status-active">Activo</span>
            </div>
        </div>

        <div style="text-align: center; margin-top: 2rem;">
            <a href="{{ route('trabajadores.index') }}" class="btn btn-danger">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar Trabajador
            </button>
        </div>
    </form>
</div>

<style>
    /* Estilos para los select en tema oscuro */
    select.form-control option {
        background: #4a5568;
        color: white;
    }
    
    #preview-icon i {
        transition: all 0.3s ease;
    }
</style>

<script>
    // Vista previa en tiempo real
    document.getElementById('Nombres').addEventListener('input', updatePreview);
    document.getElementById('Apellidos').addEventListener('input', updatePreview);
    
    function updatePreview() {
        const nombres = document.getElementById('Nombres').value;
        const apellidos = document.getElementById('Apellidos').value;
        const preview = document.getElementById('preview-nombre');
        
        if (nombres || apellidos) {
            preview.textContent = `${nombres} ${apellidos}`.trim();
        } else {
            preview.textContent = 'Nombre del Trabajador';
        }
    }

    // Actualizar cargo en vista previa
    document.getElementById('Cargo').addEventListener('change', function() {
        const cargo = this.value || 'Cargo';
        document.getElementById('preview-cargo').textContent = cargo;
        
        // Cambiar icono según el cargo
        const iconDiv = document.getElementById('preview-icon');
        let iconHtml = '';
        
        switch(cargo) {
            case 'Estilista':
                iconHtml = '<i class="fas fa-cut" style="color: #feca57;"></i>';
                break;
            case 'Manicurista':
            case 'Pedicurista':
                iconHtml = '<i class="fas fa-hand-sparkles" style="color: #ff6b6b;"></i>';
                break;
            case 'Recepcionista':
                iconHtml = '<i class="fas fa-user-check" style="color: #667eea;"></i>';
                break;
            case 'Cosmetóloga':
                iconHtml = '<i class="fas fa-spa" style="color: #a8e6cf;"></i>';
                break;
            default:
                iconHtml = '<i class="fas fa-user-circle" style="color: #667eea;"></i>';
        }
        
        iconDiv.innerHTML = iconHtml;
    });

    // Actualizar estado en vista previa
    document.getElementById('Estado').addEventListener('change', function() {
        const estadoBadge = document.getElementById('preview-estado');
        
        if (this.value === 'Activo') {
            estadoBadge.className = 'status-badge status-active';
            estadoBadge.textContent = 'Activo';
        } else {
            estadoBadge.className = 'status-badge status-cancelled';
            estadoBadge.textContent = 'Inactivo';
        }
    });

    // Convertir nombres y apellidos a mayúsculas
    document.getElementById('Nombres').addEventListener('blur', function() {
        this.value = this.value.toUpperCase();
        updatePreview();
    });

    document.getElementById('Apellidos').addEventListener('blur', function() {
        this.value = this.value.toUpperCase();
        updatePreview();
    });

    // Validación del formulario
    document.querySelector('form').addEventListener('submit', function(e) {
        const btn = e.target.querySelector('button[type="submit"]');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        btn.disabled = true;
    });
</script>
@endsection