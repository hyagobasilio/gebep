<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessorTurmaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professor_turma', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('professor_id')->unsigned();
            $table->integer('turma_id')->unsigned();
            $table->timestamps();

        });

        Schema::table('professor_turma', function(Blueprint $table) {
            $table->foreign('turma_id')->references('id')->on('turmas');
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
        Schema::table('professor_turma', function (Blueprint $table) {
            //
        });
    }
}
