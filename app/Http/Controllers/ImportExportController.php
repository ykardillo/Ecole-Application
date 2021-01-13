<?php

namespace App\Http\Controllers;

use App\Imports\StudentImport;
use App\Exports\StudentExport;
use Illuminate\Http\Request;
use DB;
use Excel;

class ImportExportController extends Controller
{
    function index()
    {
     $students = DB::table('students')->get();
     $teachers = DB::table('teachers')->get();

     return view('admin.import_export', compact('students','teachers'));
    }
}
