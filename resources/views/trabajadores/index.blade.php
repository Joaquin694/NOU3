@extends('layouts.app')

@section('title', 'Trabajadores')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-user-tie"></i> Gestión de Trabajadores</h2>
    <p>Administra el personal del salón</p>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap;">
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" id="searchTrabajadores" placeholder="Buscar trabajador...">
        </div>
        <a href="{{ route('trabajadores.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Trabajador
        </a>
    </div>

    <div class="table-container">
        <table class="table" id="trabajadoresTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Cargo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trabajadores as $trabajador)
                <tr>
                    <td>{{ str_pad($trabajador->ID_Trabajador, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <div style="display: flex; align-items: center;">
                            @if($trabajador->Cargo == 'Estilista')
                                <i class="fas fa-cut" style="color: #feca57; margin-right: 0.5rem;"></i>
                            @elseif($trabajador->Cargo == 'Manicurista' || $trabajador->Cargo == 'Pedicurista')
                                <i class="fas fa-hand-sparkles" style="color: #ff6b6b; margin-right: 0.5rem;"></i>
                            @elseif($trabajador->Cargo == 'Recepcionista')
                                <i class="fas fa-user-check" style="color: #667eea; margin-right: 0.5rem;"></i>
                            @elseif($trabajador->Cargo == 'Cosmetóloga')
                                <i class="fas fa-spa" style="color: #a8e6cf; margin-right: 0.5rem;"></i>
                            @else
                                <i class="fas fa-user" style="color: #f093fb; margin-right: 0.5rem;"></i>
                            @endif
                            {{ $trabajador->Nombres }}
                        </div>
                    </td>
                    <td>{{ $trabajador->Apellidos }}</td>
                    <td>
                        <span style="padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.85rem; 
                            background: rgba(255,255,255,0.1); color: white;">
                            {{ $trabajador->Cargo }}
                        </span>
                    </td>
                    <td>
                        @if($trabajador->Estado == 'Activo')
                            <span class="status-badge status-active">Activo</span>
                        @else
                            <span class="status-badge status-cancelled">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('trabajadores.show', $trabajador) }}" 
                           class="btn btn-primary" 
                           style="padding: 0.5rem 0.75rem;"
                           title="Ver Detalles">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('trabajadores.edit', $trabajador) }}" 
                           class="btn btn-warning" 
                           style="padding: 0.5rem 0.75rem;"
                           title="Editar Trabajador">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" 
                              action="{{ route('trabajadores.destroy', $trabajador) }}" 
                              style="display:inline;" 
                              onsubmit="return confirm('¿Está seguro de eliminar este trabajador?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-danger" 
                                    style="padding: 0.5rem 0.75rem;"
                                    title="Eliminar Trabajador">
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

<!-- Estadísticas de trabajadores -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-number">{{ $trabajadores->count() }}</div>
        <div class="stat-label">Total de Trabajadores</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-user-check"></i>
        </div>
        <div class="stat-number">{{ $trabajadores->where('Estado', 'Activo')->count() }}</div>
        <div class="stat-label">Trabajadores Activos</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-cut"></i>
        </div>
        <div class="stat-number">{{ $trabajadores->where('Cargo', 'Estilista')->count() }}</div>
        <div class="stat-label">Estilistas</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="stat-number">
            @php
                $citasHoy = 0;
                foreach($trabajadores as $trabajador) {
                    if($trabajador->citas) {
                        $citasHoy += $trabajador->citas->filter(function($cita) {
                            return $cita->Fecha_Hora->isToday();
                        })->count();
                    }
                }
            @endphp
            {{ $citasHoy }}
        </div>
        <div class="stat-label">Citas Asignadas Hoy</div>
    </div>
</div>

<!-- Filtros por cargo -->
<div class="card">
    <h3 style="color: white; margin-bottom: 1rem;">
        <i class="fas fa-filter"></i> Filtrar por Cargo
    </h3>
    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
        <button class="btn btn-primary" onclick="filtrarPorCargo('todos')">
            <i class="fas fa-users"></i> Todos
        </button>
        <button class="btn btn-warning" onclick="filtrarPorCargo('Estilista')">
            <i class="fas fa-cut"></i> Estilistas
        </button>
        <button class="btn btn-danger" onclick="filtrarPorCargo('Manicurista')">
            <i class="fas fa-hand-sparkles"></i> Manicuristas
        </button>
        <button class="btn btn-success" onclick="filtrarPorCargo('Cosmetóloga')">
            <i class="fas fa-spa"></i> Cosmetólogas
        </button>
        <button class="btn btn-primary" onclick="filtrarPorCargo('Recepcionista')">
            <i class="fas fa-user-check"></i> Recepcionistas
        </button>
    </div>
</div>

<script>
    // Búsqueda en tiempo real
    document.getElementById('searchTrabajadores').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const table = document.getElementById('trabajadoresTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        for (let row of rows) {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        }
    });

    // Filtrar por cargo
    function filtrarPorCargo(cargo) {
        const table = document.getElementById('trabajadoresTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        for (let row of rows) {
            if (cargo === 'todos') {
                row.style.display = '';
            } else {
                const cargoTrabajador = row.cells[3].textContent.trim();
                row.style.display = cargoTrabajador === cargo ? '' : 'none';
            }
        }
    }

    // Ordenar tabla por columna
    function sortTable(columnIndex) {
        const table = document.getElementById('trabajadoresTable');
        const tbody = table.getElementsByTagName('tbody')[0];
        const rows = Array.from(tbody.getElementsByTagName('tr'));
        
        rows.sort((a, b) => {
            const aValue = a.cells[columnIndex].textContent;
            const bValue = b.cells[columnIndex].textContent;
            return aValue.localeCompare(bValue);
        });
        
        tbody.innerHTML = '';
        rows.forEach(row => tbody.appendChild(row));
    }

    // Hacer columnas ordenables
    document.querySelectorAll('#trabajadoresTable th').forEach((th, index) => {
        if (index < 5) { // Solo las primeras 5 columnas
            th.style.cursor = 'pointer';
            th.addEventListener('click', () => sortTable(index));
        }
    });
</script>
@endsection