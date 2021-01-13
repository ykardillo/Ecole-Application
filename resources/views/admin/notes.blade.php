@extends('layouts.master')

@section('title')
Notes
@endsection

@section('pageTitle')
Notes pour l'interrogation.
@endsection


@section('content')

<div class="row">
    <div class="col emp-profile" style="margin: 2%;">
        <h1>Note pour l'interrogation : {{$nameOfInterro->nom}}</h1>
        
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
            </div>
        </div>

        <form action="/note/update/{{$idOfInterro}}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <button style="float:right;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#attrStudClass">
                    Ajouter élève a cette interrogation
                </button>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Note de l'élève / <span>{{$nameOfInterro->noteMaximale}}</span>
                        <th scope="col"> </th>
                    </tr>


                </thead>
                <tbody>

                @if($notes!='')

                    @foreach($notes as $note)

                    <!-- @if (session('statusGood'))
                    <div class="alert alert-success" role="alert">
                        {{ session('statusGood') }}
                    </div>
                    @endif
                    @if (session('statusBad'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('statusBad') }}
                    </div>
                    @endif -->

                    <tr id="{{$note->id}}">
                        <th scope="row" value="{{ $loop->iteration }}">{{ $loop->iteration }}</th>
                        <td name="nameOfStudent[]"> {{$note->nomEtudiant}}</td>
                        <td> {{$note->prenomEtudiant}}</td>

                        @if($note->noteEleve >= $nameOfInterro->noteMaximale/2)
                        <td> <input style="width:20%;background-color:#01BD3A;color:white;text-align:center;" step="0.5" min="0" max="{{$nameOfInterro->noteMaximale}}" class="form-control" name="noteOfStudent[]" type="number" value='{{$note->noteEleve}}'> </td>

                        @else                            
                        <td> <input style="width:20%;background-color:#F2441E;color:white; text-align:center;" step="0.5" min="0" max="{{$nameOfInterro->noteMaximale}}" class="form-control" name="noteOfStudent[]" type="number" value='{{$note->noteEleve}}'> </td>
                       
                        @endif

                            <td> <input name="idStudents[]" type="text" style="display:none;" value='{{$note->student_id}}'> </td>

                    </tr>

                    @endforeach
                    @endif

                </tbody>
            </table>
            <button style="margin-left:43%;" id="soumettre" class="btn btn-success profile-edit-btn">Soumettre</button>
        </form>
    </div>
</div>

<!-- Modal pour créer une attribution StudentToClass -->

        <div class="modal fade bd-example-modal-lg " id="attrStudClass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Ajouter Eleve a l'interrogation si il ne l'a pas faite. </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/notes/addStudentToInterrogation/" method="post">
                        <div class="modal-body">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                
                            </div>
                            <div class="form-group">
                                <label>Étudiants</label>
                                <table class="table table-striped table-hover" id="tableauProf">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nom</th>
                                            <th scope="col">Prenom</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($students!='')
                                        @foreach ($students as $student)
                                        <tr>
                                            <td> {{$student->nomEtudiant}}</td>
                                            <td> {{$student->prenomEtudiant}}</td>
                                            <td><input type="checkbox" name="students[]" value="{{$student->id}}" ></td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        <td><input type="hidden" name="id_interro" value="{{$nameOfInterro->id}}" ></td>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button onclick="this.disabled=true; this.form.submit();" id="inscription" type="submit" class="btn btn-primary">Créer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- FIN Modal pour créer une attribution StudentToClass -->
@endsection

@section('scripts')

<script>

</script>

@endsection