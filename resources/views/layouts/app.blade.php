<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            body { background-color: #f8fafc; font-family: 'Figtree', sans-serif; }
            .page-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem; border-radius: 12px; margin-bottom: 2rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
            .page-header h2 { font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.75rem; }
            .page-header p { font-size: 1rem; opacity: 0.9; margin: 0; }
            .card { background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; margin-bottom: 2rem; }
            .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600; text-decoration: none; border: none; cursor: pointer; transition: all 0.2s ease; font-size: 0.875rem; }
            .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
            .btn-warning { background: linear-gradient(135deg, #feca57 0%, #ff9ff3 100%); color: white; }
            .btn-danger { background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); color: white; }
            .btn-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; }
            .btn:hover { transform: translateY(-1px); opacity: 0.9; }
            .search-container { position: relative; max-width: 300px; }
            .search-input { width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.875rem; }
            .search-input:focus { outline: none; border-color: #667eea; }
            .search-icon { position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #9ca3af; }
            .table-container { overflow-x: auto; border-radius: 8px; border: 1px solid #e2e8f0; }
            .table { width: 100%; border-collapse: collapse; background: white; }
            .table th { background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); padding: 1rem; text-align: left; font-weight: 600; color: #374151; border-bottom: 2px solid #e2e8f0; }
            .table td { padding: 1rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
            .table tr:hover { background-color: #f8fafc; }
            .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-top: 2rem; }
            .stat-card { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 1rem; transition: transform 0.2s ease; }
            .stat-card:hover { transform: translateY(-2px); }
            .stat-icon { width: 3rem; height: 3rem; border-radius: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.25rem; }
            .stat-number { font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 0.25rem; }
            .stat-label { font-size: 0.875rem; color: #6b7280; font-weight: 500; }

            /* Formularios */
            .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; }
            .form-group { margin-bottom: 1.5rem; }
            .form-label { display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; }
            .form-control, .search-input { width: 100%; padding: 0.75rem; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.875rem; transition: border-color 0.2s ease; }
            .form-control:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }

            /* Status badges */
            .status-badge { padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; }
            .status-pending { background-color: #fef3c7; color: #92400e; }
            .status-active { background-color: #d1fae5; color: #065f46; }
            .status-cancelled { background-color: #fee2e2; color: #991b1b; }

            /* Container principal */
            main { padding: 2rem; max-width: 1200px; margin: 0 auto; }
            
            @media (max-width: 768px) {
                .form-grid { grid-template-columns: 1fr; }
                main { padding: 1rem; }
                .page-header { padding: 1.5rem; }
                .card { padding: 1.5rem; }
            }
        </style>
    </head>
    <body class="font-sans antialiased" x-data="{ mobileOpen: false }">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                @yield('content')
                @if(isset($slot))
                    {{ $slot }}
                @endif
            </main>
        </div>
    </body>
</html>