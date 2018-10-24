@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Temporary Admin Admin
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white mb-1">
                    @yield('page-title')
                    <a href="{{ route('tempadmin::add') }}" class="float-right badge-info badge">
                        Add new temporary admin.
                    </a>
                </div>

                <table class="table table-hover table-sm">

                    <thead>

                    <tr class="bg-dark text-white">

                        <td class="pl-3">User</td>
                        <td>Given by</td>
                        <td>From</td>
                        <td>Until</td>
                        <td></td>

                    </tr>

                    </thead>

                    @foreach($tempadmins as $tempadmin)

                        <tr>
                            <td class="pl-3">
                                <a href="{{ route("user::profile", ['id' => $tempadmin->user->getPublicId()]) }}">{{ $tempadmin->user->name }}</a>
                            </td>
                            <td>
                                <a href="{{ route("user::profile", ['id' => $tempadmin->creator->getPublicId()]) }}">{{ $tempadmin->creator->name }}</a>
                            </td>
                            <td @if(Carbon::parse($tempadmin->start_at)->isPast()) class="text-muted" @endif>{{ $tempadmin->start_at }}</td>
                            <td>{{ $tempadmin->end_at }}</td>
                            <td>
                                <a href="{{ route("tempadmin::edit", ['id' => $tempadmin->id]) }}">
                                    <i class="fas fa-edit fa-fw mr-2"></i>
                                </a>

                                <a href="{{ route('tempadmin::endId', ['id' => $tempadmin->id]) }}"
                                   onclick="return confirm('Are you sure?')" role="button">
                                    @if(Carbon::parse($tempadmin->start_at)->isFuture())
                                        <i class="fas fa-trash fa-fw text-danger"></i>
                                    @else
                                        <i class="fas fa-hourglass-end text-danger fa-fw"></i>
                                    @endif
                                </a>
                            </td>
                        </tr>

                    @endforeach

                    @foreach($pastTempadmins as $pastTempadmin)

                        <tr class="text-muted">
                            <td class="pl-3">
                                <a href="{{ route("user::profile", ['id' => $pastTempadmin->user->getPublicId()]) }}">{{ $pastTempadmin->user->name }}</a>
                            </td>
                            <td>
                                <a href="{{ route("user::profile", ['id' => $pastTempadmin->creator->getPublicId()]) }}">{{ $pastTempadmin->creator->name }}</a>
                            </td>
                            <td>{{ $pastTempadmin->start_at }}</td>
                            <td>{{ $pastTempadmin->end_at }}</td>
                            <td></td>
                        </tr>

                    @endforeach

                </table>


            </div>

        </div>

    </div>

@endsection