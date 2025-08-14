<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Evento;
use Illuminate\Support\Facades\DB;
class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('eventos')->insert([
            ['id' => 1, 'codigo' => '1234', 'duracion' => 240, 'descripcion' => 'Evento estandar de 4 horas'],
            ['id' => 2, 'codigo' => '5678', 'duracion' => 480, 'descripcion' => 'Evento de dia completo (8horas)'],
            ['id' => 3, 'codigo' => '9012', 'duracion' => 1440, 'descripcion' => 'Evento de 24 Horas'],
        ]);
    }
}
