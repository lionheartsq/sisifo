<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clientes', function(Blueprint $table)
		{
			$table->id();
			$table->string('cedula', 25)->unique('cedula');
			$table->string('nombres', 250);
			$table->string('apellidos', 250);
			$table->string('direccion', 750)->nullable();
			$table->string('telefono', 45)->nullable();
			$table->string('correo', 70)->nullable();
            $table->foreignId('idEmpresa')->constrained('tb_configuracion_basica');
			$table->integer('estado')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clientes');
	}

}
