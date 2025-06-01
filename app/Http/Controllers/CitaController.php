<?php
// app/Http/Controllers/CitaController.php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Servicio;
use App\Models\Trabajador;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index()
    {
        $citas = Cita::with(['cliente', 'servicio', 'trabajador'])->get();
        return view('citas.index', compact('citas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $servicios = Servicio::all();
        $trabajadores = Trabajador::where('Estado', 'Activo')->get();
        return view('citas.create', compact('clientes', 'servicios', 'trabajadores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ID_Cliente' => 'required|exists:clientes,ID_Cliente',
            'ID_Servicio' => 'required|exists:servicios,ID_Servicio',
            'ID_Trabajador' => 'required|exists:trabajadors,ID_Trabajador',
            'Fecha_Hora' => 'required|date_format:Y-m-d\TH:i',
            'Estado' => 'required|in:Pendiente,Confirmada,Completada,Cancelada'
        ]);

        Cita::create($request->all());
        return redirect()->route('citas.index')->with('success', 'Cita creada exitosamente');
    }

    public function show(Cita $cita)
    {
        return view('citas.show', compact('cita'));
    }

    public function edit(Cita $cita)
    {
        $clientes = Cliente::all();
        $servicios = Servicio::all();
        $trabajadores = Trabajador::where('Estado', 'Activo')->get();
        return view('citas.edit', compact('cita', 'clientes', 'servicios', 'trabajadores'));
    }

    public function update(Request $request, Cita $cita)
    {
        $request->validate([
            'ID_Cliente' => 'required|exists:clientes,ID_Cliente',
            'ID_Servicio' => 'required|exists:servicios,ID_Servicio',
            'ID_Trabajador' => 'required|exists:trabajadors,ID_Trabajador',
            'Fecha_Hora' => 'required|date_format:Y-m-d\TH:i',
            'Estado' => 'required|in:Pendiente,Confirmada,Completada,Cancelada'
        ]);

        $cita->update($request->all());
        return redirect()->route('citas.index')->with('success', 'Cita actualizada exitosamente');
    }

    public function destroy(Cita $cita)
    {
        $cita->delete();
        return redirect()->route('citas.index')->with('success', 'Cita eliminada exitosamente');
    }
}