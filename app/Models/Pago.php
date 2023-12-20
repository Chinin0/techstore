<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;


    protected $table = 'pagos';

    protected $fillable = [
        'iduser',
        'fecha',
        'nombre',
        'numero_referencia',
        'monto',
        'metodo_pago',
        'descripcion',
        'estado_pago',
    ];
    public function venta(){
        return $this->hasOne(Venta::class);
    }

    // public function servicio()
    // {
    //     return $this->belongsTo(Servicio::class, 'idservicio');
    // }

}
