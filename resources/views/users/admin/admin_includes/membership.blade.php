<div class="card mb-3">

    <div class="card-header bg-dark text-white">Membership center for <strong>{{ $user->name }}</strong></div>

    <div class="card-body">

        <ul class="list-group mb-3">

            <li class="list-group-item list-group-item-dark">
                Membership
            </li>
            @if($user->is_member)
                <li class="list-group-item">
                    Member since
                    {{ strtotime($user->member->created_at) > 0 ? date('d-m-Y', strtotime($user->member->created_at)) : 'forever' }}
                </li>
                <a href="javascript:void();" class="list-group-item text-danger" data-toggle="modal" data-target="#removeMembership">
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
                @if($user->hasSignedMembershipForm())
                    <a class="list-group-item" href="{{ route('memberform::download', ['id' => $user->id]) }}">
                        Get signed membership form
                    </a>
                @endif
            @else
                <li class="list-group-item">
                    Not a member
                </li>
                @if($user->address&&$user->hasCompletedProfile())
                    <li class="list-group-item">
                        <i class="fas fa-check-circle text-success"></i>
                        Has complete profile
                    </li>
                    @if ($user->hasSignedMembershipForm())
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success"></i>
                            <b>Signed</b> membership form
                        </li>
                        <a class="list-group-item" href="{{ route('memberform::download', ['id' => $user->id]) }}">
                            Get signed membership form
                        </a>
                        <a href="javascript:void();" class="list-group-item text-danger" data-toggle="modal" data-target="#removeMemberForm">
                            Delete signed membership form
                        </a>
                    @else
                        <li class="list-group-item">
                            <i class="fas fa-times-circle text-danger"></i>
                            <b>Has not signed</b> membership form
                        </li>

                        <a class="list-group-item" href="{{ route('memberform::download', ['id' => $user->id]) }}">
                            Download membership form
                        </a>
                        <a class="list-group-item" href="{{ route('memberform::print', ['id' => $user->id]) }}">
                            Print membership form
                        </a>
                    @endif
                    <a href="javascript:void();" class="list-group-item text-warning" data-toggle="modal" data-target="#addMembership">
                        Make member
                    </a>
                @else
                    <li class="list-group-item">
                        <i class="fas fa-times-circle text-danger"></i>
                        Has not completed profile yet
                    </li>
                @endif
            @endif

        </ul>

    </div>

</div>