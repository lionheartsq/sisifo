<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallefacturasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detallefacturas', function(Blueprint $table)
		{
			$table->id();
			$table->float('cantidad', 10, 0);
			$table->integer('valor');
			$table->integer('valorImpuesto');
			$table->integer('total');
			$table->foreignId('idFacturas')->constrained('facturas');
			$table->foreignId('idProductos')->constrained('productos');
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
		Schema::drop('detallefacturas');
	}

}
