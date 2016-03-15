<nav class="navbar navbar-inverse navbar-top">
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
            <a class="navbar-brand" href="{{ route('homepage') }}">{{ config("association.name") }}</a>
        </div>

        <!--
            The actual navbar contents with links to pages and tools and shit.
        //-->
        <ul class="nav navbar-nav navbar-right">
            @if (Auth::check() && Auth::user()->can("board"))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Administration <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route("user::member::list") }}">User Administration</a></li>
                    </ul>
                </li>
            @endif

            @if (Auth::check())
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('user::dashboard') }}">My Dashboard</a></li>
                        <li><a href="{{ route('user::profile') }}">My Profile</a></li>

                        @if (Session::has('impersonator'))
                            <li><a href="{{ route('user::quitimpersonating') }}">Quit Impersonation</a></li>
                        @else
                            <li><a href="{{ route('login::logout') }}">Logout</a></li>
                        @endif
                    </ul>
                </li>
            @else
                <form class="navbar-form navbar-right">
                    <a class="btn btn-success" href="{{ route('login::show') }}">
                        <i class="fa fa-unlock-alt"></i>
                    </a>
                </form>
            @endif
        </ul>

    </div>
</nav>