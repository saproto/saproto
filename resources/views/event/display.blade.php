@extends('website.layouts.redesign.generic')

@section('page-title')
    {{ $event->title }}
@endsection

@section('og-description')
    From {{ $event->generateTimespanText('l j F Y, H:i', 'H:i', 'till') }} @ {{ $event->location }}.

    {{ $event->description }}
@endsection

@if($event->image)
@section('og-image'){{ $event->image->generateImagePath(800,300) }}@endsection
@endif

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-4">

            @include('event.display_includes.event_details', [
                'event' => $event
            ])

        </div>

        @if(($event->activity && $event->activity->withParticipants()) || $event->tickets()->count() > 0)

            <div class="col-md-4">

                @include('event.display_includes.tickets', [
                    'event' => $event
                ])

                @include('event.display_includes.participation', [
                    'event' => $event
                ])

            </div>

        @endif

        @if($event->activity && Auth::check() && Auth::user()->member && count($event->activity->helpingCommitteeInstances) > 0)

            <div class="col-md-4">

                @include('event.display_includes.helpers', [
                    'event' => $event
                ])

            </div>

        @endif

    </div>

@endsection
