<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;

class Encodage extends Model
{
    protected $table = 'encodages';
    protected $fillable = ['noteEleve', 'interrogation_id', 'student_id'];

    public static function getInterrosOfAClass($id)
    {

        $encodage = DB::table('interrogations')
            ->select('interrogations.*', 'matières.nom_fr as matiere_nom_fr', 'matières.nom_ar as matiere_nom_ar', 'matières.id as matiere_id')
            ->join('matières', 'matières.id', '=', 'interrogations.matieres_id')
            ->where('classe_id', $id)
            ->get();
        return  $encodage;
    }
    public static function initInterroOfClass($classe_id, $interro_id)
    {
        $encode = DB::table('students')
            ->where('classe_id', $classe_id)->get();
        foreach ($encode as $interro) {
            DB::table('encodages')->insert(
                ['noteEleve' => '0', 'interrogation_id' => $interro_id, "student_id" => $interro->id]
            );
        }
    }
    public static function updateInterro($idInterro, $idStudents, $noteOfStudents)
    {
        for ($x = 0; $x < count($idStudents); $x++) {
            DB::table('encodages')
                ->where([
                    ['interrogation_id', '=', $idInterro],
                    ['student_id', '=', $idStudents[$x]],

                ])
                ->update(['noteEleve' => $noteOfStudents[$x]]);
        }
    }
    public static function getBulletin($id)
    {
        $report = DB::table('interrogations')
            ->join('encodages as s', 'encodages.interrogation_id', '=', 'interrogations.id')
            ->join('students', 'students.id', '=', 'encodages.student_id')
            ->join('matières', 'matières.id', '=', 'interrogations.matieres_id')
            ->where('encodages.student_id', '=', $id)
            ->groupBy('encodages.noteEleve', 'interrogations.matieres_id')
            ->orderBy('interrogations.matieres_id')
            ->select('interrogations.*', 'round(avg(s.noteEleve),2) as avg')

            //->sum('encodages.noteEleve')
            ->get();



        $tmp = $report->sum('avg');
        error_log("Affichage de la variable tmp : " . $tmp, 0);

        $coefTotal = $report->sum('coefficient');

        if (count($report) === 0) {
            return "";
        } else {
            error_log("Affichage de la variable report" . $report, 0);

            return [$report, $tmp, $coefTotal];
        }
        error_log("Affichage de la variable report" . $report, 0);
    }
}
