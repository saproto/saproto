@extends('website.default.container')

@section('page-title')
    Profile of {{ $user->name }}
@endsection

@section('container')

    <div class="row">

        <div class="col-md-4 col-xs-12">

            <!-- Public profile //-->

            <div class="panel panel-default">
                <div class="panel-body" style="padding: 0; position: relative;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; padding: 0 20px; background-color: rgba(0,0,0,0.5);">
                        <h3 style="color: #fff">{{ $user->name }}</h3></div>
                    <img src="//www.gravatar.com/avatar/{{ md5($user->email) }}?s=1000" width="100%">
                </div>
            </div>

            <div class="panel panel-default">

                <div class="panel-body">

                    <!-- Member information //-->

                    @if($user->member != null)

                        @foreach($user->studies as $study)
                            @if ((strtotime($study->pivot->till) > date('U') || $study->pivot->till == null) && strtotime($study->pivot->created_at) < date('U'))
                                <p>
                                    <span class="pull-right" style="text-align: right;">
                                        {{ $study->name }}
                                    </span>

                                    <strong>
                                        Study
                                    </strong>

                                <div class="clearfix"></div>
                                </p>
                            @endif
                        @endforeach

                        <p><strong>E-mail</strong> <span class="pull-right"><a
                                        href="mailto:{{ $user->email }}">{{ $user->email }}</a></span></p>

                        @if($user->member->phone_visible)
                            <p><strong>Phone</strong> <span class="pull-right"><a
                                            href="tel:{{ $user->member->phone }}">{{ $user->member->phone }}</a></span>
                            </p>
                        @endif

                        @foreach($user->address as $address)
                            @if(($address->is_primary == true && ($user->member->address_visible || Auth::id() == $user->id || Auth::user()->can('bigbrother'))))
                                <hr>
                                <p>
                                    <span class="pull-right" style="text-align: right;">
                                        {{ $address->street }} {{ $address->number }}<br>
                                        {{ $address->zipcode }} {{ $address->city }}<br>
                                        {{ $address->country }}
                                    </span>

                                    <strong>
                                        Address
                                    </strong>

                                <div class="clearfix"></div>
                                </p>
                            @endif
                        @endforeach

                    @else

                        <strong style="text-align: center;">This user is not a member.</strong>

                    @endif

                    <div class="clearfix"></div>

                </div>

            </div>

        </div>

        @if(Auth::id() == $user->id || Auth::user()->can('bigbrother'))

            <div class="col-md-4 col-xs-12">

                <p style="text-align: center;"><strong>Only you can see this column.</strong></p>

                <!-- Address boxes //-->

                <hr>

                @foreach($user->address as $address)
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            @if($address->is_primary == true)
                                Address <p class="pull-right"><i class="fa fa-star"></i></p>
                            @else
                                Address <p class="pull-right"><i class="fa fa-home"></i></p>
                            @endif
                        </div>

                        <div class="panel-body">

                            <p>
                                {{ $address->street }} {{ $address->number }}<br>
                                {{ $address->zipcode }} {{ $address->city }} ({{ $address->country }})
                            </p>

                            <div class="clear-fix"></div>

                            @if((Auth::user()->can('board') || Auth::id() == $user->id))
                                <div class="row">
                                    <div class="col-md-4 col-xs-4 pull-right">
                                        <form method="POST"
                                              action="{{ route('user::address::delete', ['address_id' => $address->id, 'id' => $user->id]) }}">
                                            {!! csrf_field() !!}
                                            <div class="btn-group btn-group-justified" role="group">
                                                <a class="btn btn-default">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                    @if ($address->is_primary == false)
                                        <div class="col-md-4 col-xs-4 pull-right">
                                            <form method="POST"
                                                  action="{{ route('user::address::primary', ['address_id' => $address->id, 'id' => $user->id]) }}">
                                                {!! csrf_field() !!}
                                                <div class="btn-group btn-group-justified" role="group">
                                                    <div class="btn-group" role="group">
                                                        <button type="submit" class="btn btn-default">
                                                            <i class="fa fa-star"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                    @if ($address->is_primary == false || $user->member == null)
                                        <div class="col-md-4 col-xs-4 pull-right">
                                            <form method="POST"
                                                  action="{{ route('user::address::delete', ['address_id' => $address->id, 'id' => $user->id]) }}">
                                                {!! csrf_field() !!}
                                                <div class="btn-group btn-group-justified" role="group">
                                                    <div class="btn-group" role="group">
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fa fa-trash-o"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endif

                        </div>
                    </div>
                @endforeach

                <div class="btn-group-justified btn-group" role="group">
                    <a type="button" class="btn btn-success"
                       href="{{ route('user::address::add', ['id' => $user->id]) }}">Add
                        address</a>
                </div>

                <!-- Authorization bank account boxes //-->

                <hr>

                @if($user->bank != null)

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Bank Account <p class="pull-right"><i class="fa fa-bank"></i></p>
                        </div>
                        <div class="panel-body">

                            <p style="text-align: center">
                                <strong>{{ $user->bank->iban }}</strong>&nbsp;&nbsp;&nbsp;&nbsp;{{ $user->bank->bic }}
                            </p>

                            <p style="text-align: center">
                                <sub>{{ ($user->bank->withdrawal_type == "FRST" ? "First time" : "Recurring") }}
                                    authorization issued on {{ $user->bank->created_at }}.<br>
                            </p>

                            <div class="clear-fix"></div>

                            <div class="btn-group btn-group-justified" role="group">
                                <div class="btn-group" role="group">
                                    <button type="submit" class="btn btn-danger" data-toggle="modal"
                                            data-target="#bank-modal-cancel">
                                        Cancel authorization
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                @else

                    <div class="btn-group btn-group-justified" role="group">
                        <div class="btn-group" role="group">
                            <button type="submit" class="btn btn-success" data-toggle="modal"
                                    data-target="#bank-modal-add">
                                Authorize for automatic withdrawal
                            </button>
                        </div>
                    </div>

                @endif

                <hr>

                <!-- Study boxes //-->

                @if(count($user->studies) == 0)
                    <p style="text-align: center;">
                        <strong>
                            No studies registered for this user.
                        </strong>
                    </p>
                @else
                    @foreach($user->studies as $study)

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Study <p class="pull-right"><i class="fa fa-graduation-cap"></i></p>
                            </div>
                            <div class="panel-body">

                                <p style="text-align: center">

                                    <strong>{{ $study->name }}</strong>

                                    <br>

                                    @if($study->pivot->till == null)
                                        Since {{ date('d-m-Y',strtotime($study->pivot->created_at)) }}
                                    @else
                                        Between {{ date('d-m-Y',strtotime($study->pivot->created_at)) }}
                                        and {{ date('d-m-Y',strtotime($study->pivot->till)) }}
                                    @endif

                                </p>

                                <div class="clear-fix"></div>

                                <div class="col">

                                    <div class="col-md-6">
                                        <div class="btn-group-justified btn-group" role="group">
                                            <a type="button" class="btn btn-default" href="{{ route("user::study::edit", ["id" => $user->id, "study_id" => $study->id]) }}">Edit</a>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <form method="POST"
                                              action="{{ route('user::study::delete', ['study_id' => $study->id, 'id' => $user->id]) }}">
                                            {!! csrf_field() !!}
                                            <div class="btn-group btn-group-justified" role="group">
                                                <div class="btn-group" role="group">
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>

                            </div>
                        </div>

                    @endforeach
                @endif

                <div class="btn-group-justified btn-group" role="group">
                    <a href="{{ route("user::study::add", ['id' => $user->id]) }}" class="btn btn-success">Add study</a>
                </div>

            </div>

        @endif

    </div>

    @include("users.profile.addbank")
    @include("users.profile.deletebank");

@endsection
