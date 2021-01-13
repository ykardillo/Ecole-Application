<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    protected $table = 'students';
    protected $fillable = ['photo', 'nomEtudiant', 'prenomEtudiant', 'dateNaissanceEtudiant', 'adresseMaisonEtudiant', 'nomParent', 'prenomParent', 'noTelephoneParent', 'emailParent'];

    public static function getStudentsOfAClass($id)
    {
        $students = DB::table('students')->where('classe_id', $id)->get();
        return  $students;
    }

    public static function getStudentsWithoutAClass()
    {
        $students = DB::table('students')->where('classe_id', NULL)->get();
        return  $students;
    }
    public static function getStudentsWithAClass()
    {
        $students = DB::table('students')
            ->leftJoin('classes', 'students.classe_id', '=', 'classes.id')
            ->select('students.*', 'classes.nom as classe_nom')
            ->where('students.classe_id', '<>', 'NULL')
            ->get();
        return $students;
    }
    public static function getStudentsWhoHaventPaid()
    {
        $students = DB::table('students')
            ->select('students.id', 'students.nomEtudiant', 'students.prenomEtudiant', 'students.adresseMaisonEtudiant', 'students.nomParent', 'students.prenomParent', 'students.noTelephoneParent', 'students.emailParent', 'students.montantAPayer')
            ->where('students.montantAPayer', '<>', '0')
            ->get();
        return $students;
    }
    public static function getStudentsWhoHaventPaidExcel()
    {
        $students = DB::table('students')
            ->select('students.nomEtudiant', 'students.prenomEtudiant', 'dateNaissanceEtudiant', 'students.adresseMaisonEtudiant', 'students.genre', 'students.nomParent', 'students.prenomParent', 'students.noTelephoneParent', 'students.emailParent', 'students.montantAPayer', 'students.created_at')
            ->where('students.montantAPayer', '<>', '0')
            ->get();
        return $students;
    }

    public static function getStudentsNoInTheTable($students, $classe_id)
    {
        $studentsNotPresent = DB::table('students')
            ->where('classe_id', '=', $classe_id)
            ->whereNotIn('id', $students)
            ->get();
        return $studentsNotPresent;
    }

    public static function checkNbStudents($nbStudents, $classe_id)
    {
        $count = DB::table('students')
            ->where('classe_id', $classe_id)
            ->count();
        $maxStudents = DB::table('classes')
            ->where('id', $classe_id)
            ->max('max_eleves');

        if ($count + $nbStudents > $maxStudents) {
            return true;
        } else {
            return false;
        }
    }

    public static function getStudentsDetail()
    {
        $students = DB::select(
            'SELECT *
                FROM students s
                WHERE s.classe_id = ? AND s.id NOT IN (SELECT s.id
                                                        FROM students s
                                                        LEFT JOIN presences p ON s.id = p.student_id
                                                        WHERE p.classe_id = ? AND p.date_start = ?)'
        );
        return $students;

        // SELECT s.nomEtudiant, s.prenomEtudiant, presence, count(presence) FROM presences p join students s on p.student_id = s.id group by student_id, presence
        // SELECT s.*,count(presence) as nombredeprésence  FROM presences p join students s on p.student_id = s.id where presence = "A" group by s.id
    }

    public static function exportExcel()
    {
        $student = DB::table('students')
        ->select('students.nomEtudiant', 'students.prenomEtudiant', 'dateNaissanceEtudiant', 'students.adresseMaisonEtudiant', 'students.genre', 'students.nomParent', 'students.prenomParent', 'students.noTelephoneParent', 'students.emailParent', 'students.montantAPayer', 'students.created_at')
            ->get();
        return $student;
    }

    public static function getStudentsOfAClassNotInInterrogation($id_classe,$id_interro)
    {
        //$students = DB::table('students')->where('classe_id', $id_classe)->get();
        $students = DB::select(
            'SELECT *
                FROM students s
                WHERE s.classe_id = :classe_id AND s.id NOT IN (SELECT student_id
                                                        FROM encodages
                                                        where interrogation_id=:interrogation_id)',['classe_id'=>$id_classe,'interrogation_id'=>$id_interro]
        );
        return  $students;
    }
}
