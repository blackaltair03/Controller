<?php

// database/factories/BrazaleteFactory.php
namespace Database\Factories;

use App\Models\Estatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrazaleteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'qr_code' => 'BR' . $this->faker->unique()->numerify('########'),
            'fecha_in' => $this->faker->dateTimeThisMonth(),
            'fecha_out' => $this->faker->dateTimeThisMonth('+2 days'),
            'estatus_id' => Estatus::inRandomOrder()->first()->id ?? Estatus::factory(),
            'contador_reingresos' => $this->faker->numberBetween(0, 3),
        ];
    }
}