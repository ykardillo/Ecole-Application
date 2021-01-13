<?php

namespace App\Imports;

use App\Model\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;

class StudentImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $student = "";
        if(($row[0] != "nom élève")){

            $student = new Student([
                'nomEtudiant' => $row[0],
                'prenomEtudiant' => $row[1],
                'dateNaissanceEtudiant' => $row[2],
                'adresseMaisonEtudiant' => $row[3],
                'genre' => $row[4],
                'nomParent' => $row[5],
                'prenomParent' => $row[6],
                'noTelephoneParent' => $row[7],
                'emailParent' => $row[8]
            ]);
            if(count($row) > 9 && $row[9] != null){
                $student->montantAPayer = $row[9];
            }else{
                $student->montantAPayer = 0;  
            }
            if(count($row) > 10 && $row[10] != null){
                $student->created_at = $row[10];
            }else{
                $student->created_at = date('Y-m-d H:i:s');  
            }
            return $student;
                        
        }
    }
}
