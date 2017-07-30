<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/feed') }}">
                {{ config('app.name', 'Lifecanvas') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            @if (Auth::check())
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Bytes<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/bytes/create">Add Byte</a></li>
                        <li><a href="/bytes">My Bytes</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Lines<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/lines/create">Add Lifeline</a></li>
                        <li><a href="/lines">My Lifelines</a></li>
                        <li role="separator" class="divider"></li>
                        @foreach($mylines as $myline)
                            <li><a href="/lines/{{ $myline->id }}">{{ $myline->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">People<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/people/create">Add Person</a></li>
                        <li><a href="/people">My People</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Places<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/places/create">Add Place</a></li>
                        <li><a href="/places">My Places</a></li>
                    </ul>
                </li>
            </ul>
            @endif

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ route('signin') }}">Sign In</a></li>
                    <li><a href="{{ route('signup') }}">Sign Up</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->username }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="/profiles">Profile</a></li>
                            <li>
                                <a href="{{ route('signout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Sign Out
                                </a>
                                <form id="logout-form" action="{{ route('signout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
