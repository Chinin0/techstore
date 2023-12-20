<style>
    .bg-custom {
        background-color: #007c00;
    }

    .contador {
        pointer-events: none;
    }

</style>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-custom shadow-sm">
    <div class="container">
        <div id="sfcuyh48d39a8rrz2axadeahl15mw3ct9eu" class="contador"></div><script type="text/javascript" src="https://counter7.optistats.ovh/private/counter.js?c=uyh48d39a8rrz2axadeahl15mw3ct9eu&down=async" async></script><noscript><a href="https://www.contadorvisitasgratis.com" title="contador para pagina web"><img src="https://counter7.optistats.ovh/private/contadorvisitasgratis.php?c=uyh48d39a8rrz2axadeahl15mw3ct9eu" border="0" title="contador para pagina web" alt="contador para pagina web"></a></noscript>
        <div class="navbar-brand">
            <img src="{{ asset('img/logo.png') }}" alt="Logo de la Empresa" height="50">
        </div>
        <a class="navbar-brand" href="{{ url('/') }}">
            TECH STORE GIP TIENDA
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{route('listaPagos')}}">Pagos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('compras') }}">Compras</a>
                </li>
                @if(Auth::check() && (Auth::user()->hasRole('root') || Auth::user()->hasRole('personal')))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}"><b>Backoffice</b></a>
                    </li>
                @endif

                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle"
                       href="#" role="button" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false"
                    >
                        <span class="badge badge-pill badge-dark">
                            <i class="fa fa-shopping-cart"></i> {{ \Cart::session(auth()->id())->getTotalQuantity()}}
                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="width: 450px; padding: 0px; border-color: #9DA0A2">
                        <ul class="list-group" style="margin: 20px;">
                            @include('carrito.partials.cart-drop')
                        </ul>

                    </div>
                </li>
                @auth
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            ¡Hola, {{ Auth::user()->name }}!
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
                
            </ul>
        </div>
    </div>
</nav>

