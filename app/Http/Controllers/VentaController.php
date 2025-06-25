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
            'Total' => 'required|numeric|min:0'
        ]);

        Venta::create($request->all());
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