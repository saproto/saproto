<div class="card mb-3">

    <div class="card-header bg-dark text-white">Action center for <strong>{{ $user->name }}</strong></div>

    <div class="card-body">

        @if(Auth::user()->can('board'))
            <a class="btn btn-{{ $user->signed_nda ? 'info' : 'warning' }} btn-block mb-3"
               href="{{ Auth::user()->can('sysadmin') ? route('user::admin::toggle_nda', ['id' => $user->id]) : 'javascript:void();' }}">
                User <strong>{{ !$user->signed_nda ? 'did not sign' : 'signed' }}</strong> an NDA.
            </a>
        @endif

        <ul class="list-group mb-3">

            <li class="list-group-item list-group-item-dark">Actions</li>
            <a class="list-group-item"
               href="{{ route("user::member::impersonate", ["id" => $user->id]) }}">
                Impersonate
            </a>
            @if($user->isTempadmin())
                <a href="{{ route('tempadmin::end', ['id' => $user->id]) }}"
                   class="list-group-item">
                    End temporary admin
                </a>
            @else
                <a href="{{ route('tempadmin::make', ['id' => $user->id]) }}"
                   class="list-group-item">
                    Make temporary admin
                </a>
            @endif
            @if($user->member)
                <a class="list-group-item"
                   href="{{ route('user::profile', ['id' => $user->getPublicId()]) }}">
                    Go to profile
                </a>
            @endif

        </ul>

        <ul class="list-group">

            <!-- Study details //-->
            <li class="list-group-item list-group-item-dark">Study</li>
            <a class="list-group-item"
               href="{{ route('user::admin::toggle_studied_create', ['id' => $user->id]) }}">
                Has {!! $user->did_study_create ? '' : '<strong>not</strong>' !!} studied CreaTe.
            </a>
            <a class="list-group-item"
               href="{{ route('user::admin::toggle_studied_itech', ['id' => $user->id]) }}">
                Has {!! $user->did_study_itech ? '' : '<strong>not</strong>' !!} studied ITech.
            </a>

        </ul>

    </div>

</div>