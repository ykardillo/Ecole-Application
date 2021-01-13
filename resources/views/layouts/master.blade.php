<!DOCTYPE html>

<title>
  @yield('title')
</title>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  @yield('style')
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">


  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


  <!-- CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/css/layoutStyle.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">


  <!-- CSS Files Full Calendar -->
  <link rel="stylesheet" href="{{ asset('assets/css/fullcalendar.css') }}">


  <!--   Core JS Files   -->
  <script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/scrollTableBody.js') }}"></script>



  <!-- DataTables JS -->
  <script src="{{ asset('assets/js/dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>


  <!--  Notifications Plugin    -->
  <script src="{{ asset('assets/js/plugins/bootstrap-notify.js') }}"></script>

  <!-- AutoCompet Localsiation JS -->
  <script src="{{ asset('assets/js/core/places.js') }}"></script>


  <!-- FullCalendar JS -->
  <script src="{{ asset('assets/js/moment.min.js') }}" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
  <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
  <script src="{{ asset('assets/js/fullcalendar_locales-all.min.js') }}"></script>

  


</head>

<body>

  <header>
    <!--Navbar blue-->
    <nav class="mb-4 navbar navbar-expand-lg navbar-dark unique-color-dark">
      <a class="navbar-brand" href="{{ url('/home') }}">École</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        @guest
        @if (Route::has('register'))
        @endif
        @else
        @if (Auth::user()->usertype == "admin")
        <ul class="navbar-nav mr-auto">
          <li class="nav-item {{ strpos(request()->path(), 'students') === 0 ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('students') }}">Étudiants</a>
          </li>
          <!-- <li class="nav-item {{ strpos(request()->path(), 'teachers') === 0 ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('teachers') }}">Professeurs</a>
          </li> -->
          <li class="nav-item {{ strpos(request()->path(), 'classes') === 0 ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('classes') }}">Classes</a>
          </li>
          <li class="nav-item {{ strpos(request()->path(), 'presences') === 0 ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('presences') }}">Présences</a>
          </li>
          <li class="nav-item {{ strpos(request()->path(), 'interrogation') === 0 ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('interrogations') }}">Interrogations</a>
          </li>
          <li class="nav-item {{ strpos(request()->path(), 'horaire') === 0 ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('horaire/0') }}">Horaires</a>
          </li>
          <li class="nav-item {{ strpos(request()->path(), 'paiement') === 0 ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('paiement') }}">Paiements</a>
          </li>
        </ul>

        @endif
        @if (Auth::user()->usertype == "teacher")
        <ul class="navbar-nav mr-auto">
          <li class="nav-item {{ strpos(request()->path(), 'presences') === 0 ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('presences') }}">Présences</a>
          </li>
          <li class="nav-item {{ strpos(request()->path(), 'interrogation') === 0 ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('interrogations') }}">Interrogations</a>
          </li>
        </ul>
        @endif
        @endguest
        <ul class="float-right navbar-nav ml-auto nav-flex-icons mr-3">
          @guest
          <li class="nav-item active">
            <a class="nav-link" href="{{ route('login') }}">{{ __('Connexion') }}</a>
          </li>
          @if (Route::has('register'))
          <li class="nav-item active">
            <a class="nav-link" href="{{ route('register') }}">{{ __('S\'enregistrer') }}</a>
          </li>
          @endif
          @else
          <li class="nav-item dropdown active">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              {{ucfirst(Auth::user()->name)}} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              @if (Auth::user()->usertype == "admin")
              <a class="dropdown-item" href="/users">
                {{ __('Gestion des utilisateurs') }}
              </a>
              <a class="dropdown-item" href="/attributions">
                {{ __('Gestion des attributions') }}
              </a>
              <a class="dropdown-item" href="/gestion_horaires">
                {{ __('Gestion des horaires') }}
              </a>
              <a class="dropdown-item" href="/matieres">
                {{ __('Gestion des matières') }}
              </a>
              <a class="dropdown-item" href="/import_export">
                {{ __('Import/Export') }}
              </a>
              <div class="dropdown-divider"></div>
              @endif
              <a id="deconnexion" class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                {{ __('Déconnexion') }}
                <span class="glyphicon glyphicon-log-out pull-right"></span>
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </li>
          @endguest
        </ul>
      </div>
    </nav>

  </header>

  <main class="overflow-hidden">
    @yield('content')
  </main>

  @yield('scripts')

</body>





</html>
