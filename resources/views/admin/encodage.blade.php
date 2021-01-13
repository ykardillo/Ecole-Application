@extends('layouts.master')

@section('title')
Encodage note
@endsection

@section('pageTitle')
Encoder note interrogation
@endsection


@section('content')
<div class="row">
    {{-- <div class="col emp-profile" style="margin: 2%;">
        <section class="services py-5 bg-light1 text-center">
            <div class="container">
        </section>


        <div class="row "> --}}
    <div class="col emp-profile" style="margin: 2%;">
        <h1>Encodages</h1>

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


        </div>
        <table class="table table-striped table-hover" id="tableau">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom de la classe </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classes as $classe)

                <tr id="{{$classe->id}}">
                    <th scope="row" value="{{ $loop->iteration }}">{{ $loop->iteration }}</th>
                    <td> {{$classe->nom}}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="/interrogation/{{ $classe->id }}" style=" padding-left:1em; padding-right:1em;" class="btn btn-outline-success">Voir Listes Interrogations</a>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="col collapse multi-collapse" id="multiCollapseExample2">
        <div style="padding:2%;margin-right:5%;">
            <div class="row">
                <div class="col-10">
                </div>
                <div class="col">
                </div>
            </div>

        </div>
    </div>
</div>

</div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#tableau').DataTable();
    });

</script>
@endsection
