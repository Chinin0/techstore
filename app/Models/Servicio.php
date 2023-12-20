<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paciente;
use App\Models\Persona;


class Servicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'responsable',
        'idpaciente',
        'idmedico',
        'fecha',
        'total',
    ];

        // Relación con el modelo Paciente
        public function paciente()
        {
            return $this->belongsTo(Paciente::class, 'idpaciente');
        }
        public function persona()
        {
            return $this->belongsTo(Persona::class, 'idmedico');
        }
}
