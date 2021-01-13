<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrecensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presences', function (Blueprint $table) {
            $table->date('date_start');
            $table->date('date_end');
            $table->bigInteger('classe_id')->unsigned();
            $table->bigInteger('student_id')->unsigned();
            $table->string('presence');
            $table->timestamps();
            $table->primary(['date_start', 'classe_id', 'student_id']);

            $table->foreign('classe_id')
                    ->references('id')
                    ->on('classes')
                    ->onDelete('cascade');

            $table->foreign('student_id')
                    ->references('id')
                    ->on('students')
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
        Schema::dropIfExists('presences');
    }
}
