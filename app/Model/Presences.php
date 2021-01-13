<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Presences extends Model
{
    protected $table = 'presences';
    protected $fillable = ['date_start', 'date_end', 'classe_id', 'student_id'];

    public static function getDateAndNameClasse($classes_id)
    {
        $presences = DB::table('presences')
            ->join('classes', 'presences.classe_id', '=', 'classes.id')
            ->groupby('presences.date_start', 'presences.classe_id', 'classes.nom', 'presences.date_end')
            ->orderByRaw('presences.date_start - classes.nom DESC')
            ->whereIn('classes.id',$classes_id)
            ->select('presences.date_start', 'presences.date_end', 'presences.classe_id', 'classes.nom as classe_nom')
            ->get();
        return $presences;
    }

    public static function deletePresencesFromDateAndClasse($date, $classe_id)
    {
        DB::delete('DELETE p
                    FROM presences p
                    JOIN classes c
                    ON p.classe_id=c.id
                    WHERE p.date_start = ? AND c.id = ?', [$date, $classe_id]);
    }

    public static function getListPresenceOfClass($date_start, $classe_id)
    {

        $students = DB::select(
            'SELECT s.id, s.nomEtudiant, s.prenomEtudiant, p.presence
                                FROM students s
                                LEFT JOIN presences p ON s.id = p.student_id
                                WHERE p.classe_id = ? AND p.date_start = ?',
            [$classe_id, $date_start]
        );

        return $students;
    }


    public static function checkDateIfExiste($date_start, $classe_id)
    {

        $presence = DB::select('SELECT * FROM presences WHERE presences.classe_id = ? AND presences.date_start = ?', [$classe_id, $date_start]);

        return empty($presence);
    }

    public static function getNbAbsenceFromStudentId($student_id)
    {
        $absence = DB::select('SELECT count(p.presence) as nbAbsence FROM presences p right join students s on p.student_id = s.id AND presence = "A" where s.id = ? group by s.id', [$student_id]);
        return $absence;
    }
}
