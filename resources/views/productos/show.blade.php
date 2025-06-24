@extends('layouts.app')

@section('title', 'Detalle del Producto')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-box"></i> Detalle del Producto</h2>
    <p>Información completa e historial del producto</p>
</div>

<div class="card">
    <h3><i class="fas fa-info-circle"></i> Información del Producto</h3>
    
    <div class="table-container">
        <table class="table">
            <tr>
                <th style="width: 200px;">ID</th>
                <td>{{ $producto->ID_Producto }}</td>
            </tr>
            <tr>
                <th>Nombre</th>
                <td>{{ $producto->Nombre }}</td>
            </tr>
            <tr>
                <th>Cantidad en Stock</th>
                <td>
                    <span style="font-size: 1.2rem; font-weight: bold; 
                        color: @if($producto->Cantidad > 10) #22c55e
                              @elseif($producto->Cantidad > 0) #fbbf24
                              @else #ef4444 @endif">
                        {{ $producto->Cantidad }} unidades
                    </span>
                </td>
            </tr>
            <tr>
                <th>Precio de Venta</th>
                <td style="font-size: 1.2rem; font-weight: bold; color: #22c55e;">
                    S/ {{ number_format($producto->Precio_Venta, 2) }}
                </td>
            </tr>
            <tr>
                <th>Estado del Stock</th>
                <td>
                    <span class="status-badge 
                        @if($producto->Cantidad > 10) status-active
                        @elseif($producto->Cantidad > 0) status-pending
                        @else status-cancelled
                        @endif
                    ">
                        @if($producto->Cantidad > 10)
                            <i class="fas fa-check-circle"></i> Disponible
                        @elseif($producto->Cantidad > 0)
                            <i class="fas fa-exclamation-triangle"></i> Poco Stock
                        @else
                            <i class="fas fa-times-circle"></i> Agotado
                        @endif
                    </span>
                </td>
            </tr>
            <tr>
                <th>Valor Total en Stock</th>
                <td style="font-size: 1.2rem; font-weight: bold; color: #667eea;">
                    S/ {{ number_format($producto->Cantidad * $producto->Precio_Venta, 2) }}
                </td>
            </tr>
            <tr>
                <th>Fecha de Creación</th>
                <td>{{ $producto->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th>Última Actualización</th>
                <td>{{ $producto->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>
</div>

<div class="stats-grid" style="grid-template-columns: repeat(4, 1fr); margin-bottom: 2rem;">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-cubes"></i>
        </div>
        <div class="stat-number">{{ $producto->Cantidad }}</div>
        <div class="stat-label">Stock Actual</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="stat-number">S/ {{ number_format($producto->Precio_Venta, 2) }}</div>
        <div class="stat-label">Precio Unitario</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-calculator"></i>
        </div>
        <div class="stat-number">S/ {{ number_format($producto->Cantidad * $producto->Precio_Venta, 2) }}</div>
        <div class="stat-label">Valor Total</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="stat-number">{{ $producto->detalleVentas->count() }}</div>
        <div class="stat-label">Ventas Realizadas</div>
    </div>
</div>

<div class="card">
    <h3><i class="fas fa-exchange-alt"></i> Historial de Movimientos de Inventario</h3>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($producto->movimientosInventario as $movimiento)
                <tr>
                    <td>{{ $movimiento->ID_Movimiento }}</td>
                    <td>
                        <span class="status-badge {{ $movimiento->Tipo == 'Entrada' ? 'status-active' : 'status-cancelled' }}">
                            @if($movimiento->Tipo == 'Entrada')
                                <i class="fas fa-plus-circle"></i> Entrada
                            @else
                                <i class="fas fa-minus-circle"></i> Salida
                            @endif
                        </span>
                    </td>
                    <td style="font-weight: bold; color: {{ $movimiento->Tipo == 'Entrada' ? '#22c55e' : '#ef4444' }};">
                        {{ $movimiento->Tipo == 'Entrada' ? '+' : '-' }}{{ $movimiento->Cantidad }}
                    </td>
                    <td>{{ $movimiento->Fecha->format('d/m/Y H:i') }}</td>
                    <td>
                        <span class="status-badge status-active">
                            <i class="fas fa-check"></i> Procesado
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: rgba(255, 255, 255, 0.6);">
                        <i class="fas fa-info-circle"></i> No hay movimientos de inventario registrados
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <h3><i class="fas fa-chart-line"></i> Historial de Ventas</h3>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Cliente</th>
                    <th>Cantidad Vendida</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($producto->detalleVentas as $detalle)
                <tr>
                    <td>{{ $detalle->ID_Venta }}</td>
                    <td>{{ $detalle->venta->cliente->Nombres ?? 'N/A' }} {{ $detalle->venta->cliente->Apellidos ?? '' }}</td>
                    <td style="font-weight: bold; color: #ef4444;">{{ $detalle->Cantidad }}</td>
                    <td>S/ {{ number_format($detalle->Precio, 2) }}</td>
                    <td style="font-weight: bold; color: #22c55e;">S/ {{ number_format($detalle->Cantidad * $detalle->Precio, 2) }}</td>
                    <td>{{ $detalle->venta->Fecha->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: rgba(255, 255, 255, 0.6);">
                        <i class="fas fa-info-circle"></i> No hay ventas registradas para este producto
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="text-align: center; margin-top: 2rem;">
    <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning">
        <i class="fas fa-edit"></i> Editar Producto
    </a>
    <a href="{{ route('productos.index') }}" class="btn btn-primary">
        <i class="fas fa-arrow-left"></i> Volver a Lista
    </a>
    @if($producto->Cantidad > 0)
        <a href="{{ route('ventas.create') }}" class="btn btn-success">
            <i class="fas fa-cart-plus"></i> Registrar Venta
        </a>
    @endif
    
    @if($producto->Cantidad <= 5)
        <button class="btn btn-warning" onclick="alert('¡Alerta! Stock bajo. Considera reabastecer este producto.')">
            <i class="fas fa-exclamation-triangle"></i> Stock Bajo
        </button>
    @endif
</div>
@endsection