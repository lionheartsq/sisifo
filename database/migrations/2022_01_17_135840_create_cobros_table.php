<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCobrosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cobros', function(Blueprint $table)
		{
			$table->id();
			$table->date('fechaAbono');
			$table->integer('valorCobro');
			$table->integer('abono');
			$table->foreignId('idFacturas')->constrained('facturas');
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
		Schema::drop('cobros');
	}

}
