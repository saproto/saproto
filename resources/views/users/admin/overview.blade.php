@extends('website.layouts.redesign.dashboard')

@section('page-title')
    User Administration
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-3">
            <form method="get" action="{{ route('user::admin::list') }}">
                <div class="card">
                    <div class="card-header bg-dark text-white">Search in users</div>
                    <div class="card-body">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search term" name="query"
                                   value="{{ $query }}">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-9">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white mb-1">
                    @yield('page-title')
                </div>

                <table class="table table-striped table-hover table-sm">

                    <thead>
                    <tr class="bg-dark text-white">
                        <td class="text-right">Controls</td>
                        <td></td>
                        <td>Name</td>
                        <td>Type</td>
                        <td>E-mail</td>
                        <td>Username</td>
                        <td>UTwente</td>
                        <td></td>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($users as $user)
                        <tr style="opacity: {{ $user->deleted_at ? '0.5' : '1' }};">
                            <td class="text-right">
                                @if(!$user->deleted_at)
                                    <a href="{{ route('user::admin::details', ['id'=>$user->id]) }}"
                                       data-toggle="tooltip" data-placement="top" title="Go to public profile">
                                        <i class="fas fa-info-circle fa-fw mr-2 text-info" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('user::profile', ['id'=>$user->getPublicId()]) }}"
                                       data-toggle="tooltip" data-placement="top" title="Go to user admin">
                                        <i class="fas fa-user-circle fa-fw mr-2 text-primary" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('user::member::impersonate', ['id'=>$user->id]) }}"
                                       data-toggle="tooltip" data-placement="top" title="Impersonate">
                                        <i class="fas fa-sign-in-alt fa-fw mr-2 text-warning" aria-hidden="true"></i>
                                    </a>
                                    @if ($user->isTempadmin())
                                        <a href="{{ route('tempadmin::end', ['id'=>$user->id]) }}"
                                           data-toggle="tooltip" data-placement="top" title="Revoke temp admin">
                                            <i class="fas fa-user-lock fa-fw text-dark" aria-hidden="true"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('tempadmin::make', ['id'=>$user->id]) }}"
                                           data-toggle="tooltip" data-placement="top" title="Grant temp admin till midnight">
                                            <i class="fas fa-user-clock fa-fw text-dark" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                @endif
                            </td>
                            <td class="text-right">#{{ $user->id }}</td>
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
                        </tr>
                    @endforeach
                    </tbody>

                </table>

                <div class="card-footer pb-0">
                    {!! $users->appends($_GET)->links() !!}
                </div>

            </div>

        </div>

    </div>

@endsection