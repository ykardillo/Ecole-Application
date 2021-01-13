@extends('layouts.master')
@section('title','Horaire')
@section('content')

<div class="row">
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

        <div class="row">
            <div class="col-6">
            </div>
            <div class="col">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formAddGroupe">
                    Ajouter un Groupe
                </button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formAddCours">
                    Ajouter un cours
                </button>

            </div>
        </div>

        <!-- Modal pour créer un cours -->
        <div class="modal fade" id="formAddCours" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="/cours/add" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ajouter un cours</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label><b>Jour</b></label>
                                <select class="form-control" name="jour" id="jour">
                                    <option value="">--Choisissez un jour--</option>
                                    <option value="1">Lundi</option>
                                    <option value="2">Mardi</option>
                                    <option value="3">Mercredi</option>
                                    <option value="4">Jeudi</option>
                                    <option value="5">Vendredi</option>
                                    <option value="6">Samedi</option>
                                    <option value="7">Dimanche</option>
                                </select>                    
                            </div>
                            <div class="form-group">
                                <label><b>Début</b></label>
                                <input type="time" class="form-control" placeholder="Entrez l'heure de début..." min="08:00" max="18:00" step="1800" name="heure_debut" id="heure_debut" required >
                            </div>
                            <div class="form-group">
                                <label><b>Fin</b></label>
                                <input type="time" class="form-control" placeholder="Entrez l'heure de fin..." min="08:00" max="18:00" step="1800" oninput="checkHeureFin(this)" name="heure_fin" id="heure_fin" required >
                            </div>
                            <div class="form-group">
                                <label><b>Groupe</b></label>
                                <select class="form-control select2 {{ $errors->has('group') ? 'is-invalid' : '' }}" name="groupe_id" id="groupe_id" required>
                                    @foreach($groups as $id => $group)
                                        <option value="{{ $id }}" {{ old('groupe_id') == $id ? 'selected' : '' }}>{{ $group }}</option>
                                    @endforeach
                                </select>                    
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Inscrire</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- FIN Modal pour créer un cours -->

        <!-- Modal pour créer un groupe  -->
        <div class="modal fade" id="formAddGroupe" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="/groupes/add" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ajouter un Groupe</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label><b>Nom</b></label>
                                <input type="text" placeholder="Entrez votre nom..." class="form-control" name="nom" id="nom" required >
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
        <!-- FIN Modal pour créer un groupe -->


        <!-- Modal pour modifier un groupe -->
        <div class="modal fade" id="ModifierUnGroupe" tabindex="-1" role="dialog" aria-labelledby="modifierGroupe" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modifier un groupe</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formModificationGroupe" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div>
                                <div class="form-group">
                                    <label><b>Nom</b></label>
                                    <input type="text" placeholder="Entrez le nom du groupe..." class="form-control" name="nom" id="nomGroupeAModifier" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                <input id="modifierGroupe" class="btn btn-primary" type="submit" value="Modifier">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- FIN Modal pour modifier un groupe -->


        <!-- Modal pour modifier un cours -->
        <div class="modal fade" id="ModifierUnCours" tabindex="-1" role="dialog" aria-labelledby="modifierCours" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modifier un groupe</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formModificationCours" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <label>Jour</label>
                                    <select class="form-control" name="jour" id="jourAModifier">
                                        <option value="1">Lundi</option>
                                        <option value="2">Mardi</option>
                                        <option value="3">Mercredi</option>
                                        <option value="4">Jeudi</option>
                                        <option value="5">Vendredi</option>
                                        <option value="6">Samedi</option>
                                        <option value="7">Dimanche</option>
                                    </select>
                                </div>
                            <div class="form-group">
                                <label>Début</label>
                                <input type="time" class="form-control"  min="08:00" max="18:00" step="1800" name="heure_debut" id="heure_debutAModifier" required>
                            </div>
                            <div class="form-group">
                                <label>Fin</label>
                                <input type="time" class="form-control" min="08:00" max="18:00" step="1800" oninput="checkHeureFin(this)" name="heure_fin" id="heure_finAModifier"required>
                            </div>
                            <div class="form-group">
                                <label>Groupe</label>
                                <select class="form-control {{ $errors->has('group') ? 'is-invalid' : '' }}" name="groupe_id" id="groupe_idAModifier" required>
                                    @foreach($groupes as $group)
                                        <option value="{{$group->id}}" >{{ $group->nom }}</option>
                                    @endforeach
                                </select>                    
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                <input id="modifierCours" class="btn btn-primary" type="submit" value="Modifier">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- FIN Modal pour modifier un cours -->
        
        <nav class="nav nav-tabs">
            <a class="nav-item nav-link active" href="#groupe" data-toggle="tab">Groupe</a>
            <a class="nav-item nav-link " href="#cours" data-toggle="tab">Cours</a>
        </nav>
        <div class="tab-content">
            <div class="tab-pane active" id="groupe">
                <table id="tableauGroupe" class="table table-striped table-hover" >
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($groupes as $groupe)
                    <tr id="{{$groupe->id}}">
                        <td id="{{$groupe->id}}" scope="row" value="{{ $loop->iteration }}">{{ $loop->iteration }}</td>
                        <td id="{{$groupe->nom}}"> {{$groupe->nom}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" style=" margin-right:10%; margin-left:10%;" class="btn btn-outline-success btnModifGroupe" data-toggle="modal" data-target="#ModifierUnGroupe">✎</button>
                                <a href="javascript:void(0)" class="btn btn-outline-danger deletebtngroupe"> 🗑 </a>

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <div class="tab-pane" id="cours">
                <table id="tableauCours" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Jour</th>
                            <th scope="col">Début</th>
                            <th scope="col">Fin</th>
                            <th scope="col">Groupe</th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courss as $cours)
                        <tr id="{{$cours->id}}">
                            <td scope="row" value="{{ $loop->iteration }}">{{ $loop->iteration }}</td>
                            @switch($cours->jour)
                                @case(1)
                                    <td id="{{$cours->jour}}"> Lundi </td>
                                    @break
                                @case(2)
                                    <td id="{{$cours->jour}}"> Mardi </td>
                                    @break
                                @case(3)
                                    <td id="{{$cours->jour}}"> Mercredi </td>
                                    @break
                                @case(4)
                                    <td id="{{$cours->jour}}"> Jeudi </td>
                                    @break
                                @case(5)
                                    <td id="{{$cours->jour}}"> Vendredi </td>
                                    @break
                                @case(6)
                                    <td id="{{$cours->jour}}"> Samedi </td>
                                    @break
                                @case(7)
                                    <td id="{{$cours->jour}}"> Dimanche </td>
                                    @break
                            @endswitch
                            <td id="{{$cours->heure_debut}}">{{$cours->heure_debut}}</td>
                            <td id="{{$cours->heure_fin}}">{{$cours->heure_fin}}</td>
                            <td id="{{$cours->group->id}}">{{$cours->group->nom}}</td>

                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" style=" margin-right:10%; margin-left:10%;" class="btn btn-outline-success btnModifCours" data-toggle="modal" data-target="#ModifierUnCours">✎</button>
                                    <a href="javascript:void(0)" class="btn btn-outline-danger deletebtncours"> 🗑 </a>
                                </div>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal pour supprimer un groupe -->
