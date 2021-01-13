@extends('layouts.master')

@section('title')
Présences
@endsection

@section('pageTitle')
Présences
@endsection


@section('content')
<div class="row ">
    <div class="col emp-profile" style="margin: 2%;">
        
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
        <div class="card-body">
            <div class=" d-flex justify-content-end ">
            <a href="/presences" class="btn btn-secondary mb-2"> Retour </a>
            </div>
            <div class="response"></div>
            <div id='calendar'></div>
        </div>
    </div>
</div>

<!-- Modal pour créer une présence -->

<div class="modal fade bd-example-modal-lg " id="addPresence" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if(count($classes) == 0)
            <div class="modal-body">
                <div class="alert alert-secondary" role="alert">
                    <h4 class="alert-heading">Info :</h4>
                    <p>Vous êtes attribué à aucune classe.</p>
                    <hr>
                    <p class="mb-0">Demandez à l'administrateur de l'application d'être attribué à des classes.</p>
                </div>
            </div>
            @else
                <form method="post" id="addPresenceForm">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('GET') }}
                        
                        <div class="form-group">
                            <label><b>Classe</b></label>
                            <select class="form-control" name="classe">
                                @foreach ($classes as $classe)
                                <option value="{{$classe->id}}">{{$classe->nom}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button onclick="this.disabled=true; this.form.submit();" id="inscription" type="submit" class="btn btn-primary">Suivant</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
<!-- FIN Modal pour créer une présence -->
@endsection

@section('scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">

    <script>


    $(document).ready(function () {

            var SITEURL = "{{url('/presences/')}}";
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            var calendar = $('#calendar').fullCalendar({
                monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
                monthNamesShort: ['Janv.','Févr.','Mars','Avr.','Mai','Juin','Juil.','Août','Sept.','Oct.','Nov.','Déc.'],
                dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
                dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
                firstDay:1,
                editable: true,
                height: 500,
                events: SITEURL + "/calendar",
                displayEventTime: true,
                editable: true,
                header: {
                    left: '',
                    center: 'title'
                },
                eventRender: function (event, element, view) {
                    if (event.allDay === 'true') {
                        event.allDay = true;
                    } else {
                        event.allDay = false;
                    }
                },
                selectable: true,
                selectHelper: true,
                select: function (start, end, allDay) {


                    var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                    var end = $.fullCalendar.formatDate(end, "Y-MM-DD");

                    $('#addPresenceForm').attr('action', '/presences/calendar/showStudents/' + start+'/'+end);

                    $('#titleModal').text('Présence pour le '+start);
                    $('#addPresence').modal('show');

                },

                eventDrop: function (event, delta) {
                            var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                            var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
                            $.ajax({
                                url: SITEURL + '/calendar/update',
                                data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
                                type: "POST",
                                success: function (response) {
                                    displayMessage("Updated Successfully");
                                }
                            });
                        },
                eventClick: function (event) {/*
                    var deleteMsg = confirm("Do you really want to delete?");
                    if (deleteMsg) {
                        $.ajax({
                            type: "POST",
                            url: SITEURL + '/fullcalendareventmaster/delete',
                            data: "&id=" + event.id,
                            success: function (response) {
                                if(parseInt(response) > 0) {
                                    $('#calendar').fullCalendar('removeEvents', event.id);
                                    displayMessage("Deleted Successfully");
                                }
                            }
                        });
                    }*/
                    location.href = "/calendar/show-event/"+event.id;
                }

            });
    });

    function displayMessage(message) {
        $(".response").html(""+message+"");
        setInterval(function() { $(".success").fadeOut(); }, 1000);
    }
    </script>

@endsection
