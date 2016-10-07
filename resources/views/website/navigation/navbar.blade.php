<nav id="nav" class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
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

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav navbar-right">
                @foreach($menuItems as $menuItem)

                    @if(!$menuItem->is_member_only || (Auth::check() && Auth::user()->member()))

                        @if($menuItem->children->count() > 0)

                            <li class="dropdown">
                                <a href="{{ $menuItem->getUrl()  }}" class="dropdown-toggle" data-toggle="dropdown"
                                   role="button" aria-haspopup="true"
                                   aria-expanded="false">{{ $menuItem->menuname }} <span class="caret"></span></a>
                                <ul class="dropdown-menu">

                                    @foreach($menuItem->children->sortBy('order') as $childItem)
                                        @if(!$childItem->is_member_only || (Auth::check() && Auth::user()->member()))
                                            <li><a href="{{ $childItem->getUrl()  }}">{{ $childItem->menuname }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                </ul>
                            </li>

                        @else

                            <li>
                                <a href="{{ $menuItem->getUrl() }}" role="button" aria-haspopup="false"
                                   aria-expanded="false">{{ $menuItem->menuname }}</a>
                            </li>

                        @endif

                    @endif

                @endforeach

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Association <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route("page::show", ["slug" => "board"]) }}">Board</a></li>
                        <li><a href="{{ route("committee::list") }}">Committees</a></li>
                        <li><a href="{{ route("event::list") }}">Calendar</a></li>
                        <li><a href="{{ route("photo::albums") }}">Photos</a></li>
                        <li><a href="{{ route("protube.nl::remote") }}">ProTube</a></li>
                        @if (Auth::check() && Auth::user()->member)
                            <li><a href="{{ route("quotes::list") }}">Quote Corner</a></li>
                        @endif
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Career <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route("companies::index") }}">Companies</a></li>
                    </ul>
                </li>

                @if (Auth::check() && Auth::user()->can(["omnomcom","pilscie"]))
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">OmNomCom <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route("omnomcom::store::show") }}">Application</a></li>
                            @if (Auth::check() && Auth::user()->can("omnomcom"))
                                <li role="separator" class="divider"></li>
                                <li><a class="navbar-title">Administration:</a></li>
                                <li><a href="{{ route("omnomcom::orders::adminlist") }}">Orders</a></li>
                                <li><a href="{{ route("omnomcom::products::list") }}">Products</a></li>
                                <li><a href="{{ route("omnomcom::categories::list") }}">Categories</a></li>
                                <li><a href="{{ route("omnomcom::generateorder") }}">Generate Supplier Order</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if (Auth::check() && Auth::user()->can("board"))
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Administration <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a class="navbar-title">Association:</a></li>
                            <li><a href="{{ route("user::member::list") }}">Users</a></li>
                            <li><a href="{{ route("study::list") }}">Studies</a></li>
                            <li><a href="{{ route("protube::admin") }}">ProTube Admin</a></li>
                            <li><a href="{{ route("committee::add") }}">Add Committee</a></li>
                            <li><a href="{{ route("event::add") }}">Add Event</a></li>

                            <li role="separator" class="divider"></li>

                            <li><a class="navbar-title">Website:</a></li>
                            <li><a href="{{ route("menu::list") }}">Menu</a></li>
                            <li><a href="{{ route("page::list") }}">Pages</a></li>
                            <li><a href="{{ route("email::admin") }}">Email</a></li>
                            <li><a href="{{ route("achievement::list") }}">Achievements</a></li>
                            <li><a href="{{ route("welcomeMessages::list") }}">Welcome Messages</a></li>

                            @if(Auth::user()->can('admin'))
                                <li><a href="{{ route("alias::index") }}">Aliases</a></li>
                                <li><a href="{{ route("authorization::overview") }}">Authorization</a></li>
                            @endif

                            <li role="separator" class="divider"></li>

                            <li><a class="navbar-title">External Affairs:</a></li>
                            <li><a href="{{ route("narrowcasting::list") }}">Narrowcasting</a></li>
                            <li><a href="{{ route("companies::admin") }}">Companies</a></li>

                            <li role="separator" class="divider"></li>

                            <li><a class="navbar-title">Internal Affairs:</a></li>
                            <li><a href="{{ route("pastries::list") }}">Pastries</a></li>

                            @if (Auth::user()->can("finadmin"))
                                <li role="separator" class="divider"></li>
                                <li><a class="navbar-title">Financial:</a></li>
                                <li><a href="{{ route("omnomcom::accounts::list") }}">Accounts</a></li>
                                <li><a href="{{ route("event::financial::list") }}">Activities</a></li>
                                <li><a href="{{ route("omnomcom::withdrawal::list") }}">Withdrawals</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                <li>
                    <a href="{{ route('search') }}">Search</a>
                </li>

                @if (Auth::check())

                    @if(Auth::user()->isTempadmin())
                        <li>
                            <a href="{{ route("protube::admin") }}" role="button" aria-haspopup="false"
                               aria-expanded="false">ProTube Admin</a>
                        </li>
                    @endif

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('user::dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ route('omnomcom::orders::list') }}">Purchase History</a></li>

                            @if(Auth::check() && Auth::user()->member)
                                <li><a href="{{ route('user::profile') }}">My Profile</a></li>
                                <li><a href="{{ route('print::form') }}">Print Something</a></li>
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
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
