<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('iduser');
            $table->date('fecha');
            $table->string('nombre');
            $table->string('numero_referencia')->nullable();
            $table->decimal('monto', 8, 2);
            $table->string('metodo_pago');
            $table->text('descripcion')->nullable();
            $table->string('estado_pago');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos');
    }
};
