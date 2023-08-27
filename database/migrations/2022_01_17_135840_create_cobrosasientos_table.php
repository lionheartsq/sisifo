<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCobrosasientosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cobrosasientos', function(Blueprint $table)
		{
			$table->id();
			$table->foreignId('idCobros')->constrained('cobros');
			$table->foreignId('idAsientos')->constrained('asientos');
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
		Schema::drop('cobrosasientos');
	}

}
