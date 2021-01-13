<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cours extends Model
{

    public $table = 'cours';

    protected $dates = [
        'created_at',
        'updated_at',
 
    ];

    protected $fillable = [
        'jour',
        'groupe_id',
        'heure_fin',
        'heure_debut',
        'created_at',
        'updated_at',
    ];

    const WEEK_DAYS = [
        '1' => 'Lundi    ',
        '2' => 'Mardi    ',
        '3' => 'Mercredi',
        '4' => 'Jeudi     ',
        '5' => 'Vendredi',
        '6' => 'Samedi  ',
        '7' => 'Dimanche',
    ];

    public function getDifferenceAttribute()
    {
        return Carbon::parse($this->heure_fin)->diffInMinutes($this->heure_debut);
    }

    public function getHeureDebutAttribute($value)
    {
        return $value ? Carbon::createFromFormat('H:i:s', $value)->format("H:i") : null;
    }

    public function setHeureDebutAttribute($value)
    {
        $this->attributes['heure_debut'] = $value ? Carbon::createFromFormat("H:i",
            $value)->format('H:i:s') : null;
    }

    public function getHeureFinAttribute($value)
    {
        return $value ? Carbon::createFromFormat('H:i:s', $value)->format("H:i") : null;
    }

    public function setHeureFinAttribute($value)
    {
        $this->attributes['heure_fin'] = $value ? Carbon::createFromFormat("H:i",
            $value)->format('H:i:s') : null;
    }

    function group()
    {
        return $this->belongsTo(Groupe::class, 'groupe_id');
    }

    public static function isTimeAvailable($jour, $heure_debut, $heure_fin, $group)
    {
        $courss = self::where('jour', $jour)
            ->where(function ($query) use ($group) {
                $query->where('groupe_id', $group);
            })
            ->where([
                ['heure_debut', '<', $heure_fin],
                ['heure_fin', '>', $heure_debut],
            ])
            ->count();
        return !$courss;
    }

    public static function isJustAfterAnotherCourse($jour, &$heure_debut, $group,&$idCourseBefore)
    {
        $cours = self::where('jour', $jour)
            ->selectRaw(DB::raw('id, heure_debut'))
            ->where(function ($query) use ($group) {
                $query->where('groupe_id', $group);
            })
            ->where([
                ['heure_fin', '=', $heure_debut],
            ])
            ->get();
            if(count($cours)){
                $idCourseBefore = $cours[0]->id;
                $heure_debut = $cours[0]->heure_debut;
            }
        return count($cours);
    }

    public static function isJustBeforeAnotherCourse($jour, &$heure_fin, $group,&$idCourseAfter)
    {
        $cours = self::where('jour', $jour)
            ->selectRaw(DB::raw('id, heure_fin'))
            ->where(function ($query) use ($group) {
                $query->where('groupe_id', $group);
            })
            ->where([
                ['heure_debut', '=', $heure_fin],
            ])
            ->get();
            if(count($cours)){
                $idCourseAfter = $cours[0]->id;
                $heure_fin = $cours[0]->heure_fin;
            }
        return count($cours);
    }
    public function scopeCalendarByRoleOrGroupId($query)
    {

        return $query->when(!request()->input('groupe_id'), function ($query) {
            })->when(request()->input('groupe_id'), function ($query) {
                $query->where('groupe_id', request()->input('groupe_id'));
            });
    }
}
