@extends('website.layouts.default')

@section('page-title')
    Authorization Matrix
@endsection

@section('content')

    <table class="table">

        <?php $width = 100 / (count($permissions) + 1) ?>

        <thead>
        <tr>
            <th>Role</th>
            <th colspan="{{ count($permissions) }}">Permissions</th>
        </tr>
        </thead>

        <tbody>
        @foreach($roles as $role)
            <tr>
                <th width="{{ $width }}%">
                    {{ $role->name }}
                </th>
                @foreach($permissions as $permission)
                    <td width="{{ $width }}%">
                        <span style="opacity: {{ DB::table('permission_role')->wherePermissionId($permission->id)->whereRoleId($role->id)->count() > 0 ? '1' : '0.2' }};">
                            {{ $permission->name }}
                        </span>
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>

    </table>

    <hr>

    <p>
        Below it is possible to assign and unassign people to and from the various roles. Please keep in mind that most
        roles are automatically (un)assigned when a user authenticates and changes may thus be discarded the next time a
        user logs in. For those roles adding or removing the member from the roles associated committee probably is what
        you're looking for. Adding and removing roles and permissions, as well as changing their association, can only
        be done in the application code.
    </p>

    <hr>

    @foreach($roles as $i => $role)

        @if ($i % 4 == 0)

            <div class="row">

                @endif

                <div class="col-md-3">

                    <form method="post" action="{{ route('authorization::grant', ['id' => $role->id]) }}">

                        <div class="list-group">
                            <a class="list-group-item list-group-item-success">
                                <strong>{{ $role->name }}</strong>
                            </a>

                            @foreach($role->users as $user)
                                <span class="list-group-item">
                                    {{ $user->name }}
                                    <span class="pull-right">
                                        <a href="{{ route("authorization::revoke", ['id' => $role->id, 'user' => $user->id]) }}">
                                           X
                                       </a>
                                    </span>
                                </span>
                            @endforeach
                        </div>

                        <select class="form-control" name="user">
                            @foreach(User::orderBy('name', 'asc')->get() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} (#{{ $user->id }})</option>
                            @endforeach
                        </select>
                        <br>
                        <input type="submit" class="btn btn-success" value="Grant">

                        {!! csrf_field() !!}

                    </form>

                </div>

                @if ($i % 4 == 3 || $i == count($roles) - 1)

            </div>

            <hr>

        @endif

    @endforeach

@endsection