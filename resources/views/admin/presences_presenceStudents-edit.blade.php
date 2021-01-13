@extends('layouts.master')

@section('title')
Présences
@endsection

@section('pageTitle')
Présences de la classe
@endsection


@section('content')
<div class="row ">
    <div class="col emp-profile"style="margin: 2%;">
        <h1>{{$classe->nom}} - {{$date_start}}</h1>
        


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
        <form action="/presences/update/{{$classe->id}}/{{$date_start}}/{{$date_end}}" method="post">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-9">
                    <div class=" d-flex justify-content-end ">
                    <a href="/presences/info/{{$classe->id}}/{{$date_start}}/{{$date_end}}" class="btn btn-secondary mr-1 "> Annuler </a>
                    <button  type="submit" class="btn btn-success float-right">Enregistrer les nouvelles présencs</button>
                    </div>
                </div>
                <div class="col">
                </div>
            </div>
            <table class="table table-striped table-hover" id="tableau">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th></th>
                        <td></td>
                        <td></td>
                        <td>
                            <input class="form-check-input" type="checkbox" onClick="toggle(this)" id="toutCheck">
                            <label class="form-check-label" for="toutCheck" id="lblToutCheck">Tout cocher
                        </td>
                    </tr>
                    @foreach($students as $student)
                    <tr id="{{$student->id}}">
                        <th scope="row" value="{{ $loop->iteration }}">{{ $loop->iteration }}</th>
                        <td> {{$student->nomEtudiant}}</td>
                        <td> {{$student->prenomEtudiant}}</td>
                        @if($student->presence == 'P')
                            <td><input type="checkbox" name="students[]" value="{{$student->id}}" id="{{$student->id}}" checked></td>
                        @else
                            <td><input type="checkbox" name="students[]" value="{{$student->id}}" id="{{$student->id}}"></td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
</div>


@endsection

@section('scripts')
<script>
        $(document).ready( function () {
            $('#tableau').DataTable();

        });
        function toggle(source) {
            checkboxes = document.getElementsByName('students[]');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
            if($('#lblToutCheck').text() == "Tout décocher"){
                $('#lblToutCheck').text("Tout cocher");
            }else{
                $('#lblToutCheck').text("Tout décocher");
            }
        }

</script>

@endsection
