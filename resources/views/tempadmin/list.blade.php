@extends('website.layouts.default')

@section('page-title')
    Temporary Admin Admin
@endsection

@section('content')

    <p style="text-align: center;"><a href="{{ route('tempadmin::add') }}">Grant temporary admin access.</a></p>

    @if (count($tempadmins) > 0 || count($pastTempadmins) > 0)

        <table class="table">

            <thead>

            <tr>

                <th>User</th>
                <th>Given by</th>
                <th>From</th>
                <th>Until</th>
                <th>Controls</th>

            </tr>

            </thead>

            @foreach($tempadmins as $tempadmin)

                <tr>
                    <td><a href="{{ route("user::profile", ['id' => $tempadmin->user->getPublicId()]) }}">{{ $tempadmin->user->name }}</a></td>
                    <td><a href="{{ route("user::profile", ['id' => $tempadmin->creator->getPublicId()]) }}">{{ $tempadmin->creator->name }}</a></td>
                    <td @if(Carbon::parse($tempadmin->start_at)->isPast()) style="color: lightgray" @endif>{{ $tempadmin->start_at }}</td>
                    <td>{{ $tempadmin->end_at }}</td>
                    <td>
                        <a class="btn btn-xs btn-default"
                           href="{{ route("tempadmin::edit", ['id' => $tempadmin->id]) }}" role="button">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>

                        <a class="btn btn-xs btn-danger"
                           href="{{ route('tempadmin::endId', ['id' => $tempadmin->id]) }}" onclick="return confirm('Are you sure?')" role="button">
                            @if(Carbon::parse($tempadmin->start_at)->isFuture()) <i class="fa fa-trash-o" aria-hidden="true"></i>
                            @else <i class="fa fa-hourglass-end" aria-hidden="true"></i> @endif
                        </a>
                    </td>
                </tr>

            @endforeach

            @foreach($pastTempadmins as $pastTempadmin)

                <tr class="tempadmin__past">
                    <td><a href="{{ route("user::profile", ['id' => $pastTempadmin->user->getPublicId()]) }}">{{ $pastTempadmin->user->name }}</a></td>
                    <td><a href="{{ route("user::profile", ['id' => $pastTempadmin->creator->getPublicId()]) }}">{{ $pastTempadmin->creator->name }}</a></td>
                    <td>{{ $pastTempadmin->start_at }}</td>
                    <td>{{ $pastTempadmin->end_at }}</td>
                    <td>
                        <a class="btn btn-xs btn-default disabled"
                           href="#" role="button">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>

                        <a class="btn btn-xs btn-danger disabled"
                           href="#" role="button">
                            <i class="fa fa-hourglass-end" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>

            @endforeach

        </table>

    @else

        <p style="text-align: center;">There are no temporary admins. <a href="{{ route('tempadmin::add') }}">Grant temporary admin access.</a></p>

    @endif


    <style type="text/css">
        .tempadmin__past {
            color: lightgray;
        }

        .tempadmin__past a {
            color: lightgray;
        }
    </style>

@endsection