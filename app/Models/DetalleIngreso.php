<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Ingreso;
use App\Models\Producto;


class DetalleIngreso extends Model
{
    use HasFactory;

    protected $table = 'detalle_ingresos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'idingreso',
        'idproducto',
        'cantidad',
        'precio',
    ];

    public function ingreso()
    {
        return $this->belongsTo(Ingreso::class, 'idingreso');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idproducto');
    }
}
