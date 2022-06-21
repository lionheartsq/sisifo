<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('facturas', function(Blueprint $table)
		{
			$table->id();
			$table->integer('consecutivo');
			$table->date('fecha');
			$table->integer('valor');
			$table->integer('impuesto');
			$table->integer('total');
			$table->string('vendedor', 250);
			$table->foreignId('idVendedor')->constrained('users');
			$table->foreignId('tipoFactura')->constrained('tipofactura');
			$table->foreignId('idClientes')->constrained('clientes');
			$table->integer('estado')->default(1);
			$table->foreignId('idEmpresa')->constrained('empresa');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('facturas');
	}

}
