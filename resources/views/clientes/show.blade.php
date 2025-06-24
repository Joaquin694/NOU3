@extends('layouts.app')

@section('title', 'Detalle del Cliente')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-user"></i> Detalle del Cliente</h2>
    <p>Información completa y historial del cliente</p>
</div>

<div class="card">
    <h3><i class="fas fa-info-circle"></i> Información Personal</h3>
    
    <div class="table-container">
        <table class="table">
            <tr>
                <th style="width: 200px;">ID</th>
                <td>{{ $cliente->ID_Cliente }}</td>
            </tr>
            <tr>
                <th>Nombres</th>
                <td>{{ $cliente->Nombres }}</td>
            </tr>
            <tr>
                <th>Apellidos</th>
                <td>{{ $cliente->Apellidos }}</td>
            </tr>
            <tr>
                <th>DNI</th>
                <td>{{ $cliente->DNI }}</td>
            </tr>
            <tr>
                <th>Teléfono</th>
                <td>{{ $cliente->Telefono }}</td>
            </tr>
            <tr>
                <th>Correo</th>
                <td>{{ $cliente->Correo }}</td>
            </tr>
            <tr>
                <th>Fecha de Registro</th>
                <td>{{ $cliente->Fecha_Registro->format('d/m/Y') }}</td>
            </tr>
        </table>
    </div>
</div>

<div class="card">
    <h3><i class="fas fa-calendar-alt"></i> Historial de Citas</h3>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Servicio</th>
                    <th>Trabajador</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cliente->citas as $cita)
                <tr>
                    <td>{{ $cita->ID_Cita }}</td>
                    <td>{{ $cita->Fecha_Hora->format('d/m/Y H:i') }}</td>
                    <td>{{ $cita->servicio->Nombre ?? 'N/A' }}</td>
                    <td>{{ $cita->trabajador->Nombres ?? 'N/A' }} {{ $cita->trabajador->Apellidos ?? '' }}</td>
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
                    <td>
                        <a href="{{ route('citas.show', $cita) }}" class="btn btn-primary">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: rgba(255, 255, 255, 0.6);">
                        No hay citas registradas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <h3><i class="fas fa-shopping-cart"></i> Historial de Compras</h3>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cliente->ventas as $venta)
                <tr>
                    <td>{{ $venta->ID_Venta }}</td>
                    <td>{{ $venta->Fecha->format('d/m/Y H:i') }}</td>
                    <td>S/ {{ number_format($venta->Total, 2) }}</td>
                    <td>
                        <a href="{{ route('ventas.show', $venta) }}" class="btn btn-primary">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: rgba(255, 255, 255, 0.6);">
                        No hay compras registradas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="text-align: center; margin-top: 2rem;">
    <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">
        <i class="fas fa-edit"></i> Editar Cliente
    </a>
    <a href="{{ route('clientes.index') }}" class="btn btn-primary">
        <i class="fas fa-arrow-left"></i> Volver a Lista
    </a>
    <a href="{{ route('citas.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Nueva Cita
    </a>
</div>
@endsection