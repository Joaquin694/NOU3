@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h2>Dashboard - Salón de Belleza NUO3</h2>

<div>
    <h3>Estadísticas Generales</h3>
    <table border="1">
        <tr>
            <th>Métrica</th>
            <th>Cantidad</th>
        </tr>
        <tr>
            <td>Total de Clientes</td>
            <td>{{ \App\Models\Cliente::count() }}</td>
        </tr>
        <tr>
            <td>Trabajadores Activos</td>
            <td>{{ \App\Models\Trabajador::where('Estado', 'Activo')->count() }}</td>
        </tr>
        <tr>
            <td>Total de Servicios</td>
            <td>{{ \App\Models\Servicio::count() }}</td>
        </tr>
        <tr>
            <td>Productos en Stock</td>
            <td>{{ \App\Models\Producto::where('Cantidad', '>', 0)->count() }}</td>
        </tr>
        <tr>
            <td>Citas de Hoy</td>
            <td>{{ \App\Models\Cita::whereDate('Fecha_Hora', today())->count() }}</td>
        </tr>
        <tr>
            <td>Citas Pendientes</td>
            <td>{{ \App\Models\Cita::where('Estado', 'Pendiente')->count() }}</td>
        </tr>
        <tr>
            <td>Ventas del Mes</td>
            <td>{{ \App\Models\Venta::whereMonth('Fecha', now()->month)->count() }}</td>
        </tr>
        <tr>
            <td>Ingresos del Mes</td>
            <td>S/ {{ number_format(\App\Models\Venta::whereMonth('Fecha', now()->month)->sum('Total'), 2) }}</td>
        </tr>
    </table>
</div>

<div>
    <h3>Citas de Hoy</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Hora</th>
                <th>Cliente</th>
                <th>Servicio</th>
                <th>Trabajador</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach(\App\Models\Cita::with(['cliente', 'servicio', 'trabajador'])->whereDate('Fecha_Hora', today())->orderBy('Fecha_Hora')->get() as $cita)
            <tr>
                <td>{{ $cita->Fecha_Hora->format('H:i') }}</td>
                <td>{{ $cita->cliente->Nombres ?? 'N/A' }} {{ $cita->cliente->Apellidos ?? '' }}</td>
                <td>{{ $cita->servicio->Nombre ?? 'N/A' }}</td>
                <td>{{ $cita->trabajador->Nombres ?? 'N/A' }}</td>
                <td>{{ $cita->Estado }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div>
    <h3>Productos con Poco Stock</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach(\App\Models\Producto::where('Cantidad', '<=', 10)->get() as $producto)
            <tr>
                <td>{{ $producto->Nombre }}</td>
                <td>{{ $producto->Cantidad }}</td>
                <td>
                    @if($producto->Cantidad == 0)
                        <span style="color: red;">Agotado</span>
                    @else
                        <span style="color: orange;">Poco Stock</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div>
    <h3>Servicios Más Solicitados</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Cantidad de Citas</th>
                <th>Ingresos Generados</th>
            </tr>
        </thead>
        <tbody>
            @foreach(\App\Models\Servicio::withCount('citas')->orderBy('citas_count', 'desc')->take(5)->get() as $servicio)
            <tr>
                <td>{{ $servicio->Nombre }}</td>
                <td>{{ $servicio->citas_count }}</td>
                <td>S/ {{ number_format($servicio->citas_count * $servicio->Precio, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div>
    <h3>Trabajadores con Más Citas</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Trabajador</th>
                <th>Cargo</th>
                <th>Citas Asignadas</th>
            </tr>
        </thead>
        <tbody>
            @foreach(\App\Models\Trabajador::withCount('citas')->where('Estado', 'Activo')->orderBy('citas_count', 'desc')->get() as $trabajador)
            <tr>
                <td>{{ $trabajador->Nombres }} {{ $trabajador->Apellidos }}</td>
                <td>{{ $trabajador->Cargo }}</td>
                <td>{{ $trabajador->citas_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div>
    <h3>Acciones Rápidas</h3>
    <ul>
        <li><a href="{{ route('citas.create') }}">Agendar Nueva Cita</a></li>
        <li><a href="{{ route('clientes.create') }}">Registrar Nuevo Cliente</a></li>
        <li><a href="{{ route('ventas.create') }}">Registrar Nueva Venta</a></li>
        <li><a href="{{ route('productos.index') }}">Ver Inventario</a></li>
        <li><a href="{{ route('citas.index') }}">Ver Todas las Citas</a></li>
    </ul>
</div>
@endsection