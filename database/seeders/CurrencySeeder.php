<?php

namespace Database\Seeders;

use App\Models\Divisa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Divisa::create([
            'name' => 'Dolar',
            'symbol' => 'USD',
            'exchange_rate' => 1,
        ]);
    }
}
