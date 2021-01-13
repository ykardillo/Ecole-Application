<?php

namespace App\Http\Controllers;

use App\Model\Interrogation;
use Illuminate\Http\Request;

class InterrogationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Interrogation  $interrogation
     * @return \Illuminate\Http\Response
     */
    public function show(Interrogation $interrogation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Interrogation  $interrogation
     * @return \Illuminate\Http\Response
     */
    public function edit(Interrogation $interrogation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Interrogation  $interrogation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        // $noteOfStudents = $_POST['noteOfStudent'];
        // $idStudents = $_POST['idStudents'];

        $interro = Interrogation::findOrFail($id);
        $interro->nom = ucfirst($request->input('nom'));
        $interro->noteMaximale = $request->input('noteMaximaleInterro');
        $interro->matieres_id = $request->input('typeModif');
        $classe = $request->input('id_classe');

       
        $interro->update();

        return redirect('interrogation/'.$classe )->with('statusGood', 'L\'interrogation a bien été modifié.');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Interrogation  $interrogation
     * @return \Illuminate\Http\Response
     */
    public function destroy($classe_id,$interro_id)
    {
        $inter = Interrogation::findOrFail($interro_id);
        $inter->delete();

        return redirect('interrogation/'.$classe_id)->with('statusGood', 'L\'interrogation a bien été supprimé.');
    }
}
