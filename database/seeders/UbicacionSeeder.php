<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\DB;
class UbicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ubicacions')->insert([
            ['id' => 1, 'codigo' => 'AL01', 'nombre' => 'Alberca de Olas', 'descripcion' => 'Ubicacion Principal'],
            ['id' => 2, 'codigo' => 'AL02', 'nombre' => 'Alberca Olimpica', 'descripcion' => 'Ubicacion Secundaria'],
            ['id' => 3, 'codigo' => 'AL03', 'nombre' => 'Alberca Infantil', 'descripcion' => 'Ubicacion Zona Familiar'],
        ]);
    }
}
