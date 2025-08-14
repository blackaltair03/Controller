<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brazalete;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BrzaleteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factor::create();

        for ($i = 0; $i < 20; $i++) {
            $fecha_in = $faker->dateTimeBetween('-1 week', 'now');
            $fecha_out = rand(0, 1) ? $faker->dateTimeBetween($fecha_in, 'now') : null;

            DB::table('brazalete')->insert([
                'qr_code' => strtoupper(Str::random(10)),
                'fecha_in' => $fecha_in,
                'fecha_out' => $fecha_out,
                'eststus_id' => $faker->numberBetween(1, 5), #Coincidencia con el estatus existentes}
                'contador_reingresos' => $faker->numberBetween(0, 3),
            ]);
        }
    }
}
