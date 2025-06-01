@extends('layouts.app')

@section('title', 'Servicios')

@section('content')
<h2>Gestión de Servicios</h2>

<a href="{{ route('servicios.create') }}">Nuevo Servicio</a>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Duración (min)</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($servicios as $servicio)
        <tr>
            <td>{{ $servicio->ID_Servicio }}</td>
            <td>{{ $servicio->Nombre }}</td>
            <td>S/ {{ number_format($servicio->Precio, 2) }}</td>
            <td>{{ $servicio->Duracion }}</td>
            <td>
                <a href="{{ route('servicios.show', $servicio) }}">Ver</a>
                <a href="{{ route('servicios.edit', $servicio) }}">Editar</a>
                <form method="POST" action="{{ route('servicios.destroy', $servicio) }}" style="display:inline;">
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