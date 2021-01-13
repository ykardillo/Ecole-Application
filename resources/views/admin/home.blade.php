@extends('layouts.master')

@section('title')
Home
@endsection

@section('pageTitle')
Home
@endsection


@section('content')


<div class="row">
    <div class="col emp-profile" style="margin: 2%;">
        <section class="services py-5 bg-light1 text-center">
            <div class="container">
                <div class="row">
                    @if (Auth::user()->usertype == "admin")
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <a href="{{ url('students') }}" class="text-body">
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <img src="{{ asset('assets/images/ic_student.png') }}" width="100" height="100"></br></br>
                                    <small class="text-secondary"></small>
                                    <h5>Étudiants</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- <div class="col-xs-12 col-sm-6 col-md-4">
                        <a href="{{ url('teachers') }}" class="text-body">
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <img src="{{ asset('assets/images/ic_teacher.png') }}" width="100" height="100"></br></br>
                                    <small class="text-secondary"></small>
                                    <h5>Professeurs</h5>
                                </div>
                            </div>
                        </a>
                    </div> -->
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <a href="{{ url('classes') }}" class="text-body">
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <img src="{{ asset('assets/images/ic_classe.png') }}" width="100" height="100"></br></br>
                                    <small class="text-secondary"></small>
                                    <h5>Classes</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <a href="{{ url('presences') }}" class="text-body">
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <img src="{{ asset('assets/images/ic_presence.png') }}" width="100" height="100"></br></br>
                                    <small class="text-secondary"></small>
                                    <h5>Présences</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <a href="{{ url('interrogations') }}" class="text-body">
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <img src="{{ asset('assets/images/ic_test.png') }}" width="100" height="100"></br></br>
                                    <small class="text-secondary"></small>
                                    <h5>Interrogations</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <a href="{{ url('horaire/0') }}" class="text-body">
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <img src="{{ asset('assets/images/ic_horaire.png') }}" width="100" height="100"></br></br>
                                    <small class="text-secondary"></small>
                                    <h5>Horaire</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <a href="{{ url('paiement') }}" class="text-body">
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <img src="{{ asset('assets/images/ic_paiement.png') }}" width="100" height="100"></br></br>
                                    <small class="text-secondary"></small>
                                    <h5>Paiements</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    @if (Auth::user()->usertype == "teacher")
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <a href="{{ url('presences') }}" class="text-body">
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <img src="{{ asset('assets/images/ic_presence.png') }}" width="100" height="100"></br></br>
                                    <small class="text-secondary"></small>
                                    <h5>Présences</h5>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <a href="{{ url('interrogations') }}" class="text-body">
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <img src="{{ asset('assets/images/ic_test.png') }}" width="100" height="100"></br></br>
                                    <small class="text-secondary"></small>
                                    <h5>Interrogations</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                </div>
        </section>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $("#import-export").hover(function() {
        $("#a_import-export").toggle();
        $("#a2_import-export").toggle();
    });
</script>
@endsection
