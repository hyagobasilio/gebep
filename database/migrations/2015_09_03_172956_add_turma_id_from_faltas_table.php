<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTurmaIdFromFaltasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faltas', function (Blueprint $table) {
            $table->integer('turma_id')->unsigned();
        });

        Schema::table('faltas', function(Blueprint $table) {
            $table->foreign('turma_id')->references('id')->on('turmas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faltas', function (Blueprint $table) {
            $table->dropForeign('faltas_turma_id_foreign');
            $table->dropColumn('turma_id');
        });
    }
}
