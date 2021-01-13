@extends('layouts.master')

@section('title')
Présences
@endsection

@section('pageTitle')
Présences de la classe
@endsection


@section('content')
<div class="row ">
    <div class="col emp-profile"style="margin: 2%;">
        <h1>{{$classe->nom}} - {{$date_start}}</h1>

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
                    <a href="/presences/edit/{{$classe->id}}/{{$date_start}}/{{$date_end}}" class="btn btn-primary">Modifier</a>

                </div>
            </div>
            <table class="table table-striped table-hover" id="tableau">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Présence</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($studentsPresent as $student)
                    <tr id="{{$student->id}}">
                        <th scope="row" value="{{ $loop->iteration }}">{{ $loop->iteration }}</th>
                        <td> {{$student->nomEtudiant}}</td>
                        <td> {{$student->prenomEtudiant}}</td>

                        @if($student->presence == "A")
                            <td class="bg-warning text-white float-left">Absent(e) </td>
                        @else
                            <td class="bg-success text-white float-left">Présent(e)</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
</div>


@endsection

@section('scripts')
<script>
        $(document).ready( function () {
            $('#tableau').DataTable();

        });

</script>

@endsection
