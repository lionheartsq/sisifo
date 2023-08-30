<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_producto', function (Blueprint $table) {
            $table->id();
            $table->string('producto', 255);
            $table->string('referencia', 255)->nullable();
            $table->string('plu', 255)->nullable();
            $table->string('foto', 2038);
            $table->string('descripcion', 255)->nullable();
            $table->foreignId('idMedida')->constrained('tb_unidad_base');
            $table->foreignId('idColeccion')->constrained('tb_coleccion');
            $table->foreignId('idArea')->constrained('tb_area');
            $table->foreignId('idEmpresa')->constrained('tb_configuracion_basica');
            $table->foreignId('idImpuesto')->constrained('impuesto');
            $table->enum('tipo', array('1','2'))->default('2')->comment('1-Term 2-Trans');
            $table->integer('valorCompra');
            $table->integer('pvp');
            $table->boolean('estado')->default(1);
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_producto');
    }
}
