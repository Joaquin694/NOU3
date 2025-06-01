<?php
// app/Models/Cliente.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_Cliente';
    
    protected $fillable = [
        'Nombres',
        'Apellidos',
        'DNI',
        'Telefono',
        'Correo',
        'Fecha_Registro'
    ];

    protected $casts = [
        'Fecha_Registro' => 'date'
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class, 'ID_Cliente');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'ID_Cliente');
    }
}