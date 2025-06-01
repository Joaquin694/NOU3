@extends('layouts.app')

@section('title', 'Nuevo Servicio')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-plus-circle"></i> Nuevo Servicio</h2>
    <p>Agrega un nuevo servicio al catálogo del salón</p>
</div>

<div class="card">
    <form method="POST" action="{{ route('servicios.store') }}">
        @csrf
        
        <div class="form-grid">
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="Nombre" class="form-label">
                    <i class="fas fa-tag"></i> Nombre del Servicio
                </label>
                <input type="text" 
                       id="Nombre" 
                       name="Nombre" 
                       class="form-control" 
                       value="{{ old('Nombre') }}" 
                       placeholder="Ej: Corte y Peinado, Manicure Francesa, etc."
                       required>
            </div>

            <div class="form-group">
                <label for="Precio" class="form-label">
                    <i class="fas fa-dollar-sign"></i> Precio (S/)
                </label>
                <input type="number" 
                       id="Precio" 
                       name="Precio" 
                       class="form-control" 
                       value="{{ old('Precio') }}" 
                       step="0.01" 
                       min="0" 
                       placeholder="0.00"
                       required>
            </div>

            <div class="form-group">
                <label for="Duracion" class="form-label">
                    <i class="fas fa-clock"></i> Duración (minutos)
                </label>
                <input type="number" 
                       id="Duracion" 
                       name="Duracion" 
                       class="form-control" 
                       value="{{ old('Duracion') }}" 
                       min="1" 
                       placeholder="30"
                       required>
            </div>
        </div>

        <!-- Vista previa del servicio -->
        <div class="card" style="background: rgba(255,255,255,0.05); margin-top: 2rem;">
            <h4 style="color: white; font-size: 1.1rem; margin-bottom: 1rem;">
                <i class="fas fa-eye"></i> Vista Previa del Servicio
            </h4>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <div style="text-align: center; padding: 1rem; background: rgba(255,255,255,0.05); border-radius: 12px;">
                    <i class="fas fa-tag" style="font-size: 2rem; color: #667eea; margin-bottom: 0.5rem; display: block;"></i>
                    <span style="color: white; font-weight: 600;" id="preview-nombre">Nombre del Servicio</span>
                </div>
                <div style="text-align: center; padding: 1rem; background: rgba(255,255,255,0.05); border-radius: 12px;">
                    <i class="fas fa-dollar-sign" style="font-size: 2rem; color: #feca57; margin-bottom: 0.5rem; display: block;"></i>
                    <span style="color: white; font-weight: 600;">S/ <span id="preview-precio">0.00</span></span>
                </div>
                <div style="text-align: center; padding: 1rem; background: rgba(255,255,255,0.05); border-radius: 12px;">
                    <i class="fas fa-clock" style="font-size: 2rem; color: #56ab2f; margin-bottom: 0.5rem; display: block;"></i>
                    <span style="color: white; font-weight: 600;"><span id="preview-duracion">0</span> minutos</span>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 2rem;">
            <a href="{{ route('servicios.index') }}" class="btn btn-danger">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar Servicio
            </button>
        </div>
    </form>
</div>

<style>
    /* Animación para la vista previa */
    #preview-nombre, #preview-precio, #preview-duracion {
        transition: all 0.3s ease;
    }
</style>

<script>
    // Vista previa en tiempo real
    document.getElementById('Nombre').addEventListener('input', function() {
        const preview = document.getElementById('preview-nombre');
        preview.textContent = this.value || 'Nombre del Servicio';
    });

    document.getElementById('Precio').addEventListener('input', function() {
        const preview = document.getElementById('preview-precio');
        const valor = parseFloat(this.value) || 0;
        preview.textContent = valor.toFixed(2);
    });

    document.getElementById('Duracion').addEventListener('input', function() {
        const preview = document.getElementById('preview-duracion');
        preview.textContent = this.value || '0';
    });

    // Formatear precio mientras se escribe
    document.getElementById('Precio').addEventListener('blur', function() {
        if (this.value) {
            this.value = parseFloat(this.value).toFixed(2);
        }
    });

    // Validación del formulario antes de enviar
    document.querySelector('form').addEventListener('submit', function(e) {
        const btn = e.target.querySelector('button[type="submit"]');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        btn.disabled = true;
    });

    // Sugerencias de duración basadas en el nombre del servicio
    document.getElementById('Nombre').addEventListener('blur', function() {
        const nombre = this.value.toLowerCase();
        const duracionInput = document.getElementById('Duracion');
        
        if (!duracionInput.value) {
            if (nombre.includes('corte')) {
                duracionInput.value = 45;
            } else if (nombre.includes('manicure')) {
                duracionInput.value = 30;
            } else if (nombre.includes('pedicure')) {
                duracionInput.value = 45;
            } else if (nombre.includes('tinte') || nombre.includes('color')) {
                duracionInput.value = 90;
            } else if (nombre.includes('peinado')) {
                duracionInput.value = 60;
            }
            
            // Actualizar vista previa
            duracionInput.dispatchEvent(new Event('input'));
        }
    });
</script>
@endsection