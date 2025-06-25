<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-800">
                        <i class="fas fa-cut text-indigo-600 mr-2"></i>
                        NOU3 Salón
                    </a>
                </div>

                <!-- Enlaces de navegación -->
                @auth
                <div class="hidden sm:ml-6 sm:flex sm:space-x-4">
                    <a href="{{ route('dashboard') }}" 
                       class="nav-link {{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('citas.index') }}" 
                       class="nav-link {{ request()->routeIs('citas.*') ? 'nav-active' : '' }}">
                        <i class="fas fa-calendar-alt mr-1"></i> Citas
                    </a>
                    <a href="{{ route('clientes.index') }}" 
                       class="nav-link {{ request()->routeIs('clientes.*') ? 'nav-active' : '' }}">
                        <i class="fas fa-users mr-1"></i> Clientes
                    </a>
                    <a href="{{ route('servicios.index') }}" 
                       class="nav-link {{ request()->routeIs('servicios.*') ? 'nav-active' : '' }}">
                        <i class="fas fa-cut mr-1"></i> Servicios
                    </a>
                    <a href="{{ route('ventas.index') }}" 
                       class="nav-link {{ request()->routeIs('ventas.*') ? 'nav-active' : '' }}">
                        <i class="fas fa-cash-register mr-1"></i> Ventas
                    </a>
                </div>
                @endauth
            </div>

            <!-- Menú de usuario -->
            @auth
            <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
                <!-- Notificaciones (opcional) -->
                <div class="text-sm text-gray-600">
                    <i class="fas fa-user-circle mr-1"></i>
                    {{ Auth::user()->name }}
                </div>

                <!-- Dropdown de usuario -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="bg-indigo-100 p-2 rounded-full">
                            <i class="fas fa-user text-indigo-600"></i>
                        </span>
                    </button>

                    <div x-show="open" 
                         @click.away="open = false"
                         class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-1">
                            <a href="{{ route('profile.edit') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user-edit mr-2"></i> Perfil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menú móvil -->
            <div class="sm:hidden flex items-center">
                <button @click="mobileOpen = !mobileOpen" 
                        class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
            @else
            <!-- Enlaces para usuarios no autenticados -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Iniciar Sesión</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Registrarse</a>
            </div>
            @endauth
        </div>

        <!-- Menú móvil -->
        @auth
        <div x-show="mobileOpen" class="sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="mobile-nav-link {{ request()->routeIs('dashboard') ? 'mobile-nav-active' : '' }}">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>
                <a href="{{ route('citas.index') }}" 
                   class="mobile-nav-link {{ request()->routeIs('citas.*') ? 'mobile-nav-active' : '' }}">
                    <i class="fas fa-calendar-alt mr-2"></i> Citas
                </a>
                <a href="{{ route('clientes.index') }}" 
                   class="mobile-nav-link {{ request()->routeIs('clientes.*') ? 'mobile-nav-active' : '' }}">
                    <i class="fas fa-users mr-2"></i> Clientes
                </a>
                <a href="{{ route('servicios.index') }}" 
                   class="mobile-nav-link {{ request()->routeIs('servicios.*') ? 'mobile-nav-active' : '' }}">
                    <i class="fas fa-cut mr-2"></i> Servicios
                </a>
                <a href="{{ route('ventas.index') }}" 
                   class="mobile-nav-link {{ request()->routeIs('ventas.*') ? 'mobile-nav-active' : '' }}">
                    <i class="fas fa-cash-register mr-2"></i> Ventas
                </a>
                
                <div class="border-t border-gray-200 pt-4">
                    <div class="px-4 text-sm text-gray-600">{{ Auth::user()->name }}</div>
                    <a href="{{ route('profile.edit') }}" class="mobile-nav-link">
                        <i class="fas fa-user-edit mr-2"></i> Perfil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="mobile-nav-link w-full text-left">
                            <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endauth
    </div>
</nav>

<style>
    .nav-link {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        text-decoration: none;
        color: #4b5563;
        font-weight: 500;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
    }
    
    .nav-link:hover {
        background-color: #f3f4f6;
        color: #1f2937;
    }
    
    .nav-active {
        background-color: #e0e7ff;
        color: #4338ca;
    }
    
    .mobile-nav-link {
        display: block;
        padding: 0.75rem 1rem;
        text-decoration: none;
        color: #4b5563;
        font-weight: 500;
        border-radius: 0.375rem;
        margin: 0.25rem 0;
        transition: all 0.2s ease;
    }
    
    .mobile-nav-link:hover {
        background-color: #f3f4f6;
        color: #1f2937;
    }
    
    .mobile-nav-active {
        background-color: #e0e7ff;
        color: #4338ca;
    }
</style>

<script>
    // Alpine.js para los dropdowns
    document.addEventListener('alpine:init', () => {
        Alpine.data('navigation', () => ({
            mobileOpen: false
        }))
    })
</script>

<!-- Alpine.js para interactividad -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>