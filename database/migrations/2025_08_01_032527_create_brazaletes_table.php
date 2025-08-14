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
        Schema::create('brazaletes', function (Blueprint $table) {
            $table->id();
            $table->string('qr_code', 100)->unique();
            $table->dateTime('fecha_in');
            $table->dateTime('fecha_out');
            $table->foreignId('estatus_id')->constrained('estatuses');
            $table->integer('contador_reingresos')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brazaletes');
    }
};
