@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-box"></i> Gestión de Productos</h2>
    <p>Administra el inventario de productos del salón</p>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" placeholder="Buscar producto..." id="searchProduct">
        </div>
        <a href="{{ route('productos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Producto
        </a>
    </div>

    <div class="table-container">
        <table class="table">
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
                    <td>
                        <span style="font-weight: bold; 
                            color: @if($producto->Cantidad > 10) #22c55e
                                  @elseif($producto->Cantidad > 0) #fbbf24
                                  @else #ef4444 @endif">
                            {{ $producto->Cantidad }}
                        </span>
                    </td>
                    <td>S/ {{ number_format($producto->Precio_Venta, 2) }}</td>
                    <td>
                        <span class="status-badge 
                            @if($producto->Cantidad > 10) status-active
                            @elseif($producto->Cantidad > 0) status-pending
                            @else status-cancelled
                            @endif
                        ">
                            @if($producto->Cantidad > 10)
                                <i class="fas fa-check-circle"></i> Disponible
                            @elseif($producto->Cantidad > 0)
                                <i class="fas fa-exclamation-triangle"></i> Poco Stock
                            @else
                                <i class="fas fa-times-circle"></i> Agotado
                            @endif
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('productos.show', $producto) }}" class="btn btn-primary">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('productos.destroy', $producto) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar este producto?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
document.getElementById('searchProduct').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.table tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endsection