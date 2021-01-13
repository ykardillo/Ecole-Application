<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncodagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encodages', function (Blueprint $table) {
            $table->bigInteger('interrogation_id')->unsigned();
            $table->bigInteger('student_id')->unsigned();
            $table->timestamps();
            $table->string('noteEleve');
            $table->primary(['interrogation_id','student_id']);

            $table->foreign('interrogation_id')
                ->references('id')
                ->on('interrogations')
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
        Schema::dropIfExists('encodages');
    }
}
