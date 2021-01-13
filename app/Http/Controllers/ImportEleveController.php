<?php

namespace App\Http\Controllers;

use App\Imports\StudentImport;
use App\Exports\StudentExport;
use Illuminate\Http\Request;
use DB;
use Excel;

class ImportEleveController extends Controller
{
    function export(Request $request)
    {
        $student = DB::table('students')->get();
        if($student->count() < 1){
            return redirect('/import_export')->with('statusBad', "Il n'y a aucun étudiant inscrit !");

        }
        return Excel::download(new StudentExport, 'étudiants.xlsx');

    }

    function import(Request $request)
    {

        $this->validate($request, ['select_file'  => 'required|mimes:xls,xlsx']);

        $path = $request->file('select_file')->getRealPath();

        Excel::import(new StudentImport, $path);

        return redirect('/import_export')->with('statusGood', 'le fichier a été importé avec succès !');
    }
}
