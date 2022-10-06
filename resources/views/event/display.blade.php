@extends('website.layouts.redesign.generic')

@section('page-title')
    {{ $event->title }}
@endsection

@section('og-description')
    From {{ $event->generateTimespanText('l j F Y, H:i', 'H:i', 'till') }} @ {{ $event->location }}.

    {{ $event->description }}
@endsection

@if($event->photo)
@section('og-image'){{ $event->photo->getMediumUrl() }}@endsection
@endif

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-4">

            @include('event.display_includes.event_details', [
                'event' => $event
            ])

        </div>

        @if(Auth::check() && (($event->activity && $event->activity->withParticipants()) || $event->tickets()->count() > 0))

            <div class="col-md-4">

                @include('event.display_includes.tickets', [
                    'event' => $event,
                    'payment_methods' => $payment_methods
                ])

                @include('event.display_includes.participation', [
                    'event' => $event
                ])

            </div>

        @endif

        @if($event->activity && Auth::check() && Auth::user()->is_member && count($event->activity->helpingCommitteeInstances) > 0)

            <div class="col-md-4">

                @include('event.display_includes.helpers', [
                    'event' => $event
                ])

            </div>

        @endif

    </div>

@endsection
