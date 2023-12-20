<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleReceta extends Model
{
    use HasFactory;
    protected $fillable = [
        'idreceta',
        'nombre_producto',
        'indicaciones',
    ];

    // Relación inversa con el modelo Receta
    public function receta()
    {
        return $this->belongsTo(Receta::class, 'idreceta');
    }
}
