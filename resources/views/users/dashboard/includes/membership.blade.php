@if($user->member)
    <div class="card mb-3">
        <div class="card-header">
            Your membership
        </div>
        <div class="card-body">

            <table class="table table-borderless table-sm mb-0">
                <tbody>
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
                @if($user->member->is_honorary || $user->member->is_donator || $user->member->is_lifelong)
                    <tr>
                        <th>Special status</th>
                        <td>
                            @if($user->member->is_honorary)
                                <span class="badge badge-pill badge-primary">
                                    Honorary member! <i class="fas fa-trophy"></i>
                                </span>
                            @endif

                            @if($user->member->is_donator)
                                <span class="badge badge-pill badge-primary">
                                    Donator <i class="far fa-handshake"></i>
                                </span>
                            @endif

                            @if($user->member->is_lifelong)
                                <span class="badge badge-pill badge-primary">
                                    Lifelong member
                                </span>
                            @endif
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>

        </div>
    </div>
@endif