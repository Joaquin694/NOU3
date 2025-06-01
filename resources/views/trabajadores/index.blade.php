@extends('layouts.app')

@section('title', 'Trabajadores')

@section('content')
<h2>Gestión de Trabajadores</h2>

<a href="{{ route('trabajadores.create') }}">Nuevo Trabajador</a>

<table border="1">
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
            <td>{{ $trabajador->ID_Trabajador }}</td>
            <td>{{ $trabajador->Nombres }}</td>
            <td>{{ $trabajador->Apellidos }}</td>
            <td>{{ $trabajador->Cargo }}</td>
            <td>{{ $trabajador->Estado }}</td>
            <td>
                <a href="{{ route('trabajadores.show', $trabajador) }}">Ver</a>
                <a href="{{ route('trabajadores.edit', $trabajador) }}">Editar</a>
                <form method="POST" action="{{ route('trabajadores.destroy', $trabajador) }}" style="display:inline;">
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