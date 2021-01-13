<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('nomParent');
            $table->string('prenomParent');
            $table->string('noTelephoneParent');
            $table->string('emailParent');
            $table->string('photo', 5100)->default("photo");
            $table->string('nomEtudiant');
            $table->string('prenomEtudiant');
            $table->enum('genre', ['masculin', 'feminin']);
            $table->date('dateNaissanceEtudiant');
            $table->string('adresseMaisonEtudiant');
            $table->integer('montantAPayer')->default(250)->min(0);
            $table->bigInteger('classe_id')->unsigned()->nullable();

            $table->foreign('classe_id')
                    ->references('id')
                    ->on('classes')
                    ->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student');
    }
}
