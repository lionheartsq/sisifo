<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibromayorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('libromayor', function(Blueprint $table)
		{
			$table->id();
			$table->integer('valorEntrada');
			$table->integer('valorSalida');
			$table->integer('acumulado');
			$table->foreignId('idAsientos')->constrained('asientos');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('libromayor');
	}

}
