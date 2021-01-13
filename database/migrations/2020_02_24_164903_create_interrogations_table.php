<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterrogationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interrogations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('nom');
            $table->string('noteMaximale');
            $table->bigInteger('matieres_id')->unsigned();

            $table->bigInteger('classe_id')->unsigned();



            
            $table->foreign('classe_id')
                ->references('id')
                ->on('classes')
                ->onDelete('cascade');

                $table->foreign('matieres_id')
            ->references('id')
            ->on('matières')->unsigned()->index();

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interrogations');
    }
}
