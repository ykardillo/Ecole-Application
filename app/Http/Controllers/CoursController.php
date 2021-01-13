<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Cours;
use App\Model\Groupe;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CoursController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        if($request->input('jour')=="" || $request->input('heure_debut')=="" || $request->input('heure_fin')=="" || $request->input('groupe_id')==""){
            return redirect('/gestion_horaires')->with('statusBad','Veuillez fournir un jour, une heure de début et de fin ains qu\'un groupe !');
        }
        if(!Cours::isTimeAvailable($request->input('jour'), $request->input('heure_debut'), $request->input('heure_fin'), $request->input('groupe_id'))){
            return redirect('/gestion_horaires')->with('statusBad','Il y\'a déjà cours pour ce groupe à cette heure là');
        }
        $idCourseBefore="";
        $heureDebut= $request->input('heure_debut');
        $heureFin= $request->input('heure_fin');
        if(Cours::isJustAfterAnotherCourse($request->input('jour'), $heureDebut, $request->input('groupe_id'),$idCourseBefore)){
            $request['heure_debut'] = $heureDebut;
            $courseBefore = Cours::findOrFail($idCourseBefore);
            $courseBefore->delete();
        }
        if(Cours::isJustBeforeAnotherCourse($request->input('jour'), $heureFin, $request->input('groupe_id'),$idCourseAfter)){
            $request['heure_fin'] = $heureFin;
            $courseAfter = Cours::findOrFail($idCourseAfter);
            $courseAfter->delete();
        }
        
        Cours::create($request->all());
        return redirect('/gestion_horaires')->with('statusGood','Le cours a bien été ajouté.');
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        $cours = Cours::findOrFail($id);
        $cours->jour = ucfirst($request->input('jour'));
        $cours->heure_debut = ucfirst($request->input('heure_debut'));
        $cours->heure_fin = ucfirst($request->input('heure_fin'));
        $cours->groupe_id = ucfirst($request->input('groupe_id'));
        $cours->update();
        return redirect('/gestion_horaires')->with('statusGood', 'Le cours a bien été modifié.');
    }

    public function destroy($id)
    {
        $cours = Cours::findOrFail($id);
        $cours->delete();

        return redirect('/gestion_horaires')->with('statusGood', 'Le cours a bien été supprimé.');
    }

    public function massDestroy(Request $request)
    {
        Cours::whereIn('id', request('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
