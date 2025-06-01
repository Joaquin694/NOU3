@extends('layouts.app')

@section('title', 'Detalle del Servicio')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-info-circle"></i> Detalle del Servicio</h2>
    <p>Información completa del servicio</p>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h3 style="color: white; margin: 0;">{{ $servicio->Nombre }}</h3>
        <div>
            <a href="{{ route('servicios.edit', $servicio) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('servicios.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-hashtag"></i>
            </div>
            <div class="stat-number">{{ str_pad($servicio->ID_Servicio, 3, '0', STR_PAD_LEFT) }}</div>
            <div class="stat-label">ID del Servicio</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-number">S/ {{ number_format($servicio->Precio, 2) }}</div>
            <div class="stat-label">Precio</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-number">{{ $servicio->Duracion }} min</div>
            <div class="stat-label">Duración</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-number">{{ $servicio->citas ? $servicio->citas->count() : 0 }}</div>
            <div class="stat-label">Citas Realizadas</div>
        </div>
    </div>
</div>

<div class="card">
    <h3 style="color: white; margin-bottom: 1.5rem;">
        <i class="fas fa-chart-line"></i> Estadísticas del Servicio
    </h3>
    
    <div class="table-container">
        <table class="table">
            <tr>
                <th style="width: 40%;">Información</th>
                <th style="width: 60%;">Detalle</th>
            </tr>
            <tr>
                <td><i class="fas fa-tag"></i> Nombre del Servicio</td>
                <td>{{ $servicio->Nombre }}</td>
            </tr>
            <tr>
                <td><i class="fas fa-money-bill-wave"></i> Precio Actual</td>
                <td style="color: #feca57; font-weight: 600;">S/ {{ number_format($servicio->Precio, 2) }}</td>
            </tr>
            <tr>
                <td><i class="fas fa-hourglass-half"></i> Tiempo de Duración</td>
                <td>{{ $servicio->Duracion }} minutos ({{ number_format($servicio->Duracion / 60, 1) }} horas)</td>
            </tr>
            <tr>
                <td><i class="fas fa-calendar-plus"></i> Fecha de Creación</td>
                <td>{{ $servicio->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td><i class="fas fa-edit"></i> Última Actualización</td>
                <td>{{ $servicio->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
            @if($servicio->citas && $servicio->citas->count() > 0)
            <tr>
                <td><i class="fas fa-chart-bar"></i> Ingresos Generados</td>
                <td style="color: #56ab2f; font-weight: 600;">
                    S/ {{ number_format($servicio->citas->count() * $servicio->Precio, 2) }}
                </td>
            </tr>
            @endif
        </table>
    </div>
</div>

@if($servicio->citas && $servicio->citas->count() > 0)
<div class="card">
    <h3 style="color: white; margin-bottom: 1.5rem;">
        <i class="fas fa-history"></i> Últimas Citas con este Servicio
    </h3>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Trabajador</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servicio->citas->take(10) as $cita)
                <tr>
                    <td>{{ $cita->cliente->Nombres ?? 'N/A' }} {{ $cita->cliente->Apellidos ?? '' }}</td>
                    <td>{{ $cita->trabajador->Nombres ?? 'N/A' }}</td>
                    <td>{{ $cita->Fecha_Hora->format('d/m/Y H:i') }}</td>
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
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Trabajadores que realizan este servicio -->
@php
    $trabajadoresServicio = $servicio->citas ? 
        $servicio->citas->pluck('trabajador')->unique('ID_Trabajador')->filter() : 
        collect();
@endphp

@if($trabajadoresServicio->count() > 0)
<div class="card">
    <h3 style="color: white; margin-bottom: 1.5rem;">
        <i class="fas fa-user-tie"></i> Trabajadores que Realizan este Servicio
    </h3>
    
    <div class="stats-grid">
        @foreach($trabajadoresServicio as $trabajador)
        <div class="stat-card" style="cursor: pointer;">
            <div class="stat-icon">
                <i class="fas fa-user"></i>
            </div>
            <div style="color: white; font-weight: 600; margin-bottom: 0.5rem;">
                {{ $trabajador->Nombres }} {{ $trabajador->Apellidos }}
            </div>
            <div class="stat-label">{{ $trabajador->Cargo }}</div>
            <div style="color: rgba(255,255,255,0.7); font-size: 0.9rem; margin-top: 0.5rem;">
                {{ $servicio->citas->where('ID_Trabajador', $trabajador->ID_Trabajador)->count() }} citas realizadas
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Acciones rápidas -->
<div class="card" style="background: rgba(255,255,255,0.05);">
    <h4 style="color: white; margin-bottom: 1rem;">
        <i class="fas fa-bolt"></i> Acciones Rápidas
    </h4>
    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <a href="{{ route('citas.create') }}?servicio={{ $servicio->ID_Servicio }}" class="btn btn-success">
            <i class="fas fa-calendar-plus"></i> Agendar Cita con este Servicio
        </a>
        <a href="{{ route('servicios.edit', $servicio) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Modificar Servicio
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
            const finalValue = stat.textContent;
            const isPrice = finalValue.includes('S/');
            
            if (!isNaN(finalValue) || isPrice) {
                let startValue = 0;
                const endValue = isPrice ? 
                    parseFloat(finalValue.replace('S/ ', '').replace(',', '')) : 
                    parseInt(finalValue);
                
                const duration = 1000;
                const increment = endValue / (duration / 16);
                
                const counter = setInterval(() => {
                    startValue += increment;
                    
                    if (startValue >= endValue) {
                        stat.textContent = finalValue;
                        clearInterval(counter);
                    } else {
                        if (isPrice) {
                            stat.textContent = `S/ ${startValue.toFixed(2)}`;
                        } else {
                            stat.textContent = Math.floor(startValue);
                        }
                    }
                }, 16);
            }
        });
    });
</script>
@endsection