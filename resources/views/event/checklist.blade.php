@extends('website.layouts.redesign.generic')

@section('page-title')
    Participant checklist for {{ $event->title }}
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-8 col-sm-10 col-xs-12">

            <div class="card">

                <div class="card-header bg-dark text-white">
                    @yield('page-title')
                </div>

                <div class="card-body">

                    <table width="100%" class="table table-bordered">

                        <thead>

                        <tr>

                            <th>Check</th>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Age</th>
                            @if ($event->shouldShowDietInfo())
                                <th width="20%">Allergies</th>
                            @endif

                        </tr>

                        </thead>

                        <tbody>

                        @foreach($event->activity->allUsersSorted() as $user)
                            <tr>

                                <td>
                                    @php
                                        $participation = $user->pivot;
                                    @endphp
                                    <a href="{{ route('event::togglepresence', ['id' => $participation->id]) }}"
                                       class="badge badge-{{ $participation->is_present ? 'success' : 'danger' }}">
                                        {{ $participation->is_present ? 'Present' : 'Absent' }}
                                    </a>
                                </td>

                                <td>
                                    @if($event->activity)
                                        @php
                                            $participation = $user->pivot;
                                        @endphp
                                        @if($participation->committees_activities_id !== null)
                                            <span class="badge badge-success">helper</span>
                                        @else
                                            participant
                                        @endif
                                    @endif
                                </td>

                                <td>
                                    <strong>{{ $user->name }}</strong>
                                </td>

                                <td>
                                    @if($user->age() >= 18)

                                        <span class="badge badge-success">
                            <i class="fas fa-check" aria-hidden="true"></i> 18+
                        </span>
                                    @else
                                        <span class="badge badge-danger">
                            <i class="fas fa-exclamation-triangle" aria-hidden="true"></i> 18-
                        </span>
                                    @endif
                                </td>

                                @if ($event->shouldShowDietInfo())
                                    <td>
                                        @if($user->hasDiet())
                                            {!! Markdown::convertToHtml($user->diet) !!}
                                        @endif
                                    </td>
                                @endif
                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection