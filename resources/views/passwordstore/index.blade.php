@extends('website.layouts.default')

@section('head')
    @parent
    <meta http-equiv="refresh" content="{{ Session::get('passwordstore-verify') - time() }}">
@endsection

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
                <th>&nbsp;</th>
                <th>Description</th>
                <th>Access</th>
                <th>URL</th>
                <th>Username</th>
                <th>Password</th>
                <th>Age</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>

            </tr>

            </thead>

            @foreach($passwords as $password)

                @if($password->canAccess(Auth::user()))

                    <tr>

                        <td>{{ $password->id }}</td>

                        <td>
                            @if($password->isNote())
                                <i class="fa fa-sticky-note-o" aria-hidden="true"></i>
                            @else
                                <i class="fa fa-key" aria-hidden="true"></i>
                            @endif
                        </td>

                        <td>
                            {{ $password->description }}
                        </td>
                        <td>{{ $password->permission->display_name }}</td>

                        @if($password->isNote())

                            <td colspan="3">
                                <span class="passwordmanager__shownote" data-toggle="modal"
                                      data-target="#passwordmodal-{{ $password->id }}">
                                    Click here to view this secure note.
                                </span>
                            </td>

                        @else

                            <td>
                                @if($password->url)
                                    <a href="{{ $password->url }}">{{ $password->url }}</a>
                                @endif
                            </td>
                            <td>{{ Crypt::decrypt($password->username) }}</td>
                            <td class="passwordmanager__password">{{ Crypt::decrypt($password->password) }}</td>

                        @endif

                        <td style="color: {{ ($password->age() > 12 ? '#ff0000' : '#00ff00') }};">
                            {{ $password->age() }} months
                        </td>

                        <td>
                            <a href="{{ route("passwordstore::edit", ['id' => $password->id]) }}">Edit</a>
                        </td>

                        <td>
                            <a href="{{ route("passwordstore::delete", ['id' => $password->id]) }}">Delete</a>
                        </td>

                    </tr>

                @endif

            @endforeach

        </table>

    @else

        <p style="text-align: center;">
            There is nothing for you to see.
        </p>

    @endif

    @foreach($passwords as $password)

        @if($password->isNote())

            <div class="modal fade" id="passwordmodal-{{ $password->id }}" tabindex="-1" role="dialog"
                 aria-labelledby="passwordmodal-label-{{ $password->id }}">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"
                                id="passwordmodal-label-{{ $password->id }}">{{ $password->description }}</h4>
                        </div>
                        <div class="modal-body">
                            <textarea class="form-control" rows="30"
                                      readonly>{{ Crypt::decrypt($password->note) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

        @endif

    @endforeach

@endsection