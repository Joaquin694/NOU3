<?php
// app/Models/Cita.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_Cita';
    
    protected $fillable = [
        'ID_Cliente',
        'ID_Servicio',
        'ID_Trabajador',
        'Fecha_Hora',
        'Estado'
    ];

    protected $casts = [
        'Fecha_Hora' => 'datetime'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'ID_Cliente');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'ID_Servicio');
    }

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class, 'ID_Trabajador');
    }
}