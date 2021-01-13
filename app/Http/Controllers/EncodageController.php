<?php

namespace App\Http\Controllers;

use App\Model\Classes;

use App\Model\Encodage;
use App\Model\Interrogation;
use App\Model\Matiere;
use App\Model\ProfToClasse;
use App\Model\Student;
use App\Model\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class EncodageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = [];
        $user_id = Auth::user()->id;
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
        return view('admin.encodage')->with('classes', $classes);
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

        $interro = new Interrogation();

        $interro->nom = ucfirst($request->input('nom'));
        $interro->noteMaximale = ucfirst($request->input('noteMaximale'));
        $interro->classe_id = ucfirst($request->input('classe'));

        $interro->matieres_id = ucfirst($request->input('type'));
        error_log("Type = " . $interro->matieres_id, 0);


        $interro->save();
        Encodage::initInterroOfClass($interro->classe_id, $interro->id);



        return redirect('interrogation/' . $interro->classe_id)->with('statusGood', 'L\'interrogations a bien été ajouté.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Encodage  $encodage
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $nom_classe = Classes::getNameOfClass($id);
        $interros = Encodage::getInterrosOfAClass($id);
        $matiere = Matiere::all();

        return view('admin.interro')->with('interros', $interros)->with('id_classe', $id)->with('nom_classe', $nom_classe)->with('matiere', $matiere);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Encodage  $encodage
     * @return \Illuminate\Http\Response
     */
    public function edit($encodage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Encodage  $encodage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $encodage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Encodage  $encodage
     * @return \Illuminate\Http\Response
     */
    public function destroy($encodage)
    {
        //
    }
    public function showNotes($id)
    {
        $idInterro = $id;
        $notes = Interrogation::getNotesOfAClass($id);
        $nomInterro = Interrogation::getNameOfInterro($id);
        $students = '';
        //je recupere le class id ici.
        //ensuite je dois recuperer les eleves de cette classe a partir de cette id .
        //  $students=Student::getStudentsOfAClass($notes[0]->classe_id);
        $students = Student::getStudentsOfAClassNotInInterrogation($nomInterro->classe_id, $idInterro);

        return view('admin.notes')->with('notes', $notes)->with('nameOfInterro', $nomInterro)->with('idOfInterro', $idInterro)->with('students', $students);
    }
    public function updateInterros($idInterro)
    {
        if (isset($_POST['noteOfStudent']) && isset($_POST['idStudents'])) {
            $noteOfStudents = $_POST['noteOfStudent'];
            $idStudents = $_POST['idStudents'];
            Encodage::updateInterro($idInterro, $idStudents, $noteOfStudents);


            $notes = Interrogation::getNotesOfAClass($idInterro);
            $nomInterro = Interrogation::getNameOfInterro($idInterro);
            $students = Student::getStudentsOfAClassNotInInterrogation($nomInterro->classe_id, $idInterro);

            // return view('admin.notes')->with('notes', $notes)->with('nameOfInterro', $nomInterro)->with('idOfInterro', $idInterro)->with('students', $students);
            return redirect('/notes' . '/' . $idInterro)->with('statusGood', "Les notes de l'interrogation ont bien été modifiées.");

        } else {
            return redirect('/notes' . '/' . $idInterro)->with('statusBad', "Vous n'avez encodé aucune note. Veuillez ajouter des étudiants a l'interrogation si aucun n'est dans la liste.");

        }
        //return redirect('/notes'.'/'.$id_interro)->with('statusGood', "Les/L'étudiant/s ont bien été ajouté/s.");
    }
    public function addStudentToInterrogation(Request $request)
    {
        $students = $request->input('students');
        $id_interro = $request->input('id_interro');
        if (empty($students)) {
            return redirect('/notes' . '/' . $id_interro)->with('statusBad', 'Aucun étudiant choisi.');
        } else {

            foreach ($students as $student) {
                DB::table('encodages')->insert(
                    ['noteEleve' => '0', 'interrogation_id' => $id_interro, "student_id" => $student]
                );
            }
            return redirect('/notes' . '/' . $id_interro)->with('statusGood', "Les/L'étudiant(s) ont bien été ajouté(s).");
        }
    }
}
