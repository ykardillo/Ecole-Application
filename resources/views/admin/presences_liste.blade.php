@extends('layouts.master')

@section('title')
Présences
@endsection

@section('pageTitle')
Présences
@endsection

{{-- {{dd($presences  ?? '')}} --}}
@section('content')
<div class="row ">
    <div class="col emp-profile" style="margin: 2%;">
        <h1>Présences</h1>


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
                <a href="/presences/calendar"  class="btn btn-primary">Prendre les présences</a>

            </div>
        </div>

        <table class="table table-striped table-hover" id="tableau">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Classe</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($presences as $presence)
                <tr id="{{$presence->date_start}}_{{$presence->classe_id}}">
                    <th scope="row" value="{{ $loop->iteration }}">{{ $loop->iteration }}</th>
                    <td id="{{$presence->date_start}}">{{$presence->date_start}}</td>
                    <td id="{{$presence->classe_id}}">{{$presence->classe_nom}}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="/presences/info/{{$presence->classe_id}}/{{$presence->date_start}}/{{$presence->date_end}}" style="margin-right:10%; margin-left:10%; padding-right:1em;padding-left:1em;" class="btn btn-outline-success">🡆</a>
                            <a href="javascript:void(0)" class="btn btn-outline-danger deletebtn"> 🗑 </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal DELETE -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel">Supprimer une Présence</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="delete_modal_form" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <div class="modal-body">
                    <h4>Êtes-vous sûr de vouloir supprimer la présence ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button onclick="this.disabled=true; this.form.submit();" type="submit" class="btn btn-primary">Oui, je suis sûr !</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#tableau').DataTable();

        $('#tableau').on('click', '.deletebtn', function() {
            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).attr('id');
            }).get();

            $('#delete_modal_form').attr('action', '/presences/delete/' + data[0] + '/' + data[1]);

            $('#modalDelete').modal('show');
        });

    });
</script>

@endsection