<div class="modal fade" id="modalDeleteGroupe" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel">Supprimer un Groupe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="delete_modal_form_groupe" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <div class="modal-body">
                    <h4>Êtes-vous sûr de vouloir supprimer le groupe ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button onclick="this.disabled=true; this.form.submit();" type="submit" class="btn btn-primary">Oui, je suis sûr !</button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- FIN Modal pour supprimer un groupe -->

<!-- Modal pour supprimer un cours -->
<div class="modal fade" id="modalDeleteCours" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel">Supprimer un Étudiant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="delete_modal_form_cours" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <div class="modal-body">
                    <h4>Êtes-vous sûr de vouloir supprimer le cours ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Oui, je suis sûr !</button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- FIN Modal pour supprimer un cours -->

<script>
    function checkHeureFin(input) {
        if (input.value <= $('#heure_debut').val()) {
            input.setCustomValidity("La date de fin doit être postérieure à la date de début");
        }else{
            input.setCustomValidity("");
        }
    }
$(document).ready(function() {
    $('#tableauGroupe').DataTable();
    $("#tableauCours").DataTable();

    $('#tableauGroupe').on('click', '.deletebtngroupe', function() {
        let tr = $(this).closest('tr');

        $('#delete_modal_form_groupe').attr('action', '/groupes/delete/' + tr.attr('id'));

        $('#modalDeleteGroupe').modal('show');
    });

    $('#tableauCours').on('click', '.deletebtncours', function() {
        let tr = $(this).closest('tr');

        $('#delete_modal_form_cours').attr('action', '/cours/delete/'+ tr.attr('id'));

        $('#modalDeleteCours').modal('show');
    });

    $(".btnModifGroupe").click(function() {
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).attr('id');
        }).get();
        $("#nomGroupeAModifier").attr("value", data[1]);

        $('#formModificationGroupe').attr('action', '/groupes/update/' +data[0]);
    });

    $(".btnModifCours").click(function() {
        let tr = $(this).closest('tr');
        var data = tr.children("td").map(function() {
            return $(this).attr('id');
        }).get();
        $("#jourAModifier").val(data[0]);
        $("#heure_debutAModifier").attr("value", data[1]);
        $("#heure_finAModifier").attr("value", data[2]);
        $(`#groupe_idAModifier option:eq(${data[3]-1})`).prop('selected', true);
        $('#formModificationCours').attr('action', '/cours/update/' + tr.attr('id'));
    });

})  
</script>




@endsection