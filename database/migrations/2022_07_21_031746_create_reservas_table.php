<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
			$table->id();
			$table->string('detalle', 250);
			$table->string('estado', 250);
            $table->date('fecha');
			$table->foreignId('idCliente')->constrained('clientes');
            $table->foreignId('idHabitacion')->constrained('habitacion');
            $table->foreignId('idEmpresa')->constrained('tb_configuracion_basica');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservas');
    }
}
