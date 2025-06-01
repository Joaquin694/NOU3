<?php
// app/Http/Controllers/ServicioController.php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::all();
        return view('servicios.index', compact('servicios'));
    }

    public function create()
    {
        return view('servicios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:255',
            'Precio' => 'required|numeric|min:0',
            'Duracion' => 'required|integer|min:1'
        ]);

        Servicio::create($request->all());
        return redirect()->route('servicios.index')->with('success', 'Servicio creado exitosamente');
    }

    public function show(Servicio $servicio)
    {
        return view('servicios.show', compact('servicio'));
    }

    public function edit(Servicio $servicio)
    {
        return view('servicios.edit', compact('servicio'));
    }

    public function update(Request $request, Servicio $servicio)
    {
        $request->validate([
            'Nombre' => 'required|max:255',
            'Precio' => 'required|numeric|min:0',
            'Duracion' => 'required|integer|min:1'
        ]);

        $servicio->update($request->all());
        return redirect()->route('servicios.index')->with('success', 'Servicio actualizado exitosamente');
    }

    public function destroy(Servicio $servicio)
    {
        $servicio->delete();
        return redirect()->route('servicios.index')->with('success', 'Servicio eliminado exitosamente');
    }
}