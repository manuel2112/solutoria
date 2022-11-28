<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicators', function (Blueprint $table) {
            $table->id();
            $table->string('nombreIndicador',64)->default('UNIDAD DE FOMENTO (UF)');
            $table->string('codigoIndicador',4)->default('UF');
            $table->string('unidadMedidaIndicador',16)->default('Pesos');
            $table->decimal('valorIndicador', 8, 2);
            $table->date('fechaIndicador');
            $table->boolean('flag')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indicators');
    }
}
