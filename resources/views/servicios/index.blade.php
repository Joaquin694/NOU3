@extends('layouts.app')

@section('title', 'Servicios')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-cut"></i> Gestión de Servicios</h2>
    <p>Administra los servicios ofrecidos por el salón</p>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap;">
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" id="searchServicios" placeholder="Buscar servicio...">
        </div>
        <a href="{{ route('servicios.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Servicio
        </a>
    </div>

    <div class="table-container">
        <table class="table" id="serviciosTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Duración</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servicios as $servicio)
                <tr>
                    <td>{{ str_pad($servicio->ID_Servicio, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <div style="display: flex; align-items: center;">
                            @if(str_contains(strtolower($servicio->Nombre), 'corte'))
                                <i class="fas fa-cut" style="color: #feca57; margin-right: 0.5rem;"></i>
                            @elseif(str_contains(strtolower($servicio->Nombre), 'manicure') || str_contains(strtolower($servicio->Nombre), 'uñas'))
                                <i class="fas fa-hand-sparkles" style="color: #ff6b6b; margin-right: 0.5rem;"></i>
                            @elseif(str_contains(strtolower($servicio->Nombre), 'tinte') || str_contains(strtolower($servicio->Nombre), 'color'))
                                <i class="fas fa-palette" style="color: #a8e6cf; margin-right: 0.5rem;"></i>
                            @elseif(str_contains(strtolower($servicio->Nombre), 'peinado'))
                                <i class="fas fa-magic" style="color: #f093fb; margin-right: 0.5rem;"></i>
                            @else
                                <i class="fas fa-spa" style="color: #667eea; margin-right: 0.5rem;"></i>
                            @endif
                            {{ $servicio->Nombre }}
                        </div>
                    </td>
                    <td>
                        <span style="font-weight: 600; color: #feca57;">
                            S/ {{ number_format($servicio->Precio, 2) }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-clock" style="color: rgba(255,255,255,0.6); margin-right: 0.5rem;"></i>
                            {{ $servicio->Duracion }} min
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('servicios.show', $servicio) }}" 
                           class="btn btn-primary" 
                           style="padding: 0.5rem 0.75rem;"
                           title="Ver Detalles">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('servicios.edit', $servicio) }}" 
                           class="btn btn-warning" 
                           style="padding: 0.5rem 0.75rem;"
                           title="Editar Servicio">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" 
                              action="{{ route('servicios.destroy', $servicio) }}" 
                              style="display:inline;" 
                              onsubmit="return confirm('¿Está seguro de eliminar este servicio?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-danger" 
                                    style="padding: 0.5rem 0.75rem;"
                                    title="Eliminar Servicio">
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

<!-- Estadísticas de servicios -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-list"></i>
        </div>
        <div class="stat-number">{{ $servicios->count() }}</div>
        <div class="stat-label">Total de Servicios</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="stat-number">S/ {{ number_format($servicios->avg('Precio'), 2) }}</div>
        <div class="stat-label">Precio Promedio</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-number">{{ round($servicios->avg('Duracion')) }} min</div>
        <div class="stat-label">Duración Promedio</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="stat-number">S/ {{ number_format($servicios->max('Precio'), 2) }}</div>
        <div class="stat-label">Servicio Más Caro</div>
    </div>
</div>

<script>
    // Búsqueda en tiempo real
    document.getElementById('searchServicios').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const table = document.getElementById('serviciosTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        for (let row of rows) {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        }
    });

    // Ordenar tabla por columna
    function sortTable(columnIndex) {
        const table = document.getElementById('serviciosTable');
        const tbody = table.getElementsByTagName('tbody')[0];
        const rows = Array.from(tbody.getElementsByTagName('tr'));
        
        rows.sort((a, b) => {
            const aValue = a.cells[columnIndex].textContent;
            const bValue = b.cells[columnIndex].textContent;
            
            if (columnIndex === 2) { // Precio
                return parseFloat(aValue.replace(/[^0-9.-]+/g,"")) - parseFloat(bValue.replace(/[^0-9.-]+/g,""));
            } else if (columnIndex === 3) { // Duración
                return parseInt(aValue) - parseInt(bValue);
            } else {
                return aValue.localeCompare(bValue);
            }
        });
        
        tbody.innerHTML = '';
        rows.forEach(row => tbody.appendChild(row));
    }

    // Hacer columnas ordenables
    document.querySelectorAll('#serviciosTable th').forEach((th, index) => {
        if (index < 4) { // Solo las primeras 4 columnas
            th.style.cursor = 'pointer';
            th.addEventListener('click', () => sortTable(index));
        }
    });
</script>
@endsection