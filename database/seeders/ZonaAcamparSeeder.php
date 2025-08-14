<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ZonaAcampar;
use Illuminate\Support\Facades\DB;
class ZonaAcamparSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('zona_acampars')->insert([
            ['id' => 1, 'zona_id' => 2, 'lote' => 'L01', 'area_comun' => 0],
            ['id' => 2, 'zona_id' => 3, 'lote' => 'L02', 'area_comun' => 1],
        ]);
    }
}
