@extends('layouts.master')

@section('title')
Classes
@endsection

@section('pageTitle')
Classes
@endsection


@section('content')
<div class="row ">
    <div class="col emp-profile" style="margin: 2%;">
        <h1>Classes</h1>
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ajouterUneClasse">
                    Ajouter une classe
                </button>
                
            </div>
        </div>
        <table class="table table-striped table-hover" id="tableau">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom de la classe </th>
                    <th scope="col">Nombre maximum d'étudiants</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classes as $classe)

                <tr id="{{$classe->id}}">
                    <td id="{{$classe->id}}">{{ $loop->iteration }}</th>
                    <td id="{{$classe->nom}}"> {{$classe->nom}}</td>
                    <td id="{{$classe->max_eleves}}"> {{$classe->max_eleves}}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="/classes/info/{{ $classe->id }}" style=" padding-left:1em; padding-right:1em;" class="btn btn-outline-success">🡆</a>
                            <button type="button" style=" margin-right:10%; margin-left:10%;" class="btn btn-outline-success btnModif" data-toggle="modal" data-target="#ModifierUneClasse">✎</button>
                            <a href="javascript:void(0)" class="btn btn-outline-danger deletebtn"> 🗑 </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="col collapse multi-collapse" id="multiCollapseExample2">
        <div style="padding:2%;margin-right:5%;">
            <div class="row">
                <div class="col-10">
                </div>
                <div class="col">
                </div>
            </div>

        </div>
    </div>
</div>




<!-- Modal pour créer une inscription -->
<div class="modal fade" id="ajouterUneClasse" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Ajouter une classe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <form action="/classes/add/" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label><b>Nom</b></label>
                                <input type="text" placeholder="Entrez le nom de la classe..." class="form-control" name="nom" required>
                            </div>
                            <div class="form-group">
                                <label><b>Nombre maximum d'étudiants</b></label>
                                <input type="number" placeholder="Entrez le nombre maximum..." class="form-control" name="nombre" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button id="inscription" type="submit" class="btn btn-primary" onclick="this.disabled=true;this.form.submit();">Créer</button>
                        </div>

                    </form>
            </div>
        </div>
    </div>
</div>

<!-- FIN Modal pour créer une inscription -->


<!-- Modal pour modifier une classe -->
<div class="modal fade" id="ModifierUneClasse" tabindex="-1" role="dialog" aria-labelledby="modifierClasse" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modifier une classe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <form id="formModification" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div>
                            <div class="form-group">
                                <label><b>Nom</b></label>
                                <input type="text" placeholder="Entrez le nom de la classe..." class="form-control" name="nom" id="nomAModifier" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><b>Nombre maximum d'étudiants</b></label>
                            <input type="number" placeholder="Entrez le nombre maximum..." class="form-control" name="nombre" id="nombreAModifier" required>
                        </div>
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

<!-- FIN Modal pour modifier une classe -->



<!-- Modal pour supprimer une classe -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel">Supprimer une Classe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <form id="delete_modal_form" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <div class="modal-body">
                    <h4>Êtes-vous sûr de vouloir supprimer la classe ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button onclick="this.disabled=true; this.form.submit();" type="submit" class="btn btn-primary">Oui, je suis sûr !</button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- FIN Modal pour supprimer une classe -->

@endsection

@section('scripts')
<script>

    $(document).ready(function() {
        $('#tableau').DataTable();

        $(".btnModif").click(function() {
            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function() {
                return $(this).attr('id');
            }).get();
            $("#nomAModifier").attr("value", data[1]);
            $("#nombreAModifier").attr("value", data[2]);

            $('#formModification').attr('action', '/classes/update/' + data[0]);
        });
        $('#tableau').on('click', '.deletebtn', function() {
            let tr = $(this).closest('tr');

            $('#delete_modal_form').attr('action', '/classes/delete/' + tr.attr('id'));

            $('#modalDelete').modal('show');
        });
    });
</script>

@endsection