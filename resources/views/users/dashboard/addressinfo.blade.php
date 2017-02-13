<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Your address information</strong>
    </div>
    <div class="panel-body">

        @if($user->address)

            <p style="text-align: center;">
                <strong>{{ $user->address->street }} {{ $user->address->number }}</strong>
                <br>
                {{ $user->address->zipcode }} {{ $user->address->city }} ({{ $user->address->country }})
            </p>

            <p style="text-align: center;">
                <sub>
                    Currently other members are

                    <strong>
                        @if(!$user->address_visible)
                            not
                        @endif
                        able
                    </strong>

                    to see your address.
                    <br>
                    Click

                    <a href="{{ route('user::address::togglehidden', ['id' => $user->id]) }}">
                        here
                    </a>

                    to toggle this.
                </sub>
            </p>

        @else

            <p style="text-align: center; font-weight: bold;">
                We don't have an address for you.
            </p>

        @endif

    </div>

    <div class="panel-footer">
        @if(!$user->address)
            <div class="btn-group btn-group-justified" role="group">
                <div class="btn-group" role="group">
                    <a type="button" class="btn btn-success"
                       href="{{ route('user::address::add', ['id' => $user->id]) }}">
                        Add your address
                    </a>
                </div>
            </div>
        @else
            @if($user->member)
                <div class="btn-group btn-group-justified" role="group">
                    <a class="btn btn-success"
                       href="{{ route('user::address::edit', ['id' => $user->id]) }}">
                        Update your address
                    </a>
                </div>
            @else
                <div class="row">
                    <div class="col-md-6">
                        <div class="btn-group btn-group-justified" role="group">
                            <a class="btn btn-success"
                               href="{{ route('user::address::edit', ['id' => $user->id]) }}">
                                Update
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="btn-group btn-group-justified" role="group">
                            <a class="btn btn-danger"
                               href="{{ route('user::address::delete', ['id' => $user->id]) }}">
                                Delete
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>