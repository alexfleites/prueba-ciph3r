<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Datos de ejemplo
        $products = [
            [
                'name' => 'Producto A',
                'description' => 'Descripción del Producto A',
                'price' => 100.00,
                'currency_id' => 1, // Asegúrate de que esta ID exista en la tabla de divisas
                'tax_cost' => 10.00,
                'manufacturing_cost' => 60.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Producto B',
                'description' => 'Descripción del Producto B',
                'price' => 200.00,
                'currency_id' => 1,
                'tax_cost' => 20.00,
                'manufacturing_cost' => 120.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Producto C',
                'description' => 'Descripción del Producto C',
                'price' => 150.00,
                'currency_id' => 1,
                'tax_cost' => 15.00,
                'manufacturing_cost' => 90.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insertar los datos en la tabla 'products'
        DB::table('productos')->insert($products);
    }
}
