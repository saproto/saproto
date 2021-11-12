<div class="card mb-3">

    <div class="card-header text-white border-bottom-0 bg-white" style="position: relative; height: 250px;">

        <div class="card-header bg-dark" style="position: absolute; top: 0; left: 0; right: 0; height: 200px;"></div>

        <div style="position: absolute; top: 0; left: 0; right: 0;">

            <h3 class="text-center ellipsis mb-3 mt-4">
                {{ $user->name }}
            </h3>

            <div class="text-center">

                <img src="{{ $user->generatePhotoPath(170, 170) }}" class="rounded-circle mt-2 border-white"
                     width="170px" height="170px" style="border-style: solid; border-width: 5px;">

            </div>

        </div>

    </div>

    <div class="card-body">

        @if($user->is_member)
            @if($user->member->is_honorary)
                <p class="card-text ellipsis">
                    <i class="fas fa-trophy fa-fw me-3 text-primary" aria-hidden="true"></i>
                    <strong>{{ $user->calling_name }} is an honorary member.</strong>
                </p>
            @elseif($user->member->is_pet)
                <p class="card-text ellipsis">
                    <i class="fas fa-paw fa-fw me-3 text-primary" aria-hidden="true"></i>
                    <strong>{{ $user->calling_name }} is a pet.</strong>
                </p>
            @endif
        @endif

        @can('board')
            <p class="card-text ellipsis">
                <i class="fas fa-user-cog fa-fw me-3 text-info" aria-hidden="true"></i>
                <a href="{{ route('user::admin::details', ['id'=>$user->id]) }}">
                    View this user in the user administration.
                </a>
            </p>
        @endcan

        <p class="card-text ellipsis">
            <i class="fas fa-envelope fa-fw me-3"></i>
            <a href="mailto:{{ $user->getDisplayEmail() }}">{{ $user->getDisplayEmail() }}</a>
        </p>

        @if($user->website)
            <p class="card-text ellipsis">
                <i class="fas fa-globe-africa fa-fw me-3"></i>
                <a href="{{ $user->websiteUrl() }}">{{ $user->websiteDisplay() }}</a>
            </p>
        @endif

        @if($user->phone_visible)
            <p class="card-text ellipsis">
                <i class="fas fa-phone fa-fw me-3" aria-hidden="true"></i>
                <a href="tel:{{ $user->phone }}">{{ $user->phone }}</a>
            </p>
        @endif

        @if($user->address_visible && $user->address != null)
            <p class="card-text ellipsis">
                <i class="fas fa-home fa-fw me-3" aria-hidden="true"></i>
                {{ $user->address->street }} {{ $user->address->number }}, {{ $user->address->city }}
            </p>
        @endif

        <p class="card-text ellipsis">

            @if(!$user->is_member)
                <i class="fas fa-user-times fa-fw me-3"></i>
                Not a member
            @else
                <i class="fas fa-user-friends fa-fw me-3"></i>
                Member
                @if(date('U', strtotime($user->member->created_at)) > 0)
                    as of {{ date('F j, Y', strtotime($user->member->created_at)) }}.
                @else
                    since <strong>before we kept track</strong>!
                @endif
            @endif

        </p>

    </div>

</div>
