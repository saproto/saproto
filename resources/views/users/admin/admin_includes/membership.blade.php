<div class="card mb-3">

    <div class="card-header bg-dark text-white">Membership center for <strong>{{ $user->name }}</strong></div>

    <div class="card-body">

        <ul class="list-group mb-3">

            <li class="list-group-item list-group-item-dark">
                Membership actions
            </li>

            @if($user->is_member)
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
            @else
                <li class="list-group-item">
                    Not a member
                </li>
                @if($user->address&&$user->completed_profile&&$user->signed_membership_form)
                    <li class="list-group-item">
                        <i class="fas fa-check-circle text-success"></i>
                        Has complete profile
                    </li>
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

        @if($user->is_member)
            <ul class="list-group mb-3">
                <li class="list-group-item list-group-item-dark">
                    Current Membership
                </li>
                    <li class="table-responsiv list-group-item">
                        <table class="w-100">
                            <thead>
                                <tr>
                                    <td>Since</td>
                                    <td>Type</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <td>
                                    {{ strtotime($user->member->created_at) > 0 ? date('d-m-Y', strtotime($user->member->created_at)) : 'forever' }}
                                </td>
                                <td>
                                    @if($user->member->is_lifelong)
                                        <i class="fas fa-clock"></i> Lifelong
                                    @elseif($user->member->is_honorary)
                                        <i class="fas fa-hand-holding-heart"></i> Honorary
                                    @elseif($user->member->is_donator)
                                        <i class="fas fa-hand-holding-usd"></i> Donator
                                    @else
                                        Regular
                                    @endif
                                </td>
                                <td>
                                    <a class="ml-2" href="{{ route('memberform::download::signed', ['id' => $user->member->membership_form_id]) }}">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </td>
                            </tbody>
                        </table>
                    </li>

            </ul>
        @endif

        @if($memberships['pending']->count() > 0)
            <ul class="list-group mb-3">
                <li class="list-group-item list-group-item-dark">
                    Pending Membership(s)
                </li>
                <li class="table-responsive list-group-item">
                    <table class="w-100">
                        <thead>
                            <tr>
                                <td>
                                    Since
                                </td>
                                <td>
                                    Actions
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($memberships['pending'] as $membership)
                                <tr>
                                    <td>
                                        {{ strtotime($membership->created_at) > 0 ? date('d-m-Y', strtotime($membership->created_at)) : 'forever' }}
                                    </td>
                                    @if($membership->membership_form_id)
                                        <td>
                                            <a href="{{ route('memberform::download::signed', ['id' => $membership->membership_form_id]) }}" class="text-decoration-none">
                                                <i class="fas fa-download fa-fw mr-2 text-info" aria-hidden="true"></i>
                                            </a>
                                            <a href="javascript:void();" data-toggle="modal" data-target="#removeMemberForm" class="text-decoration-none">
                                                <i class="fas fa-trash fa-fw mr-2 text-danger" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </li>
            </ul>
        @endif

        @if($memberships['previous']->count() > 0)
            <ul class="list-group mb-3">
                <li class="list-group-item list-group-item-dark">
                    Previous Membership(s)
                </li>
                <li class="table-responsive list-group-item">
                    <table class="w-100">
                        <thead>
                        <tr>
                            <td>
                                From
                            </td>
                            <td>
                                Until
                            </td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($memberships['previous'] as $membership)
                            <tr>
                                <td>
                                    {{ strtotime($membership->created_at) > 0 ? date('d-m-Y', strtotime($membership->created_at)) : 'forever' }}
                                </td>
                                <td>
                                    {{ date('d-m-Y', strtotime($membership->deleted_at)) }}
                                </td>
                                @if($membership->membership_form_id)
                                    <td>
                                        <a href="{{ route('memberform::download::signed', ['id' => $membership->membership_form_id]) }}" class="text-decoration-none">
                                            <i class="fas fa-download fa-fw mr-2 text-info" aria-hidden="true"></i>
                                        </a>
                                        <a href="javascript:void();" data-toggle="modal" data-target="#removeMemberForm" class="text-decoration-none">
                                            <i class="fas fa-trash fa-fw mr-2 text-danger" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </li>
            </ul>
        @endif

    </div>

</div>