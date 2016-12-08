<div class="panel panel-default">
    <div class="panel-heading"><strong>Your membership details</strong></div>
    <div class="panel-body">

        <div class="form-horizontal">

            @if($user->member)

                <div class="form-group">
                    <label for="member" class="col-sm-4 control-label">Member</label>
                    <div class="col-sm-8 control-label" style="text-align: left;">Yes!</div>
                </div>

                <div class="form-group">
                    <label for="member_since" class="col-sm-4 control-label">Since</label>
                    <div class="col-sm-8 control-label" style="text-align: left;">
                        @if(date('U', strtotime($user->member->created_at)) > 0)
                            {{ date('F j, Y', strtotime($user->member->created_at)) }}
                        @else
                            Before we kept track!
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="member_mods" class="col-sm-4 control-label">Modifiers</label>
                    <div class="col-sm-8 control-label" style="text-align: left;">

                        @if($user->member->is_honorary)
                            <strong>Honorary!</strong><br>
                        @endif

                        @if($user->member->is_associate)
                            External
                        @else
                            Primary
                        @endif

                        @if($user->member->is_donator)
                            <br>Donator
                        @endif

                        @if($user->member->is_lifelong)
                            <br>Lifelong
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="member_isactive" class="col-sm-4 control-label">Active</label>
                    <div class="col-sm-8 control-label"
                         style="text-align: left;">{{ ($user->isActiveMember() ? 'Yes!' : 'No. :(') }}</div>
                </div>

                @if($user->isActiveMember())

                    <hr>

                    <div class="form-group">
                        <label for="member_proto_mail" class="col-sm-4 control-label">Proto E-mail</label>
                        <div class="col-sm-8 control-label" style="text-align: left;">
                            <span style="margin-right: 5px;">{{ $user->member->proto_username }}</span>@<span
                                    style="margin-left: 5px;">{{ config('proto.emaildomain') }}</span>
                        </div>
                    </div>

                    <p>
                        <sub>
                            You are granted a Proto e-mail alias when you become an active member. Your e-mail alias is
                            a forwarder to <strong>{{ $user->email }}</strong>.
                        </sub>
                    </p>

                @endif

            @else

                <div class="form-group">
                    <label for="member_ismember" class="col-sm-4 control-label">Member</label>
                    <div class="col-sm-8 control-label" style="text-align: left;">Nope</div>
                </div>

            @endif

        </div>

    </div>

    <div class="panel-footer">

    </div>

</div>