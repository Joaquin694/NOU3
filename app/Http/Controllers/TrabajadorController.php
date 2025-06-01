<?php
// app/Http/Controllers/TrabajadorController.php

namespace App\Http\Controllers;

use App\Models\Trabajador;
use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
    public function index()
    {
        $trabajadores = Trabajador::all();
        return view('trabajadores.index', compact('trabajadores'));
    }

    public function create()
    {
        return view('trabajadores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nombres' => 'required|max:255',
            'Apellidos' => 'required|max:255',
            'Cargo' => 'required|max:50',
            'Estado' => 'required|in:Activo,Inactivo'
        ]);

        Trabajador::create($request->all());
        return redirect()->route('trabajadores.index')->with('success', 'Trabajador creado exitosamente');
    }

    public function show(Trabajador $trabajador)
    {
        return view('trabajadores.show', compact('trabajador'));
    }

    public function edit(Trabajador $trabajador)
    {
        return view('trabajadores.edit', compact('trabajador'));
    }

    public function update(Request $request, Trabajador $trabajador)
    {
        $request->validate([
            'Nombres' => 'required|max:255',
            'Apellidos' => 'required|max:255',
            'Cargo' => 'required|max:50',
            'Estado' => 'required|in:Activo,Inactivo'
        ]);

        $trabajador->update($request->all());
        return redirect()->route('trabajadores.index')->with('success', 'Trabajador actualizado exitosamente');
    }

    public function destroy(Trabajador $trabajador)
    {
        $trabajador->delete();
        return redirect()->route('trabajadores.index')->with('success', 'Trabajador eliminado exitosamente');
    }
}