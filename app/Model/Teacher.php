<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Teacher extends Model
{
    //
    protected $table='teachers';
    protected $fillable = ['nom','prenom','user_id'];


    public static function exportExcel()
    {
        $teachers = DB::table('teachers')
            ->select('nom', 'prenom','user_id')
            ->get();
        return $teachers;
    }
    
    public static function getTeacherIfExisteWithUserId($user_id){
        $teacher = DB::table('teachers')
        ->where('user_id' , '=' , $user_id)
        ->select('*')
        ->first();
        return $teacher;
    }

}
