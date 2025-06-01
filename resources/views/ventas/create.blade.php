@extends('layouts.app')

@section('title', 'Nueva Venta')

@section('content')
<h2>Nueva Venta</h2>

<form method="POST" action="{{ route('ventas.store') }}">
    @csrf
    
    <div>
        <label for="ID_Cliente">Cliente:</label>
        <select id="ID_Cliente" name="ID_Cliente" required>
            <option value="">Seleccione un cliente</option>
            @foreach($clientes as $cliente)
                <option value="{{ $cliente->ID_Cliente }}" {{ old('ID_Cliente') == $cliente->ID_Cliente ? 'selected' : '' }}>
                    {{ $cliente->Nombres }} {{ $cliente->Apellidos }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="Fecha">Fecha:</label>
        <input type="datetime-local" id="Fecha" name="Fecha" value="{{ old('Fecha', now()->format('Y-m-d\TH:i')) }}" required>
    </div>

    <div>
        <label for="Total">Total:</label>
        <input type="number" id="Total" name="Total" value="{{ old('Total') }}" step="0.01" min="0" required>
    </div>

    <h3>Productos Disponibles</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            <tr>
                <td>{{ $producto->Nombre }}</td>
                <td>S/ {{ number_format($producto->Precio_Venta, 2) }}</td>
                <td>{{ $producto->Cantidad }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        <button type="submit">Registrar Venta</button>
        <a href="{{ route('ventas.index') }}">Cancelar</a>
    </div>
</form>
@endsection