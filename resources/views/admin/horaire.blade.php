@extends('layouts.master')
@section('title')
Horaire
@endsection
@section('pageTitle')
Horaire
@endsection
@section('content')
<div class="content">
    <div class="row ">
        <div class="col emp-profile" style="margin: 2%;">
            <h1>Horaire</h1>
            @if (session('statusGood'))
                <div class="alert alert-success alert-dismissible w-25 p-3" role="alert" 
                    style="position: fixed;
                        top: 5%; 
                        right:5%;
                        width: 96%;">
                    {{ session('statusGood') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            
            @endif
            @if (session('statusBad'))
                <div class="alert  alert-danger alert-dismissible w-25 p-3" role="alert" 
                style="position: fixed;
                    top: 5%; 
                    right:5%;
                    width: 96%;">
                    {{ session('statusBad') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <!-- <div class="row">
                <div class="col-9">
                </div>
                <div class="col">
                Groupe : <select id="idGroup" style="width:130px;" class="form-control" name="" id="">
                    @foreach($groups as $id => $group)
                    <option  value="{{ $group->id }}">  {{ $group->nom }} </option>
                    @endforeach
                </select> 
            </div>
        </div> -->
        <div class="row " style="padding-bottom:2em">
            <div class="col-md-6 d-flex justify-content-end">
                <h4><label>Groupe : </label></h4>
            </div>
            <div class="col-md-6">
                <select id="idGroup" class="form-control w-25" name="" id="">
                    @foreach($groups as $id => $group)
                        <option  value="{{ $group->id }}">  {{ $group->nom }} </option>
                    @endforeach
                </select>                          
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <table id="horaireTab" class="table table-bordered"> 
                    <thead>
                        <tr>
                        <th scope="col">Heure</th>
                        @foreach($jours as $jour)
                            <th>{{ $jour }}</th>
                        @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($calendarData as $time => $jours)
                            <tr>
                                <td>
                                    {{ $time }}
                                </td>
                                @foreach($jours as $value)
                                    @if (is_array($value))
                                        <td rowspan="{{ $value['rowspan'] }}" class="align-middle text-center" style="background-color:#f0f0f0">
                                        {{ $value['group_nom'] }}
                                        </td>
                                    @elseif ($value === 1)
                                        <td></td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div  class="col">
            <div class="row" >
                <div class="col">
                </div>
                <div class="col-8">
                    <table id="classesTab" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Classe</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(empty($classes) || $classes->isEmpty())
                                <tr>
                                    <td>Aucune classe ne figure dans ce groupe</td>
                                </tr>
                            @else
                                @foreach($classes as $classe)
                                <tr>
                                    <td>{{ $classe->nom }}</td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="col">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script> 
$(document).ready(function() {
    $('#idGroup').val("{{$idGroup}}")
    $('#idGroup').change(function(){
        let idGroup = $('#idGroup').val();
        window.location.replace("./"+idGroup);
    })
    $("#classesTab").scrollTableBody({rowsToDisplay:10})
    $("#horaireTab").scrollTableBody({rowsToDisplay:10})

})
</script>
@endsection
