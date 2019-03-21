@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Alias Management
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white mb-1">
                    @yield('page-title')
                </div>

                <table class="table table-hover">

                    <thead>

                    <tr class="bg-dark text-white">

                        <td class="text-right">Alias</td>
                        <td>Destination</td>

                    </tr>

                    </thead>

                    @foreach($aliases as $alias => $destinations)

                        <tr>

                            <td class="text-right">

                                <strong>{{ $alias }}</strong> @ {{ config('proto.emaildomain') }}

                                <a href="{{ route('alias::delete', ['idOrAlias' => $alias]) }}" class="ml-2">
                                    <i class="fas fa-trash text-danger"></i>
                                </a>

                            </td>
                            <td>

                                @foreach($destinations as $destination)

                                    <a href="{{ route('alias::delete', ['idOrAlias' => $destination->id]) }}" class="mr-2">
                                        <i class="fas fa-trash text-danger"></i>
                                    </a>

                                    @if($destination->destination)
                                        {{ $destination->destination }}
                                    @elseif($destination->user)
                                        @if($destination->user->isMember)
                                            <a href="{{ route('user::profile', ['id' => $destination->user->getPublicId()]) }}">
                                                @endif
                                                @if($destination->user->trashed())
                                                    <span style="text-decoration: line-through;">{{ $destination->user->name }}</span>
                                                @else
                                                    {{ $destination->user->name }}
                                                @endif
                                                @if($destination->user->isMember)
                                            </a>
                                        @endif
                                    @else
                                        <i>deleted user</i>
                                    @endif

                                    <br>

                                @endforeach

                            </td>

                        </tr>

                    @endforeach

                </table>

            </div>

        </div>

        <div class="col-md-2">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white">
                    Make changes
                </div>

                <div class="card-body">

                    <p>
                        <a href="{{ route('alias::add') }}" class="form-control btn btn-success">Create a new alias.</a>
                    </p>

                    <p style="text-align: center;">
                        - or -
                    </p>

                    <form method="post" action="{{ route('alias::update') }}">

                        {{ csrf_field() }}

                        <input class="form-control mb-3" name="from" placeholder="old alias name">
                        <input class="form-control" name="into" placeholder="new alias name">

                        <br>

                        <input type="submit" class="form-control btn btn-success" value="Rename">

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection