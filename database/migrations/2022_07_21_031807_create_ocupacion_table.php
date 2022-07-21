<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOcupacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocupacion', function (Blueprint $table) {
			$table->id();
			$table->string('detalle', 250);
			$table->string('estado', 250);
            $table->date('fechaIngreso');
            $table->date('fechaSalida');
            $table->time('horaIngreso');
            $table->time('horaSalida');
			$table->foreignId('idCliente')->constrained('clientes');
            $table->foreignId('idHabitacion')->constrained('habitacion');
            $table->foreignId('idEmpresas')->constrained('empresa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ocupacion');
    }
}
