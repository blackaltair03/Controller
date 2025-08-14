<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('zona_hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zona_id')->unique()->constrained('zonas');
            $table->string('habitacion', 20)->nullable();
            $table->string('piso', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zona_hotels');
    }
};
