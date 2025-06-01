<!-- resources/views/citas/create.blade.php -->
@extends('layouts.app')

@section('title', 'Nueva Cita')

@section('content')
<h2>Nueva Cita</h2>

<form method="POST" action="{{ route('citas.store') }}">
    @csrf
    
    <div>
        <label for="ID_Cliente">Cliente:</label>
        <select id="ID_Cliente" name="ID_Cliente" required>
            <option value="">Seleccione un cliente</option>
            @foreach($clientes as $cliente)
                <option value="{{ $cliente->ID_Cliente }}" {{ old('ID_Cliente') == $cliente->ID_Cliente ? 'selected' : '' }}>
                    {{ $cliente->Nombres }} {{ $cliente->Apellidos }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="ID_Servicio">Servicio:</label>
        <select id="ID_Servicio" name="ID_Servicio" required>
            <option value="">Seleccione un servicio</option>
            @foreach($servicios as $servicio)
                <option value="{{ $servicio->ID_Servicio }}" {{ old('ID_Servicio') == $servicio->ID_Servicio ? 'selected' : '' }}>
                    {{ $servicio->Nombre }} - S/ {{ $servicio->Precio }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="ID_Trabajador">Trabajador:</label>
        <select id="ID_Trabajador" name="ID_Trabajador" required>
            <option value="">Seleccione un trabajador</option>
            @foreach($trabajadores as $trabajador)
                <option value="{{ $trabajador->ID_Trabajador }}" {{ old('ID_Trabajador') == $trabajador->ID_Trabajador ? 'selected' : '' }}>
                    {{ $trabajador->Nombres }} {{ $trabajador->Apellidos }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="Fecha_Hora">Fecha y Hora:</label>
        <input type="datetime-local" id="Fecha_Hora" name="Fecha_Hora" value="{{ old('Fecha_Hora') }}" required>
    </div>

    <div>
        <label for="Estado">Estado:</label>
        <select id="Estado" name="Estado" required>
            <option value="Pendiente" {{ old('Estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="Confirmada" {{ old('Estado') == 'Confirmada' ? 'selected' : '' }}>Confirmada</option>
            <option value="Completada" {{ old('Estado') == 'Completada' ? 'selected' : '' }}>Completada</option>
            <option value="Cancelada" {{ old('Estado') == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
        </select>
    </div>

    <div>
        <button type="submit">Guardar Cita</button>
        <a href="{{ route('citas.index') }}">Cancelar</a>
    </div>
</form>
@endsection