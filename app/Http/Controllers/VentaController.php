<?php
// app/Http/Controllers/VentaController.php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('cliente')->get();
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::where('Cantidad', '>', 0)->get();
        return view('ventas.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ID_Cliente' => 'required|exists:clientes,ID_Cliente',
            'Fecha' => 'required|date',
            'Total' => 'required|numeric|min:0',
            'productos' => 'required|array|min:1',
            'productos.*.ID_Producto' => 'required|exists:productos,ID_Producto',
            'productos.*.Cantidad' => 'required|integer|min:1',
            'productos.*.Precio' => 'required|numeric|min:0'
        ]);

        // Crear la venta
        $venta = Venta::create([
            'ID_Cliente' => $request->ID_Cliente,
            'Fecha' => $request->Fecha,
            'Total' => $request->Total
        ]);

        // Crear los detalles de la venta
        foreach($request->productos as $producto) {
            DetalleVenta::create([
                'ID_Venta' => $venta->ID_Venta,
                'ID_Producto' => $producto['ID_Producto'],
                'Cantidad' => $producto['Cantidad'],
                'Precio' => $producto['Precio']
            ]);

            // Actualizar stock del producto
            $productoModel = Producto::find($producto['ID_Producto']);
            $productoModel->Cantidad -= $producto['Cantidad'];
            $productoModel->save();

            // Registrar movimiento de inventario
            MovimientoInventario::create([
                'ID_Producto' => $producto['ID_Producto'],
                'Tipo' => 'Salida',
                'Cantidad' => $producto['Cantidad'],
                'Fecha' => now()
            ]);
        }

        return redirect()->route('ventas.index')->with('success', 'Venta registrada exitosamente');
    }

    public function show(Venta $venta)
    {
        $venta->load(['cliente', 'detalles.producto']);
        return view('ventas.show', compact('venta'));
    }

    public function edit(Venta $venta)
    {
        $clientes = Cliente::all();
        return view('ventas.edit', compact('venta', 'clientes'));
    }

    public function update(Request $request, Venta $venta)
    {
        $request->validate([
            'ID_Cliente' => 'required|exists:clientes,ID_Cliente',
            'Fecha' => 'required|date',
            'Total' => 'required|numeric|min:0'
        ]);

        $venta->update($request->all());
        return redirect()->route('ventas.index')->with('success', 'Venta actualizada exitosamente');
    }

    public function destroy(Venta $venta)
    {
        $venta->delete();
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada exitosamente');
    }
}