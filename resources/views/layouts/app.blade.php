<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salón NUO3 - @yield('title')</title>
</head>
<body>
    <nav>
        <h1>Salón de Belleza NUO3</h1>
        <ul>
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('clientes.index') }}">Clientes</a></li>
            <li><a href="{{ route('trabajadores.index') }}">Trabajadores</a></li>
            <li><a href="{{ route('servicios.index') }}">Servicios</a></li>
            <li><a href="{{ route('citas.index') }}">Citas</a></li>
            <li><a href="{{ route('productos.index') }}">Productos</a></li>
            <li><a href="{{ route('ventas.index') }}">Ventas</a></li>
        </ul>
    </nav>

    <main>
        @if(session('success'))
            <div>{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>