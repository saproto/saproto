@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Actual membership totals
@endsection

@section('container')
    <div class="row d-inline-flex justify-content-center w-100">
        <div class="col-10">
            <div class="card mb-3">
                <div class="card-header">
                    <form method="get">
                        <div class="row">
                            <label
                                for="datetimepicker-start"
                                class="col-sm-auto col-form-label pe-0"
                            >
                                Start:
                            </label>
                            <div class="col-sm-auto">
                                @include(
                                    'components.forms.datetimepicker',
                                    [
                                        'name' => 'start',
                                        'format' => 'date',
                                        'placeholder' => $start->timestamp,
                                    ]
                                )
                            </div>
                            <label
                                for="datetimepicker-start"
                                class="col-sm-auto col-form-label pe-0"
                            >
                                End:
                            </label>
                            <div class="col-sm-auto">
                                @include(
                                    'components.forms.datetimepicker',
                                    [
                                        'name' => 'end',
                                        'format' => 'date',
                                        'placeholder' => $end->timestamp,
                                    ]
                                )
                            </div>

                            <div class="col-sm-auto">
                                <button type="submit" class="btn btn-success">
                                    Calculate Protube stats!
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Totals</div>
                <div class="card-body">
                    There were a total of
                    <b>{{ $totalPlayed }}</b>
                    video's played!
                    <br />
                    This was done by
                    <b>{{ $uniqueUsers }}</b>
                    unique users!
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">User statistics</div>
                <div class="card-body">
                    The average user played
                    <b>{{ $averagePerUser }}</b>
                    video's!
                    <br />
                    The median user played
                    <b>{{ $medianPerUser }}</b>
                    video's!
                    <br />
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Top contributors</div>
                <div class="card-body">
                    <table class="table-hover table-sm table">
                        <thead>
                            <tr class="bg-dark text-white">
                                <td>User</td>
                                <td>Videos played</td>
                            </tr>
                        </thead>

                        @foreach ($topUsers as $topUser)
                            <tr
                                class="{{ $topUser?->user === null ? 'text-muted' : null }}"
                            >
                                <td class="hidden-sm hidden-xs">
                                    {{ $topUser->user?->name }}
                                </td>
                                <td>
                                    {{ $topUser->played_count }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Top videos</div>
                <div class="card-body">
                    <table class="table-hover table-sm table">
                        <thead>
                            <tr class="bg-dark text-white">
                                <td>Video</td>
                                <td>times played</td>
                            </tr>
                        </thead>

                        @foreach ($topVideos as $topVideo)
                            <tr>
                                <td class="hidden-sm hidden-xs">
                                    {{ $topVideo->video_title }}
                                </td>
                                <td>
                                    {{ $topVideo->played_count }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Top videos by an individual user</div>
                <div class="card-body">
                    <table class="table-hover table-sm table">
                        <thead>
                            <tr class="bg-dark text-white">
                                <td>Video</td>
                                <td>times played</td>
                                <td>by user</td>
                            </tr>
                        </thead>

                        @foreach ($topVideosByIndividualUsers as $topVideoByIndividualUser)
                            <tr>
                                <td class="hidden-sm hidden-xs">
                                    {{ $topVideoByIndividualUser->video_title }}
                                </td>
                                <td>
                                    {{ $topVideoByIndividualUser->played_count }}
                                </td>
                                <td>
                                    {{ $topVideoByIndividualUser->user?->name }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
