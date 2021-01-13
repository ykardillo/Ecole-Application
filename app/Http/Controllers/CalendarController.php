<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Cours;
use App\Model\Groupe;
use App\Model\Classes;
use App\Services\CalendarService;

class CalendarController extends Controller
{
    public function index()
    {
        $courss = Cours::with('group')->get();
        $groups = Groupe::all()->pluck('nom', 'id');

        $groupes = Groupe::all();


        return view('admin.horaire-gestion', compact('courss','groups','groupes'));
    }

    public function horaire(CalendarService $calendarService,$idGroup)
    {
        $jours = Cours::WEEK_DAYS;
        $cours = Cours::all();
        $groups = Groupe::all();
        $calendarData = $calendarService->generateCalendarData($jours,$idGroup);
        $classes = Classes::getClassesFromGroupId($idGroup);

        return view('admin.horaire', compact('jours', 'calendarData','groups','idGroup','classes'));
    }
}
