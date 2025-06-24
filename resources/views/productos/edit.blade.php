@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-edit"></i> Editar Producto</h2>
    <p>Actualiza la información del producto seleccionado</p>
</div>

<div class="card">
    <h3><i class="fas fa-box"></i> Información del Producto</h3>
    
    <form method="POST" action="{{ route('productos.update', $producto) }}">
        @csrf
        @method('PUT')
        
        <div class="form-grid">
            <div class="form-group">
                <label for="Nombre" class="form-label">Nombre del Producto:</label>
                <input type="text" id="Nombre" name="Nombre" class="form-control" value="{{ old('Nombre', $producto->Nombre) }}" required>
            </div>

            <div class="form-group">
                <label for="Cantidad" class="form-label">Cantidad en Stock:</label>
                <input type="number" id="Cantidad" name="Cantidad" class="form-control" value="{{ old('Cantidad', $producto->Cantidad) }}" min="0" required>
            </div>

            <div class="form-group">
                <label for="Precio_Venta" class="form-label">Precio de Venta:</label>
                <input type="number" id="Precio_Venta" name="Precio_Venta" class="form-control" value="{{ old('Precio_Venta', $producto->Precio_Venta) }}" step="0.01" min="0" required>
            </div>
        </div>

        <div style="text-align: center; margin-top: 2rem;">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Actualizar Producto
            </button>
            <a href="{{ route('productos.index') }}" class="btn btn-danger">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<div class="card">
    <h3><i class="fas fa-info-circle"></i> Estado Actual del Stock</h3>
    
    <div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-cubes"></i>
            </div>
            <div class="stat-number">{{ $producto->Cantidad }}</div>
            <div class="stat-label">Unidades en Stock</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-number">S/ {{ number_format($producto->Precio_Venta, 2) }}</div>
            <div class="stat-label">Precio Actual</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                @if($producto->Cantidad > 10)
                    <i class="fas fa-check-circle" style="color: #22c55e;"></i>
                @elseif($producto->Cantidad > 0)
                    <i class="fas fa-exclamation-triangle" style="color: #fbbf24;"></i>
                @else
                    <i class="fas fa-times-circle" style="color: #ef4444;"></i>
                @endif
            </div>
            <div class="stat-number" style="font-size: 1.5rem;">
                @if($producto->Cantidad > 10)
                    Disponible
                @elseif($producto->Cantidad > 0)
                    Poco Stock
                @else
                    Agotado
                @endif
            </div>
            <div class="stat-label">Estado del Stock</div>
        </div>
    </div>
</div>
@endsection