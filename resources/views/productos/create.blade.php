@extends('layouts.app')

@section('title', 'Nuevo Producto')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-plus-circle"></i> Nuevo Producto</h2>
    <p>Registra un nuevo producto en el inventario</p>
</div>

<div class="card">
    <h3><i class="fas fa-box"></i> Información del Producto</h3>
    
    <form method="POST" action="{{ route('productos.store') }}">
        @csrf
        
        <div class="form-grid">
            <div class="form-group">
                <label for="Nombre" class="form-label">Nombre del Producto:</label>
                <input type="text" id="Nombre" name="Nombre" class="form-control" value="{{ old('Nombre') }}" placeholder="Ej: Shampoo Premium" required>
            </div>

            <div class="form-group">
                <label for="Cantidad" class="form-label">Cantidad en Stock:</label>
                <input type="number" id="Cantidad" name="Cantidad" class="form-control" value="{{ old('Cantidad') }}" placeholder="0" min="0" required>
            </div>

            <div class="form-group">
                <label for="Precio_Venta" class="form-label">Precio de Venta:</label>
                <input type="number" id="Precio_Venta" name="Precio_Venta" class="form-control" value="{{ old('Precio_Venta') }}" placeholder="0.00" step="0.01" min="0" required>
            </div>
        </div>

        <div style="text-align: center; margin-top: 2rem;">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar Producto
            </button>
            <a href="{{ route('productos.index') }}" class="btn btn-danger">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection