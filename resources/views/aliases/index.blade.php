@extends('website.layouts.default')

@section('page-title')
    Alias Management
@endsection

@section('content')

    <div class="row">

        <div class="col-md-9">

            <table class="table">

                <thead>

                <tr>

                    <th style="text-align: right;">Alias</th>
                    <th>Destination</th>

                </tr>

                </thead>

                @foreach($aliases as $alias => $destinations)

                    <tr>

                        <td style="text-align: right;">

                            <a href="{{ route('alias::delete', ['idOrAlias' => $alias]) }}">
                                <span class="label label-danger pull-left">delete alias</span>
                            </a>

                            <strong>{{ $alias }}</strong> @ {{ config('proto.emaildomain') }}

                        </td>
                        <td>

                            @foreach($destinations as $destination)

                                @if($destination->destination)
                                    {{ $destination->destination }}
                                @elseif($destination->user)
                                    <a href="{{ route('user::profile', ['id' => $destination->user->getPublicId()]) }}">
                                        @if($destination->user->trashed())
                                            <span style="text-decoration: line-through;">{{ $destination->user->name }}</span>
                                        @else
                                            {{ $destination->user->name }}
                                        @endif
                                    </a>
                                @else
                                    <i>deleted user</i>
                                @endif

                                <a href="{{ route('alias::delete', ['idOrAlias' => $destination->id]) }}">
                                    <span class="label label-danger pull-right">delete destination</span>
                                </a>

                                <br>

                            @endforeach

                        </td>

                    </tr>

                @endforeach

            </table>

        </div>

        <div class="col-md-3">

            <p>
                <a href="{{ route('alias::add') }}" class="form-control btn btn-success">Create a new alias.</a>
            </p>

            <p style="text-align: center;">
                - or -
            </p>

            <form method="post" action="{{ route('alias::update') }}">

                {{ csrf_field() }}

                <input class="form-control" name="from" placeholder="old alias name">
                <input class="form-control" name="into" placeholder="new alias name">

                <br>

                <input type="submit" class="form-control btn btn-success" value="Rename">

            </form>

        </div>

    </div>

@endsection