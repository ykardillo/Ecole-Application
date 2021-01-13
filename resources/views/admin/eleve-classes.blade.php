@extends('layouts.master')

@section('title')
{{$info->nom}}
@endsection

@section('pageTitle')
Liste des eleves de cette classes.
@endsection


@section('content')
<div class="row ">
    <div class="col emp-profile" style="margin: 2%;">
        <h2>Classe : {{$info->nom}}</h2>
        @if($teacher == null)
            <div class="alert alert-secondary float-left" role="alert">
                Cette classe n'a pas de professeur.
        </div>
        @else
        <h3>Professeur : {{$teacher->nom}} {{$teacher->prenom}}</h3>
        @endif
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
        <div class="row">
            <div class="col-9">
            </div>
            <div class="col">

            </div>
        </div>
        <form action="/bulletin/generate/class/{{$info->id}}" method="get" >
                    <button style="float:right; margin-right:40px;" type="submit" class="btn btn-success" >
                        Générer bulletin de cette classe
                    </button>
                </form>
        <table class="table table-striped table-hover" id="tableau">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classes as $classe)
                <tr id="{{$classe->id}}">
                    <th scope="row" value="{{ $loop->iteration }}">{{ $loop->iteration }}</th>
                    <td> {{$classe->nomEtudiant}}</td>
                    <td> {{$classe->prenomEtudiant}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#tableau').DataTable();
    });
</script>

@endsection
