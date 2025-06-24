@extends('layouts.app')

@section('title', 'Detalle de la Cita')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-calendar-alt"></i> Detalle de la Cita</h2>
    <p>Información completa y opciones de gestión de la cita</p>
</div>

<div class="card">
    <h3><i class="fas fa-info-circle"></i> Información de la Cita</h3>
    
    <div class="table-container">
        <table class="table">
            <tr>
                <th style="width: 200px;">ID Cita</th>
                <td>{{ $cita->ID_Cita }}</td>
            </tr>
            <tr>
                <th>Cliente</th>
                <td>{{ $cita->cliente->Nombres ?? 'N/A' }} {{ $cita->cliente->Apellidos ?? '' }}</td>
            </tr>
            <tr>
                <th>DNI Cliente</th>
                <td>{{ $cita->cliente->DNI ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Teléfono</th>
                <td>{{ $cita->cliente->Telefono ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Servicio</th>
                <td>{{ $cita->servicio->Nombre ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Precio del Servicio</th>
                <td>S/ {{ number_format($cita->servicio->Precio ?? 0, 2) }}</td>
            </tr>
            <tr>
                <th>Duración</th>
                <td>{{ $cita->servicio->Duracion ?? 'N/A' }} minutos</td>
            </tr>
            <tr>
                <th>Trabajador</th>
                <td>{{ $cita->trabajador->Nombres ?? 'N/A' }} {{ $cita->trabajador->Apellidos ?? '' }}</td>
            </tr>
            <tr>
                <th>Cargo</th>
                <td>{{ $cita->trabajador->Cargo ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Fecha y Hora</th>
                <td>{{ $cita->Fecha_Hora->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th>Estado</th>
                <td>
                    <span class="status-badge 
                        @if($cita->Estado == 'Pendiente') status-pending
                        @elseif($cita->Estado == 'Confirmada') status-active
                        @elseif($cita->Estado == 'Completada') status-active
                        @else status-cancelled
                        @endif
                    ">
                        {{ $cita->Estado }}
                    </span>
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="card">
    <h3><i class="fas fa-cogs"></i> Acciones Rápidas</h3>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Acción</th>
                    <th>Disponible</th>
                    <th>Ejecutar</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><i class="fas fa-check-circle"></i> Confirmar Cita</td>
                    <td>
                        <span class="status-badge {{ $cita->Estado == 'Pendiente' ? 'status-active' : 'status-cancelled' }}">
                            {{ $cita->Estado == 'Pendiente' ? 'Sí' : 'No' }}
                        </span>
                    </td>
                    <td>
                        @if($cita->Estado == 'Pendiente')
                            <form method="POST" action="{{ route('citas.update', $cita) }}" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="ID_Cliente" value="{{ $cita->ID_Cliente }}">
                                <input type="hidden" name="ID_Servicio" value="{{ $cita->ID_Servicio }}">
                                <input type="hidden" name="ID_Trabajador" value="{{ $cita->ID_Trabajador }}">
                                <input type="hidden" name="Fecha_Hora" value="{{ $cita->Fecha_Hora->format('Y-m-d\TH:i') }}">
                                <input type="hidden" name="Estado" value="Confirmada">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i> Confirmar
                                </button>
                            </form>
                        @else
                            <span style="color: rgba(255, 255, 255, 0.5);">-</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><i class="fas fa-check-double"></i> Completar Cita</td>
                    <td>
                        <span class="status-badge {{ $cita->Estado == 'Confirmada' ? 'status-active' : 'status-cancelled' }}">
                            {{ $cita->Estado == 'Confirmada' ? 'Sí' : 'No' }}
                        </span>
                    </td>
                    <td>
                        @if($cita->Estado == 'Confirmada')
                            <form method="POST" action="{{ route('citas.update', $cita) }}" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="ID_Cliente" value="{{ $cita->ID_Cliente }}">
                                <input type="hidden" name="ID_Servicio" value="{{ $cita->ID_Servicio }}">
                                <input type="hidden" name="ID_Trabajador" value="{{ $cita->ID_Trabajador }}">
                                <input type="hidden" name="Fecha_Hora" value="{{ $cita->Fecha_Hora->format('Y-m-d\TH:i') }}">
                                <input type="hidden" name="Estado" value="Completada">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check-double"></i> Completar
                                </button>
                            </form>
                        @else
                            <span style="color: rgba(255, 255, 255, 0.5);">-</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><i class="fas fa-times-circle"></i> Cancelar Cita</td>
                    <td>
                        <span class="status-badge {{ ($cita->Estado == 'Pendiente' || $cita->Estado == 'Confirmada') ? 'status-active' : 'status-cancelled' }}">
                            {{ ($cita->Estado == 'Pendiente' || $cita->Estado == 'Confirmada') ? 'Sí' : 'No' }}
                        </span>
                    </td>
                    <td>
                        @if($cita->Estado == 'Pendiente' || $cita->Estado == 'Confirmada')
                            <form method="POST" action="{{ route('citas.update', $cita) }}" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="ID_Cliente" value="{{ $cita->ID_Cliente }}">
                                <input type="hidden" name="ID_Servicio" value="{{ $cita->ID_Servicio }}">
                                <input type="hidden" name="ID_Trabajador" value="{{ $cita->ID_Trabajador }}">
                                <input type="hidden" name="Fecha_Hora" value="{{ $cita->Fecha_Hora->format('Y-m-d\TH:i') }}">
                                <input type="hidden" name="Estado" value="Cancelada">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de cancelar esta cita?')">
                                    <i class="fas fa-times"></i> Cancelar
                                </button>
                            </form>
                        @else
                            <span style="color: rgba(255, 255, 255, 0.5);">-</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div style="text-align: center; margin-top: 2rem;">
    <a href="{{ route('citas.edit', $cita) }}" class="btn btn-warning">
        <i class="fas fa-edit"></i> Editar Cita
    </a>
    <a href="{{ route('citas.index') }}" class="btn btn-primary">
        <i class="fas fa-arrow-left"></i> Volver a Lista
    </a>
    <a href="{{ route('clientes.show', $cita->cliente) }}" class="btn btn-primary">
        <i class="fas fa-user"></i> Ver Cliente
    </a>
    @if($cita->Estado == 'Completada')
        <a href="{{ route('ventas.create') }}" class="btn btn-success">
            <i class="fas fa-cash-register"></i> Registrar Venta
        </a>
    @endif
</div>
@endsection