<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elemento_pizarras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pizarra_id')->constrained('pizarras');
            $table->string('tipo');
            $table->string('nombre');
            $table->integer('posicion_x', 8 );
            $table->integer('posicion_y', 8 );
            $table->string('cid');
            $table->text('contenido')->nullable();
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
        Schema::dropIfExists('elementos_pizarra');
    }
};
