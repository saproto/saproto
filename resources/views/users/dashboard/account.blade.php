<form class="form-horizontal" method="post" action="{{ route("user::dashboard", ["id" => $user->id]) }}">

    <div class="panel panel-default">

        <div class="panel-heading">
            <strong>Update account</strong>
        </div>

        <div class="panel-body">

            {!! csrf_field() !!}

            @if($user->member)

                <div class="form-group">
                    <label for="member_proto_mail" class="col-sm-4 control-label">Username</label>
                    <div class="col-sm-8 control-label" style="text-align: left;">
                        {{ $user->member->proto_username }}
                    </div>
                </div>

            @endif

            <div class="form-group">
                <label for="calling_name" class="col-sm-4 control-label">Display name</label>

                <div class="col-sm-8">
                    <input type="calling_name" class="form-control" id="calling_name" name="calling_name"
                           value="{{ $user->calling_name }}"
                           required>
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="col-sm-4 control-label">E-mail</label>

                <div class="col-sm-8">
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                           required>
                </div>
            </div>

            <div class="form-group">
                <label for="phone" class="col-sm-4 control-label">Phone</label>

                <div class="col-sm-8">
                    <input type="phone" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">

                    <div class="checkbox">
                        <label>
                            <input name="phone_visible"
                                   type="checkbox" {{ ($user->phone_visible == 1 ? 'checked' : '') }}>
                            Show to members
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input name="receive_sms"
                                   type="checkbox" {{ ($user->receive_sms == 1 ? 'checked' : '') }}>
                            Receive text messages
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="website" class="col-sm-4 control-label">Homepage</label>

                <div class="col-sm-8">
                    <input type="text" class="form-control" id="website" name="website"
                           value="{{ $user->website }}">
                </div>
            </div>

        </div>

        <div class="panel-footer">
            <div class="btn-group btn-group-justified" role="group">
                <div class="btn-group" role="group">
                    <button type="submit" class="btn btn-success">
                        Update account
                    </button>
                </div>
            </div>
        </div>

    </div>

</form>

<form class="form-horizontal" method="post" action="{{ route("user::changepassword", ["id" => $user->id]) }}">

    <div class="panel panel-default">

        <div class="panel-heading">
            <strong>Change Proto password</strong>
        </div>

        <div class="panel-body">

            <p>
                <i>This will not change your University of Twente password.</i> You can change that password <a
                        href="https://tap.utwente.nl/tap/" target="_blank">here</a>.
            </p>

        </div>

        <div class="panel-footer">

            <div class="btn-group btn-group-justified" role="group">
                <div class="btn-group" role="group">
                    <a href="{{ route('login::password::change') }}" class="btn btn-success">
                        Update password
                    </a>
                </div>
            </div>

        </div>

    </div>

</form>
