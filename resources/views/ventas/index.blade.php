@extends('layouts.app')

@section('title', 'Ventas')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-shopping-cart"></i> Gestión de Ventas</h2>
    <p>Registra y administra las ventas del salón</p>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap;">
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" id="searchVentas" placeholder="Buscar venta...">
        </div>
        <a href="{{ route('ventas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Venta
        </a>
    </div>

    <div class="table-container">
        <table class="table" id="ventasTable">
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
                    <td>{{ str_pad($venta->ID_Venta, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-user" style="color: #667eea; margin-right: 0.5rem;"></i>
                            {{ $venta->cliente->Nombres ?? 'N/A' }} {{ $venta->cliente->Apellidos ?? '' }}
                        </div>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-calendar" style="color: rgba(255,255,255,0.6); margin-right: 0.5rem;"></i>
                            {{ $venta->Fecha->format('d/m/Y H:i') }}
                        </div>
                    </td>
                    <td>
                        <span style="font-weight: 600; color: #feca57; font-size: 1.1rem;">
                            S/ {{ number_format($venta->Total, 2) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('ventas.show', $venta) }}" 
                           class="btn btn-primary" 
                           style="padding: 0.5rem 0.75rem;"
                           title="Ver Detalles">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button class="btn btn-success" 
                                style="padding: 0.5rem 0.75rem;"
                                onclick="imprimirRecibo({{ $venta->ID_Venta }})"
                                title="Imprimir Recibo">
                            <i class="fas fa-print"></i>
                        </button>
                        <a href="{{ route('ventas.edit', $venta) }}" 
                           class="btn btn-warning" 
                           style="padding: 0.5rem 0.75rem;"
                           title="Editar Venta">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" 
                              action="{{ route('ventas.destroy', $venta) }}" 
                              style="display:inline;" 
                              onsubmit="return confirm('¿Está seguro de eliminar esta venta?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-danger" 
                                    style="padding: 0.5rem 0.75rem;"
                                    title="Eliminar Venta">
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

<!-- Resumen de Ventas -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-receipt"></i>
        </div>
        <div class="stat-number">{{ $ventas->count() }}</div>
        <div class="stat-label">Total de Ventas</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div class="stat-number">S/ {{ number_format($ventas->sum('Total'), 2) }}</div>
        <div class="stat-label">Monto Total</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-calendar-day"></i>
        </div>
        <div class="stat-number">
            {{ $ventas->filter(function($venta) { return $venta->Fecha->isToday(); })->count() }}
        </div>
        <div class="stat-label">Ventas Hoy</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="stat-number">S/ {{ number_format($ventas->avg('Total'), 2) }}</div>
        <div class="stat-label">Venta Promedio</div>
    </div>
</div>

<!-- Filtros rápidos -->
<div class="card">
    <h3 style="color: white; margin-bottom: 1rem;">
        <i class="fas fa-filter"></i> Filtros Rápidos
    </h3>
    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
        <button class="btn btn-primary" onclick="filtrarPorFecha('todas')">
            <i class="fas fa-calendar"></i> Todas
        </button>
        <button class="btn btn-warning" onclick="filtrarPorFecha('hoy')">
            <i class="fas fa-calendar-day"></i> Hoy
        </button>
        <button class="btn btn-success" onclick="filtrarPorFecha('semana')">
            <i class="fas fa-calendar-week"></i> Esta Semana
        </button>
        <button class="btn btn-danger" onclick="filtrarPorFecha('mes')">
            <i class="fas fa-calendar-alt"></i> Este Mes
        </button>
    </div>
    
    <div style="margin-top: 1rem;">
        <label style="color: white; margin-right: 1rem;">Rango de Montos:</label>
        <input type="number" 
               id="montoMin" 
               placeholder="Mínimo" 
               class="form-control" 
               style="width: 150px; display: inline-block;">
        <span style="color: white; margin: 0 0.5rem;">-</span>
        <input type="number" 
               id="montoMax" 
               placeholder="Máximo" 
               class="form-control" 
               style="width: 150px; display: inline-block;">
        <button class="btn btn-primary" onclick="filtrarPorMonto()" style="margin-left: 1rem;">
            <i class="fas fa-filter"></i> Filtrar
        </button>
    </div>
</div>

<script>
    // Búsqueda en tiempo real
    document.getElementById('searchVentas').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const table = document.getElementById('ventasTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        for (let row of rows) {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        }
    });

    // Filtrar por fecha
    function filtrarPorFecha(filtro) {
        const table = document.getElementById('ventasTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        const hoy = new Date();
        
        for (let row of rows) {
            const fechaCelda = row.cells[2].textContent;
            const partesFecha = fechaCelda.split(' ')[0].split('/');
            const fechaVenta = new Date(partesFecha[2], partesFecha[1] - 1, partesFecha[0]);
            
            let mostrar = true;
            
            switch(filtro) {
                case 'hoy':
                    mostrar = fechaVenta.toDateString() === hoy.toDateString();
                    break;
                case 'semana':
                    const inicioSemana = new Date(hoy);
                    inicioSemana.setDate(hoy.getDate() - hoy.getDay());
                    mostrar = fechaVenta >= inicioSemana;
                    break;
                case 'mes':
                    mostrar = fechaVenta.getMonth() === hoy.getMonth() && 
                              fechaVenta.getFullYear() === hoy.getFullYear();
                    break;
            }
            
            row.style.display = mostrar ? '' : 'none';
        }
    }

    // Filtrar por monto
    function filtrarPorMonto() {
        const montoMin = parseFloat(document.getElementById('montoMin').value) || 0;
        const montoMax = parseFloat(document.getElementById('montoMax').value) || Infinity;
        const table = document.getElementById('ventasTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        for (let row of rows) {
            const montoTexto = row.cells[3].textContent;
            const monto = parseFloat(montoTexto.replace('S/', '').replace(',', ''));
            
            row.style.display = (monto >= montoMin && monto <= montoMax) ? '' : 'none';
        }
    }

    // Imprimir recibo
    function imprimirRecibo(ventaId) {
        window.open(`{{ url('ventas') }}/${ventaId}?print=true`, '_blank');
    }

    // Ordenar tabla por columna
    function sortTable(columnIndex) {
        const table = document.getElementById('ventasTable');
        const tbody = table.getElementsByTagName('tbody')[0];
        const rows = Array.from(tbody.getElementsByTagName('tr'));
        
        rows.sort((a, b) => {
            const aValue = a.cells[columnIndex].textContent;
            const bValue = b.cells[columnIndex].textContent;
            
            if (columnIndex === 3) { // Total
                return parseFloat(aValue.replace(/[^0-9.-]+/g,"")) - parseFloat(bValue.replace(/[^0-9.-]+/g,""));
            } else if (columnIndex === 2) { // Fecha
                const aDate = new Date(aValue.split(' ')[0].split('/').reverse().join('-'));
                const bDate = new Date(bValue.split(' ')[0].split('/').reverse().join('-'));
                return aDate - bDate;
            } else {
                return aValue.localeCompare(bValue);
            }
        });
        
        tbody.innerHTML = '';
        rows.forEach(row => tbody.appendChild(row));
    }

    // Hacer columnas ordenables
    document.querySelectorAll('#ventasTable th').forEach((th, index) => {
        if (index < 4) { // Solo las primeras 4 columnas
            th.style.cursor = 'pointer';
            th.addEventListener('click', () => sortTable(index));
        }
    });
</script>
@endsection