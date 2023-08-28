<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control', function (Blueprint $table) {
            $table->id();
			$table->foreignId('idEmpleado')->constrained('tb_empleado');
            $table->timestamp('ingreso')->useCurrent();
            $table->timestamp('salida')->nullable();
            $table->foreignId('idEmpresa')->constrained('tb_configuracion_basica');
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
        Schema::dropIfExists('control');
    }
}
