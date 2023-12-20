<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $fillable = [
        'detalle',
        'f_ini',
        'f_fin',
        'idpersonal',
        'iduser',
        'estado',
    ];
}
