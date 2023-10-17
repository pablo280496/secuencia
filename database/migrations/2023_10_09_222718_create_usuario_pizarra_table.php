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
        Schema::create('usuario_pizarra', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_pizarra');
            $table->string('rol'); // Por ejemplo: 'admin', 'miembro', etc.
            $table->timestamps();

            $table->unique(['id_user', 'id_pizarra']); // Evita duplicados

            // Definir las claves foráneas
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_pizarra')->references('id')->on('pizarras');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario_pizarra');
    }
};
