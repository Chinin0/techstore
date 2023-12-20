<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'especie',
        'raza',
        'sexo',
        'color',
        'f_nacimiento',
        'propietario',
        'perfil',
    ];
}
