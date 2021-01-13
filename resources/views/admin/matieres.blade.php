@extends('layouts.master')

@section('title')
Matières
@endsection

@section('pageTitle')
Matières
@endsection


@section('content')
<div class="row ">
    <div class="col emp-profile" style="margin: 2%;">
        <h1>Matières</h1>
       
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formAdd">Ajouter une matière</button>
            </div>
        </div>
        <table class="table table-striped table-hover" id="tableau">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Nom en arabe</th>
                    <th scope="col">Coefficient</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($matieres as $matiere)
                <tr id="{{$matiere->id}}">
                    <td id="{{$matiere->id}}" scope="row" value="{{ $loop->iteration }}">{{ $loop->iteration }}</td>
                    <td id="{{$matiere->nom_fr}}"> {{$matiere->nom_fr}}</td>
                    <td id="{{$matiere->nom_ar}}"> {{$matiere->nom_ar}}</td>
                    <td id="{{$matiere->coefficient}}"> {{$matiere->coefficient}}</td>

                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" style=" margin-right:10%; margin-left:10%;" class="btn btn-outline-success btnModif" data-toggle="modal" data-target="#ModifierUneMatiere">✎</button>

                            <a href="javascript:void(0)" class="btn btn-outline-danger deletebtn"> 🗑 </a>

                        </div>
                    </td>
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
            <form action="/matieres/add" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter une matière</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label><b>Nom en francais</b></label>
                        <input type="text" placeholder="Entrez le nom en francais..." class="form-control" name="name_fr" id="name_fr" required >
                    </div>
                    <div class="form-group">
                        <label><b>Nom en arabe</b></label>
                        <input type="text" placeholder="Entrez le nom en arabe..." class="form-control" name="name_ar" id="name_ar" required >
                    </div>
                    <div class="form-group">
                        <label><b>Coefficient</b></label>
                        <input type="number" placeholder="Entrez le coefficient..." class="form-control" name="coefficient" id="coefficient" min=1 required >
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
<div class="modal fade" id="ModifierUneMatiere" tabindex="-1" role="dialog" aria-labelledby="modifierMatiere" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modifier une Matière</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formModification" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="modal-body">
                    <div class="form-group">
                        <label><b>Nom en francais</b></label>
                        <input type="text" placeholder="Entrez le nom en francais..." class="form-control" name="name_fr" id="name_frAModifier" required >
                    </div>
                    <div class="form-group">
                        <label><b>Nom en arabe</b></label>
                        <input type="text" placeholder="Entrez le nom en arabe..." class="form-control" name="name_ar" id="name_arAModifier" required >
                    </div>
                    <div class="form-group">
                        <label><b>Coefficient</b></label>
                        <input type="number" placeholder="Entrez le coefficient..." class="form-control" name="coefficient" id="coefficientAModifier" min=1 required >
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


<!-- Modal DELETE -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel">Supprimer une matière</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="delete_modal_form" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <div class="modal-body">
                    <h4>Êtes-vous sûr de vouloir supprimer la matière ?</h4>
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
            $("#name_frAModifier").attr("value", data[1]);
            $("#name_arAModifier").attr("value", data[2]);
            $("#coefficientAModifier").attr("value", data[3]);

            $('#formModification').attr('action', '/matieres/update/' + tr.attr('id'));
        });

        $('#tableau').on('click', '.deletebtn', function() {
            let tr = $(this).closest('tr');

            $('#delete_modal_form').attr('action', '/matieres/delete/' + tr.attr('id'));

            $('#modalDelete').modal('show');
        });

    });
</script>

@endsection