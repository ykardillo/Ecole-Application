@extends('layouts.master')
@section('title','Accueil')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Accueil</div>

                <div class="card-body d-flex justify-content-center">
                    @guest
                        <a class="btn btn-primary" href="{{ route('login') }}">{{ __('Connexion') }}</a> 
                    @if (Route::has('register'))
                        <a class="btn btn-primary" href="{{ route('register') }}">{{ __('S\'enregistrer') }}</a>
                    @endif
                    @else
                        <a class="btn btn-primary" href="{{ route('home') }}">{{ __('Accueil') }}</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
