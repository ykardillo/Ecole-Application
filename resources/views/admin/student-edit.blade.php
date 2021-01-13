@extends('layouts.master')
@section('title','Modification Etudiant')
@section('content')

<link rel="stylesheet" href="{{ asset('assets/css/studentProfil.css') }}">

<div class="container emp-profile">
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

    <form action="/students/update/{{ $student->id }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        
        <div class="row">
            <div class="col-md-4">
                <div class="profile-img">
                    @if($student->photo == "photo")
                        <img src="{{ asset('assets/images/ic_user.png') }}" width="50" height="50" alt="Photo de profil" id="photoProfil">
                    @else
                        <img id="photoProfil" src="data:image/jpeg;base64,{{$student->photo}}" alt="Photo de profil" />
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="profile-head">
                    <h2>{{$student->nomEtudiant}} {{$student->prenomEtudiant}}</h2>

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Information Etudiant</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Information Parent</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success profile-edit-btn" style="color:white">Valider Modification</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-8">
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nom</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Entrez votre nom..." value="{{ $student->nomEtudiant }}" name="name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Prenom </label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Entrez votre prénom..." value="{{ $student->prenomEtudiant }}" name="firstname" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Adresse Domicile</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Entrez l'adresse..." value="{{$student->adresseMaisonEtudiant}}" name="adresseMaison" id="address-input" required>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Date de naissance </label>
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="form-control" value="{{$student->dateNaissanceEtudiant}}" name="dateNaissance" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Genre </label>
                            </div>
                            <div class="col-md-6">
                                <select name="genre" class="form-control">
                                    @if ($student->genre=="masculin")
                                    <option selected="selected" value="Masculin">Masculin</option>
                                    <option value="Feminin">Feminin</option>

                                    @elseif($student->genre=="feminin")
                                    <option value="Masculin">Masculin</option>
                                    <option selected="selected" value="Feminin">Feminin</option>

                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nom</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="{{ $student->nomParent }}" placeholder="Entrez le nom du parent..." name="nameParent" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Prenom</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Entrez le prénom du parent..." value="{{ $student->prenomParent }}" name="firstnameParent" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Email</label>
                            </div>
                            <div class="col-md-6">
                                <input type="email" placeholder="Entrez l'email du parent..." class="form-control" value="{{$student->emailParent}}" name="emailParent" id="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Numéro de téléphone</label>
                            </div>
                            <div class="col-md-6">
                                <input type="number" placeholder="Entrez le numéro de téléphone..." class="form-control" value="{{$student->noTelephoneParent}}" name="noTelParent" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>





@endsection

@section('scripts')
<script>
    var placesAutocomplete = places({
        appId: 'pl33MGBGRAIO',
        apiKey: '51227f3702218a50c13c3f67ba5add74',
        container: document.querySelector('#address-input')
    });
</script>
@endsection
