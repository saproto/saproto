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
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#loginModal">
            <i class="fa fa-unlock-alt"></i>
        </button>
    </form>
@endif