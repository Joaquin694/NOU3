<?php
// app/Models/Producto.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_Producto';
    
    protected $fillable = [
        'Nombre',
        'Cantidad',
        'Precio_Venta'
    ];

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'ID_Producto');
    }

    public function movimientosInventario()
    {
        return $this->hasMany(MovimientoInventario::class, 'ID_Producto');
    }
}