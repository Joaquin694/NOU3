@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-users"></i> Gestión de Clientes</h2>
    <p>Administra la información de tus clientes</p>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap;">
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" id="searchClientes" placeholder="Buscar cliente...">
        </div>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Cliente
        </a>
    </div>

    <div class="table-container">
        <table class="table" id="clientesTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Fecha Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientes as $cliente)
                <tr>
                    <td>{{ str_pad($cliente->ID_Cliente, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $cliente->Nombres }}</td>
                    <td>{{ $cliente->Apellidos }}</td>
                    <td>{{ $cliente->Telefono }}</td>
                    <td>{{ $cliente->Correo }}</td>
                    <td>{{ \Carbon\Carbon::parse($cliente->Fecha_Registro)->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-primary" style="padding: 0.5rem 0.75rem;">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning" style="padding: 0.5rem 0.75rem;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('clientes.destroy', $cliente) }}" style="display:inline;" onsubmit="return confirm('¿Está seguro de eliminar este cliente?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 0.5rem 0.75rem;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // Búsqueda en tiempo real
    document.getElementById('searchClientes').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const table = document.getElementById('clientesTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        for (let row of rows) {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        }
    });
</script>
@endsection