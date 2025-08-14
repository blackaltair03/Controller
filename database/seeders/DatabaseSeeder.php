<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            EstatusSeeder::class,
            EventoSeeder::class,
            ServicioSeeder::class,
            UbicacionSeeder::class,
            ZonaSeeder::class,
            ZonaAcamparSeeder::class,
            ZonaHotelSeeder::class,
            ZonaGeneralSeeder::class,
        ]);

        User::factory()->create([
        # 'name' => 'Test User',
            #'email' => 'test@example.com',
        ]);
    }
}
