@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<h2>Gestión de Productos</h2>

<a href="{{ route('productos.create') }}">Nuevo Producto</a>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Precio Venta</th>
            <th>Estado Stock</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productos as $producto)
        <tr>
            <td>{{ $producto->ID_Producto }}</td>
            <td>{{ $producto->Nombre }}</td>
            <td>{{ $producto->Cantidad }}</td>
            <td>S/ {{ number_format($producto->Precio_Venta, 2) }}</td>
            <td>
                @if($producto->Cantidad > 10)
                    Disponible
                @elseif($producto->Cantidad > 0)
                    Poco Stock
                @else
                    Agotado
                @endif
            </td>
            <td>
                <a href="{{ route('productos.show', $producto) }}">Ver</a>
                <a href="{{ route('productos.edit', $producto) }}">Editar</a>
                <form method="POST" action="{{ route('productos.destroy', $producto) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Está seguro?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection