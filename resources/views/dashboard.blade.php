<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard - Sistema NOU3') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold">¡Bienvenido {{ Auth::user()->name }}!</h3>
                        <p class="text-gray-600">Gestiona tu negocio desde este panel de control</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Gestión de Personal -->
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200 hover:bg-blue-100 transition">
                            <div class="flex items-center mb-3">
                                <div class="bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">👥</div>
                                <h4 class="font-semibold text-blue-800 ml-3">Personal</h4>
                            </div>
                            <a href="{{ route('trabajadores.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                Ver Trabajadores →
                            </a>
                        </div>
                        
                        <!-- Gestión de Clientes -->
                        <div class="bg-green-50 p-6 rounded-lg border border-green-200 hover:bg-green-100 transition">
                            <div class="flex items-center mb-3">
                                <div class="bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">👤</div>
                                <h4 class="font-semibold text-green-800 ml-3">Clientes</h4>
                            </div>
                            <a href="{{ route('clientes.index') }}" class="text-green-600 hover:text-green-800 font-medium">
                                Ver Clientes →
                            </a>
                        </div>
                        
                        <!-- Servicios -->
                        <div class="bg-purple-50 p-6 rounded-lg border border-purple-200 hover:bg-purple-100 transition">
                            <div class="flex items-center mb-3">
                                <div class="bg-purple-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">⚙️</div>
                                <h4 class="font-semibold text-purple-800 ml-3">Servicios</h4>
                            </div>
                            <a href="{{ route('servicios.index') }}" class="text-purple-600 hover:text-purple-800 font-medium">
                                Ver Servicios →
                            </a>
                        </div>
                        
                        <!-- Citas -->
                        <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-200 hover:bg-yellow-100 transition">
                            <div class="flex items-center mb-3">
                                <div class="bg-yellow-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">📅</div>
                                <h4 class="font-semibold text-yellow-800 ml-3">Citas</h4>
                            </div>
                            <a href="{{ route('citas.index') }}" class="text-yellow-600 hover:text-yellow-800 font-medium">
                                Ver Citas →
                            </a>
                        </div>
                        
                        <!-- Inventario -->
                        <div class="bg-red-50 p-6 rounded-lg border border-red-200 hover:bg-red-100 transition">
                            <div class="flex items-center mb-3">
                                <div class="bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">📦</div>
                                <h4 class="font-semibold text-red-800 ml-3">Inventario</h4>
                            </div>
                            <div class="space-y-1">
                                <a href="{{ route('productos.index') }}" class="text-red-600 hover:text-red-800 font-medium block">
                                    Ver Productos →
                                </a>
                                <a href="{{ route('movimiento-inventarios.index') }}" class="text-red-600 hover:text-red-800 text-sm block">
                                    Movimientos →
                                </a>
                            </div>
                        </div>
                        
                        <!-- Ventas -->
                        <div class="bg-indigo-50 p-6 rounded-lg border border-indigo-200 hover:bg-indigo-100 transition">
                            <div class="flex items-center mb-3">
                                <div class="bg-indigo-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">💰</div>
                                <h4 class="font-semibold text-indigo-800 ml-3">Ventas</h4>
                            </div>
                            <div class="space-y-1">
                                <a href="{{ route('ventas.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium block">
                                    Ver Ventas →
                                </a>
                                <a href="{{ route('detalle-ventas.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm block">
                                    Detalles →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>