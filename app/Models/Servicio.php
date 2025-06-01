<?php
// app/Models/Servicio.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_Servicio';
    
    protected $fillable = [
        'Nombre',
        'Precio',
        'Duracion'
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class, 'ID_Servicio');
    }
}