@extends('layouts.app')

@section('title', 'Citas')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-calendar-alt"></i> Gestión de Citas</h2>
    <p>Programa y administra las citas del salón</p>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap;">
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" id="searchCitas" placeholder="Buscar cita...">
        </div>
        <a href="{{ route('citas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Cita
        </a>
    </div>

    <div class="table-container">
        <table class="table" id="citasTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Servicio</th>
                    <th>Trabajador</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($citas as $cita)
                <tr>
                    <td>{{ str_pad($cita->ID_Cita, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $cita->cliente->Nombres ?? 'N/A' }} {{ $cita->cliente->Apellidos ?? '' }}</td>
                    <td>{{ $cita->servicio->Nombre ?? 'N/A' }}</td>
                    <td>{{ $cita->trabajador->Nombres ?? 'N/A' }} {{ $cita->trabajador->Apellidos ?? '' }}</td>
                    <td>{{ $cita->Fecha_Hora->format('d/m/Y') }}</td>
                    <td>{{ $cita->Fecha_Hora->format('H:i A') }}</td>
                    <td>
                        @if($cita->Estado == 'Pendiente')
                            <span class="status-badge status-pending">Pendiente</span>
                        @elseif($cita->Estado == 'Confirmada')
                            <span class="status-badge status-active">Confirmada</span>
                        @elseif($cita->Estado == 'Completada')
                            <span class="status-badge status-active">Completada</span>
                        @elseif($cita->Estado == 'Cancelada')
                            <span class="status-badge status-cancelled">Cancelada</span>
                        @endif
                    </td>
                    <td>
                        @if($cita->Estado == 'Pendiente')
                            <button class="btn btn-success" 
                                    style="padding: 0.5rem 0.75rem;" 
                                    onclick="confirmarCita({{ $cita->ID_Cita }})"
                                    title="Confirmar Cita">
                                <i class="fas fa-check"></i>
                            </button>
                        @endif
                        
                        <a href="{{ route('citas.show', $cita) }}" 
                           class="btn btn-primary" 
                           style="padding: 0.5rem 0.75rem;"
                           title="Ver Detalles">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        <a href="{{ route('citas.edit', $cita) }}" 
                           class="btn btn-warning" 
                           style="padding: 0.5rem 0.75rem;"
                           title="Editar Cita">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        @if($cita->Estado != 'Cancelada' && $cita->Estado != 'Completada')
                            <form method="POST" 
                                  action="{{ route('citas.destroy', $cita) }}" 
                                  style="display:inline;" 
                                  onsubmit="return confirm('¿Está seguro de cancelar esta cita?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-danger" 
                                        style="padding: 0.5rem 0.75rem;"
                                        title="Cancelar Cita">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Filtros adicionales -->
<div class="card">
    <h3 style="color: white; margin-bottom: 1rem;">
        <i class="fas fa-filter"></i> Filtros Rápidos
    </h3>
    <div class="stats-grid">
        <button class="stat-card" onclick="filtrarPorEstado('todos')" style="cursor: pointer;">
            <div class="stat-icon">
                <i class="fas fa-calendar"></i>
            </div>
            <div class="stat-number">{{ $citas->count() }}</div>
            <div class="stat-label">Todas las Citas</div>
        </button>
        
        <button class="stat-card" onclick="filtrarPorEstado('Pendiente')" style="cursor: pointer;">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-number">{{ $citas->where('Estado', 'Pendiente')->count() }}</div>
            <div class="stat-label">Pendientes</div>
        </button>
        
        <button class="stat-card" onclick="filtrarPorEstado('Confirmada')" style="cursor: pointer;">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-number">{{ $citas->where('Estado', 'Confirmada')->count() }}</div>
            <div class="stat-label">Confirmadas</div>
        </button>
        
        <button class="stat-card" onclick="filtrarPorFecha('hoy')" style="cursor: pointer;">
            <div class="stat-icon">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="stat-number">{{ $citas->filter(function($cita) { return $cita->Fecha_Hora->isToday(); })->count() }}</div>
            <div class="stat-label">Citas de Hoy</div>
        </button>
    </div>
</div>

<script>
    // Búsqueda en tiempo real
    document.getElementById('searchCitas').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const table = document.getElementById('citasTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        for (let row of rows) {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        }
    });

    // Filtrar por estado
    function filtrarPorEstado(estado) {
        const table = document.getElementById('citasTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        for (let row of rows) {
            if (estado === 'todos') {
                row.style.display = '';
            } else {
                const estadoCita = row.querySelector('.status-badge')?.textContent || '';
                row.style.display = estadoCita === estado ? '' : 'none';
            }
        }
    }

    // Filtrar por fecha
    function filtrarPorFecha(filtro) {
        const table = document.getElementById('citasTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        const hoy = new Date().toLocaleDateString('es-ES');
        
        for (let row of rows) {
            const fechaCita = row.cells[4].textContent; // Columna de fecha
            
            if (filtro === 'hoy') {
                const fechaCitaFormateada = fechaCita.split('/').reverse().join('-');
                const fechaCitaDate = new Date(fechaCitaFormateada).toLocaleDateString('es-ES');
                row.style.display = fechaCitaDate === hoy ? '' : 'none';
            }
        }
    }

    // Confirmar cita (simulación - en producción haría una petición AJAX)
    function confirmarCita(citaId) {
        if (confirm('¿Desea confirmar esta cita?')) {
            // Aquí iría la lógica para actualizar el estado
            alert('Cita confirmada exitosamente (demo)');
            location.reload();
        }
    }

    // Resaltar citas próximas
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('#citasTable tbody tr');
        const ahora = new Date();
        
        rows.forEach(row => {
            const fecha = row.cells[4].textContent.split('/');
            const hora = row.cells[5].textContent.split(':');
            const fechaCita = new Date(fecha[2], fecha[1]-1, fecha[0], hora[0], hora[1]);
            
            // Si la cita es en las próximas 2 horas y está pendiente o confirmada
            const diffHoras = (fechaCita - ahora) / (1000 * 60 * 60);
            if (diffHoras > 0 && diffHoras <= 2) {
                const estado = row.querySelector('.status-badge')?.textContent;
                if (estado === 'Pendiente' || estado === 'Confirmada') {
                    row.style.background = 'rgba(251, 191, 36, 0.1)';
                }
            }
        });
    });
</script>
@endsection