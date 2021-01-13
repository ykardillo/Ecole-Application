<?php

namespace App\Http\Controllers;

use App\Model\Groupe;
use Illuminate\Http\Request;

class GroupeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        if($request->input('nom')==""){
            return redirect('/gestion_horaires')->with('statusBad','Veuillez fournir  un nom !');
        }
        if(!Groupe::checkNameIfExist($request->input('nom'))){
            return redirect('/gestion_horaires')->with('statusBad','Le nom de groupe fourni existe déjà !');
        }
        $groupe = new Groupe;

        $groupe->nom = ucfirst($request->input('nom'));
        $groupe->save();

        return redirect('/gestion_horaires')->with('statusGood','Le groupe a bien été ajouté.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Groupe  $groupe
     * @return \Illuminate\Http\Response
     */
    public function show(Groupe $groupe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Groupe  $groupe
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Groupe  $groupe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        if($request->input('nom')==""){
            return redirect('/groupes/edit/'.$id)->with('statusBad','Veuillez fournir  un nom !');
        }
        if(!Groupe::checkNameIfExistWithId($id, $request->input('nom'))){
            return redirect('/groupes/edit/'.$id)->with('statusBad','Le nom de groupe fourni existe déjà !');
        }
        $groupe = Groupe::findOrFail($id);

        $groupe->nom = ucfirst($request->input('nom'));
        $groupe->update();

        return redirect('/gestion_horaires')->with('statusGood', 'Le groupe a bien été modifié.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Groupe  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $groupe = Groupe::findOrFail($id);
        $groupe->delete();

        return redirect('/gestion_horaires')->with('statusGood', 'Le groupe a bien été supprimé.');
    }
}
