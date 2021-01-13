<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Groupe extends Model
{
    protected $table='groups';
    protected $fillable = ['nom','color'];
    

    public static function checkNameIfExist($nom)
    {

        $groupe = DB::select('SELECT * FROM groups WHERE groups.nom = ? ', [$nom]);

        return empty($groupe);
    }
    public static function checkNameIfExistWithId($id, $nom)
    {

        $groupe = DB::select('SELECT * FROM groups WHERE groups.nom = ? AND id != ?' , [$nom, $id]);

        return empty($groupe);
    }
}
