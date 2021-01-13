<?php

namespace App\Http\Controllers;

use App\Model\Teacher;
use App\Model\Classes;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::all();

        return view('admin.teachers')->with('teachers', $teachers);
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
    public function store(Request $request){
        
        //Ne marche pas car il manque le user_id

        if($request->input('name')=="" || $request->input('firstname')==""){
            return redirect('/teachers')->with('statusBad','Veuillez fournir  un nom ET et un prenom !');
        }
        $teacher = new Teacher;

        $teacher->nom = ucfirst($request->input('name'));
        $teacher->prenom = ucfirst($request->input('firstname'));

        $teacher->save();

        return redirect('/teachers')->with('statusGood','Le professeur a bien été ajouté.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit($id){

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){


        $teacher = Teacher::findOrFail($id);

        $teacher->nom = ucfirst($request->input('name'));
        $teacher->prenom = ucfirst($request->input('firstname'));
        $teacher->update();

        return redirect('/teachers')->with('statusGood', 'Le professeur a bien été modifier.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Teacher  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return redirect('/teachers')->with('statusGood', 'Le professeur a bien été supprimé.');
    }

    


    
}
