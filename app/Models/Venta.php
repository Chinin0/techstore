<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Persona;
use App\Models\User;
use App\Models\DetalleVenta;
use App\Models\Pago;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'idPago',
        'idusuario',
        'tipo_comprobante',
        'serie_comprobante',
        'num_comprobante',
        'fecha_hora',
        'impuesto',
        'total',
        'estado',
    ];

    public function cliente()
    {
        return $this->belongsTo(Persona::class, 'idcliente');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idusuario');
    }
    public function pago()
    {
        return $this->belongsTo(Pago::class, 'idPago');
    }

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'idventa');
    }
}
