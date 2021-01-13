<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProfToClasse extends Model
{
    protected $table = 'prof_to_classes';
    protected $fillable = ['teacher_id', 'classe_id'];

    public static function getClasseProfNom()
    {
        $classeProfNom = DB::table('prof_to_classes')
            ->join('classes', 'prof_to_classes.classe_id', '=', 'classes.id')
            ->join('teachers', 'prof_to_classes.teacher_id', '=', 'teachers.id')
            ->select('prof_to_classes.*', 'teachers.nom as teacher_nom', 'teachers.prenom as teacher_prenom', 'classes.nom as classe_nom')
            ->get();
        return $classeProfNom;
    }
    public static function deleteProfClasse($teacher_id, $classe_id)
    {
        DB::delete('DELETE p
            FROM prof_to_classes p
            WHERE p.teacher_id = ? AND p.classe_id = ?', [$teacher_id, $classe_id]);
    }

    public static function rawDontExist($teacher, $classe)
    {
        $classeProfNom = DB::select('SELECT * FROM prof_to_classes WHERE prof_to_classes.teacher_id = ? AND prof_to_classes.classe_id = ?', [$teacher, $classe]);

        return empty($classeProfNom);
    }

    public static function getClassesOfTeacher($teacher_id)
    {
        $classes = DB::select('SELECT classes.* from prof_to_classes 
        JOIN classes on prof_to_classes.classe_id = classes.id 
        where prof_to_classes.teacher_id= ?', [$teacher_id]);
        return $classes;
    }

    public static function getClassesIdOfTeacher($teacher_id)
    {
        $classes = DB::table('prof_to_classes')
            ->join('classes', 'prof_to_classes.classe_id', '=', 'classes.id')
            ->where('prof_to_classes.teacher_id', '=', $teacher_id)
            ->select('classes.id')
            ->get();
        $classes_id = [];
        foreach ($classes as $classe) {
            array_push($classes_id, $classe->id);
        }

        return $classes_id;
    }
}
