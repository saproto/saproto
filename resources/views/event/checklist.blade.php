@extends('website.layouts.default')

@section('page-title')
    Participant checklist for {{ $event->title }}
@endsection

@section('content')

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
                       class="label label-{{ $participation->is_present ? 'success' : 'warning' }}">
                        {{ $participation->is_present ? 'Present' : 'Absent' }}
                    </a>
                </td>
                <td>
                    @if($event->activity)
                        @php
                            $participation = $user->pivot;
                        @endphp
                        @if($participation->committees_activities_id !== null)
                            <span class="label label-success">helper</span>
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

                        <span class="label label-success">
                            <i class="fas fa-check" aria-hidden="true"></i> 18+
                        </span>
                    @else
                        <span class="label label-danger">
                            <i class="fas fa-exclamation-triangle" aria-hidden="true"></i> 18-
                        </span>
                    @endif
                </td>
                @if ($event->shouldShowDietInfo())
                    <td>
                        {!! $user->renderDiet() !!}
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection

@section('stylesheet')
    @parent
    <style type="text/css">
        @media print {
            a[href]:after {
                content: none !important;
            }

            #footer, #header {
                display: none !important;
            }
        }
    </style>
@endsection