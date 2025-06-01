@extends('layouts.app')

@section('title', 'Editar Venta')

@section('content')
<h2>Editar Venta</h2>

<form method="POST" action="{{ route('ventas.update', $venta) }}">
    @csrf
    @method('PUT')
    
    <div>
        <label for="ID_Cliente">Cliente:</label>
        <select id="ID_Cliente" name="ID_Cliente" required>
            <option value="">Seleccione un cliente</option>
            @foreach($clientes as $cliente)
                <option value="{{ $cliente->ID_Cliente }}" {{ old('ID_Cliente', $venta->ID_Cliente) == $cliente->ID_Cliente ? 'selected' : '' }}>
                    {{ $cliente->Nombres }} {{ $cliente->Apellidos }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="Fecha">Fecha:</label>
        <input type="datetime-local" id="Fecha" name="Fecha" value="{{ old('Fecha', $venta->Fecha->format('Y-m-d\TH:i')) }}" required>
    </div>

    <div>
        <label for="Total">Total:</label>
        <input type="number" id="Total" name="Total" value="{{ old('Total', $venta->Total) }}" step="0.01" min="0" required>
    </div>

    <div>
        <button type="submit">Actualizar Venta</button>
        <a href="{{ route('ventas.index') }}">Cancelar</a>
    </div>
</form>
@endsection