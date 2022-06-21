<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallepedidosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detallepedidos', function(Blueprint $table)
		{
			$table->id();
			$table->float('cantidad', 10, 0);
			$table->integer('valor');
			$table->integer('valorImpuesto');
			$table->integer('total');
			$table->foreignId('idPedidos')->constrained('pedidos');
			$table->foreignId('idProductos')->constrained('productos');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('detallepedidos');
	}

}
