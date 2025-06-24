@extends('layouts.app')

@section('title', 'Nueva Venta')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-plus-circle"></i> Nueva Venta</h2>
    <p>Registra una nueva venta de productos del salón</p>
</div>

<div class="card">
    <h3><i class="fas fa-shopping-cart"></i> Información de la Venta</h3>
    
    <form method="POST" action="{{ route('ventas.store') }}" id="ventaForm">
        @csrf
        
        <div class="form-grid">
            <div class="form-group">
                <label for="ID_Cliente" class="form-label">Cliente:</label>
                <select id="ID_Cliente" name="ID_Cliente" class="form-control" required>
                    <option value="">Seleccione un cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->ID_Cliente }}" {{ old('ID_Cliente') == $cliente->ID_Cliente ? 'selected' : '' }}>
                            {{ $cliente->Nombres }} {{ $cliente->Apellidos }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="Fecha" class="form-label">Fecha:</label>
                <input type="datetime-local" id="Fecha" name="Fecha" class="form-control" value="{{ old('Fecha', now()->format('Y-m-d\TH:i')) }}" required>
            </div>

            <div class="form-group">
                <label for="Total" class="form-label">Total:</label>
                <input type="number" id="Total" name="Total" class="form-control" value="{{ old('Total') }}" step="0.01" min="0" readonly>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <h3><i class="fas fa-box"></i> Productos Disponibles</h3>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                <tr data-producto-id="{{ $producto->ID_Producto }}">
                    <td>{{ $producto->Nombre }}</td>
                    <td class="precio">S/ {{ number_format($producto->Precio_Venta, 2) }}</td>
                    <td>
                        <span class="status-badge {{ $producto->Cantidad > 0 ? 'status-active' : 'status-cancelled' }}">
                            {{ $producto->Cantidad }}
                        </span>
                    </td>
                    <td>
                        <input type="number" 
                               class="form-control cantidad-input" 
                               min="0" 
                               max="{{ $producto->Cantidad }}" 
                               value="0"
                               style="width: 80px;"
                               {{ $producto->Cantidad == 0 ? 'disabled' : '' }}>
                    </td>
                    <td class="subtotal">S/ 0.00</td>
                    <td>
                        <button type="button" 
                                class="btn btn-success agregar-producto" 
                                data-id="{{ $producto->ID_Producto }}"
                                data-nombre="{{ $producto->Nombre }}"
                                data-precio="{{ $producto->Precio_Venta }}"
                                {{ $producto->Cantidad == 0 ? 'disabled' : '' }}>
                            <i class="fas fa-plus"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <h3><i class="fas fa-list"></i> Productos Seleccionados</h3>
    
    <div class="table-container">
        <table class="table" id="productosSeleccionados">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unit.</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <!-- Se llena dinámicamente -->
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" style="text-align: right;">TOTAL:</th>
                    <th id="totalVenta">S/ 0.00</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div style="text-align: center; margin-top: 2rem;">
    <button type="button" class="btn btn-success" onclick="procesarVenta()" id="btnProcesar" disabled>
        <i class="fas fa-save"></i> Registrar Venta
    </button>
    <a href="{{ route('ventas.index') }}" class="btn btn-danger">
        <i class="fas fa-times"></i> Cancelar
    </a>
</div>

<script>
let productosCarrito = [];
let total = 0;

// Actualizar subtotal cuando cambia cantidad
document.querySelectorAll('.cantidad-input').forEach(input => {
    input.addEventListener('input', function() {
        const row = this.closest('tr');
        const precio = parseFloat(row.querySelector('.precio').textContent.replace('S/', '').replace(',', ''));
        const cantidad = parseInt(this.value) || 0;
        const subtotal = precio * cantidad;
        
        row.querySelector('.subtotal').textContent = `S/ ${subtotal.toFixed(2)}`;
    });
});

// Agregar producto al carrito
document.querySelectorAll('.agregar-producto').forEach(btn => {
    btn.addEventListener('click', function() {
        const row = this.closest('tr');
        const cantidadInput = row.querySelector('.cantidad-input');
        const cantidad = parseInt(cantidadInput.value);
        
        if (cantidad > 0) {
            const producto = {
                id: this.dataset.id,
                nombre: this.dataset.nombre,
                precio: parseFloat(this.dataset.precio),
                cantidad: cantidad
            };
            
            agregarAlCarrito(producto);
            cantidadInput.value = 0;
            row.querySelector('.subtotal').textContent = 'S/ 0.00';
        }
    });
});

function agregarAlCarrito(producto) {
    const existe = productosCarrito.find(p => p.id === producto.id);
    
    if (existe) {
        existe.cantidad += producto.cantidad;
    } else {
        productosCarrito.push(producto);
    }
    
    actualizarCarrito();
}

function eliminarDelCarrito(id) {
    productosCarrito = productosCarrito.filter(p => p.id !== id);
    actualizarCarrito();
}

function actualizarCarrito() {
    const tbody = document.querySelector('#productosSeleccionados tbody');
    tbody.innerHTML = '';
    total = 0;
    
    productosCarrito.forEach(producto => {
        const subtotal = producto.precio * producto.cantidad;
        total += subtotal;
        
        const row = `
            <tr>
                <td>${producto.nombre}</td>
                <td>${producto.cantidad}</td>
                <td>S/ ${producto.precio.toFixed(2)}</td>
                <td>S/ ${subtotal.toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-danger" onclick="eliminarDelCarrito('${producto.id}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
    
    document.getElementById('totalVenta').textContent = `S/ ${total.toFixed(2)}`;
    document.getElementById('Total').value = total.toFixed(2);
    document.getElementById('btnProcesar').disabled = productosCarrito.length === 0;
}

function procesarVenta() {
    if (productosCarrito.length === 0) {
        alert('Debe agregar al menos un producto');
        return;
    }
    
    // Crear inputs hidden para los productos
    const form = document.getElementById('ventaForm');
    
    productosCarrito.forEach((producto, index) => {
        const inputProducto = document.createElement('input');
        inputProducto.type = 'hidden';
        inputProducto.name = `productos[${index}][ID_Producto]`;
        inputProducto.value = producto.id;
        form.appendChild(inputProducto);
        
        const inputCantidad = document.createElement('input');
        inputCantidad.type = 'hidden';
        inputCantidad.name = `productos[${index}][Cantidad]`;
        inputCantidad.value = producto.cantidad;
        form.appendChild(inputCantidad);
        
        const inputPrecio = document.createElement('input');
        inputPrecio.type = 'hidden';
        inputPrecio.name = `productos[${index}][Precio]`;
        inputPrecio.value = producto.precio;
        form.appendChild(inputPrecio);
    });
    
    form.submit();
}
</script>
@endsection