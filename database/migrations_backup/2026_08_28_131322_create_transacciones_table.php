<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transacciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comercio_id')->constrained();
            $table->decimal('monto', 10, 2);
            $table->string('moneda', 3)->default('USD');
            $table->string('cliente_nombre');
            $table->string('metodo_pago');
            $table->string('estado')->default('Iniciada');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transacciones');
    }
};
