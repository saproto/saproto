<div class="card mb-3">

    <div class="card-body">

        <h3 class="text-center ellipsis">
            {{ $user->name }}
        </h3>

        <div class="text-center">

            <img src="{{ $user->generatePhotoPath(170, 170) }}" class="rounded-circle" width="170px" height="170px">

        </div>

        <hr>

        @if($user->member && $user->member->is_honorary)
            <p class="card-text ellipsis">
                <i class="fas fa-trophy fa-fw mr-3 text-primary" aria-hidden="true"></i>
                <strong>{{ $user->calling_name }} is an honorary member.</strong>
            </p>
        @endif

        <p class="card-text ellipsis">
            <i class="fas fa-envelope fa-fw mr-3"></i>
            <a href="mailto:{{ $user->getDisplayEmail() }}">{{ $user->getDisplayEmail() }}</a>
        </p>

        @if($user->website)
            <p class="card-text ellipsis">
                <i class="fas fa-globe-africa fa-fw mr-3"></i>
                <a href="{{ $user->websiteUrl() }}">{{ $user->websiteDisplay() }}</a>
            </p>
        @endif

        @if($user->phone_visible)
            <p class="card-text ellipsis">
                <i class="fas fa-phone fa-fw mr-3" aria-hidden="true"></i>
                <a href="tel:{{ $user->phone }}">{{ $user->phone }}</a>
            </p>
        @endif

        @if($user->address_visible && $user->address != null)
            <p class="card-text ellipsis">
                <i class="fas fa-home fa-fw mr-3" aria-hidden="true"></i>
                {{ $user->address->street }} {{ $user->address->number }}, {{ $user->address->city }}
            </p>
        @endif

        <p class="card-text ellipsis">

            @if($user->member == null)
                <i class="fas fa-user-times fa-fw mr-3"></i>
                Not a member
            @else
                <i class="fas fa-user-friends fa-fw mr-3"></i>
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
