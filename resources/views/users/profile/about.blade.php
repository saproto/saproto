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

@if($ldap)
    <div class="panel panel-default">
        <div class="panel-heading">
            From the University of Twente address book
        </div>
        <div class="panel-body">
            <table class="table borderless">
                @if($ldap->description == "Student")
                    <tr>
                        <td style="text-align: right;"><strong>Name</strong></td>
                        <td>{{ $ldap->cn }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: right;"><strong>E-mail</strong></td>
                        <td><a href="mailto:{{ $ldap->mail }}">{{ $ldap->mail }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: right;"><strong>Study</strong></td>
                        <td>{!! property_exists($ldap, 'ou') ? $ldap->ou : '<i>unknown</i>' !!}</td>
                    </tr>
                @elseif($ldap->description == "Employee")
                    <tr>
                        <td style="text-align: right;"><strong>Name</strong></td>
                        <td>{{ $ldap->title }} {{ $ldap->givenname }} {{ $ldap->sn }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: right;"><strong>E-mail</strong></td>
                        <td><a href="mailto:{{ $ldap->mail }}">{{ $ldap->mail }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: right;"><strong>Department</strong></td>
                        <td>{!! property_exists($ldap, 'ou') ? $ldap->ou : '<i>unknown</i>' !!}</td>
                    </tr>
                    <tr>
                        <td style="text-align: right;"><strong>Phone</strong></td>
                        <td
                        {{ $ldap->telephonenumber }}</a></td>
                        <td>
                            <a href="tel:{!! property_exists($ldap, 'telephonenumber') ? $ldap->telephonenumber : '???' !!}">{!! property_exists($ldap, 'telephonenumber') ? $ldap->telephonenumber : '<i>unknown</i>' !!}</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;"><strong>Room</strong></td>
                        <td>{!! property_exists($ldap, 'roomnumber') ? $ldap->roomnumber : '<i>unknown</i>' !!}</td>
                    </tr>
                @endif
            </table>

        </div>
    </div>
@endif
