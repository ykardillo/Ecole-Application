<?php

namespace App\Http\Controllers;

use App\Exports\TeacherExport;
use App\Imports\TeacherImport;
use Illuminate\Http\Request;
use DB;
use Excel;

class ImportProfController extends Controller
{
    function export(Request $request)
    {

        return Excel::download(new TeacherExport, 'professeurs.xlsx');

    }

    function import(Request $request)
    {

        $this->validate($request, [
            'select_file'  => 'required|mimes:xls,xlsx'
           ]);

        $path = $request->file('select_file')->getRealPath();

        Excel::import(new TeacherImport, $path);

        return redirect('/import_export')->with('statusGood', 'le fichier a été importé avec succès !');
    }
}
