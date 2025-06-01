@extends('layouts.app')

@section('title', 'Detalle de la Venta')

@section('content')
<h2>Detalle de la Venta</h2>

<table border="1">
    <tr>
        <th>ID Venta:</th>
        <td>{{ $venta->ID_Venta }}</td>
    </tr>
    <tr>
        <th>Cliente:</th>
        <td>{{ $venta->cliente->Nombres ?? 'N/A' }} {{ $venta->cliente->Apellidos ?? '' }}</td>
    </tr>
    <tr>
        <th>DNI Cliente:</th>
        <td>{{ $venta->cliente->DNI ?? 'N/A' }}</td>
    </tr>
    <tr>
        <th>Fecha:</th>
        <td>{{ $venta->Fecha->format('d/m/Y H:i') }}</td>
    </tr>
    <tr>
        <th>Total:</th>
        <td>S/ {{ number_format($venta->Total, 2) }}</td>
    </tr>
</table>

<h3>Detalles de Productos</h3>
<table border="1">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($venta->detalles as $detalle)
        <tr>
            <td>{{ $detalle->producto->Nombre ?? 'N/A' }}</td>
            <td>{{ $detalle->Cantidad }}</td>
            <td>S/ {{ number_format($detalle->Precio, 2) }}</td>
            <td>S/ {{ number_format($detalle->Cantidad * $detalle->Precio, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('ventas.edit', $venta) }}">Editar</a>
<a href="{{ route('ventas.index') }}">Volver</a>

<br><br>
<button onclick="window.print()">Imprimir Recibo</button>
@endsection