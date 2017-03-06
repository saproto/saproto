@extends('website.layouts.default')

@section('page-title')
    User Administration
@endsection

@section('content')

    <div class="row">
        <div class="col-md-5 col-xs-12">
            <form method="get" action="{{ route('user::admin::list') }}">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="text" name="query" class="form-control" id="search" placeholder="Search..."
                           value="{{ $query }}">
                    <span class="input-group-btn"><button class=" btn btn-default" id="goSearch">Go!</button></span>
                </div>
            </form>
        </div>
        <div class="col-md-7 col-xs-12">
            <div class="pull-right">
                {!! $users->render() !!}
            </div>
        </div>
    </div>

    <hr>

    <table class="table table-striped table-hover">

        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Type</th>
            <th>E-mail</th>
            <th>Phone</th>
            <th>Birthday</th>
            <th>Username</th>
            <th>UTwente</th>
            <th></th>
        </tr>
        </thead>

        <tbody>
        @foreach($users as $user)
            <tr style="opacity: {{ $user->deleted_at ? '0.5' : '1' }};">
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }} ({{ $user->calling_name }})</td>
                <td>
                    @if($user->deleted_at)
                        Deleted
                    @elseif($user->member)
                        Member
                    @else
                        User
                    @endif
                </td>
                <td>
                    {{ $user->email }}
                </td>
                <td>
                    @if(!$user->deleted_at)
                        {{ $user->phone }}
                    @endif
                </td>
                <td>
                    @if(!$user->deleted_at)
                        {{ $user->birthdate }} ({{$user->age()}})
                    @endif
                </td>
                <td>
                    @if($user->member)
                        {{$user->member->proto_username}}
                    @endif
                </td>
                <td>
                    {{ $user->utwente_username }}
                </td>
                <td>
                    @if(!$user->deleted_at)
                        <a class="btn btn-default btn-xs" href="{{ route('user::admin::details', ['id'=>$user->id]) }}">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        @else
                        <a class="btn btn-default btn-xs" href="{{ route('user::admin::restore', ['id'=>$user->id]) }}">
                            <i class="fa fa-refresh" aria-hidden="true"></i>
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

    <hr>

    <div class="pull-right">
        {!! $users->render() !!}
    </div>

@endsection

@section('stylesheet')

    @parent

    <style type="text/css">

        .pagination {
            margin: 0 !important;
        }

    </style>

@endsection