<!-- Created by: Juan Sebastián Pérez Salazar and Daniel Felipe Gómez Martínez -->
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','Home Page')</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    <link href="{{ asset('css/customStyle.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm layout-navbar">
            <div class="container">
                <a class="navbar-brand logo" href="{{ route('home.index') }}">
                    <img src="{{ asset('/logos/logo_02.png') }}" alt="" loading="lazy" class="img-fluid">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <!-- Future Left Side Links -->
                        @if (!Auth::guest())
                            @if(Auth::user()->getRole()=="Customer")
                            <a class="navbar-brand" href="{{ route('customer.accessory.list') }}"> <i class="fa fa-list-ul"></i> {{ __('accessory.title_plural') }} </a>
                            <a class="navbar-brand" href="{{ route('customer.fish.list') }}"> <i class="fa fa-fish"></i> {{ __('fish.title_plural') }} </a>
                            <a class="navbar-brand" href="{{ route('customer.wishList.list') }}"> <i class="fa fa-bookmark"></i> {{ __('fish.title_wish_list') }} </a>
                            <a class="navbar-brand" href="{{ route('customer.order.list') }}"> <i class="fas fa-file-invoice"></i> {{ __('order.user.title_plural') }} </a>
                            <a class="navbar-brand" href="{{ route('customer.cart') }}"> <i class="fa fa-shopping-cart"></i> {{ __('cart.name') }} </a>
                            @endif
                            @if(Auth::user()->getRole()=="Admin")
                            <li class="navbar-brand dropdown">
                                <a class="navbar-brand dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-list-ul"></i> {{ __('profile.lists') }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="{{ route('admin.accessory.list') }}"> <i class="fa fa-list-ul"></i> {{ __('accessory.title_plural') }} </a>
                                    <a class="dropdown-item" href="{{ route('admin.fish.list') }}"> <i class="fas fa-list-ul"></i> {{ __('fish.title_plural') }} </a>
                                    <a class="dropdown-item" href="{{ route('admin.environmentalCondition.list') }}"> <i class="fa fa-list-ul"></i> {{ __('environmentalCondition_list.title_plural') }} </a>
                                    <a class="dropdown-item" href="{{ route('admin.order.list') }}"> <i class="fas fa-list-ul"></i> {{ __('order.title_plural') }} </a>
                                </div>
                            </li>
                            <li class="navbar-brand dropdown">
                                <a class="navbar-brand dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-plus"></i> {{ __('profile.create') }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="{{ route('admin.accessory.create') }}"> <i class="fa fa-plus"></i> {{ __('accessory_create.navbar_title') }} </a>
                                    <a class="dropdown-item" href="{{ route('admin.fish.create') }}"> <i class="fas fa-plus"></i> {{ __('fish_create.navbar_title') }} </a>
                                    <a class="dropdown-item" href="{{ route('admin.environmentalCondition.create') }}"> <i class="fas fa-plus"></i> {{ __('environmentalCondition_create.navbar_title') }} </a>
                                </div>
                            </li>
                            
                            
                            @endif
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Future authentication Links --> 
                        @if (!Auth::guest())
                            <a class="navbar-brand" href="{{ route('user.show') }}"> <i class="fa fa-user-circle" aria-hidden="true"></i> {{ __('profile.title') }} </a>
                        @endif
                         @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                            @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest          
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="{{ asset('js/app.js') }}" defer></script>
</html>
