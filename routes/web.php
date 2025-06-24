<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\DetalleVentaController;
use App\Http\Controllers\MovimientoInventarioController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de recursos
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

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');