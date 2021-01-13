@extends('layouts.master')

@section('title')
Encodage interrogation
@endsection

@section('pageTitle')
Encoder note interrogation
@endsection


@section('content')
<div class="row">
    <div class="col emp-profile" style="margin: 2%;">

        <h1>Liste des interrogations de la classe : {{$nom_classe->nom}}</h1>

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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ajouterUneInterro">
                    Ajouter une Interrogation
                </button>
            </div>
        </div>
        <table class="table table-striped table-hover" id="tableau">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom de l'interrogation </th>
                    <th scope="col">Matières </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($interros as $interro)

                <tr id="{{$interro->classe_id}}-{{$interro->id}}">
                    <th scope="row" value="{{ $loop->iteration }}">{{ $loop->iteration }}</th>
                    <td id="{{$interro->nom}}">{{$interro->nom}}</td>
                    <td id="{{$interro->matiere_id}}">{{$interro->matiere_nom_fr }} <b>|</b> {{$interro->matiere_nom_ar }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="/notes/{{ $interro->id }}" style=" padding-left:1em; padding-right:1em;" class="btn btn-outline-success">ENCODER</a>
                            <button type="button" style=" margin-right:10%; margin-left:10%;" class="btn btn-outline-success btnModif" data-toggle="modal" data-target="#ModifierUneInterro">✎</button>
                            <a href="javascript:void(0)" class="btn btn-outline-danger deletebtn"> 🗑 </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Modal pour créer une interrogation -->
    <div class="modal fade" id="ajouterUneInterro" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Ajouter une Interrogation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/interrogation/add" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" id="classe" name="classe" value="{{$id_classe}}">
                                <label><b>Nom de l'interrogation :</b></label>
                                <input type="text" placeholder="Entrez le nom de l'interrogation..." class="form-control" name="nom" id="nom" required>

                                <label><b>Note maximale de l'interrogation :</b></label>
                                <input readonly type="number"  placeholder="Entrez la note maximale de l'interrogation..." step="0.5" min="0" class="form-control" name="noteMaximale" id="noteMaximale" required>

                                <label><b>Matière de l'interrogation :</b></label>

                                <select class="form-control" name="type" id="type">
                                    @foreach($matiere as $mat)
                                    <option value="{{$mat->id}}">{{$mat->nom_fr}} | {{$mat->nom_ar}} </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button id="inscription" type="submit" class="btn btn-primary">Créer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour modifier une interrogation -->
    <div class="modal fade" id="ModifierUneInterro" tabindex="-1" role="dialog" aria-labelledby="modifierInterro" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modifier une Interrogation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Entrez les nouvelles informations :
                        <form id="formModification" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="modal-body">
                                <div class="form-group">
                                    <label><b>Nom de l'interrogation :</b></label>
                                    <input type="text" placeholder="Entrez le nom de l'interrogation..." class="form-control" value="" name="nom" id="nameOfInterro" required>

                                    <label><b>Note maximale de l'interrogation est sur</b></label>
                                    <input readonly type="number" placeholder="Entrez la note maximale de l'interrogation..." step="0.5" min="0" class="form-control" name="noteMaximaleInterro" id="noteMaximaleInterro" required>

                                    <input type="hidden" class="form-control" value="{{$nom_classe->id}}" name="id_classe" id="id_classe">
                                    <label><b>Matière de l'interrogation :</b></label>

                                    <select class="form-control" name="typeModif" id="typeModif">
                                        @foreach($matiere as $mat)
                                        <option value="{{$mat->id}}">{{$mat->nom_fr}} | {{$mat->nom_ar}} </option>
                                        @endforeach</select>
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

    

<!-- Modal pour supprimer une interrogation -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel">Supprimer une Interrogation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <form id="delete_modal_form" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <div class="modal-body">
                    <h4>Êtes-vous sûr de vouloir supprimer l'interrogation ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button onclick="this.disabled=true; this.form.submit();" type="submit" class="btn btn-primary">Oui, je suis sûr !</button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- FIN Modal pour supprimer une interrogation -->
    @endsection

    @section('scripts')
    <script>

$('#tableau').DataTable();
        let nom;
        let noteMaximale;
        let idInterro;
        let type;
        $(document).ready(function() {
            $('#tableau').DataTable();
            // $("#btnModif").click(function() {
            //     nom = this.id;
            //     noteMaximale = this.value;
            //     idInterro = this.name;
            //     type = document.getElementById(idInterro).value;
            //     console.log(idInterro);

            //     document.getElementById("noteMaximaleInterro").value = noteMaximale;

            //     document.getElementById("nameOfInterro").value = nom;
            //     document.getElementById("typeModif").value = type;

            // });
            $(".btnModif").click(function() {
                let tr = $(this).closest('tr');
                var data = tr.children("td").map(function() {
                    return $(this).attr('id');
                }).get();
                let ids = tr.attr('id').split("-");
                $("#nameOfInterro").attr("value", data[0]);
                $("#noteMaximaleInterro").attr("value", ano(data[1]));
                $(`#typeModif option[value=${data[1]}]`).attr('selected','selected');

                $('#formModification').attr('action', '/interrogation/update/' + ids[1]);
            });    
            $("#noteMaximale").val(ano($("#type").find("option:selected").attr('value')));

            $(document).on('change', '#type', function() {
                let tmp = ano($(this).find("option:selected").attr('value'));
                $("#noteMaximale").val(tmp);

            });
            $(document).on('change', '#typeModif', function() {
                let tmp = ano($(this).find("option:selected").attr('value'));
                $("#noteMaximaleInterro").val(tmp);
            });
    
            function ano($id) {
                let tmp = 0;
               var jqXHR= $.ajax({
                    url: '/matieres/coefficient/' + $id, // La ressource ciblée
                    type: 'GET', // Le type de la requête HTTP.
                    success: function(reponse, statut) {
                        tmp = reponse;

                    },
                    error: function(resultat, statut, erreur) {
                        console.log("Requete error");
                    },
                    async:false,
                });

                return jqXHR.responseJSON.coeff;
            }

            $('#tableau').on('click', '.deletebtn', function() {
                let tr = $(this).closest('tr');
                let data = tr.attr('id').split("-");
                console.log(data);
                $('#delete_modal_form').attr('action', '/interrogation/delete/' + data[0]+'/'+data[1]);

                $('#modalDelete').modal('show');
            });

        });
    </script>
    @endsection