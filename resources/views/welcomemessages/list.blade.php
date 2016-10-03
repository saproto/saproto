@extends('website.layouts.default')

@section('page-title')
    Welcome Messages
@endsection

@section('content')

    @include('welcomemessages.addmessage')

    <hr>

    @if (count($messages) > 0)

        <table class="table">

            <thead>

            <tr>

                <th>#</th>
                <th>User</th>
                <th>Message</th>
                <th>Date Set</th>

            </tr>

            </thead>

            @foreach($messages as $message)

                <tr>

                    <td>{{ $message->id }}</td>
                    <td><a href="{{ route('user::profile', ['id' => $message->user->id]) }}">{{ $message->user->name }}</a></td>

                    <td>{{ $message->message }}</td>

                    <td>{{ $message->updated_at->format('d/m/Y') }}</td>

                    <td>
                        <a class="btn btn-xs btn-danger"
                           href="{{ route('welcomeMessages::delete', ['id' => $message->id]) }}" role="button">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>

                </tr>

            @endforeach

        </table>

    @else

        <p style="text-align: center;">
            No current welcome messages set
        </p>

    @endif

@endsection