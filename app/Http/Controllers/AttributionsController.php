<?php

namespace App\Http\Controllers;

use App\Model\Teacher;
use App\Model\Classes;
use App\Model\Student;
use App\Model\Groupe;
use App\Model\ProfToClasse;
use Illuminate\Http\Request;

class AttributionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::all();
        $classes = Classes::getClassesWithNbOfRemainingStudents();
        $groupes = Groupe::all();
        $classesWithoutT = Classes::getClassesWithoutTeacher();
        $classesWithG = Classes::getClassesWithAGroup();
        $classesWithoutG = Classes::getClassesWithoutGroup();
        $studentsWithC = Student::getStudentsWithAClass();
        $studentsWithoutC = Student::getStudentsWithoutAClass();
        $profToClasses = ProfToClasse::getClasseProfNom();

        return view("admin.attributions")
            ->with('classes', $classes)
            ->with('teachers', $teachers)
            ->with('groupes', $groupes)
            ->with('students', $studentsWithC)
            ->with('studentsWC', $studentsWithoutC)
            ->with('profToClasses', $profToClasses)
            ->with('classesWT', $classesWithoutT)
            ->with('classesWithG', $classesWithG)
            ->with('classesWG', $classesWithoutG);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyProfToClasse($classe_id, $teacher_id)
    {
        $profToClasse = ProfToClasse::deleteProfClasse($teacher_id, $classe_id);

        return redirect('/attributions')->with('statusGood', 'L\'attribution a bien été supprimée.');
    }
    public function destroyStudToClasse(Request $request, $student_id)
    {
        $student = Student::findOrFail($student_id);
        $student->classe_id = NULL;

        $student->update();

        return redirect('/attributions')->with('statusGood', 'L\'attribution a bien été supprimée.');
    }
    public function destroyClassToGroup(Request $request, $class_id)
    {
        $class_id = Classes::findOrFail($class_id);
        $class_id->groupe_id = NULL;

        $class_id->update();

        return redirect('/attributions')->with('statusGood', 'L\'attribution a bien été supprimée.');
    }


    public function attributeProfToClasse(Request $request)
    {
        $teacher = $request->input('teacher');
        $classes = $request->input('classes');
        if (empty($teacher)) {
            return redirect('/attributions')->with('statusBad', 'Aucun professeur choisi.');
        }else if (empty($classes)) {
            return redirect('/attributions')->with('statusBad', 'Aucune classe choisi.');
        } else {
            foreach ($classes as $classe) {
                if (ProfToClasse::rawDontExist($teacher, $classe)) {
                    $profToClasse = new ProfToClasse();
                    $profToClasse->teacher_id = $teacher;
                    $profToClasse->classe_id = $classe;
                    $profToClasse->save();
                }
            }
            return redirect('/attributions')->with('statusGood', 'La classe a bien été assigné au professeur.');
        }
    }
    public function attributeStudToClasse(Request $request)
    {
        $students = $request->input('students');
        $classe = $request->input('classe');
        if (empty($students)) {
            return redirect('/attributions')->with('statusBad', 'Aucun étudiant choisi.');
        } else {
            if(Student::checkNbStudents(sizeof($students),$classe)){
                return redirect('/attributions')->with('statusBad', 'Le nombre maximum d\'étudiant de la classe a été dépassé. Trop d\'étudiants ont été choisi.');
            }
            foreach ($students as $student) {
                $student = Student::findOrFail($student);
                $student->classe_id = $classe;
                $student->save();
            }
            return redirect('/attributions')->with('statusGood', 'Les étudiants ont bien été assignés à la classe.');
        }
    }
    public function attributeClassToGroup(Request $request)
    {
        $classes = $request->input('classes');
        $group = $request->input('group');
        if (empty($classes)) {
            return redirect('/attributions')->with('statusBad', 'Aucune classe choisie.');
        }
               foreach ($classes as $class) {
                $classe = Classes::findOrFail($class);
                $classe->groupe_id = $group;
                $classe->save();
            }
        return redirect('/attributions')->with('statusGood', 'Les classes ont bien été assignées au groupe.');
    }
    
}
