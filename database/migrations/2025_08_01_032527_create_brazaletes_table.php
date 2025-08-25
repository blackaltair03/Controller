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
        $table->string('qr_code')->unique();
        $table->string('evento_codigo');
        $table->string('ubicacion_codigo');
        $table->datetime('fecha_in');
        $table->datetime('fecha_out')->nullable();
        $table->foreignId('estatus_id')->constrained('estatuses');
        $table->integer('contador_reingresos')->default(0);
        $table->timestamps();
        
    // Claves foráneas
    $table->foreign('evento_codigo')->references('codigo')->on('eventos');
    $table->foreign('ubicacion_codigo')->references('codigo')->on('ubicacions');
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
