@extends('layouts.app')

@section('title', 'Ventas')

@section('content')
<h2>Gestión de Ventas</h2>

<a href="{{ route('ventas.create') }}">Nueva Venta</a>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ventas as $venta)
        <tr>
            <td>{{ $venta->ID_Venta }}</td>
            <td>{{ $venta->cliente->Nombres ?? 'N/A' }} {{ $venta->cliente->Apellidos ?? '' }}</td>
            <td>{{ $venta->Fecha->format('d/m/Y H:i') }}</td>
            <td>S/ {{ number_format($venta->Total, 2) }}</td>
            <td>
                <a href="{{ route('ventas.show', $venta) }}">Ver</a>
                <a href="{{ route('ventas.edit', $venta) }}">Editar</a>
                <form method="POST" action="{{ route('ventas.destroy', $venta) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Está seguro?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3>Resumen de Ventas</h3>
<p>Total de Ventas: {{ $ventas->count() }}</p>
<p>Monto Total: S/ {{ number_format($ventas->sum('Total'), 2) }}</p>
@endsection