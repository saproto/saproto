<div class="panel panel-default">

    <div class="panel-heading">
        <strong>Your linked RFID cards</strong>
    </div>

    <div class="panel-body">

        @if(count($user->rfid) > 0)

            <div class="row">

                @foreach($user->rfid as $rfid)

                    <div class="col-md-6">

                        <div class="panel panel--border panel-default">

                            <div class="panel-body">
                                <strong>{{ $rfid->name or 'No name' }}</strong>
                                <span class="pull-right">{{ $rfid->card_id }}</span>
                                <br>
                                <span style="color: #aaa;">
                            <sub>
                                Last used: {{ $rfid->updated_at }}
                            </sub>
                        </span>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-group btn-group-justified" role="group">
                                            <div class="btn-group" role="group">
                                                <a type="button" class="btn btn-xs btn-danger"
                                                   href="{{ route('user::rfid::delete', ['id' => $rfid->id]) }}">
                                                    Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="btn-group btn-group-justified" role="group">
                                            <div class="btn-group" role="group">
                                                <a type="button" class="btn btn-xs btn-default"
                                                   href="{{ route('user::rfid::edit', ['id' => $rfid->id]) }}">
                                                    Edit
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <p style="text-align: center; font-weight: bold;">
                There are no RFID cards linked to your account.
            </p>

        @endif

    </div>

    <div class="panel-footer">

    </div>

</div>
