<?php
// app/Models/Venta.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_Venta';
    
    protected $fillable = [
        'ID_Cliente',
        'Fecha',
        'Total'
    ];

    protected $casts = [
        'Fecha' => 'datetime'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'ID_Cliente');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'ID_Venta');
    }
}