<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoUsuarioToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *  0 - Aluno
     *  1 - Professor
     *  2 - Gestor
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('tipo_usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->removeColumn('tipo_usuario');
        });
    }
}
