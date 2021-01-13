<?php

namespace App\Http\Controllers;

use App\Model\Teacher;
use App\Model\Student;

use App\Model\Classes;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classes::all();
        return view('admin.classes')->with('classes', $classes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = Classes::all();
        return view('admin.classes')->with('classes', $classes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (Classes::checkNbMaxStudent($request->input('nombre'))) {
            return redirect('/classes')->with('statusBad', 'Impossible de créer la classe. Le nombre maximum d\'étudiants doit être supérieur à 0. ');
        } else {
            if ($request->input('nom') == "" || $request->input('nombre') == "") {
                return redirect('/classes')->with('statusBad', 'Veuillez fournir un nom de classe et un nombre maximum d\'étudiants !');
            }
            $classe = new Classes;
            $classe->nom = ucfirst($request->input('nom'));
            $classe->max_eleves = $request->input('nombre');

            $classe->save();

            return redirect('/classes')->with('statusGood', 'La classe a bien été ajoutée.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $infoClasse = Classes::findOrFail($id);

        $classes = Student::getStudentsOfAClass($id);
        $teacher = Classes::getTeachersOfClass($id);
        return view('admin.eleve-classes')->with('classes', $classes)->with('info', $infoClasse)
            ->with('teacher', $teacher);
    }
    public function getClass($id)
    {
        $classeName = Classes::findOrFail($id);
        return view('attributions')->with('classesName', $classeName);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function edit(Classes $classes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Classes::checkNbMaxStudent($request->input('nombre'))) {
            return redirect('/classes')->with('statusBad', 'Impossible de modifier le nombre maximum d\'étudiants.
             Il doit est supérieur à 0. ');
        } else {
            if (Classes::checkNbStudent($id, $request->input('nombre'))) {
                $classes = Classes::findOrFail($id);
                $classes->nom = ucfirst($request->input('nom'));
                $classes->max_eleves = $request->input('nombre');

                $classes->update();
                return redirect('/classes')->with('statusGood', 'La classe a bien été modifiée.');
            } else {
                return redirect('/classes')->with('statusBad', 'Impossible de modifier le nombre maximum d\'étudiants.
                 Veuillez d\'abord désinscrire assez d\'étudiant afin de pouvoir modifier le nombre maximum d\'étudiants. ');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $classes = Classes::findOrFail($id);
        $classes->delete();

        return redirect('/classes')->with('statusGood', 'La classe a bien été supprimée.');
    }
}
