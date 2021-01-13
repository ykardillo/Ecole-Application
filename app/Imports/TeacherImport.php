<?php

namespace App\Imports;

use App\Model\Teacher;
use Maatwebsite\Excel\Concerns\ToModel;

class TeacherImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $teacher = "";
        if(($row[0] != "nom")){

            $teacher = new Teacher([
                'nom' => $row[0],
                'prenom' => $row[1]
            ]);
            return $teacher;
                        
        }
    }
}
