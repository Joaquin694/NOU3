@extends('layouts.app')

@section('title', 'Nueva Cita')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-calendar-plus"></i> Nueva Cita</h2>
    <p>Agenda una nueva cita para el salón</p>
</div>

<div class="card">
    <form method="POST" action="{{ route('citas.store') }}">
        @csrf
        
        <div class="form-grid">
            <div class="form-group">
                <label for="ID_Cliente" class="form-label">
                    <i class="fas fa-user"></i> Cliente
                </label>
                <select id="ID_Cliente" 
                        name="ID_Cliente" 
                        class="form-control" 
                        required>
                    <option value="">Seleccione un cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->ID_Cliente }}" 
                                {{ old('ID_Cliente') == $cliente->ID_Cliente ? 'selected' : '' }}>
                            {{ $cliente->Nombres }} {{ $cliente->Apellidos }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="ID_Servicio" class="form-label">
                    <i class="fas fa-cut"></i> Servicio
                </label>
                <select id="ID_Servicio" 
                        name="ID_Servicio" 
                        class="form-control" 
                        required>
                    <option value="">Seleccione un servicio</option>
                    @foreach($servicios as $servicio)
                        <option value="{{ $servicio->ID_Servicio }}" 
                                data-precio="{{ $servicio->Precio }}"
                                data-duracion="{{ $servicio->Duracion }}"
                                {{ old('ID_Servicio') == $servicio->ID_Servicio ? 'selected' : '' }}>
                            {{ $servicio->Nombre }} - S/ {{ number_format($servicio->Precio, 2) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="ID_Trabajador" class="form-label">
                    <i class="fas fa-user-tie"></i> Trabajador
                </label>
                <select id="ID_Trabajador" 
                        name="ID_Trabajador" 
                        class="form-control" 
                        required>
                    <option value="">Seleccione un trabajador</option>
                    @foreach($trabajadores as $trabajador)
                        <option value="{{ $trabajador->ID_Trabajador }}" 
                                {{ old('ID_Trabajador') == $trabajador->ID_Trabajador ? 'selected' : '' }}>
                            {{ $trabajador->Nombres }} {{ $trabajador->Apellidos }} - {{ $trabajador->Cargo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="Fecha_Hora" class="form-label">
                    <i class="fas fa-clock"></i> Fecha y Hora
                </label>
                <input type="datetime-local" 
                       id="Fecha_Hora" 
                       name="Fecha_Hora" 
                       class="form-control" 
                       value="{{ old('Fecha_Hora') }}" 
                       min="{{ now()->format('Y-m-d\TH:i') }}"
                       required>
            </div>

            <div class="form-group">
                <label for="Estado" class="form-label">
                    <i class="fas fa-info-circle"></i> Estado
                </label>
                <select id="Estado" 
                        name="Estado" 
                        class="form-control" 
                        required>
                    <option value="Pendiente" {{ old('Estado', 'Pendiente') == 'Pendiente' ? 'selected' : '' }}>
                        Pendiente
                    </option>
                    <option value="Confirmada" {{ old('Estado') == 'Confirmada' ? 'selected' : '' }}>
                        Confirmada
                    </option>
                    <option value="Completada" {{ old('Estado') == 'Completada' ? 'selected' : '' }}>
                        Completada
                    </option>
                    <option value="Cancelada" {{ old('Estado') == 'Cancelada' ? 'selected' : '' }}>
                        Cancelada
                    </option>
                </select>
            </div>

            <div class="form-group">
                <div class="card" style="background: rgba(255,255,255,0.05); padding: 1rem;">
                    <h4 style="color: white; font-size: 1rem; margin-bottom: 0.5rem;">
                        <i class="fas fa-info-circle"></i> Información del Servicio
                    </h4>
                    <div id="servicio-info" style="color: rgba(255,255,255,0.7);">
                        <p style="margin: 0;">Seleccione un servicio para ver detalles</p>
                    </div>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 2rem;">
            <a href="{{ route('citas.index') }}" class="btn btn-danger">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Agendar Cita
            </button>
        </div>
    </form>
</div>

<style>
    /* Estilos para mejorar los select en el tema oscuro */
    select.form-control option {
        background: #4a5568;
        color: white;
    }
    
    select.form-control option:hover {
        background: #667eea;
    }
</style>

<script>
    // Mostrar información del servicio seleccionado
    document.getElementById('ID_Servicio').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const infoDiv = document.getElementById('servicio-info');
        
        if (this.value) {
            const precio = selectedOption.getAttribute('data-precio');
            const duracion = selectedOption.getAttribute('data-duracion');
            
            infoDiv.innerHTML = `
                <p style="margin: 0;"><strong>Precio:</strong> S/ ${parseFloat(precio).toFixed(2)}</p>
                <p style="margin: 0;"><strong>Duración:</strong> ${duracion} minutos</p>
            `;
        } else {
            infoDiv.innerHTML = '<p style="margin: 0;">Seleccione un servicio para ver detalles</p>';
        }
    });

    // Establecer fecha mínima como la actual
    document.addEventListener('DOMContentLoaded', function() {
        const fechaInput = document.getElementById('Fecha_Hora');
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        fechaInput.min = now.toISOString().slice(0, 16);
    });

    // Validación del formulario antes de enviar
    document.querySelector('form').addEventListener('submit', function(e) {
        const btn = e.target.querySelector('button[type="submit"]');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Agendando...';
        btn.disabled = true;
    });

    // Mejorar la búsqueda en los selects
    function addSearchToSelect(selectId) {
        const select = document.getElementById(selectId);
        const wrapper = select.parentElement;
        
        const searchInput = document.createElement('input');
        searchInput.type = 'text';
        searchInput.className = 'form-control';
        searchInput.placeholder = 'Buscar...';
        searchInput.style.marginBottom = '0.5rem';
        searchInput.style.display = 'none';
        
        wrapper.insertBefore(searchInput, select);
        
        select.addEventListener('focus', function() {
            searchInput.style.display = 'block';
            searchInput.focus();
        });
        
        searchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const options = select.options;
            
            for (let i = 1; i < options.length; i++) {
                const text = options[i].text.toLowerCase();
                options[i].style.display = text.includes(filter) ? '' : 'none';
            }
        });
        
        searchInput.addEventListener('blur', function() {
            setTimeout(() => {
                searchInput.style.display = 'none';
            }, 200);
        });
    }

    // Agregar búsqueda a los selects principales
    addSearchToSelect('ID_Cliente');
    addSearchToSelect('ID_Servicio');
    addSearchToSelect('ID_Trabajador');
</script>
@endsection