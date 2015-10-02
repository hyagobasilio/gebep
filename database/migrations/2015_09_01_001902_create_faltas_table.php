<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaltasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faltas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('materia_id')->unsigned();
            $table->integer('aluno_id')->unsigned();
            $table->integer('professor_id')->unsigned();
            $table->dateTime('dia_falta');
        });

        Schema::table('faltas', function(Blueprint $table) {
            $table->foreign('materia_id')->references('id')->on('materias');
            $table->foreign('aluno_id')->references('id')->on('users');
            $table->foreign('professor_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('faltas');
    }
}
