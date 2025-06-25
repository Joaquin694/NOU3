<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\DetalleVentaController;
use App\Http\Controllers\MovimientoInventarioController;

// Ruta pública (página de inicio)
Route::get('/', function () {
    return view('welcome');
});

// Dashboard protegido por autenticación
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas protegidas por autenticación (tus rutas originales)
Route::middleware(['auth'])->group(function () {
    
    // Rutas de recursos (todas protegidas)
    Route::resource('trabajadores', TrabajadorController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('servicios', ServicioController::class);
    Route::resource('citas', CitaController::class);
    Route::resource('productos', ProductoController::class);
    Route::resource('ventas', VentaController::class);
    Route::resource('detalle-ventas', DetalleVentaController::class);
    Route::resource('movimiento-inventarios', MovimientoInventarioController::class);
    
    // Ruta para vista de impresión
    Route::get('ventas/{venta}/print', [VentaController::class, 'print'])->name('ventas.print');
    
    // Rutas de perfil (agregadas por Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Incluir las rutas de autenticación de Breeze
require __DIR__.'/auth.php';