@if($user->is_member || $memberships['previous']->count() > 0 || $memberships['pending']->count() > 0)
    <div class="card mb-3">
        <div class="card-header bg-dark text-white">
            Your membership
        </div>
        <div class="card-body">
            <table class="table table-borderless table-sm mb-0">
                <tbody>
                @if($user->is_member)
                    <tr>
                        <th>Member since</th>
                        <td>
                            @if(date('U', strtotime($user->member->created_at)) > 0)
                                {{ date('F j, Y', strtotime($user->member->created_at)) }}
                            @else
                                Before we kept track
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Proto username</th>
                        <td>{{ $user->member->proto_username }}</td>
                    </tr>
                    @if($user->isActiveMember())
                        <tr>
                            <th>Active in committee(s)</th>
                            <td>Yes! <i class="far fa-thumbs-up"></i></td>
                        </tr>
                        <tr>
                            <th>Member e-mail</th>
                            <td>
                                {{ $user->member->proto_username }}<span class="text-muted">@</span><span
                                        class="text-muted">{{ config('proto.emaildomain') }}</span><br>
                                <sup class="text-muted">Forwards to {{ $user->email }}</sup>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th>Membership type</th>
                        @if($user->member->getMembertype())
                            <td>{{ ucfirst($user->member->getMembertype()) }} member
                                <br>
                                <sup class="text-muted">{{ '&euro; '. $user->member->getMembershipOrderline()->total_price . ' was paid on ' . date('F j, Y', strtotime($user->member->getMembershipOrderline()->created_at)) }}</sup>
                            </td>
                        @else
                            <td>
                                Not yet determined
                                <br>
                                <sup class="text-muted">Will be determined when membership fee is charged for this year.</sup>
                            </td>
                        @endif
                    </tr>
                    @if($user->member->is_honorary || $user->member->is_donor || $user->member->is_lifelong)
                        <tr>
                            <th>Special status</th>
                            <td>
                                @if($user->member->is_honorary)
                                    <span class="badge badge-pill badge-primary">
                                        Honorary member! <i class="fas fa-trophy ml-1"></i>
                                    </span>
                                @endif

                                @if($user->member->is_donor)
                                    <span class="badge badge-pill badge-primary">
                                        Donor <i class="far fa-hand-holding-usd ml-1"></i>
                                    </span>
                                @endif

                                @if($user->member->is_lifelong)
                                    <span class="badge badge-pill badge-primary">
                                        Lifelong member <i class="fas fa-clock ml-1"></i>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th>Current Membership</th>
                            @if($user->member->membershipForm)
                                <td>
                                    Since {{ strtotime($user->member->created_at) > 0 ? date('d-m-Y', strtotime($user->member->created_at)) : 'forever' }} <br>
                                    <a href="{{ route('memberform::download::signed', ['id' => $user->member->membership_form_id]) }}" class="badge badge-pill badge-info">
                                        Download membership form <i class="fas fa-download ml-1"></i>
                                    </a>
                                </td>
                            @else
                                <td>
                                    Since {{ strtotime($user->member->created_at) > 0 ? date('d-m-Y', strtotime($user->member->created_at)) : 'forever' }} <br>
                                    <span class="badge badge-pill badge-warning">
                                        No digital membership form <i class="fas fa-times-circle ml-1"></i>
                                    </span>
                                </td>
                            @endif
                    </tr>
                @endif

                @if($memberships['previous']->count() > 0)
                    <tr>
                        <th>Previous Membership(s)</th>
                        @foreach($memberships['previous'] as $membership)
                            @if($membership->membershipForm)
                                <td>
                                    {{ strtotime($membership->created_at) > 0 ? date('d-m-Y', strtotime($membership->created_at)) : 'forever' }} - {{ date('d-m-Y', strtotime($membership->deleted_at)) }} <br>
                                    <a href="{{ route('memberform::download::signed', ['id' => $membership->membership_form_id]) }}" class="badge badge-pill badge-info">
                                        Download membership form <i class="fas fa-download ml-1"></i>
                                    </a>
                                </td>
                            @else
                                <td>
                                    {{ strtotime($membership->created_at) > 0 ? date('d-m-Y', strtotime($membership->created_at)) : 'forever' }} - {{ date('d-m-Y', strtotime($membership->deleted_at)) }} <br>
                                    <span class="badge badge-pill badge-warning">
                                        No digital membership form <i class="fas fa-times-circle ml-1"></i>
                                    </span>
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endif

                @if($memberships['pending']->count() > 0)
                    <tr>
                        <th>Pending Membership</th>
                        @foreach($memberships['pending'] as $membership)
                            @if($membership->membershipForm)
                                <td>
                                    Since {{ strtotime($membership->created_at) > 0 ? date('d-m-Y', strtotime($membership->created_at)) : 'forever' }} <br>
                                    <a href="{{ route('memberform::download::signed', ['id' => $membership->membership_form_id]) }}" class="badge badge-pill badge-info">
                                        Download membership form <i class="fas fa-download ml-1"></i>
                                    </a>
                                </td>
                            @else
                                <td>
                                    Since {{ strtotime($membership->created_at) > 0 ? date('d-m-Y', strtotime($membership->created_at)) : 'forever' }} <br>
                                    <span class="badge badge-pill badge-warning">
                                        No digital membership form <i class="fas fa-times-circle ml-1"></i>
                                    </span>
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endif
                </tbody>
            </table>

        </div>
    </div>
@endif