<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Venta;
use App\Models\Producto;


class DetalleVenta extends Model
{
    use HasFactory;

    protected $table = 'detalle_ventas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'idventa',
        'idproducto',
        'cantidad',
        'precio',
        'descuento',
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'idventa');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idproducto');
    }
}
