<?php

namespace App\Http\Controllers;

use App\Model\Matiere;
use App\Model\Classes;

use Illuminate\Http\Request;

class MatiereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matieres = Matiere::all();

        return view('admin.matieres')->with('matieres', $matieres);
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

        if($request->input('name_fr')=="" || $request->input('name_ar')=="" || $request->input('coefficient')==""){
            return redirect('/matieres')->with('statusBad','Veuillez fournir un nom en français ET en arabe ainsi que le coefficient !');
        }
        $matiere = new Matiere;

        $matiere->nom_fr = ucfirst($request->input('name_fr'));
        $matiere->nom_ar = ucfirst($request->input('name_ar'));
        $matiere->coefficient = ucfirst($request->input('coefficient'));

        $matiere->save();

        return redirect('/matieres')->with('statusGood','La matière a bien été ajoutée.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function show(Matiere $matiere)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $matiere = Matiere::findOrFail($id);

        $matiere->nom_fr = ucfirst($request->input('name_fr'));
        $matiere->nom_ar = ucfirst($request->input('name_ar'));
        $matiere->coefficient = ucfirst($request->input('coefficient'));
        $matiere->update();

        return redirect('/matieres')->with('statusGood', 'La matière a bien été modifiée.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Matiere  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $matiere = Matiere::findOrFail($id);
        $matiere->delete();

        return redirect('/matieres')->with('statusGood', 'La matière a bien été supprimée.');
    }
    public function getCoeff($id){
        return  response()->json([
            'coeff' => Matiere::findOrFail($id)->coefficient,
            'id'  => $id,
            'nom_ar'=> Matiere::findOrFail($id)->nom_ar,
            'nom_fr'=> Matiere::findOrFail($id)->nom_fr,
        ]);

    }


    


    
}
