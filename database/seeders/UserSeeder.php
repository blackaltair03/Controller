<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => "check User",
            'email' => "check@example.com",
            'password' => Hash::make('check123'),
            'status' => 'alta',
            'roll' => 'cheacador',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
