@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Authorization Matrix
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white mb-1">
                    @yield('page-title')
                </div>

                <div class="card-body" style="overflow-x: scroll; overflow-y: hidden;">
                    <table class="table table-hover table-sm">

                        <?php $width = 100 / (count($permissions) + 1) ?>

                        <thead>
                        <tr class="bg-dark text-white">
                            <td>Role</td>
                            <td colspan="{{ count($permissions) }}">Permissions</td>
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
                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white mb-1">
                    Manage role membership
                </div>

                <div class="card-body accordion" id="role-accordion">

                    @foreach($roles as $i => $role)

                        <form method="post" action="{{ route('authorization::grant', ['id' => $role->id]) }}">

                            <div class="card mb-2">

                                <div class="card-header bg-info text-white" style="cursor: pointer;"
                                     data-bs-toggle="collapse" data-bs-target="#role-accordion-{{ $role->id }}">
                                    {{ $role->name }}
                                </div>

                                <div class="collapse" data-parent="#role-accordion" id="role-accordion-{{ $role->id }}">

                                    <div class="card-body">

                                        @foreach($role->users as $user)

                                            @include('users.includes.usercard', [
                                                'user' => $user,
                                                'subtitle' => sprintf('<div class="badge badge-%s text-white"><i class="fas fa-fw %s"></i> NDA</div>
                                                    <a href="%s"><div class="badge badge-warning"><i class="fas fa-fw fa-undo"></i> Revoke</div></a>',
                                                    $user->signed_nda ? 'primary' : 'danger',
                                                    $user->signed_nda ? 'fa-user-shield' : 'fa-user-times',
                                                    route("authorization::revoke", ['id' => $role->id, 'user' => $user->id]))
                                            ])

                                        @endforeach

                                    </div>

                                    <div class="card-footer">

                                        <select class="form-control user-search" name="user"></select>

                                        <input type="submit" class="btn btn-success btn-block mt-3" value="Grant">

                                    </div>

                                </div>

                            </div>

                            {!! csrf_field() !!}

                        </form>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

@endsection