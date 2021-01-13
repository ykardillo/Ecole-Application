@extends('layouts.master')
@section('title','Inscripion Étudiant eID')
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
    <form action="/students/add/eid" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="row">
            <div class="col-md-4">
                <div class="profile-img ">
                    <img src="{{ asset('assets/images/ic_user.png') }}" width="50" height="50">
                </div>
            </div>
            <div class="col-md-6">
                             <button type="button" class="btn float-right" data-toggle="modal" data-target="#afficherAide"><img src="{{ asset('assets/images/ic_information.png') }}" width="50" height="50"></button>

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

                    <!--------------------------------------------------------------------------->
                    <div class="tab-pane fade show active" id="eid" role="tabpanel" aria-labelledby="eid-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Parent</label>
                            </div>
                            <div class="col-md-6">
                                <textarea class="form-control" placeholder="Glissez la photo du parent ici..." value="{{ session('eidParent') }}" name="eidParent" required rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Etudiant </label>
                            </div>
                            <div class="col-md-6">
                                <textarea class="form-control" placeholder="Glissez la photo de l'étudiant ici..." value="{{ session('eidEtudiant') }}" name="eidEtudiant" required rows="3"></textarea>

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
                    <!------------------------------------------------------------------->

                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal pour pour afficher aide -->
<div class="modal fade" id="afficherAide" tabindex="-1" role="dialog" aria-labelledby="aide" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aide">Aide : Inscription étudiant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>
                        <p>Lancez le logiciel eID Viewer que vous trouverez <a href="https://eid.belgium.be/sites/default/files/software/belgium_eid_viewer_installer_4.4.23.4246.exe">ici</a> *.</p>
                    </li>
                    <li>
                        <p>Introduisez la carte d'identité dans le lecteur de carte</p>
                    </li>
                    <li>
                        <p>Glissez la photo dans l'un des champs </p>
                    </li>
                </ul>
            </div>
            <div class="modal-footer" style="word-break: break-all;">
                <div>
                    <p>* <a href="https://eid.belgium.be/sites/default/files/software/belgium_eid_viewer_installer_4.4.23.4246.exe">https://eid.belgium.be/sites/default/files/software/belgium_eid_viewer_installer_4.4.23.4246.exe</a> </p>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- FIN Modal pour afficher aide -->


@endsection

@section('scripts')
<script>

</script>
@endsection
