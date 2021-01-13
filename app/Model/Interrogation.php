<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Interrogation extends Model
{
    protected $table = 'interrogations';
    protected $fillable = ['nom', 'noteMaximale', 'id_classe', 'matieres_id'];

    public static function getNotesOfAClass($id)
    {
        //$encodage=DB::table('students')
        //->where('classe_id', $id)->get();
        $encodage = DB::table('encodages')
            ->join('students', 'students.id', '=', 'encodages.student_id')
            ->join('classes', 'classes.id', '=', 'students.classe_id')
            ->where('encodages.interrogation_id', $id)->get();
        if (count($encodage) == 0) {
            return '';
        } else {
            return  $encodage;
        }
    }
    public static function getNameOfInterro($id)
    {
        $nameInterro = DB::table('interrogations')
            ->where('id', $id)
            ->first();
        return $nameInterro;
    }
    public static function getClassFromInterroId($id_interro)
    {
        $encodage = DB::table('encodages')
            ->join('students', 'students.id', '=', 'encodages.student_id')
            ->join('classes', 'classes.id', '=', 'students.classe_id')
            ->where('encodages.interrogation_id', $id_interro)->get();
        return  $encodage;
    }
}
