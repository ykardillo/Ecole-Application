@extends('layouts.master')


@section('title')
Gestion des utilisateurs
@endsection



@section('content')


<div class="row">
    <div class="col emp-profile" style="margin: 2%;">
        <h1> Gestion des utilisateurs</h1>

        
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
        <table class="table" id="dataTable">
            <thead class=" text-primary">
                <th> ID </th>
                <th> Nom </th>
                <th> Prénom </th>
                <th> Email </th>
                <th> Type </th>
                <th>Actions</th>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td id="{{$user->id}}"> {{$user->id}} </td>
                    <td id="{{$user->name}}"> {{$user->name}} </td>
                    <td id="{{$user->firstname}}"> {{$user->firstname}} </td>
                    <td id="{{$user->email}}"> {{$user->email}} </td>
                    @switch($user->usertype)
                    @case("admin")
                    <td id="admin"> Administrateur </td>
                    @break
                    @case("teacher")
                    <td id="teacher"> Professeur </td>
                    @break
                    @default
                    <td id="pasDeType"> Pas de type </td>
                    @endswitch
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" style=" margin-right:10%; margin-left:10%;" class="btn btn-outline-success btnModif" data-toggle="modal" data-target="#ModifierUnUser">✎</button>
                            <a href="javascript:void(0)" class="btn btn-outline-danger deletebtn"> 🗑 </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal pour modifier un utilisateur -->
<div class="modal fade" id="ModifierUnUser" tabindex="-1" role="dialog" aria-labelledby="modifierUser" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modifier une utilisateur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Entrez les nouvelles informations de l'utilisateur :</p>
                <form id="formModification" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label><b>Nom</b></label>
                            <input type="text" placeholder="Entrez le nom de l'utilisateur..." class="form-control" name="nom" id="nomModifier" required>
                        </div>
                        <div class="form-group">
                            <label><b>Prénom</b></label>
                            <input type="text" placeholder="Entrez le prénom de l'utilisateur..." class="form-control" name="prenom" id="prenomModifier" required>
                        </div>
                        <div class="form-group">
                            <label><b>Adresse mail</b></label>
                            <input type="email" placeholder="Entrez l'adresse mail..." class="form-control" name="email" id="emailModifier" required>
                        </div>
                        <div class="form-group id_100">
                            <label>Type</label>
                            <select class="form-control" name="type" id="selectType">
                                <option value="pasDeType">Pas de type</option>
                                <option value="teacher">Professeur</option>
                                <option value="admin">Administrateur</option>
                            </select>
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

<!-- FIN Modal pour modifier un utilisateur -->



<!-- Modal pour supprimer un utilisateur -->

<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel">Supprimer un Utilisateur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <form id="delete_modal_form" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <div class="modal-body">
                    <h4>Êtes-vous sûr de vouloir supprimer l'utilisateur ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Oui, je suis sûr !</button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- FIN Modal pour supprimer un utilisateur -->

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
        $('#dataTable').on('click', '.deletebtn', function() {
            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function() {
                return $(this).attr('id');
            }).get();

            $('#delete_modal_form').attr('action', '/users/delete/' + data[0]);

            $('#modalDelete').modal('show');
        });

        $(".btnModif").click(function() {
            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function() {
                return $(this).attr('id');
            }).get();
            $("#nomModifier").attr("value", data[1]);
            $("#prenomModifier").attr("value", data[2]);
            $("#emailModifier").attr("value", data[3]);

            $("div.id_100 select").val(data[4]);
            $('#formModification').attr('action', '/users/edit/' + data[0]);
        });
    });
</script>
@endsection