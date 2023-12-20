<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'app_apm',
        'f_nacimiento',
        'celular',
        'direccion',
    ];


    public function contratos()
    {
        return $this->hasMany(Contrato::class, 'idpersonal');
    }
}
