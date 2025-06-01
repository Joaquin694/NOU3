<?php
// app/Models/Trabajador.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_Trabajador';
    
    protected $fillable = [
        'Nombres',
        'Apellidos', 
        'Cargo',
        'Estado'
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class, 'ID_Trabajador');
    }
}