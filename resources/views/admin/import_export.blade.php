@extends('layouts.master')
@section('title','Import / Export')
@section('content')

<div class="row">
    <div class="col emp-profile" style="margin: 2%;">
        <h1>Import / Export</h1>
        @if(count($errors) > 0)
        <div class="alert alert-danger">
            Upload Validation Error<br><br>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
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
                <div class="col-6">
                </div>
            </div>
            <nav class="nav nav-tabs">
                <a class="nav-item nav-link active" href="#etudiants" data-toggle="tab">Étudiants</a>
                <a class="nav-item nav-link " href="#professeurs" data-toggle="tab">Professeurs</a>  
                <a class="nav-item nav-link " href="#paiements" data-toggle="tab">Paiements</a>       
            </nav>
            <div class="tab-content">
                <div class="tab-pane active" id="etudiants">
                <br>   
                    <form method="post" enctype="multipart/form-data" action="{{ url('/import_students/import') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <table class="table">
                                <tr>
                                    <td width="40%" align="right"></td>
                                    <td width="30"></td>
                                    <td width="30%" align="left">
                                        <a class="btn btn-warning" href="{{ url('/import_students/export') }}">Export</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="40%" align="right"><label>Selectionnez un fichier à importer :</label></td>
                                    <td width="30">
                                        <input type="file" name="select_file" />
                                        <span class="text-muted">Fichiers acceptés : .xls, .xslx</span>
                                    </td>
                                    <td width="30%" align="left">
                                        <input type="submit" name="upload" class="btn btn-primary" value="Import">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="professeurs">
                    <br>
                    <form method="post" enctype="multipart/form-data" action="{{ url('/import_teachers/import') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <table class="table">
                                <tr>
                                    <td width="40%" align="right"></td>
                                    <td width="30"></td>
                                    <td width="30%" align="left">
                                        <a class="btn btn-warning" href="{{ url('/import_teachers/export') }}">Export</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="40%" align="right"><label>Selectionnez un fichier à importer :</label></td>
                                    <td width="30">
                                        <input type="file" name="select_file" />
                                        <span class="text-muted">Fichiers acceptés : .xls, .xslx</span>
                                    </td>
                                    <td width="30%" align="left">
                                        <input type="submit" name="upload" class="btn btn-primary" value="Import">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="paiements">
                    <br>
                    <div class="form-group">
                        <table class="table">
                            <tr>
                                <td width="40%" align="right"></td>
                                <td width="30"></td>
                                <td width="30%" align="left">
                                    <a class="btn btn-warning" href="{{ url('/paiement/export') }}">Export</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






@endsection
