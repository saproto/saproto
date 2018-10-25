@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Achievement Administration
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white mb-1">
                    @yield('page-title')
                    <a href="{{ route('achievement::add') }}" class="badge badge-info float-right">
                        Create a new achievement.
                    </a>
                </div>

                <table class="table table-hover table-sm">

                    <thead>

                    <tr class="bg-dark text-white">

                        <td></td>
                        <td>Title</td>
                        <td>Awarded</td>
                        <td>Description</td>
                        <td>Tier</td>
                        <td class="text-dark">Controls</td>

                    </tr>

                    </thead>

                    @foreach($achievements as $achievement)

                        <tr>

                            <td class="hidden-sm hidden-xs {{ $achievement->tier }}">
                                @if($achievement->fa_icon)
                                    <div><i class="{{ $achievement->fa_icon }} fa-fw"></i></div>
                                @else
                                    No icon available
                                @endif
                            </td>
                            <td>{{ $achievement->name }}</td>
                            <td>{{ count($achievement->currentOwners(true)) }}</td>
                            <td>{{ $achievement->desc }}</td>
                            <td>{{ $achievement->tier }}</td>
                            <td class="text-right">
                                <a href="{{ route('achievement::manage', ['id' => $achievement->id]) }}">
                                    <i class="fas fa-edit mr-2"></i>
                                </a>
                                <a href="{{ route('achievement::delete', ['id' => $achievement->id]) }}">
                                    <i class="fas fa-trash text-danger"></i>
                                </a>
                            </td>

                        </tr>

                    @endforeach

                </table>

                <div class="card-footer pb-0">
                    {!! $achievements->links() !!}
                </div>

            </div>

        </div>

    </div>

@endsection