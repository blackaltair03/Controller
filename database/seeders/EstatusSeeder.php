<?php

// database/seeders/EstatusSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estatuses')->insert([
            ['codigo' => 'PEND', 'nombre' => 'Pendiente', 'descripcion' => 'Brazalete generado pero no activado'],
            ['codigo' => 'ACTV', 'nombre' => 'Activo', 'descripcion' => 'Brazalete en uso'],
            ['codigo' => 'RCHZ', 'nombre' => 'Rechazado', 'descripcion' => 'Brazalete rechazado'],
            ['codigo' => 'IMPR', 'nombre' => 'Impreso', 'descripcion' => 'Brazalete impreso pero no activo'],
            ['codigo' => 'REIN', 'nombre' => 'Reingreso', 'descripcion' => 'Brazalete con reingresos'],
            ['codigo' => 'EXP', 'nombre' => 'Expirado', 'descripcion' => 'El tiempo del brazalete ha terminado'],
        ]);
    }
}