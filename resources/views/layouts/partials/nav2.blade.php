<nav class="navbar navbar-expand-md  navbar-static ms-navbar ms-navbar-white navbar-mode">
    <div class="container container-full">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url('/feed') }}">
                <img src="/assets/img/logos/logo_header.png" height="36px">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="ms-navbar">
            <ul class="navbar-nav">
            @if (Auth::check())
                <li class="nav-item dropdown {{ Request::is('bytes/create') ? "active" : "" }}">
                    <a href="/bytes/create" class="nav-link dropdown-toggle animated fadeIn animation-delay-9" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-name="add">Add Byte <i class="zmdi zmdi-plus"></i></a>
                </li>
                <li class="nav-item dropdown {{ Request::is('bytes') ? "active" : "" }}">
                    <a href="/bytes" class="nav-link dropdown-toggle animated fadeIn animation-delay-9" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-name="add">Bytes <i class="icon-byte-icon2"></i></a>
                </li>
                <li class="nav-item dropdown {{ Request::is('lines*') ? "active" : "" }}">
                    <a href="#" class="nav-link dropdown-toggle animated fadeIn animation-delay-9" data-toggle="dropdown" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-name="lines">Lines
                        <i class="zmdi zmdi-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="/lines/create">Add Lifeline</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/lines">My Lifelines</a>
                        </li>
                        <li class="dropdown-divider"></li>
                        @foreach($mylines as $myline)
                            <li><a class="dropdown-item" href="/lines/{{ $myline->id }}">{{ $myline->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item dropdown {{ Request::is('people*') ? "active" : "" }}">
                    <a href="#" class="nav-link dropdown-toggle animated fadeIn animation-delay-9" data-toggle="dropdown" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-name="people">People
                        <i class="zmdi zmdi-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="/people/create">Add Person</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/people">My People</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown {{ Request::is('places*') ? "active" : "" }}">
                    <a href="#" class="nav-link dropdown-toggle animated fadeIn animation-delay-9" data-toggle="dropdown" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-name="places">Places
                        <i class="zmdi zmdi-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="/places/create">Add Place</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/places">My Places</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/map">Byte Map</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown {{ Request::is('profile*') ? "active" : "" }}">
                    <a href="#" class="nav-link dropdown-toggle animated fadeIn animation-delay-9" data-toggle="dropdown" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-name="account">Account
                        <i class="zmdi zmdi-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/{{ Auth::user()->username }}">Profile</a></li>
                        <li><a class="dropdown-item" href="/{{ Auth::user()->username }}/edit">Update Profile</a></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>

                    </ul>
                </li>
            @else
                <li class="nav-item dropdown {{ Request::is('login*') ? "active" : "" }}">
                    <a href="{{ route('login') }}" class="nav-link dropdown-toggle animated fadeIn animation-delay-9" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-name="login">Login</a>
                </li>
                <li class="nav-item dropdown {{ Request::is('register*') ? "active" : "" }}">
                    <a href="{{ route('register') }}" class="nav-link dropdown-toggle animated fadeIn animation-delay-9" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-name="register">Register</a>
                </li>
            @endif
            </ul>
        </div>
        <a href="javascript:void(0)" class="ms-toggle-left btn-navbar-menu">
            <i class="zmdi zmdi-menu"></i>
        </a>
    </div>
    <!-- container -->
</nav>