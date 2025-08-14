<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ZonaGeneral;
use Illuminate\Support\Facades\DB;
class ZonaGeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('zona_generals')->insert([
            ['id' => 1, 'zona_id' => 1, 'area' => 'Tobogan Kraken', 'capacidad' => 1000],
            ['id' => 2, 'zona_id' => 2, 'area' => 'Alberca de Olas', 'capacidad' => 5000],

        ]);
    }
}
