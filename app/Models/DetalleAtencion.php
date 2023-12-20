<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleAtencion extends Model
{
    use HasFactory;

    protected $table = 'detalle_atencions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'idatencion',
        'detalle_procedimiento',
        'costo',
    ];


}
