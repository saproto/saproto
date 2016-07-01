<div class="panel-heading">
    <h3 class="panel-title">
        @if($user->member)
            <span class="label label-success">Member</span>
        @else
            <span class="label label-danger">No member</span>
        @endif
        {{ $user->name }}
        @if(Auth::user()->hasRole('admin'))
            <a href="{{ route("user::member::impersonate", ["id" => $user->id]) }}">
                <span class="pull-right label label-default">Impersonate</span>
            </a>
        @endif
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
                        <tr>
                            <td>Gender</td>
                            <td>@if($user->gender == 1)
                                    Male
                                @elseif($user->gender == 2)
                                    Female
                                @elseif($user->gender == 0)
                                    Unknown
                                @elseif($user->gender == 9)
                                    Not applicable
                                @else
                                    Invalid gender value
                                @endif</td>
                        </tr>
                        <tr>
                            <td>Birth date</td>
                            <td>{{ date('F j, Y', strtotime($user->birthdate)) }}</td>
                        </tr>
                        <tr>
                            <td>Nationality</td>
                            <td>{{ $user->nationality }}</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>{{ $user->phone }}</td>
                        </tr>
                        @if(count($user->studies) > 0)
                            <tr>
                                <td>Studies</td>
                                <td>

                                    @foreach($user->studies as $study)
                                        <p>
                                            <strong>{{ $study->name }}</strong><br>
                                            {{ $study->faculty }}

                                            <br>

                                            @if($study->pivot->till == null)
                                                Since {{ date('d-m-Y',strtotime($study->pivot->created_at)) }}
                                            @else
                                                Between {{ date('d-m-Y',strtotime($study->pivot->created_at)) }}
                                                and {{ date('d-m-Y',strtotime($study->pivot->till)) }}
                                            @endif
                                        </p>
                                    @endforeach

                                </td>
                            </tr>
                        @endif
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

            <div class="col-md-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Committees</h3>
                    </div>
                    <div class="panel-body">
                        @if(count($user->committees) > 0)
                            <ul class="list-group">
                                @foreach($user->committees as $committee)
                                    <li class="list-group-item">
                                        <strong>
                                            {{ $committee->name }}
                                        </strong>
                                        @if($committee->pivot->edition != null)
                                            {{ $committee->pivot->edition }}
                                        @endif
                                        <br>
                                        <sub>As {{$committee->pivot->role}} since {{$committee->pivot->start}}</sub>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            This member has never been in any committees.
                        @endif
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

        <div class="col-md-4 col-xs-4">
            <div class="btn-group btn-group-justified" role="group">
                <a class="btn btn-default" target="_blank" href="{{ route('user::membercard::download', ['id' => $user->id]) }}">
                    Print Card
                </a>
            </div>
        </div>

        <div class="col-md-4 col-xs-4">
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