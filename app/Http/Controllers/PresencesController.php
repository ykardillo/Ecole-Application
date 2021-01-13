<?php

namespace App\Http\Controllers;

use App\Model\Presences;
use App\Model\Classes;
use App\Model\ProfToClasse;
use App\Model\Student;
use App\Model\Teacher;
use Illuminate\Http\Request;
use Redirect, Response;
use Illuminate\Support\Facades\Auth;


class PresencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $classes_id = [];
        switch (Auth::user()->usertype) {
            case 'admin':
                $classes_id = Classes::all('id');
                break;
            case 'teacher':
                $checkTeacher = Teacher::getTeacherIfExisteWithUserId($user_id);
                if (!empty($checkTeacher)) {
                    $teacher = Teacher::findOrFail($checkTeacher->id);
                    $classes_id = ProfToClasse::getClassesIdOfTeacher($teacher->id);
                } else {
                    $classes_id = [];
                }
                break;

            default:
                # code...
                break;
        }
        $presences = Presences::getDateAndNameClasse($classes_id);

        return view('admin.presences_liste')->with('presences', $presences);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCalendar()
    {
        if (request()->ajax()) {

            $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
            $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');

            $data = Presences::whereDate('date_start', '>=', $start)->whereDate('date_end',   '<=', $end)->get();
            return Response::json($data);
        }
        $user_id = Auth::user()->id;
        $classes = [];
        switch (Auth::user()->usertype) {
            case 'admin':
                $classes = Classes::all();
                break;
            case 'teacher':
                $checkTeacher = Teacher::getTeacherIfExisteWithUserId($user_id);
                if (!empty($checkTeacher)) {
                    $teacher = Teacher::findOrFail($checkTeacher->id);
                    $classes = ProfToClasse::getClassesOfTeacher($teacher->id);
                } else {
                    $classes = [];
                }
                break;

            default:
                # code...
                break;
        }


        return view('admin.presences_calendar')->with('classes', $classes);
    }

    public function getStudentsOfClass($date_start, $date_end, Request $request)
    {
        $classe_id = $request->input('classe');
        if ($classe_id == "") {
            return redirect('/presences/calendar')->with('statusBad', 'Aucune classe choisie');
        }
        if (!Presences::checkDateIfExiste($date_start, $classe_id)) {
            return redirect('/presences/calendar')->with('statusBad', 'La liste de présence du ' . $date_start . ' pour cette classe existe déjà.');
        } else {
            $classe = Classes::findOrFail($classe_id);
            $students = Student::getStudentsOfAClass($classe_id);

            return view('admin.presences_presenceStudents')->with('students', $students)
                ->with('classe', $classe)
                ->with('date_start', $date_start)
                ->with('date_end', $date_end);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $classe_id, $date_start, $date_end)
    {
        if ($classe_id == "") {
            return redirect('/presences/calendar')->with('statusBad', 'Aucune classe choisie');
        }
        $students = $request->input('students');
        if (!Presences::checkDateIfExiste($date_start, $classe_id)) {
            return redirect('/presences/calendar')->with('statusBad', 'La liste de présence du ' . $date_start . ' pour cette classe existe déjà.');
        }
        if (empty($students)) {
            return redirect('/presences/calendar')->with('statusBad', 'Aucun étudiant choisi.');
        } else {
            $studentsNotPresent = Student::getStudentsNoInTheTable($students, $classe_id);
            foreach ($studentsNotPresent as $studentNotPresent) {
                $presence = new Presences();
                $presence->student_id = $studentNotPresent->id;
                $presence->classe_id = $classe_id;
                $presence->date_start = $date_start;
                $presence->date_end = $date_end;
                $presence->presence = "A";
                $presence->save();
            }
            foreach ($students as $student) {
                $presence = new Presences();
                $presence->student_id = $student;
                $presence->classe_id = $classe_id;
                $presence->date_start = $date_start;
                $presence->date_end = $date_end;
                $presence->presence = "P";
                $presence->save();
            }
            return redirect('/presences')->with('statusGood', 'La liste de présence a bien été enregistré.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Presences  $presenses
     * @return \Illuminate\Http\Response
     */
    public function show($classe_id, $date_start, $date_end)
    {
        $classe = Classes::findOrFail($classe_id);
        $studentsPresent = Presences::getListPresenceOfClass($date_start, $classe_id);

        return view('admin.presences_studentsOfClasse')->with('classe', $classe)
            ->with('studentsPresent', $studentsPresent)
            ->with('date_start', $date_start)
            ->with('date_end', $date_end);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Presences  $presenses
     * @return \Illuminate\Http\Response
     */
    public function edit($classe_id, $date_start, $date_end)
    {
        $classe = Classes::findOrFail($classe_id);
        $students = Presences::getListPresenceOfClass($date_start, $classe_id);

        return view('admin.presences_presenceStudents-edit')->with('classe', $classe)
            ->with('students', $students)
            ->with('date_start', $date_start)
            ->with('date_end', $date_end);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Presences  $presenses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $classe_id, $date_start, $date_end)
    {
        $students = $request->input('students');

        if (empty($students)) {

            $classe = Classes::findOrFail($classe_id);
            $studentsClass = Presences::getListPresenceOfClass($date_start, $classe_id);

            return redirect('/presences/edit/' . $classe_id . '/' . $date_start . '/' . $date_end)
                ->with('classe', $classe)
                ->with('students', $studentsClass)
                ->with('date_start', $date_start)
                ->with('date_end', $date_end)
                ->with('statusBad', 'Aucun étudiant choisi.');
        } else {
            Presences::deletePresencesFromDateAndClasse($date_start, $classe_id);

            $studentsNotPresent = Student::getStudentsNoInTheTable($students, $classe_id);
            foreach ($studentsNotPresent as $studentNotPresent) {
                $presence = new Presences();
                $presence->student_id = $studentNotPresent->id;
                $presence->classe_id = $classe_id;
                $presence->date_start = $date_start;
                $presence->date_end = $date_end;
                $presence->presence = "A";
                $presence->save();
            }
            foreach ($students as $student) {
                $presence = new Presences();
                $presence->student_id = $student;
                $presence->classe_id = $classe_id;
                $presence->date_start = $date_start;
                $presence->date_end = $date_end;
                $presence->presence = "P";
                $presence->save();
            }
            return redirect('/presences/info/' . $classe_id . '/' . $date_start . '/' . $date_end)->with('statusGood', 'La liste de présence a bien été modifié.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Presences  $presenses
     * @return \Illuminate\Http\Response
     */
    public function destroy($date, $classe_id)
    {
        Presences::deletePresencesFromDateAndClasse($date, $classe_id);

        return redirect('/presences')->with('statusGood', 'La présence a bien été supprimé .');
    }
}
