<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estatus;
use Illuminate\Support\Facades\DB;
class EstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estatuses')->insert([
            ['id' => 1, 'codigo' => 'PEND', 'nombre' => 'Pendiente', 'descripcion' => 'Brazalete generado pero no activado'],
            ['id' => 2, 'codigo' => 'ACTV', 'nombre' => 'Activo', 'descripcion' => 'Brazalete en uso'],
            ['id' => 3, 'codigo' => 'RCHZ', 'nombre' => 'Rechazado', 'descripcion' =>  'Brzalate rechazado'],
            ['id' => 4, 'codigo' => 'IMPR', 'nombre' => 'Imprezo' , 'descripcion' => 'Brzalate impreso peor no activo'],
            ['id' => 5,  'codigo' => 'REIN', 'nombre' => 'Reingresos', 'descripcion' => 'Brazalete con reingresos'],
        ]);
    }
}
