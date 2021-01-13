<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    protected $table='matières';
    protected $fillable = ['nom_fr','nom_ar','coefficient'];
}
