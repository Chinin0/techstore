<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $categorias = [
            [
             'nombre' => 'Cuadernos y hojas',
             'descripcion' => 'Cuadernos rayados, cuadriculados, de dibujo y hojas sueltas',
            ],
            [
             'nombre' => 'Útiles escolares',
             'descripcion' => 'Lápices, lapiceras, resaltadores, pegamento y demás artículos de uso diario',
            ],
            [
             'nombre' => 'Mochilas y bolsos',
             'descripcion' => 'Mochilas, cartucheras, bolsos y similares para transportar materiales',
            ],
            [
             'nombre' => 'Papeles y cartulinas',
             'descripcion' => 'Hojas blancas, de colores, opacas, metalizadas y tipos de cartulina',
            ],
            [
             'nombre' => 'Pinturas y manualidades',
             'descripcion' => 'Témperas, acuarelas, pinceles y otros productos de manualidades',
            ],
            [
             'nombre' => 'Otros',
             'descripcion' => 'Cualquier otro artículo que no entre en categorías anteriores',
            ],
        ];
        foreach ($categorias as $categoriaData) {
            $existingCategoria = Categoria::where('nombre', $categoriaData['nombre'])->first();

            if (!$existingCategoria) {
                Categoria::create($categoriaData);
            }
        }
    }
}
