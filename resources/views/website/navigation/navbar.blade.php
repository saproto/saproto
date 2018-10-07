<nav id="nav" class="navbar fixed-top">

    <a class="navbar-brand" href="{{ route('homepage') }}">Study Association Proto</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto">
            @foreach($menuItems as $menuItem)

                @if(!$menuItem->is_member_only || (Auth::check() && Auth::user()->member()))

                    @if($menuItem->children->count() > 0)

                        <li class="nav-item dropdown">
                            <a href="{{ $menuItem->getUrl()  }}" class="nav-link dropdown-toggle" data-toggle="dropdown"
                               role="button" aria-haspopup="true"
                               aria-expanded="false">{{ $menuItem->menuname }} <span class="caret"></span></a>
                            <ul class="dropdown-menu">

                                @foreach($menuItem->children->sortBy('order') as $childItem)
                                    @if(!$childItem->is_member_only || (Auth::check() && Auth::user()->member()))
                                        <li class="dropdown-item"><a href="{{ $childItem->getUrl()  }}">{{ $childItem->menuname }}</a>
                                        </li>
                                    @endif
                                @endforeach

                            </ul>
                        </li>

                    @else

                        <li class="nav-item">
                            <a href="{{ $menuItem->getUrl() }}" role="button" aria-haspopup="false"
                               aria-expanded="false">{{ $menuItem->menuname }}</a>
                        </li>

                    @endif

                @endif

            @endforeach

            @if (Auth::check() && Auth::user()->can(["omnomcom","tipcie"]))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">OmNomCom <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="nav-item"><a href="{{ route("omnomcom::store::show") }}">Application</a></li>
                        @if (Auth::check() && Auth::user()->can("omnomcom"))
                            <li role="separator" class="divider"></li>
                            <li class="nav-item"><a class="navbar-title">Administration:</a></li>
                            <li class="nav-item"><a href="{{ route("omnomcom::orders::adminlist") }}">Orders</a></li>
                            <li class="nav-item"><a href="{{ route("omnomcom::products::list") }}">Products</a></li>
                            <li class="nav-item"><a href="{{ route("omnomcom::categories::list") }}">Categories</a></li>
                            <li class="nav-item"><a href="{{ route("omnomcom::generateorder") }}">Generate Supplier Order</a></li>
                            <li class="nav-item"><a href="{{ route("omnomcom::products::statistics") }}">Sales statistics</a></li>
                        @endif

                        <li role="separator" class="divider"></li>

                        <li class="nav-item"><a class="navbar-title">Utilities:</a></li>
                        <li class="nav-item"><a href="{{ route("omnomcom::tipcie::orderhistory") }}">TIPCie Order Overview</a></li>
                        <li class="nav-item"><a href="{{ route("passwordstore::index") }}">Password Store</a></li>
                    </ul>
                </li>
            @endif

            @if (Auth::check() && (Auth::user()->can(["board","finadmin","alfred"])))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Admin Tools <span class="caret"></span></a>
                    <ul class="dropdown-menu">

                        @if (Auth::user()->can("board"))

                            <li class="nav-item"><a href="{{ route("user::admin::list") }}">Users</a></li>
                            <li class="nav-item"><a href="{{ route("tickets::list") }}">Tickets</a></li>
                            <li class="nav-item"><a href="{{ route("protube::admin") }}">ProTube Admin</a></li>
                            <li class="nav-item"><a href="{{ route("tempadmin::index") }}">Temp Admin Admin</a></li>

                            <li role="separator" class="divider"></li>

                            <li class="nav-item"><a href="{{ route("committee::add") }}">Add Committee</a></li>
                            <li class="nav-item"><a href="{{ route("event::add") }}">Add Event</a></li>

                            <li role="separator" class="divider"></li>

                            <li class="nav-item"><a class="navbar-title">External Affairs:</a></li>
                            <li class="nav-item"><a href="{{ route("narrowcasting::list") }}">Narrowcasting</a></li>
                            <li class="nav-item"><a href="{{ route("companies::admin") }}">Companies</a></li>
                            <li class="nav-item"><a href="{{ route("joboffers::admin") }}">Job offers</a></li>

                            <li role="separator" class="divider"></li>

                            <li class="nav-item"><a class="navbar-title">Internal Affairs:</a></li>
                            <li class="nav-item"><a href="{{ route("newsletter::show") }}">Edit Newsletter</a></li>

                        @endif

                        @if (Auth::user()->can("board") && Auth::user()->can("finadmin"))

                            <li role="separator" class="divider"></li>

                        @endif

                        @if (Auth::user()->can("finadmin"))

                            <li class="nav-item"><a class="navbar-title">Financial:</a></li>
                            <li class="nav-item"><a href="{{ route("omnomcom::accounts::list") }}">Accounts</a></li>
                            <li class="nav-item"><a href="{{ route("event::financial::list") }}">Activities</a></li>
                            <li class="nav-item"><a href="{{ route("omnomcom::withdrawal::list") }}">Withdrawals</a></li>
                            <li class="nav-item"><a href="{{ route("omnomcom::unwithdrawable") }}">Unwithdrawable</a></li>
                            <li class="nav-item"><a href="{{ route("omnomcom::mollie::list") }}">Mollie Payments</a></li>

                        @endif


                        @if(Auth::user()->can(["alfred","board"]))

                            <li role="separator" class="divider"></li>

                            <li class="nav-item"><a class="navbar-title">SmartXp:</a></li>

                            <li class="nav-item"><a href="{{ route("dmx::index") }}">Fixtures</a></li>
                            <li class="nav-item"><a href="{{ route("dmx::override::index") }}">Override</a></li>

                        @endif

                    </ul>
                </li>
            @endif

            @if (Auth::check() && Auth::user()->can("board"))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Web Admin <span class="caret"></span></a>
                    <ul class="dropdown-menu">

                        <li class="nav-item"><a href="{{ route("menu::list") }}">Menu</a></li>
                        <li class="nav-item"><a href="{{ route("video::admin::index") }}">Videos</a></li>
                        <li class="nav-item"><a href="{{ route("page::list") }}">Pages</a></li>
                        <li class="nav-item"><a href="{{ route("news::admin") }}">News</a></li>
                        <li class="nav-item"><a href="{{ route("email::admin") }}">Email</a></li>
                        <li class="nav-item"><a href="{{ route("achievement::list") }}">Achievements</a></li>
                        <li class="nav-item"><a href="{{ route("welcomeMessages::list") }}">Welcome Messages</a></li>

                        @if(Auth::user()->can('sysadmin'))
                            <li role="separator" class="divider"></li>
                            <li class="nav-item"><a href="{{ route("protube::radio::index") }}">ProTube Radio Stations</a></li>
                            <li class="nav-item"><a href="{{ route("protube::display::index") }}">ProTube Displays</a></li>
                            <li class="nav-item"><a href="{{ route("protube::soundboard::index") }}">Soundboard Sounds</a></li>
                            <li class="nav-item"><a href="{{ route("alias::index") }}">Aliases</a></li>
                            <li class="nav-item"><a href="{{ route("announcement::index") }}">Announcements</a></li>
                            <li class="nav-item"><a href="{{ route("authorization::overview") }}">Authorization</a></li>
                        @endif

                        <li role="separator" class="divider"></li>

                        <li class="nav-item"><a class="navbar-title">Utilities:</a></li>
                        <li class="nav-item"><a href="{{ route("passwordstore::index") }}">Password Store</a></li>

                    </ul>
                </li>
            @endif

            <form method="post" action="{{ route('search') }}" class="navbar-form navbar-right navbar__search">
                {{ csrf_field() }}
                <div class="input-group">
                    <input class="navbar__search__input form-control"
                           type="search" name="query" placeholder="Search">
                    <!--<span class="navbar__search__icon input-group-addon">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </span>-->
                    <span class="input-group-btn">
                            <button type="submit" class="navbar__search__icon" style=""><i class="fa fa-search"
                                                                                           aria-hidden="true"></i></button>
                        </span>
                </div>
            </form>

            @if (Auth::check())

                @if(Auth::user()->isTempadmin() || (Auth::user()->can('protube') && !Auth::user()->can('board')))
                    <li class="nav-item">
                        <a href="{{ route("protube::admin") }}" role="button" aria-haspopup="false"
                           aria-expanded="false">ProTube Admin</a>
                    </li>
                @endif

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false"><img class="profile__photo profile__photo--small"
                                                  src="{{ Auth::user()->generatePhotoPath(64, 64) }}"
                                                  alt="{{ Auth::user()->name }}"> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="nav-item"><a href="{{ route('user::dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a href="{{ route('omnomcom::orders::list') }}">Purchase History</a></li>

                        @if(Auth::check() && Auth::user()->member)
                            <li class="nav-item"><a href="{{ route('user::profile') }}">My Profile</a></li>
                        @else
                            <li class="nav-item"><a href="{{ route('becomeamember') }}">Become a member!</a></li>
                        @endif

                        @if (Auth::check() && Auth::user()->member)
                            <li class="nav-item">
                                <a href="#" data-toggle="modal" data-target="#slack-modal">
                                    Slack
                                    <span class="badge"><i class="fa fa-circle green" aria-hidden="true"></i> <span
                                                id="slack__online">...</span></span>
                                </a>
                            </li>
                        @endif

                        @if (Session::has('impersonator'))
                            <li class="nav-item"><a href="{{ route('user::quitimpersonating') }}">Quit Impersonation</a></li>
                        @else
                            <li class="nav-item"><a href="{{ route('login::logout') }}">Logout</a></li>
                        @endif
                    </ul>
                </li>
            @else

                <li class="nav-item">
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
</nav>
