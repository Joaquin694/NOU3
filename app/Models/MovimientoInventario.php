<?php
// app/Models/MovimientoInventario.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_Movimiento';
    
    protected $fillable = [
        'ID_Producto',
        'Tipo',
        'Cantidad',
        'Fecha'
    ];

    protected $casts = [
        'Fecha' => 'datetime'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'ID_Producto');
    }
}