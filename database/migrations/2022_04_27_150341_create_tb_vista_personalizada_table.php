<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbVistaPersonalizadaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_vista_personalizada', function (Blueprint $table) {

            $table->id();
            $table->boolean('administracion')->default(1);
            $table->boolean('reportes')->default(1);
            $table->boolean('facturacion')->default(1);
            $table->boolean('contabilidad')->default(1);
            $table->boolean('controlIngreso')->default(1);
            $table->boolean('documentacion')->default(1);
            $table->boolean('produccion')->default(1);
            $table->boolean('personas')->default(1);
            $table->boolean('gestionFinanciera')->default(1);
            $table->boolean('escritorio')->default(1);
            $table->foreignId('idUser')->constrained('users');
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
        Schema::dropIfExists('tb_vista_personalizada');
    }
}
