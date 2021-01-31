@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Committee Leaderboards
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white mb-1">
                    @yield('page-title')
                    <a href="{{ route('leaderboards::add') }}" class="badge badge-info float-right">
                        Create a new leaderboard.
                    </a>
                </div>

                <table class="table table-sm table-hover">

                    <thead>

                    <tr class="bg-dark text-white">

                        <td>Leaderboard</td>
                        <td>Committee</td>
                        <td></td>

                    </tr>

                    </thead>

                    @foreach($leaderboards as $leaderboard)

                        <tr>

                            <td>{{ $leaderboard->name }}</td>
                            <td>{{ $leaderboard->committee->name}}</td>
                            <td>
                                <a href="{{ route('leaderboards::edit', ['id' => $leaderboard->id]) }}">
                                    <i class="fas fa-edit mr-2 fa-fw"></i>
                                </a>
                                <a href="{{ route('leaderboards::delete', ['id' => $leaderboard->id]) }}">
                                    <i class="fas fa-trash text-danger fa-fw"></i>
                                </a>
                            </td>

                        </tr>

                    @endforeach

                </table>

            </div>

        </div>

    </div>

@endsection