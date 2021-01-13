<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Classes extends Model
{
    protected $table = 'classes';
    protected $fillable = ['nom', 'max_eleves'];

    public static function getTeacherName()
    {
        $teachers = DB::table('classes')
            ->leftJoin('teachers', 'classes.teacher_id', '=', 'teachers.id')
            ->select('classes.*', 'teachers.nom as teacher_nom')
            ->get();
        return $teachers;
    }
    public static function getClassesWithNbOfRemainingStudents(){
        $classes = DB::table('classes')
        ->select('classes.*')
        ->get();

        foreach ($classes as $classe ) {
            $classe->nbRemainingStudents = Classes::getNbOfStudentRemainning($classe->id, $classe->max_eleves);
        }
        return $classes;
    }
    public static function checkNbMaxStudent( $maxStudents)
    {
       return ($maxStudents <= 0);
    }

    public static function checkNbStudent($id, $maxStudents)
    {
        $count = DB::table('students')
            ->where('classe_id', $id)
            ->count();
        if ($count > $maxStudents) {
            return false;
        } else {
            return true;
        }
    }
    public static function getNbOfStudentRemainning($id, $max_eleves){
        $count = DB::table('students')
            ->where('classe_id', $id)
            ->count();

            return $max_eleves - $count;
    }

    public static function getClassesWithoutTeacher()
    {
        $classes = DB::select('select * from classes WHERE id NOT IN (SELECT classe_id FROM prof_to_classes)');
        return $classes;
    }

    public static function getClassesWithoutGroup()
    {
        $classes = DB::select('select * from classes WHERE groupe_id IS NULL');
        return $classes;
    }
    public static function getClassesWithAGroup()
    {
        $classes = DB::table('classes')
            ->leftJoin('groups', 'classes.groupe_id', '=', 'groups.id')
            ->select('classes.*', 'groups.nom as groupe_nom')
            ->where('classes.groupe_id', '<>', 'NULL')
            ->get();
        return $classes;
    }

    public static function getTeachersOfClass($id)
    {
        $teacher = DB::table('teachers')
            ->join('prof_to_classes', 'prof_to_classes.teacher_id', '=', 'teachers.id')
            ->where('prof_to_classes.classe_id', '=', $id)
            ->select('teachers.*')
            ->first();
        if ($teacher === null) {
            return null;
        } else {
            return $teacher;
        }
    }
    public static function getNameOfClass($id)
    {
        $name=DB::table('classes')
            ->where('id', $id)
            ->first();
        return $name;
    }
    public static function getClassesFromGroupId($groupId)
    {
        $classes = [];
        if($groupId > 0){
            $classes = DB::table('classes')
            ->select('nom')
            ->where('groupe_id',intval($groupId))
            ->get();
        }       
        return $classes;
    }

    
    public static function getClassesOfTeacher($teacher_id){
        $classes = DB::table('classes')
        ->where('teacher_id' , '=' , $teacher_id)
        ->select('*')
        ->get();
        return $classes;
    }



}
