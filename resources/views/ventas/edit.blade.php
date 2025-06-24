@extends('layouts.app')

@section('title', 'Editar Venta')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-edit"></i> Editar Venta</h2>
    <p>Modifica los datos de la venta seleccionada</p>
</div>

<div class="card">
    <h3><i class="fas fa-shopping-cart"></i> Información de la Venta</h3>
    
    <form method="POST" action="{{ route('ventas.update', $venta) }}">
        @csrf
        @method('PUT')
        
        <div class="form-grid">
            <div class="form-group">
                <label for="ID_Cliente" class="form-label">Cliente:</label>
                <select id="ID_Cliente" name="ID_Cliente" class="form-control" required>
                    <option value="">Seleccione un cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->ID_Cliente }}" {{ old('ID_Cliente', $venta->ID_Cliente) == $cliente->ID_Cliente ? 'selected' : '' }}>
                            {{ $cliente->Nombres }} {{ $cliente->Apellidos }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="Fecha" class="form-label">Fecha:</label>
                <input type="datetime-local" id="Fecha" name="Fecha" class="form-control" value="{{ old('Fecha', $venta->Fecha->format('Y-m-d\TH:i')) }}" required>
            </div>

            <div class="form-group">
                <label for="Total" class="form-label">Total:</label>
                <input type="number" id="Total" name="Total" class="form-control" value="{{ old('Total', $venta->Total) }}" step="0.01" min="0" required>
            </div>
        </div>

        <div style="text-align: center; margin-top: 2rem;">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Actualizar Venta
            </button>
            <a href="{{ route('ventas.index') }}" class="btn btn-danger">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<div class="card">
    <h3><i class="fas fa-info-circle"></i> Detalles Actuales de la Venta</h3>
    
    <div class="table-container">
        <table class="table">
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
    </div>
</div>
@endsection