<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursTable extends Migration
{
    public function up()
    {
        Schema::create('cours', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jour');
            $table->time('heure_debut')->format("H:i");
            $table->time('heure_fin')->format("H:i");
            $table->timestamps();

        });

        Schema::table('cours', function (Blueprint $table) {
            $table->unsignedBigInteger('groupe_id');
            $table->foreign('groupe_id', 'group_fk_1001508')->references('id')->on('groups')->onDelete('cascade');
        });

    }
}
