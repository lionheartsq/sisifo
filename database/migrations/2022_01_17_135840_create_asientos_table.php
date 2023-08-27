<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsientosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('asientos', function(Blueprint $table)
		{
			$table->id();
			$table->date('fecha');
			$table->string('concepto', 250);
			$table->string('detalle', 250);
			$table->integer('tipologia');
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
		Schema::drop('asientos');
	}

}
