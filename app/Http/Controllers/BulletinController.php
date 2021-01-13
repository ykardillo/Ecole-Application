<?php

namespace App\Http\Controllers;

use App\Model\Bulletin;
use App\Model\Classes;
use App\Model\Encodage;
use App\Model\Presences;
use App\Model\Student;
use Illuminate\Http\Request;

class BulletinController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        
        if (Encodage::getBulletin($id) == "") {
            return redirect('students/')->with('statusBad', 'Le bulletin n\'a pas pu être generé car aucune interro n\'a été faite pour le moment. ');
        } else {
            $classe_id = Encodage::getBulletin($id)[0][0]->classe_id;
            $classe=Classes::getNameOfClass($classe_id);
            $professeur=Classes::getTeachersOfClass($classe_id);
            $absence=Presences::getNbAbsenceFromStudentId($id);
            $data = array('data' => ['dataro' => Encodage::getBulletin($id)[0], 'total' => Encodage::getBulletin($id)[1], 'coefTotal' => Encodage::getBulletin($id)[2],
            'classe'=>$classe,
            'professeur'=>$professeur,
            'absence'=>$absence]);
                $pdf = \PDF::loadView('bulletin', $data);
                $nom = $data['data']['dataro'][0]->nomEtudiant;
                $nom = $nom . $data['data']['dataro'][0]->prenomEtudiant;

            return $pdf->download($nom . 'Bulletin.pdf');
        }
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
     * @param  \App\Bulletin  $bulletin
     * @return \Illuminate\Http\Response
     */
    public function show(Bulletin $bulletin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bulletin  $bulletin
     * @return \Illuminate\Http\Response
     */
    public function edit(Bulletin $bulletin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bulletin  $bulletin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bulletin $bulletin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bulletin  $bulletin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bulletin $bulletin)
    {
        //
    }
    public function generateBulletinOfAClass($id_classe)
    {
        $classe=Classes::getNameOfClass($id_classe);
         $studentOfClass = Student::getStudentsOfAClass($id_classe);
        $professeur=Classes::getTeachersOfClass($id_classe);
        $pdf=0;
        $html='';

        for ($i = 0; $i < count($studentOfClass); $i++) {
            $absence=Presences::getNbAbsenceFromStudentId($studentOfClass[$i]->id);

            $data = array('data' => 
            ['dataro' => (Encodage::getBulletin($studentOfClass[$i]->id))? (Encodage::getBulletin($studentOfClass[$i]->id)[0]) : null,
             'total' => (Encodage::getBulletin($studentOfClass[$i]->id) !="")?(Encodage::getBulletin($studentOfClass[$i]->id)[1]):'',
             'coefTotal' => (Encodage::getBulletin($studentOfClass[$i]->id)!="") ? (Encodage::getBulletin($studentOfClass[$i]->id)[2]):'',
             'classe'=>$classe,
             'professeur'=>$professeur,
             'absence'=>$absence]);
            //  dd($studentOfClass);

            if ($data['data']['dataro'] == "") {
                error_log("\n Je rentre iciii", 0);
                
                //return redirect('classes/')->with('statusBad', 'Le bulletin n\'a pas pu être generé car aucune interro n\'a été faite pour le moment. ');
                
            } else {
                $view=view('bulletin', $data);
                $html .= $view->render();

            }
        }
        
        $pdf = \PDF::loadHTML($html);
        $nom = $classe->nom;
        return $pdf->download( $nom.'Bulletin.pdf');

    }
}
