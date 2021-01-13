@extends('layouts.master')

@section('title')
Étudiants
@endsection

@section('pageTitle')
Étudiants
@endsection


@section('content')

<div class="row">
    <div class="col emp-profile" style="margin: 2%;">
        <h1>Étudiants</h1>
        
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
                {{-- <a href="/students/subscribe" style="margin-bottom:2em;" class="btn btn-primary">Ajouter un étudiant</a> --}}
                <ul class="navbar-nav mr-auto">
                    <li class="dropdown">
                        <a class="btn btn-primary dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white">Ajouter un étudiant</a>
                        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/students/subscribe_eID">eID</a>
                            <a class="dropdown-item" href="/students/subscribe">Manuellement</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteLabel">Supprimer un Étudiant</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <form id="delete_modal_form" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <div class="modal-body">
                            <h4>Êtes-vous sûr de vouloir supprimer l'étudiant ?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Oui, je suis sûr !</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <table id="tableau" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Genre</th>
                    <th scope="col">Nom du parent</th>
                    <th scope="col">Montant à payer</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr id="{{$student->id}}">
                    <th scope="row" value="{{ $loop->iteration }}">{{ $loop->iteration }}</th>
                    <td> {{$student->nomEtudiant}}</td>
                    <td> {{$student->prenomEtudiant}}</td>
                    <td> {{ucfirst($student->genre)}}</td>
                    <td> {{$student->nomParent}} {{$student->prenomParent}}</td>
                    <td> {{$student->montantAPayer}}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="/students/info/{{ $student->id }}" style=" padding-left:1em; padding-right:1em;" class="btn btn-outline-success">🡆</a>
                            <a href="/students/edit/{{ $student->id }}" style=" margin-right:10%; margin-left:10%;" class="btn btn-outline-success">✎</a>
                            <a href="javascript:void(0)" class="btn btn-outline-danger deletebtn"> 🗑 </a>
                            <a href="/bulletin/{{ $student->id }}" style=" margin-right:10%; margin-left:10%;" class="btn btn-outline-success">PDF</a>


                        </div>

                    </td>
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

        $("#tableau").DataTable();
        $('#tableau').on('click', '.deletebtn', function() {
            let tr = $(this).closest('tr');

            $('#delete_modal_form').attr('action', '/students/delete/' + tr.attr('id'));

            $('#modalDelete').modal('show');
        });

    });
</script>

@endsection
