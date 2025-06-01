@extends('layouts.app')

@section('title', 'Detalle del Trabajador')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-user-tie"></i> Detalle del Trabajador</h2>
    <p>Información completa del trabajador</p>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div style="display: flex; align-items: center;">
            <div style="font-size: 3rem; margin-right: 1rem;">
                @if($trabajador->Cargo == 'Estilista')
                    <i class="fas fa-cut" style="color: #feca57;"></i>
                @elseif($trabajador->Cargo == 'Manicurista' || $trabajador->Cargo == 'Pedicurista')
                    <i class="fas fa-hand-sparkles" style="color: #ff6b6b;"></i>
                @elseif($trabajador->Cargo == 'Recepcionista')
                    <i class="fas fa-user-check" style="color: #667eea;"></i>
                @elseif($trabajador->Cargo == 'Cosmetóloga')
                    <i class="fas fa-spa" style="color: #a8e6cf;"></i>
                @else
                    <i class="fas fa-user-circle" style="color: #667eea;"></i>
                @endif
            </div>
            <div>
                <h3 style="color: white; margin: 0;">{{ $trabajador->Nombres }} {{ $trabajador->Apellidos }}</h3>
                <p style="color: rgba(255,255,255,0.8); margin: 0;">{{ $trabajador->Cargo }}</p>
            </div>
        </div>
        <div>
            <a href="{{ route('trabajadores.edit', $trabajador) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('trabajadores.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-hashtag"></i>
            </div>
            <div class="stat-number">{{ str_pad($trabajador->ID_Trabajador, 3, '0', STR_PAD_LEFT) }}</div>
            <div class="stat-label">ID del Trabajador</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-toggle-on"></i>
            </div>
            <div class="stat-number">
                @if($trabajador->Estado == 'Activo')
                    <span class="status-badge status-active">Activo</span>
                @else
                    <span class="status-badge status-cancelled">Inactivo</span>
                @endif
            </div>
            <div class="stat-label">Estado</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-number">{{ $trabajador->citas ? $trabajador->citas->count() : 0 }}</div>
            <div class="stat-label">Citas Totales</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-number">4.8</div>
            <div class="stat-label">Calificación</div>
        </div>
    </div>
</div>

<div class="card">
    <h3 style="color: white; margin-bottom: 1.5rem;">
        <i class="fas fa-info-circle"></i> Información Personal
    </h3>
    
    <div class="table-container">
        <table class="table">
            <tr>
                <th style="width: 40%;">Campo</th>
                <th style="width: 60%;">Información</th>
            </tr>
            <tr>
                <td><i class="fas fa-user"></i> Nombres</td>
                <td>{{ $trabajador->Nombres }}</td>
            </tr>
            <tr>
                <td><i class="fas fa-user"></i> Apellidos</td>
                <td>{{ $trabajador->Apellidos }}</td>
            </tr>
            <tr>
                <td><i class="fas fa-briefcase"></i> Cargo</td>
                <td>
                    <span style="padding: 0.25rem 0.75rem; border-radius: 12px; 
                        background: rgba(255,255,255,0.1); color: white;">
                        {{ $trabajador->Cargo }}
                    </span>
                </td>
            </tr>
            <tr>
                <td><i class="fas fa-toggle-on"></i> Estado</td>
                <td>
                    @if($trabajador->Estado == 'Activo')
                        <span class="status-badge status-active">Activo</span>
                    @else
                        <span class="status-badge status-cancelled">Inactivo</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td><i class="fas fa-calendar-plus"></i> Fecha de Registro</td>
                <td>{{ $trabajador->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td><i class="fas fa-edit"></i> Última Actualización</td>
                <td>{{ $trabajador->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>
</div>

<!-- Estadísticas de rendimiento -->
<div class="card">
    <h3 style="color: white; margin-bottom: 1.5rem;">
        <i class="fas fa-chart-line"></i> Estadísticas de Rendimiento
    </h3>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="stat-number">
                {{ $trabajador->citas ? $trabajador->citas->filter(function($cita) { 
                    return $cita->Fecha_Hora->isToday(); 
                })->count() : 0 }}
            </div>
            <div class="stat-label">Citas Hoy</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-week"></i>
            </div>
            <div class="stat-number">
                {{ $trabajador->citas ? $trabajador->citas->filter(function($cita) { 
                    return $cita->Fecha_Hora->isCurrentWeek(); 
                })->count() : 0 }}
            </div>
            <div class="stat-label">Citas Esta Semana</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-number">
                {{ $trabajador->citas ? $trabajador->citas->filter(function($cita) { 
                    return $cita->Fecha_Hora->isCurrentMonth(); 
                })->count() : 0 }}
            </div>
            <div class="stat-label">Citas Este Mes</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-number">
                {{ $trabajador->citas ? $trabajador->citas->where('Estado', 'Completada')->count() : 0 }}
            </div>
            <div class="stat-label">Citas Completadas</div>
        </div>
    </div>
</div>

<!-- Citas Asignadas -->
<div class="card">
    <h3 style="color: white; margin-bottom: 1.5rem;">
        <i class="fas fa-calendar-alt"></i> Citas Asignadas
    </h3>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Servicio</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($trabajador->citas->sortByDesc('Fecha_Hora')->take(10) as $cita)
                <tr>
                    <td>{{ $cita->cliente->Nombres ?? 'N/A' }} {{ $cita->cliente->Apellidos ?? '' }}</td>
                    <td>{{ $cita->servicio->Nombre ?? 'N/A' }}</td>
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
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: rgba(255,255,255,0.6);">
                        No hay citas asignadas a este trabajador
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Acciones rápidas -->
<div class="card" style="background: rgba(255,255,255,0.05);">
    <h4 style="color: white; margin-bottom: 1rem;">
        <i class="fas fa-bolt"></i> Acciones Rápidas
    </h4>
    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <a href="{{ route('citas.create') }}?trabajador={{ $trabajador->ID_Trabajador }}" class="btn btn-success">
            <i class="fas fa-calendar-plus"></i> Asignar Nueva Cita
        </a>
        <a href="{{ route('trabajadores.edit', $trabajador) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Modificar Información
        </a>
        <button class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print"></i> Imprimir Información
        </button>
    </div>
</div>

<style>
    @media print {
        .sidebar, .btn, .page-header p {
            display: none !important;
        }
        
        .main-content {
            padding: 0 !important;
        }
        
        .card {
            break-inside: avoid;
            page-break-inside: avoid;
        }
    }
</style>

<script>
    // Animación al cargar las estadísticas
    document.addEventListener('DOMContentLoaded', function() {
        const statNumbers = document.querySelectorAll('.stat-number');
        
        statNumbers.forEach(stat => {
            if (!stat.querySelector('.status-badge')) {
                const finalValue = stat.textContent;
                
                if (!isNaN(finalValue)) {
                    let startValue = 0;
                    const endValue = parseInt(finalValue);
                    const duration = 1000;
                    const increment = endValue / (duration / 16);
                    
                    const counter = setInterval(() => {
                        startValue += increment;
                        
                        if (startValue >= endValue) {
                            stat.textContent = endValue;
                            clearInterval(counter);
                        } else {
                            stat.textContent = Math.floor(startValue);
                        }
                    }, 16);
                }
            }
        });
    });
</script>
@endsection