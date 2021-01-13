@extends('layouts.master')
@section('title','Profil Etudiant')
@section('content')

<link rel="stylesheet" href="{{ asset('assets/css/studentProfil.css') }}">

<div class="container emp-profile">
    <form method="put" action="/students/edit/{{$student->id}}">
        
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
                <button class="profile-edit-btn">Modifier Etudiant</button>
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
                                <label>Adresse Domicile</label>
                            </div>
                            <div class="col-md-6">
                                <p>{{$student->adresseMaisonEtudiant}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Date de naissance </label>
                            </div>
                            <div class="col-md-6">
                                <p>{{$student->dateNaissanceEtudiant}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Genre </label>
                            </div>
                            <div class="col-md-6">
                                <p>{{ucfirst($student->genre)}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nombre d'absences</label>
                            </div>
                            <div class="col-md-6">
                                <p>{{$nbAbsence[0]->nbAbsence}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nom</label>
                            </div>
                            <div class="col-md-6">
                                <p> {{$student->nomParent}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Prenom</label>
                            </div>
                            <div class="col-md-6">
                                <p>{{$student->prenomParent}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Email</label>
                            </div>
                            <div class="col-md-6">
                                <p>{{$student->emailParent}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Numéro de téléphone</label>
                            </div>
                            <div class="col-md-6">
                                <p>{{$student->noTelephoneParent}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Montant à payer</label>
                            </div>
                            <div class="col-md-6">
                                <p>{{$student->montantAPayer}} €</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
