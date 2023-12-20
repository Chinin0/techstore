<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtencionClinica extends Model
{
    use HasFactory;

    protected $table = 'atencion_clinica';
    protected $primaryKey = 'id';
    protected $fillable = [
        'iddetalle_servicio',
        'motivo',
        'hr',
    ];


}
