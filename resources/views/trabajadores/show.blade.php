@extends('layouts.app')

@section('title', 'Detalle del Trabajador')

@section('content')
<h2>Detalle del Trabajador</h2>

<table border="1">
    <tr>
        <th>ID:</th>
        <td>{{ $trabajador->ID_Trabajador }}</td>
    </tr>
    <tr>
        <th>Nombres:</th>
        <td>{{ $trabajador->Nombres }}</td>
    </tr>
    <tr>
        <th>Apellidos:</th>
        <td>{{ $trabajador->Apellidos }}</td>
    </tr>
    <tr>
        <th>Cargo:</th>
        <td>{{ $trabajador->Cargo }}</td>
    </tr>
    <tr>
        <th>Estado:</th>
        <td>{{ $trabajador->Estado }}</td>
    </tr>
    <tr>
        <th>Creado:</th>
        <td>{{ $trabajador->created_at->format('d/m/Y H:i') }}</td>
    </tr>
    <tr>
        <th>Actualizado:</th>
        <td>{{ $trabajador->updated_at->format('d/m/Y H:i') }}</td>
    </tr>
</table>

<h3>Citas Asignadas</h3>
<table border="1">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Servicio</th>
            <th>Fecha</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($trabajador->citas as $cita)
        <tr>
            <td>{{ $cita->cliente->Nombres ?? 'N/A' }} {{ $cita->cliente->Apellidos ?? '' }}</td>
            <td>{{ $cita->servicio->Nombre ?? 'N/A' }}</td>
            <td>{{ $cita->Fecha_Hora->format('d/m/Y H:i') }}</td>
            <td>{{ $cita->Estado }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('trabajadores.edit', $trabajador) }}">Editar</a>
<a href="{{ route('trabajadores.index') }}">Volver</a>
@endsection