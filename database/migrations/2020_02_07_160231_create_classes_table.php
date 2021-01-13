<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('nom');
            $table->integer('max_eleves');
            $table->bigInteger('teacher_id')->unsigned()->nullable();
            $table->bigInteger('groupe_id')->unsigned()->nullable();

            $table->foreign('groupe_id')
                    ->references('id')
                    ->on('groups')
                    ->onDelete('set null');

            $table->foreign('teacher_id')
                    ->references('id')
                    ->on('teachers')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classes');
    }
}
