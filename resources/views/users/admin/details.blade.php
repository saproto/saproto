@extends('website.layouts.default')

@section('page-title')
    User: {{ $user->name }}
@endsection

@section('content')

    <div class="row">

        <div class="col-md-4">

            <ul class="list-group">

                @if(Auth::user()->can('sysadmin'))
                    <a class="list-group-item list-group-item-{{ $user->signed_nda ? 'success' : 'warning' }}"
                       href="{{ route('user::admin::toggle_nda', ['id' => $user->id]) }}">
                        User <strong>{{ !$user->signed_nda ? 'did not sign' : 'signed' }}</strong> an NDA.
                    </a>
                @endif

            <!-- Study details //-->
                <li class="list-group-item list-group-item-success">Study</li>
                <a class="list-group-item"
                   href="{{ route('user::admin::toggle_studied_create', ['id' => $user->id]) }}">
                    Has {!! $user->did_study_create ? '' : '<strong>not</strong>' !!} studied CreaTe.
                </a>

                <!-- Quicklinks //-->
                <li class="list-group-item list-group-item-success">Quicklinks</li>
                <a class="list-group-item" href="{{ route('user::dashboard', ['id' => $user->id]) }}">
                    Dashboard
                </a>
                @if($user->member)
                    <a class="list-group-item" href="{{ route('user::profile', ['id' => $user->getPublicId()]) }}">
                        Profile
                    </a>
                @endif

            <!-- Actions //-->
                <li class="list-group-item list-group-item-success">Actions</li>
                <a class="list-group-item"
                   href="{{ route("user::member::impersonate", ["id" => $user->id]) }}">
                    Impersonate
                </a>
                @if($user->isTempadmin())
                    <a href="{{ route('tempadmin::end', ['id' => $user->id]) }}"
                       class="list-group-item">
                        End temporary admin
                    </a>
                @else
                    <a href="{{ route('tempadmin::make', ['id' => $user->id]) }}"
                       class="list-group-item">
                        Make temporary admin
                    </a>
                @endif

            <!-- Membership //-->
                <li class="list-group-item list-group-item-success">
                    Membership
                    @if($user->member)
                        (member since {{ date('d-m-Y', strtotime($user->member->created_at)) }})
                    @else
                        (not a member)
                    @endif
                </li>
                @if($user->member)
                    <li class="list-group-item" data-toggle="modal" data-target="#removeMembership">
                        End membership
                    </li>
                    <a href="{{ route('membercard::download', ['id' => $user->id]) }}" target="_blank"
                       class="list-group-item">
                        Preview membership card
                    </a>
                    <li id="print-card" data-id="{{ $user->id }}" class="list-group-item">
                        Print membership card<br>
                        (Last printed: {{ $user->member->card_printed_on }})
                    </li>
                    <li id="print-card-overlay" data-id="{{ $user->id }}" class="list-group-item">
                        Print opener overlay
                    </li>

                @else
                    <li class="list-group-item" data-toggle="modal" data-target="#addMembership">
                        Make member
                    </li>
                @endif
                @if($user->address&&$user->hasCompletedProfile())
                    <a class="list-group-item" href="{{ route('memberform::download', ['id' => $user->id]) }}">
                        Show membership form
                    </a>
                    <li id="print-form" data-id="{{ $user->id }}" class="list-group-item">Print membership form</li>
                @endif
            </ul>

        </div>

        <div class="col-md-4">

            <h3 style="text-align: center;">Update user</h3>

            <form class="form-horizontal" method="post"
                  action="{{ route("user::admin::update", ["id" => $user->id]) }}">

                {!! csrf_field() !!}

                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">Name</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">Calling name</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="calling_name" name="calling_name"
                               value="{{ $user->calling_name }}"
                               required>
                    </div>
                </div>

                @if($user->hasCompletedProfile())

                    <div class="form-group">
                        <label for="birthdate" class="col-sm-4 control-label">Birthday</label>

                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="birthdate" name="birthdate"
                                   value="{{ $user->birthdate }}">
                        </div>
                    </div>

                @endif

                <div class="col-sm-8 col-sm-offset-4">
                    <button type="submit" class="btn btn-success">Update User Account</button>
                </div>

            </form>

            <br><br>

            <h3 style="text-align: center;">Contact</h3>

            <div class="form-group">
                <div class="form-horizontal">

                    <label class="col-sm-4 control-label">Email</label>
                    <div class="col-sm-8 control-label" style="text-align: left;">
                        {{ $user->email }}
                    </div>

                    @if($user->phone)
                        <label class="col-sm-4 control-label">Phone</label>
                        <div class="col-sm-8 control-label" style="text-align: left;">
                            {{ $user->phone }}
                        </div>
                    @endif

                    @if($user->address)
                        <label class="col-sm-4 control-label">Address</label>
                        <div class="col-sm-8 control-label" style="text-align: left;">
                            @if ($user->address)
                                {{ $user->address->street }} {{ $user->address->number }}<br>
                                {{ $user->address->zipcode }} {{ $user->address->city }} ({{ $user->address->country }})
                            @else
                                <i>n/a</i>
                            @endif
                        </div>
                    @endif

                </div>
            </div>

        </div>

        <div class="col-md-4">

            <br>

            <div class="profile__photo-wrapper">
                <img class="profile__photo" src="{{ $user->generatePhotoPath(200, 200) }}" alt="">
            </div>

        </div>

    </div>

    <!-- Modal for adding membership to user -->
    @include("users.admin.add")

    <!-- Modal for removing membership from user -->
    @include("users.admin.remove")

@endsection

@section('stylesheet')

    @parent

    <style type="text/css">

        .list-group-item {
            cursor: pointer;
        }

        .list-group-item-success {
            cursor: default !important;
            font-weight: 700 !important;
        }

    </style>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">

        $('body').delegate('#print-card', 'click', function () {

            if (confirm("Please confirm you want to print a membership card.")) {
                $.ajax({
                    url: '{{ route('membercard::print') }}',
                    data: {
                        '_token': '{!! csrf_token() !!}',
                        'id': $(this).attr('data-id')
                    },
                    method: 'post',
                    dataType: 'html',
                    success: function (data) {
                        alert(data);
                    },
                    error: function (data) {
                        alert("Something went wrong while requesting the print.");
                    }
                });
            }

        });

        $('body').delegate('#print-card-overlay', 'click', function () {

            if (confirm("Please confirm you have the right member card loaded.")) {
                $.ajax({
                    url: '{{ route('membercard::printoverlay') }}',
                    data: {
                        '_token': '{!! csrf_token() !!}',
                        'id': $(this).attr('data-id')
                    },
                    method: 'post',
                    dataType: 'html',
                    success: function (data) {
                        alert(data);
                    },
                    error: function (data) {
                        alert("Something went wrong while requesting the print.");
                    }
                });
            }

        });

        $('body').delegate('#print-form', 'click', function () {

            if (confirm("Please confirm you want to print a membership document.")) {
                $.ajax({
                    url: '{{ route('memberform::print') }}',
                    data: {
                        '_token': '{!! csrf_token() !!}',
                        'id': $(this).attr('data-id')
                    },
                    method: 'post',
                    dataType: 'html',
                    success: function (data) {
                        alert(data);
                    },
                    error: function (data) {
                        alert("Something went wrong while requesting the print.");
                    }
                });
            }

        });

    </script>

@endsection
