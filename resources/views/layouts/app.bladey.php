<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield('title')</title>

    <!-- Scripts -->
    {{--jquery--}}
        <script src="//code.jquery.com/jquery.js"></script>
        {{--bootstrap--}}
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        {{--datatable--}}
        <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
       
        {{--scripts propre à la page- devant être dans le head--}}
        @stack('js-head')
    <!-- Styles -->

      {{-- bootstrap--}}
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        
        {{--datatable--}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

        {{--styles propres à la page--}}
        @yield('css')
</head>

{{--Bar de navigation--}}

<nav class="navbar navbar-expand-md navbar navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('index')}}">
            {{ config('app.name') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                        <a class="nav-link" href={{route('fo_categorie_index')}}>{{__('Catégories')}}</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link" href="{{route('fo_produit_index')}}">@lang('Produits')</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link" href="#">@lang('Enchères')</a>
                </li>
                
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
            @auth
                    @can('administrer')
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('bo_home')}}">@lang('Accueil')</a>
                        </li>
                        <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            @lang('Administrer')
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('user_create')}}">
                                @lang('Ajouter un admin')
                            </a>
                            <a class="dropdown-item"  href={{route('categorie_index')}} >Catégories</a>
                            <a class="dropdown-item"  href={{route('produit_index')}} >Produits</a>
                            <a class="dropdown-item"  href={{route('enchere_index')}} >Enchere</a> 

                        </div>
                    </li>
                    @endcan
                     <li class="nav-item">
                        <a class="nav-link" href="{{route('user_show',['user'=>Auth::id()])}}">@lang('Mes informations')</a>
                    </li>
                @endauth

            <!----------- -->
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">@lang('Se connecter')</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">@lang("S'enregistrer")</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->login }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                @lang('Déconnexion')
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
{{--contenu--}}
<body> 
{{--Messages--}}

    {{-- messages d'erreurs pour le création--}}
    @yield('errors_messages')

    {{--messages de succès--}}
     @yield('success_msessages')

    {{--contenues principal de la page--}}
    <main class="py-4">
        @yield('content')
    </main>

    {{--les scripts à ajouter au bas de la page--}}
    @stack('js-bottom')
</body>
<footer>
    @yield('footer')
</footer>
</html>
