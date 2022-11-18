<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ItaIngressos') }}</title>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/forms.css') }}" rel="stylesheet">
    <link href="{{ asset('css/panel.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"
        integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/js/masks.js"></script>
    <script src="/js/functions.js"></script>
    <script src="/js/events.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        #logo {
            width: 14rem;
        }

        .login a {
            color: black;
            font-size: 1rem;
        }
        .login{
            display: flex;
        }
        .login form input{
            margin-left: 10px;
            background-color: unset;
            border: unset;
            color: rgb(207, 1, 1)
        }
        .navbar{
            display: flex;
            justify-content: space-between;
            padding: 20px 3rem;
        }
        .options{
            display: flex;
            column-gap: 3rem;
            font-size: 1rem;
            font-weight: 600;
        }
        .options svg{
            color: #286bcf;
        }
        .options > div{
            cursor: pointer;
        }
        .options > div{
            position: relative;
        }
        .options > div > div{
            position: absolute;
            background-color: #0a3f8f;
            width: 41rem;
            padding: 3rem 2rem;
            left: -6rem;
            top: 2rem;
            /* display: none; */
            opacity: 0;
            z-index: 1;

        }

        .options > div span{
            padding: 2rem 0;
        }
        .options > div label{
            color: white;
            margin-bottom: 10px;
        }
        #opt-search:hover .modalSearch, .modalSearch:hover .modalSearch{
            opacity: 1;
            transition: opacity .3s linear;

        }
    </style>
</head>

<body>
    @include('sweetalert::alert')

    @php
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    @endphp
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            {{-- <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img id="logo" src="{{ asset('img/logo.png') }}" alt="" width="15rem">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="options">
                        <div>
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span>Buscar</span>
                        </div>
                    </div>
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        <div class="login">
                            @if (Auth::check())
                                <a href="/organizer/panel"><i class="fa-solid fa-user"></i> Seu painel</a>
                                <form action="{{route('logout')}}" method="post">
                                    @csrf
                                    <input type="submit" value="sair">
                                </form>
                            @else
                                <a href="/organizer/panel"></i>Área do administrador</a>
                            @endif
                        </div>


                    </ul>
                </div>
            </div> --}}
            {{-- teste --}}
            <header>
                <picture>
                    <a href="/">
                        <img width="220px" src="{{asset('img/logo.png')}}" alt="">
                    </a>
                </picture>
            </header>

            <div class="login">
                @if (Auth::check())
                    <a href="/organizer/panel"><i class="fa-solid fa-user"></i> Seu painel</a>
                    <form action="{{route('logout')}}" method="post">
                        @csrf
                        <input type="submit" value="sair">
                    </form>
                @else
                    <a href="/organizer/panel"></i>Área do administrador</a>
                @endif
            </div>

        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <div class="col-md-4 d-flex align-items-center">
                <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                    <svg class="bi" width="30" height="24">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                </a>
                <span class="mb-3 mb-md-0 text-muted">© 2022 {{ config('app.name') }}</span>
            </div>

            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                {{-- <li class="ms-3"><a class="text-muted" href="#"><i class="fa-brands fa-facebook"></i></a></li>
                <li class="ms-3"><a class="text-muted" href="#"><i class="fa-brands fa-instagram"></i></a></li> --}}
                <li class="ms-3"><a target="_blank" class="text-muted"
                        href="https://wa.me/5585989397098?text=Ol%C3%A1%2C+preciso+de+ajuda+para+comprar+no+Itaingressos%21"><i
                            class="fa-brands fa-whatsapp"></i></a></li>
            </ul>
        </footer>
    </div>
</body>

</html>
