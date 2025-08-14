<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ZonaHotel;
use Illuminate\Support\Facades\DB;
class ZonaHotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('zona_hotels')->insert([
            ['id' => 7, 'zona_id' => 1, 'habitacion' => 'H101', 'piso' => '1'],
            ['id' => 8, 'zona_id' => 2, 'habitacion' => 'H201', 'piso' => '2'],
        ]);    
        
    }
}
