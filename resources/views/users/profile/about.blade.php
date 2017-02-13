@include('users.profile.photo')

<div class="panel panel-default">
    <div class="panel-body">

        <table class="table borderless">
            <tr>
                <td style="text-align: right;"><strong>E-mail</strong></td>
                <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
            </tr>
            @if($user->website)
                <tr>
                    <td style="text-align: right;"><strong>Website</strong></td>
                    <td><a href="{{ $user->website }}">{{ $user->website }}</a></td>
                </tr>
            @endif
            @if($user->phone_visible)
                <tr>
                    <td style="text-align: right;"><strong>Phone</strong></td>
                    <td><a href="tel:{{ $user->phone }}">{{ $user->phone }}</a></td>
                </tr>
            @endif
            @if($user->address_visible && $user->address != null)
                <tr>
                    <td style="text-align: right;"><strong>Address</strong></td>
                    <td>
                        {{ $user->address->street }} {{ $user->address->number }}<br>
                        {{ $user->address->zipcode }}, {{ $user->address->city }}<br>
                        {{ $user->address->country }}
                    </td>
                </tr>
            @endif
            @if(count($user->studies) > 0)
                <tr>
                    <td style="text-align: right;"><strong>Studies</strong></td>
                    <td>
                        @foreach($user->studies as $study)
                            <span style="width: 100%;">
                                {{ $study->name }}
                                (
                                {{ date('M \'y',strtotime($study->pivot->created_at)) }}
                                -
                                {{ ($study->pivot->deleted_at == null ? 'now' : date('M \'y',strtotime($study->pivot->deleted_at))) }}
                                )
                            </span>
                            <br>
                        @endforeach
                    </td>
                </tr>
            @endif
            <tr>
                <td colspan="2">
                    @if($user->member == null)
                        <span class="text-info">
                        {{ $user->calling_name }} is not a member of S.A. Proto.
                    </span>
                    @else
                        <span class="text-success">
                        {{ $user->calling_name }} is a member
                            @if(date('U', strtotime($user->member->created_at)) > 0)
                                as of {{ date('F j, Y', strtotime($user->member->created_at)) }}.
                            @else
                                since <strong>ancient times</strong>!
                            @endif
                    </span>
                    @endif
                </td>
            </tr>
        </table>

    </div>
</div>

@if($ldap && Auth::user()->getUtwenteData())
    <div class="panel panel-default">
        <div class="panel-heading">
            From the University of Twente address book
        </div>
        <div class="panel-body">
            <table class="table borderless">
                <tr>
                    <td style="text-align: right;"><strong>Name</strong></td>
                    <td>{{ $ldap->givenname[0] }} {{ $ldap->sn[0] }}</td>
                </tr>
                <tr>
                    <td style="text-align: right;"><strong>E-mail</strong></td>
                    <td><a href="mailto:{{ $ldap->mail[0] }}">{{ $ldap->mail[0] }}</td>
                </tr>
                @if(substr($ldap->userprincipalname[0], 0, 1) == "s")
                    @if(property_exists($ldap, 'department'))
                        <tr>
                            <td style="text-align: right;"><strong>Study</strong></td>
                            <td>{{ $ldap->department[0] }}</td>
                        </tr>
                    @endif
                @elseif(substr($ldap->userprincipalname[0], 0, 1) == "m")
                    @if(property_exists($ldap, 'department'))
                        <tr>
                            <td style="text-align: right;"><strong>Department</strong></td>
                            <td>{{ $ldap->department[0] }}</td>
                        </tr>
                    @endif
                    @if(property_exists($ldap, 'telephonenumber'))
                        <tr>
                            <td style="text-align: right;"><strong>Phone</strong></td>
                            <td>
                                <a href="tel:{{ $ldap->telephonenumber[0] }}">{{ $ldap->telephonenumber[0] }}</a>
                            </td>
                        </tr>
                    @endif
                    @if(property_exists($ldap, 'physicaldeliveryofficename'))
                        <tr>
                            <td style="text-align: right;"><strong>Room</strong></td>
                            <td>{{ $ldap->physicaldeliveryofficename[0] }}</td>
                        </tr>
                    @endif
                @endif
            </table>

        </div>
    </div>
@endif
