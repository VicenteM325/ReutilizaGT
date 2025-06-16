<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categorias')->insert([
            [
                'nombre' => 'Electrodomésticos',
                'descripcion' => 'Artículos como licuadoras, planchas, microondas, etc.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ropa y Calzado',
                'descripcion' => 'Prendas de vestir y calzado en buen estado.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Muebles',
                'descripcion' => 'Mesas, sillas, camas, estanterías, etc.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Juguetes',
                'descripcion' => 'Juguetes reutilizables para niños y niñas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Libros y Revistas',
                'descripcion' => 'Material de lectura en buenas condiciones.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Tecnología',
                'descripcion' => 'Celulares, tablets, laptops viejas pero funcionales.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
