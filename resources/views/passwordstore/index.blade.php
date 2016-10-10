@extends('website.layouts.default')

@section('page-title')
    Password Store
@endsection

@section('content')

    <p style="text-align: center;">
        <a href="{{ route('passwordstore::add', ['type' => 'password']) }}" class="btn btn-success">
            Add Password
        </a>
        <a href="{{ route('passwordstore::add', ['type' => 'note']) }}" class="btn btn-success">
            Add Secure Note
        </a>
    </p>

    <hr>

    @if (count($passwords) > 0)

        <table class="table">

            <thead>

            <tr>

                <th>#</th>
                <th>Description</th>
                <th>Access</th>
                <th>URL</th>
                <th>Username</th>
                <th>Updated</th>

            </tr>

            </thead>

            @foreach($passwords as $password)

                @if($password->canAccess(Auth::user()))

                    <tr>

                        <td>{{ $password->id }}</td>
                        <td>
                            <a href="{{ route('passwordstore::show', ['id' => $password->id]) }}">
                                {{ $password->description }}
                            </a>
                        </td>
                        <td>{{ $password->permission->display_name }}</td>

                        @if($password->isNote())

                            <td colspan="2"></td>

                        @else

                            <td>
                                @if($password->url)
                                    <a href="{{ $password->url }}">{{ $password->url }}</a>
                                @endif
                            </td>
                            <td>{{ Crypt::decrypt($password->username) }}</td>

                        @endif

                        <td>{{ date('d-m-Y', strtotime($password->updated_at)) }}</td>

                    </tr>

                @endif

            @endforeach

        </table>

    @else

        <p style="text-align: center;">
            There is nothing for you to see.
        </p>

    @endif

@endsection