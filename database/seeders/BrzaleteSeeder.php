<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brazalete;
use App\Models\Evento;
use App\Models\Ubicacion;
use App\Models\Estatus;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BrzaleteSeeder extends Seeder
{
    public function run()
    {
        //Verificacion de que existen los datos
        if (Evento::count() === 0) {
            $this->call(EventSeeder::class);
        }

        if (Ubicacion::count() === 0) {
            $this->call(UbicacionSeeder::class);
        }

        if (Estatus::count() === 0) {
            $this->call(EventoSeeder::class);
        } 

        //obtencio de los datos
        $eventos = Evento::pluck('codigo')->toArray();
        $ubicaciones = Ubicacion::pluck('codigo')->toArray();
        $estatusIds = Estatus::pluck('id')->toArray();

        //Creacion de brazletes 
        Brazalete::factory()->count(50)->create([
            'evento_codigo' => function () use ($eventos) {
                return $this->faker->randomElemt($eventos);
            },

            'ubicacion_codigo' => function () use ($ubicaciones) {
                return $this->faker->randomElement($ubicaciones);
            },

            'estatus_id' => function () use ($estatusIds) {
                return $this->faker->randomElement($estatusIds);
            }
        ]);
            //Mensaje de confirmación
            $this->command->info('Se han generado los brazaletes de prueba con exito');
    }

}