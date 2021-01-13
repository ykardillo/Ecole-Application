<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;
class CreateMatièresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matières', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom_fr');
            $table->string('nom_ar')->nullable();
            $table->bigInteger('coefficient')->unsigned();
            $table->timestamps();
        });
        DB::table('matières')->insert(
            array(array(
                'nom_fr' => 'Activites culturelles',
                'nom_ar' => 'أنشطة ثقافية',
                'coefficient' => 20,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ),
            array(
                'nom_fr' => 'Comprehension à la lecture et à l\'audition',
                'nom_ar' => 'فهم المقروء والمسموع',
                'coefficient' => 20,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ),
            array(
                'nom_fr' => 'Dictee',
                'nom_ar' => 'إملاء',
                'coefficient' => 20,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ),
            array(
                'nom_fr' => 'Ecriture',
                'nom_ar' => 'خط',
                'coefficient' => 10,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ),
            array(
                'nom_fr' => 'Examen ecrit',
                'nom_ar' => 'كتابي امتحان',
                'coefficient' => 40,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ),
            array(
                'nom_fr' => 'Expression orale',
                'nom_ar' => 'تعبير شفوي',
                'coefficient' => 20,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ),
            array(
                'nom_fr' => 'Lecture',
                'nom_ar' => 'قراءة',
                'coefficient' => 20,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ))
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matières');
    }
}
