<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    public static function getTotal()
    {
        //ICI IL FAUT CALCULER LE TOTAL POUR POUVOIR L'INCRUSTER DANS LE BULLETIN.

        // $teachers = DB::table('encodages')
        //     ->leftJoin('teachers', 'classes.teacher_id', '=', 'teachers.id')
        //     ->select('classes.*', 'teachers.nom as teacher_nom')
        //     ->get();
        // return $teachers;
    }
}
