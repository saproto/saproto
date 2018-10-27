<div class="card mb-3">

    <div class="card-header bg-dark text-white">Membership center for <strong>{{ $user->name }}</strong></div>

    <div class="card-body">

        <ul class="list-group mb-3">

            <li class="list-group-item list-group-item-dark">
                Membership
            </li>
            @if($user->member)
                <li class="list-group-item">
                    Member since
                    {{ strtotime($user->member->created_at) > 0 ? date('d-m-Y', strtotime($user->member->created_at)) : 'forever' }}
                </li>
                <a href="javascript:void();" class="list-group-item" data-toggle="modal" data-target="#removeMembership">
                    End membership
                </a>
                <a href="{{ route('membercard::download', ['id' => $user->id]) }}" target="_blank"
                   class="list-group-item">
                    Preview membership card
                </a>
                <a href="javascript:void();" id="print-card" data-id="{{ $user->id }}" class="list-group-item">
                    Print membership card<br>
                    (Last printed: {{ $user->member->card_printed_on }})
                </a>
                <a href="javascript:void();" id="print-card-overlay" data-id="{{ $user->id }}" class="list-group-item">
                    Print opener overlay
                </a>

            @else
                <li class="list-group-item">
                    Not a member
                </li>
                <a href="javascript:void();" class="list-group-item" data-toggle="modal" data-target="#addMembership">
                    Make member
                </a>
            @endif
            @if($user->address&&$user->hasCompletedProfile())
                <a class="list-group-item" href="{{ route('memberform::download', ['id' => $user->id]) }}">
                    Show membership form
                </a>
            @endif

        </ul>

    </div>

</div>