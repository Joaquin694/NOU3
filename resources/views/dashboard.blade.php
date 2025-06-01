@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
    <p>Resumen general del salón de belleza NUO3</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-number">{{ \App\Models\Cliente::count() }}</div>
        <div class="stat-label">Clientes Totales</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="stat-number">{{ \App\Models\Cita::whereDate('Fecha_Hora', today())->count() }}</div>
        <div class="stat-label">Citas Hoy</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="stat-number">S/ {{ number_format(\App\Models\Venta::whereDate('Fecha', today())->sum('Total'), 0) }}</div>
        <div class="stat-label">Ingresos del Día</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-user-tie"></i>
        </div>
        <div class="stat-number">{{ \App\Models\Trabajador::where('Estado', 'Activo')->count() }}</div>
        <div class="stat-label">Trabajadores Activos</div>
    </div>
</div>

<div class="card">
    <h3>Próximas Citas</h3>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Servicio</th>
                    <th>Trabajador</th>
                    <th>Hora</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse(\App\Models\Cita::with(['cliente', 'servicio', 'trabajador'])
                    ->whereDate('Fecha_Hora', today())
                    ->orderBy('Fecha_Hora')
                    ->take(5)
                    ->get() as $cita)
                <tr>
                    <td>{{ $cita->cliente->Nombres ?? 'N/A' }} {{ $cita->cliente->Apellidos ?? '' }}</td>
                    <td>{{ $cita->servicio->Nombre ?? 'N/A' }}</td>
                    <td>{{ $cita->trabajador->Nombres ?? 'N/A' }}</td>
                    <td>{{ $cita->Fecha_Hora->format('H:i A') }}</td>
                    <td>
                        @if($cita->Estado == 'Pendiente')
                            <span class="status-badge status-pending">Pendiente</span>
                        @elseif($cita->Estado == 'Confirmada')
                            <span class="status-badge status-active">Confirmada</span>
                        @elseif($cita->Estado == 'Cancelada')
                            <span class="status-badge status-cancelled">Cancelada</span>
                        @else
                            <span class="status-badge status-active">{{ $cita->Estado }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: rgba(255,255,255,0.6);">
                        No hay citas programadas para hoy
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="stats-grid">
    <div class="card">
        <h3>Servicios Más Solicitados</h3>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Cantidad</th>
                        <th>Ingresos</th>
                        <th>Porcentaje</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalCitas = \App\Models\Cita::count();
                        $servicios = \App\Models\Servicio::withCount('citas')
                            ->orderBy('citas_count', 'desc')
                            ->take(3)
                            ->get();
                    @endphp
                    @foreach($servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->Nombre }}</td>
                        <td>{{ $servicio->citas_count }}</td>
                        <td>S/ {{ number_format($servicio->citas_count * $servicio->Precio, 2) }}</td>
                        <td>{{ $totalCitas > 0 ? round(($servicio->citas_count / $totalCitas) * 100) : 0 }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <h3>Productos con Poco Stock</h3>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\Producto::where('Cantidad', '<=', 10)->orderBy('Cantidad')->take(5)->get() as $producto)
                    <tr>
                        <td>{{ $producto->Nombre }}</td>
                        <td>{{ $producto->Cantidad }}</td>
                        <td>
                            @if($producto->Cantidad == 0)
                                <span class="status-badge status-cancelled">Agotado</span>
                            @else
                                <span class="status-badge status-pending">Poco Stock</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: rgba(255,255,255,0.6);">
                            Todos los productos tienen stock suficiente
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <h3>Resumen del Mes</h3>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-number">+15%</div>
            <div class="stat-label">Crecimiento Mensual</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-week"></i>
            </div>
            <div class="stat-number">{{ \App\Models\Venta::whereMonth('Fecha', now()->month)->count() }}</div>
            <div class="stat-label">Ventas del Mes</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-number">4.8</div>
            <div class="stat-label">Calificación Promedio</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-number">S/ {{ number_format(\App\Models\Venta::whereMonth('Fecha', now()->month)->sum('Total'), 0) }}</div>
            <div class="stat-label">Ingresos del Mes</div>
        </div>
    </div>
</div>
@endsection