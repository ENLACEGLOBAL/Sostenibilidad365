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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('numero_identificacion');
            $table->string('nombre_empleado'); 
            $table->string('cargo');
            $table->string('pais'); 
            $table->string('ciudad');
            $table->date('fecha_transaccion');
            $table->string('concepto_pago'); 
            $table->decimal('valor_pago', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
