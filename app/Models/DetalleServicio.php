<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Servicio;


class DetalleServicio extends Model
{
    use HasFactory;

    protected $table = 'detalle_servicios';

    protected $fillable = [
        'idservicio',
        'tipo_servicio',
        'nro_servicio',
        'costo',
    ];

    // Relación con el modelo Servicio
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'idservicio');
    }
}
