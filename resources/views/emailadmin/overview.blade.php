@extends('website.layouts.default')

@section('page-title')
    E-mail Administration
@endsection

@section('content')

    <div class="row">

        <div class="col-md-6">

            <h3>E-mail lists (<a href="{{ route('email::list::add') }}">create new</a>)</h3>

            <table class="table">

                <thead>

                <tr>

                    <th>#</th>
                    <th>List name</th>
                    <th>Public</th>
                    <th>Subscribers</th>
                    <th>Controls</th>

                </tr>

                </thead>

                <tr>
                    <td>&nbsp;</td>
                    <td>All users</td>
                    <td><i>System managed</i></td>
                    <td>{{ User::count() }}</td>
                    <td><i>Not editable</i></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td>All members</td>
                    <td><i>System managed</i></td>
                    <td>{{ Member::count() }}</td>
                    <td><i>Not editable</i></td>
                </tr>

                @foreach($lists as $list)

                    <tr>

                        <td>{{ $list->id }}</td>
                        <td>{{ ($list->is_member_only ? 'Member only' : 'Public') }}</td>
                        <td>{{ $list->name }}</td>
                        <td>{{ $list->users->count() }}</td>
                        <td>
                            <a class="btn btn-xs btn-default"
                               href="{{ route('email::list::edit', ['id' => $list->id]) }}" role="button">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            <a class="btn btn-xs btn-danger"
                               href="{{ route('email::list::delete', ['id' => $list->id]) }}" role="button">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>
                        </td>

                    </tr>

                @endforeach

            </table>

        </div>

    </div>

@endsection