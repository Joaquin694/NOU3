@extends('layouts.app')

@section('title', 'Editar Cita')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-calendar-edit"></i> Editar Cita</h2>
    <p>Modifica los detalles de la cita seleccionada</p>
</div>

<div class="card">
    <h3><i class="fas fa-calendar-alt"></i> Información de la Cita</h3>
    
    <form method="POST" action="{{ route('citas.update', $cita) }}">
        @csrf
        @method('PUT')
        
        <div class="form-grid">
            <div class="form-group">
                <label for="ID_Cliente" class="form-label">Cliente:</label>
                <select id="ID_Cliente" name="ID_Cliente" class="form-control" required>
                    <option value="">Seleccione un cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->ID_Cliente }}" {{ old('ID_Cliente', $cita->ID_Cliente) == $cliente->ID_Cliente ? 'selected' : '' }}>
                            {{ $cliente->Nombres }} {{ $cliente->Apellidos }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="ID_Servicio" class="form-label">Servicio:</label>
                <select id="ID_Servicio" name="ID_Servicio" class="form-control" required>
                    <option value="">Seleccione un servicio</option>
                    @foreach($servicios as $servicio)
                        <option value="{{ $servicio->ID_Servicio }}" {{ old('ID_Servicio', $cita->ID_Servicio) == $servicio->ID_Servicio ? 'selected' : '' }}>
                            {{ $servicio->Nombre }} - S/ {{ $servicio->Precio }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="ID_Trabajador" class="form-label">Trabajador:</label>
                <select id="ID_Trabajador" name="ID_Trabajador" class="form-control" required>
                    <option value="">Seleccione un trabajador</option>
                    @foreach($trabajadores as $trabajador)
                        <option value="{{ $trabajador->ID_Trabajador }}" {{ old('ID_Trabajador', $cita->ID_Trabajador) == $trabajador->ID_Trabajador ? 'selected' : '' }}>
                            {{ $trabajador->Nombres }} {{ $trabajador->Apellidos }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="Fecha_Hora" class="form-label">Fecha y Hora:</label>
                <input type="datetime-local" id="Fecha_Hora" name="Fecha_Hora" class="form-control" value="{{ old('Fecha_Hora', $cita->Fecha_Hora->format('Y-m-d\TH:i')) }}" required>
            </div>

            <div class="form-group">
                <label for="Estado" class="form-label">Estado:</label>
                <select id="Estado" name="Estado" class="form-control" required>
                    <option value="Pendiente" {{ old('Estado', $cita->Estado) == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="Confirmada" {{ old('Estado', $cita->Estado) == 'Confirmada' ? 'selected' : '' }}>Confirmada</option>
                    <option value="Completada" {{ old('Estado', $cita->Estado) == 'Completada' ? 'selected' : '' }}>Completada</option>
                    <option value="Cancelada" {{ old('Estado', $cita->Estado) == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>
        </div>

        <div style="text-align: center; margin-top: 2rem;">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Actualizar Cita
            </button>
            <a href="{{ route('citas.index') }}" class="btn btn-danger">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection