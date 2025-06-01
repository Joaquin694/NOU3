<!-- resources/views/citas/index.blade.php -->
@extends('layouts.app')

@section('title', 'Citas')

@section('content')
<h2>Gestión de Citas</h2>

<a href="{{ route('citas.create') }}">Nueva Cita</a>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Servicio</th>
            <th>Trabajador</th>
            <th>Fecha y Hora</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($citas as $cita)
        <tr>
            <td>{{ $cita->ID_Cita }}</td>
            <td>{{ $cita->cliente->Nombres }} {{ $cita->cliente->Apellidos }}</td>
            <td>{{ $cita->servicio->Nombre }}</td>
            <td>{{ $cita->trabajador->Nombres }} {{ $cita->trabajador->Apellidos }}</td>
            <td>{{ $cita->Fecha_Hora->format('d/m/Y H:i') }}</td>
            <td>{{ $cita->Estado }}</td>
            <td>
                <a href="{{ route('citas.show', $cita) }}">Ver</a>
                <a href="{{ route('citas.edit', $cita) }}">Editar</a>
                <form method="POST" action="{{ route('citas.destroy', $cita) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Está seguro?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection