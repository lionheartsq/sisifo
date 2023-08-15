<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('documento');
			$table->string('nombres', 250);
			$table->string('apellidos', 250);
            $table->string('direccion', 250);
            $table->string('cargo', 250);
			$table->bigInteger('telefono')->default('1');
            $table->string('email');
            $table->foreignId('idEmpresa')->constrained('empresa');
            $table->boolean('estado')->default(1);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}
