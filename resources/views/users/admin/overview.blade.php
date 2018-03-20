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
            <th>Username</th>
            <th>UTwente</th>
            <th>&nbsp;</th>
            <th>Controls</th>
        </tr>
        </thead>

        <tbody>
        @foreach($users as $user)
            <tr style="opacity: {{ $user->deleted_at ? '0.5' : '1' }};">
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>
                    @if($user->deleted_at)
                        Deleted
                    @elseif($user->member)
                        <strong>Member</strong>
                    @else
                        User
                    @endif
                </td>
                <td>
                    {{ $user->deleted_at ? '' : $user->email }}
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
                    {{ $user->utwente_department }}
                </td>
                <td>
                    @if(!$user->deleted_at)
                        <a class="btn btn-default btn-xs" href="{{ route('user::admin::details', ['id'=>$user->id]) }}">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-default btn-xs" href="{{ route('user::dashboard', ['id'=>$user->id]) }}">
                            <i class="fa fa-dashboard" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-default btn-xs" href="{{ route('user::profile', ['id'=>$user->getPublicId()]) }}">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-default btn-xs"
                           href="{{ route('user::member::impersonate', ['id'=>$user->id]) }}">
                            <i class="fa fa-user-secret" aria-hidden="true"></i>
                        </a>
                        @if ($user->isTempadmin())
                            <a class="btn btn-default btn-xs"
                               href="{{ route('tempadmin::end', ['id'=>$user->id]) }}">
                                <i class="fa fa-user-times" aria-hidden="true"></i>
                            </a>
                        @else
                            <a class="btn btn-default btn-xs"
                               href="{{ route('tempadmin::make', ['id'=>$user->id]) }}">
                                <i class="fa fa-user-plus" aria-hidden="true"></i>
                            </a>
                        @endif
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