<div class="panel panel-default">
    <div class="panel-body">

        <div class="profile__photo-wrapper">
            <img class="profile__photo" src="{{ $user->generatePhotoPath(200, 200) }}" alt="">
        </div>

        <h3 class="center">{{ $user->name }}</h3>

        <hr class="rule">

        <p class="ellipsis">
            <i class="fas fa-envelope-o" aria-hidden="true"></i>&nbsp;&nbsp;
            <a href="mailto:{{ $user->getDisplayEmail() }}">{{ $user->getDisplayEmail() }}</a>
        </p>

        @if($user->website)
            <p class="ellipsis">
                <i class="fas fa-globe" aria-hidden="true"></i>&nbsp;&nbsp;
                <a href="{{ $user->websiteUrl() }}">{{ $user->websiteDisplay() }}</a>
            </p>
        @endif
        @if($user->phone_visible)
            <p class="ellipsis">
                <i class="fas fa-phone" aria-hidden="true"></i>&nbsp;&nbsp;
                <a href="tel:{{ $user->phone }}">{{ $user->phone }}</a>
            </p>
        @endif
        @if($user->address_visible && $user->address != null)
            <p class="ellipsis">
                <i class="fas fa-home" aria-hidden="true"></i>&nbsp;&nbsp;
                {{ $user->address->street }} {{ $user->address->number }}, {{ $user->address->city }}
            </p>
        @endif

        <p class="ellipsis">
            <i class="fas fa-user" aria-hidden="true"></i>&nbsp;&nbsp;
            @if($user->member == null)
                Not a member
            @else
                Member
                @if(date('U', strtotime($user->member->created_at)) > 0)
                    as of {{ date('F j, Y', strtotime($user->member->created_at)) }}.
                @else
                    since <strong>ancient times</strong>!
                @endif
            @endif
        </p>

    </div>
</div>
