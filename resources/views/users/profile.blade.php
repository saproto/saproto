@extends('website.default.container')

@section('container')

    <div class="row">

        <div class="col-md-4 col-xs-12">

            <div class="panel panel-default">
                <div class="panel-body" style="padding: 0; position: relative;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; padding: 0 20px; background-color: rgba(0,0,0,0.5);">
                        <h3 style="color: #fff">{{ $user->name }}</h3></div>
                    <img src="http://www.gravatar.com/avatar/{{ md5($user->email) }}?s=1000" width="100%">
                </div>
            </div>

            <div class="panel panel-default">

                <div class="panel-body">

                    <p><strong>E-mail</strong> <span class="pull-right"><a
                                    href="mailto:{{ $user->email }}">{{ $user->email }}</a></span></p>

                    @if($user->member != null)

                        @if($user->member->phone_visible)
                            <p><strong>Phone</strong> <span class="pull-right"><a
                                            href="tel:{{ $user->member->phone }}">{{ $user->member->phone }}</a></span>
                            </p>
                        @endif

                        @foreach($user->address as $address)
                            @if(($address->type == "STUDY" && ($user->member->address_visible || Auth::id() == $user->id || Auth::user()->can('bigbrother'))))
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
                                </p>
                            @endif
                        @endforeach

                        @if(count($user->address) == 0)
                            <strong style="text-align: center;">This user has no addresses.</strong>
                        @endif

                    @endif

                    <div class="clearfix"></div>

                </div>

            </div>

        </div>

        @if(Auth::id() == $user->id || Auth::user()->can('bigbrother'))

            <div class="col-md-4 col-xs-12">

                @foreach($user->address as $address)
                    <div class="panel panel-default">
                        <div class="panel-body">

                            <p class="pull-right" style="text-align: right;">
                                {{ $address->street }} {{ $address->number }}<br>
                                {{ $address->zipcode }} {{ $address->city }}<br>
                                {{ $address->country }}
                            </p>

                            <p>
                                <strong>
                                    @if($address->type == 'STUDY')
                                        <i class="fa fa-graduation-cap"></i>
                                    @elseif($address->type == 'HOME')
                                        <i class="fa fa-users"></i>
                                    @elseif($address->type == 'OTHER')
                                        <i class="fa fa-home"></i>
                                    @endif
                                    Address
                                </strong>
                            </p>

                            <div class="btn-group-justified btn-group" role="group">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default">Edit</button>
                                </div>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-danger">Delete</button>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach

                <div class="btn-group-justified btn-group" role="group">
                    <div class="btn-group" role="group">
                        <a type="button" class="btn btn-success" href="{{ route('user::address::add', ['id' => Auth::user()->id]) }}">New
                            address</a>
                    </div>
                </div>

            </div>

        @endif

    </div>




@endsection