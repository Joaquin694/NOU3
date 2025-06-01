@extends('layouts.app')

@section('title', 'Detalle del Producto')

@section('content')
<h2>Detalle del Producto</h2>

<table border="1">
    <tr>
        <th>ID:</th>
        <td>{{ $producto->ID_Producto }}</td>
    </tr>
    <tr>
        <th>Nombre:</th>
        <td>{{ $producto->Nombre }}</td>
    </tr>
    <tr>
        <th>Cantidad:</th>
        <td>{{ $producto->Cantidad }}</td>
    </tr>
    <tr>
        <th>Precio Venta:</th>
        <td>S/ {{ number_format($producto->Precio_Venta, 2) }}</td>
    </tr>
    <tr>
        <th>Estado:</th>
        <td>
            @if($producto->Cantidad > 10)
                <span style="color: green;">Disponible</span>
            @elseif($producto->Cantidad > 0)
                <span style="color: orange;">Poco Stock</span>
            @else
                <span style="color: red;">Agotado</span>
            @endif
        </td>
    </tr>
    <tr>
        <th>Creado:</th>
        <td>{{ $producto->created_at->format('d/m/Y H:i') }}</td>
    </tr>
    <tr>
        <th>Actualizado:</th>
        <td>{{ $producto->updated_at->format('d/m/Y H:i') }}</td>
    </tr>
</table>

<h3>Movimientos de Inventario</h3>
<table border="1">
    <thead>
        <tr>
            <th>Tipo</th>
            <th>Cantidad</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach($producto->movimientosInventario as $movimiento)
        <tr>
            <td>{{ $movimiento->Tipo }}</td>
            <td>{{ $movimiento->Cantidad }}</td>
            <td>{{ $movimiento->Fecha->format('d/m/Y H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('productos.edit', $producto) }}">Editar</a>
<a href="{{ route('productos.index') }}">Volver</a>
@endsection