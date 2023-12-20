<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;

    protected $fillable = [
        'idatencion',
        'numero_recetario',
        'estado',
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'idatencion');
    }
}
