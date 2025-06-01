@extends('layouts.app')

@section('title', 'Nuevo Producto')

@section('content')
<h2>Nuevo Producto</h2>

<form method="POST" action="{{ route('productos.store') }}">
    @csrf
    
    <div>
        <label for="Nombre">Nombre del Producto:</label>
        <input type="text" id="Nombre" name="Nombre" value="{{ old('Nombre') }}" required>
    </div>

    <div>
        <label for="Cantidad">Cantidad en Stock:</label>
        <input type="number" id="Cantidad" name="Cantidad" value="{{ old('Cantidad') }}" min="0" required>
    </div>

    <div>
        <label for="Precio_Venta">Precio de Venta:</label>
        <input type="number" id="Precio_Venta" name="Precio_Venta" value="{{ old('Precio_Venta') }}" step="0.01" min="0" required>
    </div>

    <div>
        <button type="submit">Guardar Producto</button>
        <a href="{{ route('productos.index') }}">Cancelar</a>
    </div>
</form>
@endsection