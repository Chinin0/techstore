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
                'nombre' => 'Dispositivos de Entrada',
                'descripcion' => 'Encuentra una variedad de dispositivos de entrada esenciales para tu computadora, desde teclados y ratones ergonómicos hasta webcams de alta definición y altavoces para una experiencia completa.',
            ],
            [
                'nombre' => 'Pantallas y Proyección',
                'descripcion' => 'Explora nuestra selección de pantallas y proyección para mejorar tu visualización, incluyendo monitores LED de alta resolución, pantallas táctiles interactivas y proyectores para presentaciones impactantes.',
            ],
            [
                'nombre' => 'Conectividad y Cableado',
                'descripcion' => 'Conecta tus dispositivos de manera eficiente con nuestra gama de cables y accesorios de conectividad, que incluyen cables USB duraderos, adaptadores versátiles y soluciones de cableado para mantener todo organizado.',
            ],
            [
                'nombre' => 'Almacenamiento y Accesorios',
                'descripcion' => 'Descubre soluciones de almacenamiento inteligentes y accesorios prácticos para tu equipo, desde unidades de disco duro externas hasta estaciones de acoplamiento y bolsas de transporte para periféricos.',
            ],
            [
                'nombre' => 'Suministros de Oficina Tecnológicos',
                'descripcion' => 'Encuentra suministros tecnológicos esenciales para tu oficina, desde cartuchos de tinta y papel para impresora hasta lámparas LED de escritorio y kits de limpieza para mantener tus dispositivos en óptimas condiciones.',
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
