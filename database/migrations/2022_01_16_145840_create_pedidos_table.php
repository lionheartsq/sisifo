<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pedidos', function(Blueprint $table)
		{
			$table->id();
			$table->string('consecutivo', 50);
			$table->date('fecha');
			$table->integer('valor');
			$table->integer('impuesto');
			$table->integer('total');
			$table->foreignId('idVendedor')->constrained('tb_empleado');
			$table->foreignId('idTipoFactura')->constrained('tipofactura');
			$table->foreignId('idProveedores')->constrained('proveedores');
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
		Schema::drop('pedidos');
	}

}
