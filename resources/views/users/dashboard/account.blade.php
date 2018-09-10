<form class="form-horizontal" method="post" action="{{ route("user::dashboard") }}">

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

                <div class="form-group">
                    <label for="member_proto_mail" class="col-sm-4 control-label">Birthday</label>
                    <div class="col-sm-8 control-label" style="text-align: left;">
                        <div class="checkbox">
                            <label>
                                <input name="show_birthday"
                                       type="checkbox" {{ ($user->show_birthday == 1 ? 'checked' : '') }}>
                                Show to members
                            </label>
                        </div>
                    </div>
                </div>

            @endif

            <div class="form-group">
                <label for="email" class="col-sm-4 control-label">E-mail</label>

                <div class="col-sm-8">
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                           required>
                </div>
            </div>

            @if($user->phone)
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
            @endif

            <div class="form-group">
                <label for="website" class="col-sm-4 control-label">Homepage</label>

                <div class="col-sm-8">
                    <input type="text" class="form-control" id="website" name="website"
                           value="{{ $user->website }}">
                </div>
            </div>

            @if($user->member)

                <div class="form-group">
                    <label for="member_proto_mail" class="col-sm-4 control-label">OmNomCom</label>
                    <div class="col-sm-8 control-label" style="text-align: left;">
                        <div class="checkbox">
                            <label>
                                <input name="show_omnomcom_total"
                                       type="checkbox" {{ ($user->show_omnomcom_total == 1 ? 'checked' : '') }}>
                                After checkout, show how much I've spent today.
                            </label>
                        </div>
                    </div>
                </div>

            @endif

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

<form class="form-horizontal" method="post" action="{{ route("user::changepassword") }}">

    <div class="panel panel-default">

        <div class="panel-heading">
            <strong>Change Proto password</strong>
        </div>

        <div class="panel-body">

            <p>
                <i>This will not change your University of Twente password.</i> You can change that password <a
                        href="https://tap.utwente.nl/chpw1.php" target="_blank">here</a>.
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

<div class="panel panel-default">

    <div class="panel-heading">
        <strong>Password sync</strong>
    </div>

    <div class="panel-body">

        <p>
            Synchronizing your password between all Proto systems will resolve a lot of problems you may have with
            logging in to services like e-mail, the network drive and the wiki. If you can't login there, but can log-in
            on the Proto site, you may want to sync your password below.
        </p>

    </div>

    <div class="panel-footer">

        <div class="btn-group btn-group-justified" role="group">
            <div class="btn-group" role="group">
                <a href="{{ route('login::password::sync') }}" class="btn btn-success">
                    Synchronize passwords
                </a>
            </div>
        </div>

    </div>

</div>