<?php

namespace App\Services;

use App\Model\Cours;

class CalendarService
{
    public function generateCalendarData($weekDays,$idGroup)
    {

        $calendarData = [];
        $timeRange = (new TimeService)->generateTimeRange('08:00', '18:00');
        $lessons   = Cours::with('group')
            ->where("groupe_id","=",$idGroup)
            ->get();
            

        foreach ($timeRange as $time)
        {

            $timeText = $time['start'] . ' - ' . $time['end'];
            $calendarData[$timeText] = [];

            foreach ($weekDays as $index => $day)
            {
                $lesson = $lessons->where('jour', $index)->where('heure_debut', $time['start'])->first();

                if ($lesson)
                {

                    array_push($calendarData[$timeText], [
                        'group_nom'   => $lesson->group->nom,
                        'rowspan'      => $lesson->difference/30 ?? ''
                    ]);
                }
                else if (!$lessons->where('jour', $index)->where('heure_debut', '<', $time['start'])->where('heure_fin', '>=', $time['end'])->count())
                {
                    array_push($calendarData[$timeText], 1);
                }
                else
                {
                    array_push($calendarData[$timeText], 0);
                }
            }
        }
        
        return $calendarData;
    }
}
