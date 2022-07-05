<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('registros', function(Blueprint $table)
		{
			$table->id();
			$table->date('fecha');
			$table->string('concepto', 250);
			$table->string('detalle', 250);
			$table->foreignId('idAsientos')->constrained('asientos');
			$table->integer('entrada');
			$table->integer('salida');
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
		Schema::drop('registros');
	}

}
