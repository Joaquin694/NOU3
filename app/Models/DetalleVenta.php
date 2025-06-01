<?php
// app/Models/DetalleVenta.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_Detalle';
    
    protected $fillable = [
        'ID_Venta',
        'ID_Producto',
        'Cantidad',
        'Precio'
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'ID_Venta');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'ID_Producto');
    }
}