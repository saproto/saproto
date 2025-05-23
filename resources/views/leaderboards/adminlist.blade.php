@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Leaderboards
@endsection

@section('container')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-dark mb-1 text-white">
                    @yield('page-title')
                    <a
                        href="{{ route('leaderboards::create') }}"
                        class="badge bg-info float-end"
                    >
                        Create a new leaderboard.
                    </a>
                </div>

                <table class="table-sm table-hover table">
                    <thead>
                        <tr class="bg-dark text-white">
                            <td>Leaderboard</td>
                            <td>Committee</td>
                            <td>Total entries</td>
                            <td></td>
                        </tr>
                    </thead>

                    @foreach ($leaderboards as $leaderboard)
                        <tr>
                            <td>
                                <i class="{{ $leaderboard->icon }}"></i>
                                {{ $leaderboard->name }}
                            </td>
                            <td>{{ $leaderboard->committee->name }}</td>
                            <td>{{ $leaderboard->entries_count }}</td>
                            <td>
                                <a
                                    href="{{ route('leaderboards::edit', ['id' => $leaderboard->id]) }}"
                                >
                                    <i class="fas fa-edit fa-fw me-2"></i>
                                </a>
                                <a
                                    href="{{ route('leaderboards::delete', ['id' => $leaderboard->id]) }}"
                                >
                                    <i
                                        class="fas fa-trash text-danger fa-fw"
                                    ></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
