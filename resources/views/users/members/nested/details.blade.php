<div class="panel-heading">
    <h3 class="panel-title">
        @if($user->member)
            <span class="label label-success">Member</span>
        @else
            <span class="label label-danger">No member</span>
        @endif
        {{ $user->name }}
        <a href="{{ route("user::member::impersonate", ["id" => $user->id]) }}">
            <span class="pull-right label label-default">Impersonate</span>
        </a>
    </h3>
</div>

<div class="panel-body">
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">User info</h3>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <td width="25%">Proto#</td>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <td>Student#</td>
                            <td>{{ $user->utwente_username }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        @if($user->member)
            <div class="col-md-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Member info</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <td width="25%">Gender</td>
                                <td>@if($user->member->gender == 1) <i
                                            class="fa fa-mars"></i> @elseif($user->member->gender == 2)
                                        <i class="fa fa-venus"></i> @endif</td>
                            </tr>
                            <tr>
                                <td>Member type</td>
                                <td>{{ strtolower($user->member->type) }}</td>
                            </tr>
                            <tr>
                                <td>Fee cycle</td>
                                <td>{{ strtolower($user->member->fee_cycle) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="panel-footer">

    <div class="col clearfix">

        <div class="col-md-6 col-xs-6">
            <div class="btn-group btn-group-justified" role="group">
                <a class="btn btn-default" href="{{ route('user::dashboard', ['id' => $user->id]) }}">
                    Dashboard
                </a>
            </div>
        </div>

        <div class="col-md-6 col-xs-6">
            <div class="btn-group btn-group-justified" role="group">
                <a class="btn btn-default" href="{{ route('user::profile', ['id' => $user->id]) }}">
                    Profile
                </a>
            </div>
        </div>

    </div>

</div>