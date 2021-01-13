@extends('layouts.master')
@section('title','Accueil')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Accueil</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-secondary" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h2>Bienvenue sur la page d'accueil du site.</h2>
                        @guest
                        @if (Route::has('register'))
                        @endif
                        @else
                            @if (Auth::user()->usertype == "")
                            <div class="alert alert-warning " role="alert">
                                <h4 class="alert-heading">Info :</h4>
                                <p>Vous êtes connecté en temps qu'utilisateur.</p>
                                <hr>
                                <p class="mb-0">Demandez à l'administrateur pour avoir accès à l'entièreté du site.</p>
                            </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
