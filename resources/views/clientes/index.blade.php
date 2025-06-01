<!-- resources/views/clientes/index.blade.php -->
@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<h2>Gestión de Clientes</h2>

<a href="{{ route('clientes.create') }}">Nuevo Cliente</a>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>DNI</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Fecha Registro</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clientes as $cliente)
        <tr>
            <td>{{ $cliente->ID_Cliente }}</td>
            <td>{{ $cliente->Nombres }}</td>
            <td>{{ $cliente->Apellidos }}</td>
            <td>{{ $cliente->DNI }}</td>
            <td>{{ $cliente->Telefono }}</td>
            <td>{{ $cliente->Correo }}</td>
            <td>{{ $cliente->Fecha_Registro }}</td>
            <td>
                <a href="{{ route('clientes.show', $cliente) }}">Ver</a>
                <a href="{{ route('clientes.edit', $cliente) }}">Editar</a>
                <form method="POST" action="{{ route('clientes.destroy', $cliente) }}" style="display:inline;">
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