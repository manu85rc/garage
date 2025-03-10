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
        Schema::create('estacionamientos', function (Blueprint $table) {
            $table->id();
            $table->string('patente', 8);
            $table->dateTime('ingreso');
            $table->dateTime('salida')->nullable();
            $table->enum('servicio', ['xHora', 'Estadía', 'Lavado'])->default('xHora');
            $table->decimal('total', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estacionamientos');
    }
};