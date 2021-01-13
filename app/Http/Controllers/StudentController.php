<?php

namespace App\Http\Controllers;

use App\Model\Student;
use App\Model\Presences;
use Excel;
use App\Exports\StudentHasToPayExport;
use Illuminate\Http\Request;
use DateTime;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $liststudents = Student::getStudentsDetail();
        $liststudents = Student::all();

        return view('admin.students', ['students' => $liststudents]);
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
        $student = new student();
        $dt = new DateTime();


        if ($request->input('dateNaissance') > $dt->format('Y-m-d')) {
            return redirect('/students/subscribe')->with('nom', $request->input('nom'))
                ->with('prenom', $request->input('prenom'))
                ->with('adresse', $request->input('adresse'))
                ->with('parentnom', $request->input('parentnom'))
                ->with('parentprenom', $request->input('parentprenom'))
                ->with('tel', $request->input('tel'))
                ->with('email', $request->input('email'))
                ->with('genre', $request->input('genre'))
                ->with('statusBad', "La date de naissance doit être avant celle d'aujourd'hui !");
        } else {
            $student->photo = "photo";
            $student->nomEtudiant = ucfirst($request->input('nom'));
            $student->prenomEtudiant = ucfirst($request->input('prenom'));
            $student->dateNaissanceEtudiant = $request->input('dateNaissance');
            $student->genre = $request->input('genre');
            $student->adresseMaisonEtudiant = ucfirst($request->input('adresse'));
            $student->nomParent = ucfirst($request->input('parentnom'));
            $student->prenomParent = ucfirst($request->input('parentprenom'));
            $student->noTelephoneParent = $request->input('tel');
            $student->emailParent = $request->input('email');

            $student->save();

            return redirect('/students')->with('statusGood', "L'étudiant a bien été ajouté.");
        }
    }
    public function storeEid(Request $request)
    {
        $student = new student();

        $eidParent = $request->input('eidParent');
        $eidEtudiant = $request->input('eidEtudiant');


        $xmlParent = new \SimpleXMLElement($eidParent);
        $xmlEtudiant = new \SimpleXMLElement($eidEtudiant);

        $dte = (string) $xmlEtudiant->identity['dateofbirth'];
        $date = $dte[0] . $dte[1] . $dte[2] . $dte[3] . '-' . $dte[4] . $dte[5] . '-' . $dte[6] . $dte[7];

        $student->photo = (string) $xmlEtudiant->identity->photo;
        $student->nomEtudiant = (string) $xmlEtudiant->identity->name;
        $student->prenomEtudiant = (string) $xmlEtudiant->identity->firstname;
        $student->dateNaissanceEtudiant = $date;
        $student->genre = ((string) $xmlEtudiant->identity['gender'] == "male") ? "masculin" : "feminin";
        $student->adresseMaisonEtudiant = (string) $xmlEtudiant->address->streetandnumber . ',' . (string) $xmlEtudiant->address->zip . ',' . (string) $xmlEtudiant->address->municipality;
        $student->nomParent = (string) $xmlParent->identity->name;
        $student->prenomParent = (string) $xmlParent->identity->firstname;
        $student->noTelephoneParent = $request->input('tel');
        $student->emailParent = $request->input('email');

        $student->save();

        return redirect('/students')->with('statusGood', "L'étudiant a bien été ajouté.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.student-edit')->with('student', $student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dt = new DateTime();
        $student = Student::findOrFail($id);

        if ($request->input('dateNaissance') >= $dt->format('Y-m-d')) {
            return redirect('/students/info/' . $id)->with('statusBad', "La date de naissance doit être avant celle d'aujourd'hui !");
        }else if (($student->montantAPayer - $request->input('montantAPayer') < 0 )){
            return redirect('/students/info/' . $id)->with('statusBad', "Le montant payé est supérieur au montant restant à payer !");
        }else {
            
            $student->nomEtudiant = ucfirst($request->input('name'));
            $student->prenomEtudiant = ucfirst($request->input('firstname'));
            $student->nomParent = ucfirst($request->input('nameParent'));
            $student->prenomParent = ucfirst($request->input('firstnameParent'));
            $student->adresseMaisonEtudiant = ucfirst($request->input('adresseMaison'));
            $student->dateNaissanceEtudiant = $request->input('dateNaissance');
            $student->emailParent = $request->input('emailParent');
            $student->noTelephoneParent = $request->input('noTelParent');
            $student->genre = $request->input('genre');
            $student->montantAPayer -= $request->input('montantAPayer');

            $student->update();
            return redirect('/students/info/' . $id)->with('statusGood', 'L\'etudiant a bien été modifié.');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = student::findOrFail($id);
        $student->delete();

        return redirect('/students')->with('statusGood', 'L\'étudiant a bien été supprimé.');
    }


    function showStudent($id)
    {
        $student = Student::findOrFail($id);
        $nbAbsence = Presences::getNbAbsenceFromStudentId($id);
        return view('admin.student')->with('student', $student)->with('nbAbsence', $nbAbsence);
    }
    function subscribeStudenteID()
    {
        return view('admin.student-inscription-eid');
    }
    function subscribeStudent()
    {
        return view('admin.student-inscription');
    }

    function paiement()
    {
        $student = Student::getStudentsWhoHaventPaid();

        return view('admin.paiement')->with('students', $student);
    }

    function export()
    {
        return Excel::download(new StudentHasToPayExport, 'paiement_restants.xlsx');
    }


    function payer(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        if (($student->montantAPayer - $request->input('montant') < 0 )){
            return redirect('/paiement')->with('statusBad', "Le montant a enregistrer est supérieur au montant restant à payer !");
        }else{
            $student->montantAPayer -= $request->input('montant');

            $student->update();
            
            return redirect('/paiement')->with('statusGood', 'Le montant a bien été enregistré');

        }
    }


}
