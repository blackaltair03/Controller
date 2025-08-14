<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Servicio;
use Illuminate\Support\Facades\DB;
class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('servicios')->insert([
            ['id' => 1, 'codigo' => '0101', 'nombre' => 'VIP', 'descripcion' => 'Servicio Premium, Acceso total al los servicios del Balneario'],
            ['id' => 2, 'codigo' => '0202', 'nombre' => 'INAPAM', 'descripcion' => 'Descuento para adultos mayores, Acceso a todos los servicios del Balneario'],
            ['id' => 3, 'codigo' => '0303', 'nombre' => 'Infantil', 'descripcion' => 'Descuento para niños menores de 11 años, Descuento del 50%'],
            ['id' => 4, 'codigo' => '0404', 'nombre' => 'Consecion', 'descripcion' => 'Descuento con empresas que suministran la DP'],
        ]);
    }
}
