<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Models\Persona;
use App\Models\User;
use App\Models\DetalleIngreso;


class Ingreso extends Model
{
    use HasFactory;

    protected $table = 'ingresos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'idproveedor',
        'idusuario',
        'tipo_comprobante',
        'serie_comprobante',
        'num_comprobante',
        'fecha',
        'impuesto',
        'total',
        'estado',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Persona::class, 'idproveedor');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idusuario');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleIngreso::class, 'idingreso');
    }
}
