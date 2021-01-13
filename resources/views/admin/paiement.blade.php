@extends('layouts.master')

@section('title')
Paiements
@endsection

@section('pageTitle')

@endsection


@section('content')

<div class="row">
    <div class="col emp-profile" style="margin: 2%;">
        <h1>Paiements</h1>
        
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
        </div>
        @if(count($students) == 0)
            <div class="modal-body">
                <div class="alert alert-secondary" role="alert">
                    <h4 class="alert-heading">Info :</h4>
                    <p>Toutes les étudiants ont déjà payé les frais scolaire.</p>
                </div>
            </div>
        @else
            <table id="tableau" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
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
                        <td> {{$student->montantAPayer}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" style=" margin-right:10%; margin-left:10%;" class="btn btn-outline-success btnModif" data-toggle="modal" data-target="#ModifierPayement">Payer</button>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

<!-- Modal pour payer  -->
<div class="modal fade" id="ModifierPayement" tabindex="-1" role="dialog" aria-labelledby="modifierPayement" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Paiement</h5>
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
                                <label><b>Montant payé</b></label>
                                <input type="number" placeholder="Entrez le montant payé..." class="form-control" name="montant" id="montantPayer"  min=0 required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <input id="modifier" class="btn btn-primary" type="submit" value="Payer">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- FIN Modal pour payer  -->

@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        $(".btnModif").click(function() {
            let tr = $(this).closest('tr');

            $('#formModification').attr('action', '/students/payer/' +  tr.attr('id'));
        });
        $("#tableau").DataTable();
        

    });
</script>

@endsection