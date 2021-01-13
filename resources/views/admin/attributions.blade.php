@extends('layouts.master')
@section('title','Attributions')
@section('content')

<div class="row">
    <div class="col emp-profile" style="margin: 2%;">
        <h1>Attributions</h1>
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
                {{-- <a href="/students/subscribe" style="margin-bottom:2em;" class="btn btn-primary">Ajouter un étudiant</a> --}}
                <ul class="navbar-nav mr-auto">
                    <li class="dropdown">
                        <a class="btn btn-primary dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white">Attributions</a>
                        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#attrProfClass">
                                ... de classes à un professeur
                            </button>
                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#attrStudClass">
                                ... d'étudiants à une classe
                            </button>
                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#attrClassGroup">
                               ... de classes à un groupe
                            </button>
                        </div>
                    </li>
                </ul>
                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#attrProfClass">
                    Attributions de professeurs à une classe
                </button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#attrStudClass">
                    Attributions d'élèves à une classe
                </button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#attrClassGroup">
                    Attributions de classes à un groupe
                </button> --}}
            </div>
        </div>

        <!-- Modal pour créer une attributionProfToClass -->

        <div class="modal fade bd-example-modal-lg " id="attrProfClass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Attribution d'un professeur à une classe</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @if(empty($classesWT))
                    <div class="modal-body">
                        <div class="alert alert-secondary" role="alert">
                            <h4 class="alert-heading">Info :</h4>
                            <p>Toutes les classes ont déjà été attribuées à un professeur.</p>
                            <hr>
                            <p class="mb-0">Supprimez une attribution afin de pouvoir créer une autre attribution.</p>
                        </div>
                    </div>
                    @else
                    <form action="attributions/teacher_to_class/" method="post">
                        <div class="modal-body">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <h3>Professeurs</h3>
                                <select class="form-control" name="teacher">
                                    @foreach ($teachers as $teacher)
                                    <option value="{{$teacher->id}}">{{$teacher->nom}} {{$teacher->prenom}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <h3>Classes</h3>
                                <table class="table table-striped table-hover" id="tableauProfClasses">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nom</th>
                                            <th scope="col">Maximum d'étudiants</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($classesWT as $classe)
                                        <tr>
                                            <td> {{$classe->nom}}</td>
                                            <td> {{$classe->max_eleves}}</td>
                                            <td><input type="checkbox" name="classes[]" value="{{$classe->id}}" id="classesWT-{{$classe->id}}"></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button onclick="this.disabled=true; this.form.submit();" id="inscriptionTeacherToClasses" type="submit" class="btn btn-primary">Créer</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        <!-- FIN Modal pour créer une attributionTeacherfToClass -->

        <!-- Modal pour créer une attribution StudentToClass -->

        <div class="modal fade bd-example-modal-lg " id="attrStudClass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Attribution d'étudiants à une classe</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @if(count($studentsWC) == 0)
                        <div class="modal-body">
                            <div class="alert alert-secondary" role="alert">
                                <h4 class="alert-heading">Info :</h4>
                                <p>Toutes les étudiants ont déjà été attribuées à une classe.</p>
                                <hr>
                                <p class="mb-0">Supprimez une attribution afin de pouvoir créer une autre attribution.</p>
                            </div>
                        </div>
                    @else
                        <form action="attributions/students_to_class/" method="post">
                            <div class="modal-body">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="form-group">
                                    <h3>Classes</h3>
                                    <select class="form-control classe" name="classe">
                                        @foreach ($classes as $classe)
                                        <option value="{{$classe->id}}" id="{{$classe->nbRemainingStudents}}">{{$classe->nom}} <b>|</b> {{$classe->nbRemainingStudents}} places restantes</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <h3>Étudiants</h3>
                                    <table class="table table-striped table-hover" id="tableauStudents">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nom</th>
                                                <th scope="col">Prenom</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($studentsWC as $student)
                                            <tr>
                                                <td> {{$student->nomEtudiant}}</td>
                                                <td> {{$student->prenomEtudiant}}</td>
                                                <td><input type="checkbox" name="students[]" value="{{$student->id}}" id="studentsWC-{{$student->id}}" class="studentsWC"></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                <button onclick="this.disabled=true; this.form.submit();" id="inscriptionStudentsToClass" type="submit" class="btn btn-primary">Créer</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <!-- FIN Modal pour créer une attribution StudentToClass -->

        <!-- Modal pour créer une attribution ClassToGroup -->

        <div class="modal fade bd-example-modal-lg " id="attrClassGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Attribution de classes à un groupe</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @if(count($classesWG) == 0)
                    <div class="modal-body">
                        <div class="alert alert-secondary" role="alert">
                            <h4 class="alert-heading">Info :</h4>
                            <p>Toutes les classes ont déjà été attribuées à un groupe.</p>
                            <hr>
                            <p class="mb-0">Supprimez une attribution afin de pouvoir créer une autre attribution.</p>
                        </div>
                    </div>
                    @else
                    <form action="attributions/classes_to_group/" method="post">
                        <div class="modal-body">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <h3>Groupes</h3>
                                <select class="form-control" name="group">
                                    @foreach ($groupes as $group)
                                    <option value="{{$group->id}}">{{$group->nom}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <h3>Classes</h3>
                                <table class="table table-striped table-hover" id="tableauClasses">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nom</th>
                                            <th scope="col">Nombre maximum d'étudiants</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($classesWG as $class)
                                        <tr>
                                            <td> {{$class->nom}}</td>
                                            <td> {{$class->max_eleves }}</td>
                                            <td><input type="checkbox" name="classes[]" value="{{$class->id}}" id="classesWG-{{$class->id}}"></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button onclick="this.disabled=true; this.form.submit();" id="inscriptionGroupeToClasses" type="submit" class="btn btn-primary">Créer</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        <!-- FIN Modal pour créer une attribution ClassToGroup -->  

        <nav class="nav nav-tabs">
            <a class="nav-item nav-link active" href="#classesToProf" data-toggle="tab">Classes / Professeurs</a>
            <a class="nav-item nav-link " href="#classesToStud" data-toggle="tab">Étudiants / Classes</a>
            <a class="nav-item nav-link " href="#groupesToClasse" data-toggle="tab">Classes / Groupes</a>            
        </nav>
        <div class="tab-content">
            <div class="tab-pane active" id="classesToProf">
                <table class="table table-striped table-hover" id="classes_To_Prof">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Classes</th>
                            <th scope="col">Professeurs</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($profToClasses as $profToClasse)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td id="{{$profToClasse->classe_id}} ">{{$profToClasse->classe_nom}}</td>
                            <td id="{{$profToClasse->teacher_id}}">{{$profToClasse->teacher_nom}} {{$profToClasse->teacher_prenom}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="javascript:void(0)" class="btn btn-outline-danger deletebtnClassProf"> 🗑 </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="classesToStud">
                <table class="table table-striped table-hover" id="classes_To_Stud">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Classes</th>
                            <th scope="col">Étudiants</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td id="{{$student->classe_id}}">{{$student->classe_nom}}</td>
                            <td id="{{$student->id}}">{{$student->nomEtudiant}} {{$student->prenomEtudiant}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="javascript:void(0)" class="btn btn-outline-danger deletebtnClassStud"> 🗑 </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="groupesToClasse">
                <table class="table table-striped table-hover" id="groupes_To_Classe">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Groupes</th>
                            <th scope="col">Classes</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classesWithG as $classeWithG)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td id="{{$classeWithG->groupe_id}}">{{$classeWithG->groupe_nom}}</td>
                            <td id="{{$classeWithG->id}}"> {{$classeWithG->nom}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="javascript:void(0)" class="btn btn-outline-danger deletebtnGroupClass"> 🗑 </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour supprimer une attribution prof classe -->
<div class="modal fade" id="modalDeleteTeacher" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel">Supprimer une Attribution</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="delete_modal_form" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <div class="modal-body">
                    <h4>Êtes-vous sûr de vouloir supprimer l'attribution ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Oui, je suis sûr !</button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- FIN Modal pour supprimer une classe -->

<!-- Modal pour supprimer une attribution stud  classe -->
<div class="modal fade" id="modalDeleteStud" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel">Supprimer une Attribution</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="delete_stud" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="modal-body">
                    <h4>Êtes-vous sûr de vouloir supprimer l'attribution ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Oui, je suis sûr !</button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- FIN Modal pour supprimer un étudiant d'une classe -->

<!-- Modal pour supprimer une attribution stud  classe -->
<div class="modal fade" id="modalDeleteClass" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel">Supprimer une Attribution</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="delete_class" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="modal-body">
                    <h4>Êtes-vous sûr de vouloir supprimer l'attribution ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Oui, je suis sûr !</button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- FIN Modal pour supprimer un étudiant d'une classe -->

<script>
    $(document).ready(function() {

        $('#tableauProfClasses').DataTable();
        $('#classes_To_Stud').DataTable();
        $('#tableauStudents').DataTable();
        $('#classes_To_Prof').DataTable();
        $('#tableauClasses').DataTable();
        $('#groupes_To_Classe').DataTable();
        $('#classes_To_Prof').on('click', '.deletebtnClassProf', function() {
            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).attr('id');
            }).get();

            $('#delete_modal_form').attr('action', '/attributions/teacher_to_class/delete/' + data[0] + '/' + data[1]);

            $('#modalDeleteTeacher').modal('show');
        });
        $('#classes_To_Stud').on('click', '.deletebtnClassStud', function() {
            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).attr('id');
            }).get();

            $('#delete_stud').attr('action', '/attributions/student_to_class/delete/' + data[1]);

            $('#modalDeleteStud').modal('show');
        });
        $('#groupes_To_Classe').on('click', '.deletebtnGroupClass', function() {
            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).attr('id');
            }).get();

            $('#delete_class').attr('action', '/attributions/classes_to_group/delete/' + data[1]);

            $('#modalDeleteClass').modal('show');

            
        });
        $('select.classe').on('change', function() {
            let nbReamainingStudents = $('select.classe').children("option:selected").attr('id');
            var nbCheckedStudents=$('input[name="students[]"]:checked').length;
            if (nbCheckedStudents > nbReamainingStudents){
                $('input[name="students[]"]:checked').prop("checked", false);
            }
        });
        $('.studentsWC').click(function () {
            let nbReamainingStudents = $('select.classe').children("option:selected").attr('id');
            var nbCheckedStudents=$('input[name="students[]"]:checked').length;
            if (nbCheckedStudents > nbReamainingStudents){
                alert("Vous avez atteint la limite de la classe!");
                $(this).prop("checked", false);
            }


        });
    });
</script>




@endsection