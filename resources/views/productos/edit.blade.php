@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<h2>Editar Producto</h2>

<form method="POST" action="{{ route('productos.update', $producto) }}">
    @csrf
    @method('PUT')
    
    <div>
        <label for="Nombre">Nombre del Producto:</label>
        <input type="text" id="Nombre" name="Nombre" value="{{ old('Nombre', $producto->Nombre) }}" required>
    </div>

    <div>
        <label for="Cantidad">Cantidad en Stock:</label>
        <input type="number" id="Cantidad" name="Cantidad" value="{{ old('Cantidad', $producto->Cantidad) }}" min="0" required>
    </div>

    <div>
        <label for="Precio_Venta">Precio de Venta:</label>
        <input type="number" id="Precio_Venta" name="Precio_Venta" value="{{ old('Precio_Venta', $producto->Precio_Venta) }}" step="0.01" min="0" required>
    </div>

    <div>
        <button type="submit">Actualizar Producto</button>
        <a href="{{ route('productos.index') }}">Cancelar</a>
    </div>
</form>
@endsection