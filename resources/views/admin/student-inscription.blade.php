@extends('layouts.master')
@section('title','Inscripion Étudiant')
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
    <form action="/students/add" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="row">
            <div class="col-md-4">
                <div class="profile-img">
                    <img src="{{ asset('assets/images/ic_user.png') }}" width="50" height="50">
                </div>
            </div>
            <div class="col-md-6">
                <div class="profile-head">
                    <h2></h2>

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item ">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">Information Etudiant</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Information Parent</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success profile-edit-btn" style="color:white">Inscrire</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-8">
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade show active " id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nom</label>
                            </div>
                            <div class="col-md-6">
                                @if (session('nom'))
                                <input type="text" placeholder="Entrez le nom..." class="form-control is-valid" name="nom" value="{{ session('nom') }}" id="nom" required>
                                @else
                                <input type="text" placeholder="Entrez le nom..." class="form-control" name="nom" id="nom" required>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Prenom </label>
                            </div>
                            <div class="col-md-6">
                                @if (session('prenom'))
                                <input type="text" placeholder="Entrez votre prénom..." class="form-control is-valid" name="prenom" id="prenom" value="{{ session('prenom') }}" required>
                                @else
                                <input type="text" placeholder="Entrez votre prénom..." class="form-control" name="prenom" id="prenom" required>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Adresse Domicile</label>
                            </div>
                            <div class="col-md-6">
                                @if (session('adresse'))
                                <input type="text" placeholder="Entrez l'adresse..." id="address-input" class="form-control is-valid" name="adresse" value="{{ session('adresse')}}" required>
                                @else
                                <input type="text" placeholder="Entrez l'adresse..." class="form-control" name="adresse" id="address-input" required>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Date de naissance </label>
                            </div>
                            <div class="col-md-6">
                                @if (session('statusBad'))
                                <input type="date" class="form-control is-invalid" name="dateNaissance" required>
                                @else
                                <input type="date" class="form-control" name="dateNaissance" required>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Genre</label>
                            </div>
                            <div class="col-md-6">
                                @if (session('genre'))
                                <select name="genre" class="form-control is-valid">
                                    @if (session('genre')=="Masculin")
                                    <option selected="selected" value="Masculin">Masculin</option>
                                    <option value="Feminin">Feminin</option>

                                    @elseif(session('genre')=="Feminin")
                                    <option value="Masculin">Masculin</option>
                                    <option selected="selected" value="Feminin">Feminin</option>
                                    @endif
                                </select>
                                @else
                                <select name="genre" class="form-control ">
                                    <option value="Masculin">Masculin</option>
                                    <option value="Feminin">Feminin</option>
                                </select>
                                @endif


                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nom</label>
                            </div>
                            <div class="col-md-6">
                                @if (session('parentnom'))
                                <input type="text" placeholder="Entrez le nom du parent..." class="form-control is-valid" name="parentnom" value="{{ session('parentnom')}}" id="parentnom" required>
                                @else
                                <input type="text" placeholder="Entrez le nom du parent..." class="form-control" name="parentnom" id="parentnom" required>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Prenom</label>
                            </div>
                            <div class="col-md-6">
                                @if (session('parentprenom'))
                                <input type="text" placeholder="Entrez le prénom du parent..." class="form-control is-valid" name="parentprenom" value="{{ session('parentprenom')}}" id="parentprenom" required>
                                @else
                                <input type="text" placeholder="Entrez le prénom du parent..." class="form-control" name="parentprenom" id="parentprenom" required>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Email</label>
                            </div>
                            <div class="col-md-6">
                                @if (session('email'))
                                <input type="email" placeholder="Entrez l'email du parent..." class="form-control is-valid" name="email" value="{{ session('email')}}" id="email" required>
                                @else
                                <input type="email" placeholder="Entrez l'email du parent..." class="form-control" name="email" id="email" required>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Numéro de téléphone</label>
                            </div>
                            <div class="col-md-6">
                                @if (session('tel'))
                                <input type="number" placeholder="Entrez le numéro de téléphone..." class="form-control is-valid" name="tel" id="tel" value="{{ session('tel')}}" required>
                                @else
                                <input type="number" placeholder="Entrez le numéro de téléphone..." class="form-control" name="tel" id="tel" required>
                                @endif
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
