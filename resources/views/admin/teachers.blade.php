@extends('layouts.master')

@section('title')
Professeurs
@endsection

@section('pageTitle')
Professeurs
@endsection


@section('content')
<div class="row ">
    <div class="col emp-profile" style="margin: 2%;">
        <h1>Professeurs</h1>
        
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
                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formAdd">Ajouter un Professeur</button> --}}
            </div>
        </div>
        <table class="table table-striped table-hover" id="tableau">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    {{-- <th>Actions</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($teachers as $teacher)
                    <tr id="{{$teacher->id}}">
                        <td id="{{$teacher->id}}"  scope="row" value="{{ $loop->iteration }}">{{ $loop->iteration }}</td>
                        <td id="{{$teacher->nom}}"> {{$teacher->nom}}</td>
                        <td id="{{$teacher->prenom}}"> {{$teacher->prenom}}</td>
                        {{-- <td>

                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" style=" margin-right:10%; margin-left:10%;" class="btn btn-outline-success btnModif" data-toggle="modal" data-target="#ModifierUnProf">✎</button>
                                <a href="javascript:void(0)" class="btn btn-outline-danger deletebtn"> 🗑 </a>

                            </div>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Modal ADD -->
<div class="modal fade" id="formAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="/teachers/add" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter un Professeur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label><b>Nom</b></label>
                        <input type="text" placeholder="Entrez votre nom..." class="form-control" name="name" id="name" required >
                    </div>
                    <div class="form-group">
                        <label><b>Prénom</b></label>
                        <input type="text" placeholder="Entrez votre prénom..." class="form-control" name="firstname" id="firstname" required >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button onclick="this.disabled=true; this.form.submit();" id="inscription" type="submit" class="btn btn-primary">Inscrire</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal EDIT -->
<div class="modal fade" id="ModifierUnProf" tabindex="-1" role="dialog" aria-labelledby="modifierProf" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modifier un Professeur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formModification" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" placeholder="Entrez le nom du professeur..." class="form-control" name="name" id="nomAModifier" required>
                    </div>

                    <div class="form-group">
                        <label>Prénom</label>
                        <input type="text" placeholder="Entrez le prénom du professeur..." class="form-control" name="firstname" id="prenomAModifier" required>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <input id="modifier" class="btn btn-primary" type="submit" value="Modifier">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal DELETE -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel">Supprimer un Professeur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="delete_modal_form" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <div class="modal-body">
                    <h4>Êtes-vous sûr de vouloir supprimer le professeur ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button onclick="this.disabled=true; this.form.submit();" type="submit" class="btn btn-primary">Oui, je suis sûr !</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#tableau').DataTable();
        $(".btnModif").click(function() {
            let tr = $(this).closest('tr');
            var data = tr.children("td").map(function() {
                return $(this).attr('id');
            }).get();
            $("#nomAModifier").attr("value", data[1]);
            $("#prenomAModifier").attr("value", data[2]);

            $('#formModification').attr('action', '/teachers/update/' + tr.attr('id'));
        });

        $('#tableau').on('click', '.deletebtn', function() {
            let tr = $(this).closest('tr');

            $('#delete_modal_form').attr('action', '/teachers/delete/' + tr.attr('id'));

            $('#modalDelete').modal('show');
        });

    });
</script>

@endsection