<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Zona;
use Illuminate\Support\Facades\DB;
class ZonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('zonas')->insert([
            ['id' => 1, 'codigo' => 'A01', 'nombre' => 'Zona General', 'tipo' => 'general', 'descripcion' => 'Area comun para todo publico.'],
            ['id' => 2, 'codigo' => 'A02', 'nombre' => 'Zona Hotel', 'tipo' => 'hotel', 'descripcion' => 'Area exclusiva hotel'],
            ['id' => 3, 'codigo' => 'A03', 'nombre' => 'Zona Camping', 'tipo' => 'acampar', 'descripcion' => 'Area exclusiva acampar'],
        ]);
    }
}
