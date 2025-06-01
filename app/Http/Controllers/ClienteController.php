<?php
// app/Http/Controllers/ClienteController.php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nombres' => 'required|max:255',
            'Apellidos' => 'required|max:255',
            'DNI' => 'required|unique:clientes|max:15',
            'Telefono' => 'required|max:15',
            'Correo' => 'required|email|max:100',
            'Fecha_Registro' => 'required|date'
        ]);

        Cliente::create($request->all());
        return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente');
    }

    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'Nombres' => 'required|max:255',
            'Apellidos' => 'required|max:255',
            'DNI' => 'required|max:15|unique:clientes,DNI,' . $cliente->ID_Cliente . ',ID_Cliente',
            'Telefono' => 'required|max:15',
            'Correo' => 'required|email|max:100',
            'Fecha_Registro' => 'required|date'
        ]);

        $cliente->update($request->all());
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente');
    }
}