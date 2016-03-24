<div class="panel panel-default">
    <div class="panel-heading">
        About {{ $user->name_first }}
    </div>
    <div class="panel-body">

        <table class="table borderless">
            <tr>
                <td style="text-align: right;"><strong>E-mail</strong></td>
                <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
            </tr>
            @if($user->phone_visible)
                <tr>
                    <td style="text-align: right;"><strong>Phone</strong></td>
                    <td><a href="tel:{{ $user->phone }}">{{ $user->phone }}</a></td>
                </tr>
            @endif
            @if($user->address_visible && $user->getPrimaryAddress() != null)
                <tr>
                    <td style="text-align: right;"><strong>Address</strong></td>
                    <td>
                        {{ $user->getPrimaryAddress()->street }} {{ $user->getPrimaryAddress()->number }}<br>
                        {{ $user->getPrimaryAddress()->zipcode }}, {{ $user->getPrimaryAddress()->city }}<br>
                        {{ $user->getPrimaryAddress()->country }}
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
                                {{ ($study->pivot->till == null ? 'now' : date('M \'y',strtotime($study->pivot->till))) }}
                                )
                            </span>
                        @endforeach
                    </td>
                </tr>
            @endif
        </table>

    </div>
    <div class="panel-footer">
        <div class="btn-group btn-group-justified">
            @if($user->member == null)
                <a class="btn btn-warning">
                    {{ $user->name_first }} is not a member of {{ config('association.name') }}.
                </a>
            @else
                <a class="btn btn-primary">
                    {{ $user->name_first }} is a member
                    @if(date('U', strtotime($user->member->created_at)) > 0)
                        as of {{ date('F j, Y', strtotime($user->member->created_at)) }}.
                    @else
                        since <strong>ancient times</strong>!
                    @endif
                </a>
            @endif
        </div>
    </div>
</div>