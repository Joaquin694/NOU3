@extends('layouts.app')

@section('title', 'Editar Trabajador')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-user-edit"></i> Editar Trabajador</h2>
    <p>Modifica la información del trabajador</p>
</div>

<div class="card">
    <form method="POST" action="{{ route('trabajadores.update', $trabajador) }}">
        @csrf
        @method('PUT')
        
        <div class="form-grid">
            <div class="form-group">
                <label for="Nombres" class="form-label">
                    <i class="fas fa-user"></i> Nombres
                </label>
                <input type="text" 
                       id="Nombres" 
                       name="Nombres" 
                       class="form-control" 
                       value="{{ old('Nombres', $trabajador->Nombres) }}" 
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
                       value="{{ old('Apellidos', $trabajador->Apellidos) }}" 
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
                    <option value="Estilista" {{ old('Cargo', $trabajador->Cargo) == 'Estilista' ? 'selected' : '' }}>
                        Estilista
                    </option>
                    <option value="Manicurista" {{ old('Cargo', $trabajador->Cargo) == 'Manicurista' ? 'selected' : '' }}>
                        Manicurista
                    </option>
                    <option value="Pedicurista" {{ old('Cargo', $trabajador->Cargo) == 'Pedicurista' ? 'selected' : '' }}>
                        Pedicurista
                    </option>
                    <option value="Recepcionista" {{ old('Cargo', $trabajador->Cargo) == 'Recepcionista' ? 'selected' : '' }}>
                        Recepcionista
                    </option>
                    <option value="Cosmetóloga" {{ old('Cargo', $trabajador->Cargo) == 'Cosmetóloga' ? 'selected' : '' }}>
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
                    <option value="Activo" {{ old('Estado', $trabajador->Estado) == 'Activo' ? 'selected' : '' }}>
                        Activo
                    </option>
                    <option value="Inactivo" {{ old('Estado', $trabajador->Estado) == 'Inactivo' ? 'selected' : '' }}>
                        Inactivo
                    </option>
                </select>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="stats-grid" style="margin-top: 2rem;">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-number">{{ $trabajador->citas ? $trabajador->citas->count() : 0 }}</div>
                <div class="stat-label">Citas Totales</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="stat-number">
                    {{ $trabajador->citas ? $trabajador->citas->filter(function($cita) { 
                        return $cita->Fecha_Hora->isToday(); 
                    })->count() : 0 }}
                </div>
                <div class="stat-label">Citas Hoy</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number">
                    {{ $trabajador->citas ? $trabajador->citas->where('Estado', 'Pendiente')->count() : 0 }}
                </div>
                <div class="stat-label">Citas Pendientes</div>
            </div>
        </div>

        <!-- Vista previa del trabajador -->
        <div class="card" style="background: rgba(255,255,255,0.05); margin-top: 2rem;">
            <h4 style="color: white; font-size: 1.1rem; margin-bottom: 1rem;">
                <i class="fas fa-eye"></i> Vista Previa del Trabajador
            </h4>
            <div style="text-align: center; padding: 2rem;">
                <div id="preview-icon" style="font-size: 4rem; margin-bottom: 1rem;">
                    @if($trabajador->Cargo == 'Estilista')
                        <i class="fas fa-cut" style="color: #feca57;"></i>
                    @elseif($trabajador->Cargo == 'Manicurista' || $trabajador->Cargo == 'Pedicurista')
                        <i class="fas fa-hand-sparkles" style="color: #ff6b6b;"></i>
                    @elseif($trabajador->Cargo == 'Recepcionista')
                        <i class="fas fa-user-check" style="color: #667eea;"></i>
                    @elseif($trabajador->Cargo == 'Cosmetóloga')
                        <i class="fas fa-spa" style="color: #a8e6cf;"></i>
                    @else
                        <i class="fas fa-user-circle" style="color: #667eea;"></i>
                    @endif
                </div>
                <h3 style="color: white; margin-bottom: 0.5rem;">
                    <span id="preview-nombre">{{ $trabajador->Nombres }} {{ $trabajador->Apellidos }}</span>
                </h3>
                <p style="color: rgba(255,255,255,0.8); margin-bottom: 0.5rem;">
                    <i class="fas fa-briefcase"></i> <span id="preview-cargo">{{ $trabajador->Cargo }}</span>
                </p>
                <span id="preview-estado" class="status-badge {{ $trabajador->Estado == 'Activo' ? 'status-active' : 'status-cancelled' }}">
                    {{ $trabajador->Estado }}
                </span>
            </div>
            <div style="text-align: center; color: rgba(255,255,255,0.6); font-size: 0.9rem;">
                <p style="margin: 0.5rem 0;">
                    <i class="fas fa-calendar-plus"></i> Registrado: {{ $trabajador->created_at->format('d/m/Y H:i') }}
                </p>
                <p style="margin: 0.5rem 0;">
                    <i class="fas fa-edit"></i> Última actualización: {{ $trabajador->updated_at->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>

        <div style="text-align: center; margin-top: 2rem;">
            <a href="{{ route('trabajadores.index') }}" class="btn btn-danger">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Actualizar Trabajador
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
        if (!confirm('¿Está seguro de actualizar la información del trabajador?')) {
            e.preventDefault();
            return;
        }
        
        const btn = e.target.querySelector('button[type="submit"]');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Actualizando...';
        btn.disabled = true;
    });
</script>
@endsection