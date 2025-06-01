@extends('layouts.app')

@section('title', 'Detalle del Servicio')

@section('content')
<h2>Detalle del Servicio</h2>

<table border="1">
    <tr>
        <th>ID:</th>
        <td>{{ $servicio->ID_Servicio }}</td>
    </tr>
    <tr>
        <th>Nombre:</th>
        <td>{{ $servicio->Nombre }}</td>
    </tr>
    <tr>
        <th>Precio:</th>
        <td>S/ {{ number_format($servicio->Precio, 2) }}</td>
    </tr>
    <tr>
        <th>Duración:</th>
        <td>{{ $servicio->Duracion }} minutos</td>
    </tr>
    <tr>
        <th>Creado:</th>
        <td>{{ $servicio->created_at->format('d/m/Y H:i') }}</td>
    </tr>
    <tr>
        <th>Actualizado:</th>
        <td>{{ $servicio->updated_at->format('d/m/Y H:i') }}</td>
    </tr>
</table>

<a href="{{ route('servicios.edit', $servicio) }}">Editar</a>
<a href="{{ route('servicios.index') }}">Volver</a>
@endsection