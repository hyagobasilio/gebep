<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessorMateriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('professor_materia', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('professor_id')->unsigned();
            $table->integer('materia_id')->unsigned();

        });

        Schema::table('professor_materia', function(Blueprint $table) {
            $table->foreign('materia_id')->references('id')->on('materias');
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
        Schema::drop('professor_materia');
    }
}
