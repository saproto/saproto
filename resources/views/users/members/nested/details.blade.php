<div class="panel-heading">
    <h3 class="panel-title">
        @if($user->member)
            <span class="pull-right label label-success">Member</span>
        @else
            <span class="pull-right label label-danger">No member</span>
        @endif
        {{ $user->name }}
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
                                <td width="25%">Member since</td>
                                @if(date('U', strtotime($user->member->created_at)) > 0)
                                    <td>{{ date('F j, Y', strtotime($user->member->created_at)) }}</td>
                                @else
                                    <td>ancient times</td>
                                @endif

                            </tr>
                            <tr>
                                <td>Member until</td>
                                <td>@if($user->member->till) <span
                                            style="color: red;">{{ date('F j, Y', strtotime($user->member->till)) }}</span> @else &mdash; @endif
                                </td>
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

        <div class="col-md-4 col-xs-4">
            <div class="btn-group btn-group-justified" role="group">
                <a class="btn btn-default" href="{{ route('user::dashboard', ['id' => $user->id]) }}">
                    Dashboard
                </a>
            </div>
        </div>

        <div class="col-md-4 col-xs-4">
            <div class="btn-group btn-group-justified" role="group">
                <a class="btn btn-default" href="{{ route('user::profile', ['id' => $user->id]) }}">
                    Profile
                </a>
            </div>
        </div>

        @if(Auth::user()->hasRole('admin'))
            <div class="col-md-4 col-xs-4">
                <div class="btn-group btn-group-justified" role="group">
                    <a class="btn btn-default" target="_blank"
                       href="{{ route("user::member::impersonate", ["id" => $user->id]) }}">
                        Impersonate
                    </a>
                </div>
            </div>
        @endif

        <hr>

        <div class="col-md-3 col-xs-6">
            <div class="btn-group btn-group-justified" role="group">
                <a href="{{ route('membercard::download', ['id' => $user->id]) }}" class="btn btn-default" target="_blank">
                    Preview Card
                </a>
            </div>
        </div>

        <div class="col-md-5 col-xs-6">
            <div class="btn-group btn-group-justified" role="group">
                <a id="print-card" data-id="{{ $user->id }}" class="btn btn-default" target="_blank">
                    Print Card ({{ $user->member->card_printed_on or 'First' }})
                </a>
            </div>
        </div>

        <div class="col-md-4 col-xs-6">
            <div class="btn-group btn-group-justified" role="group">
                @if(!$user->member) <a class="btn btn-primary" data-toggle="modal" data-target="#addMembership">
                    Make member
                </a>
                @else <a class="btn btn-danger" data-toggle="modal"
                         data-target="#removeMembership">
                    End membership
                </a>
                @endif
            </div>
        </div>

    </div>

</div>


<!-- Modal for adding membership to user -->
@include("users.members.add")

<!-- Modal for removing membership from user -->
@include("users.members.remove")