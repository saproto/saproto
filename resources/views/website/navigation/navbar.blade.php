<nav id="navbar" class="navbar navbar-default navbar-fixed-top">
    <div class="container">

        <!--
            Navbar header. The part where the icon and name and shit is.
        //-->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('homepage') }}">Study Association Proto</a>
        </div>

        <!--
            The actual navbar contents with links to pages and tools and shit.
        //-->
        <ul class="nav navbar-nav navbar-right">

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                   aria-expanded="false">Association <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route("committee::list") }}">Committees</a></li>
                    <li><a href="{{ route("event::list") }}">Calendar</a></li>
                    @if (Auth::check() && Auth::user()->member)
                        <li><a href="{{ route("quotes::list") }}">Quote Corner</a></li>
                    @endif
                </ul>
            </li>

            @if (Auth::check() && Auth::user()->can("board"))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Administration <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a class="navbar-title">Administration:</a></li>
                        <li><a href="{{ route("user::member::list") }}">Users</a></li>
                        <li><a href="{{ route("study::list") }}">Studies</a></li>
                        <li><a href="{{ route("narrowcasting::list") }}">Narrowcasting</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a class="navbar-title">Create new:</a></li>
                        <li><a href="{{ route("committee::add") }}">Committee</a></li>
                        <li><a href="{{ route("event::add") }}">Event</a></li>
                    </ul>
                </li>
            @endif

            @if (Auth::check())
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('user::dashboard') }}">My Dashboard</a></li>

                        @if(Auth::check() && Auth::user()->member)
                            <li><a href="{{ route('user::profile') }}">My Profile</a></li>
                        @endif

                        @if (Session::has('impersonator'))
                            <li><a href="{{ route('user::quitimpersonating') }}">Quit Impersonation</a></li>
                        @else
                            <li><a href="{{ route('login::logout') }}">Logout</a></li>
                        @endif
                    </ul>
                </li>
            @else

                <li>
                    <a href="{{ route('login::register') }}">New Account</a>
                </li>

                <form class="navbar-form navbar-right">
                    <a class="btn btn-success" href="{{ route('login::show') }}">
                        LOG-IN
                    </a>
                </form>

            @endif
        </ul>

    </div>
</nav>