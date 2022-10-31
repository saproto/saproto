@extends('website.layouts.redesign.generic')

@section('page-title')
    advent
@endsection

@section('container')

    @if($date->timestamp<Carbon::now()->timestamp)
        <div class="p-5">
        <div class="row justify-content-start">
            <h1>12 'VO</h1>
        </div>
        <div class="row justify-content-between row-cols-3" style="z-index: 0">
                @foreach($eventsArray as $event)
                <div class="col">
                        @if($event->isPublished())
                        <div>
                            <a class="card h-100 mb-3 border-0">
                                @include('event.display_includes.event_block', ['event'=> $event])
                            </a>
                        </div>
                        @else
                        <div>
                            <a class="card h-100 mb-3 border-0">
                                <a class="card mb-3 leftborder leftborder-info text-decoration-none">
                                    <div class="card-body event text-start">
                                        <div unix-time="{{$event->publication}}" class="h1 col text-center december-countdown">Loading...</div>
                                    </div>
                                </a>
                            </a>
                        </div>
                        @endif
                </div>
                    @endforeach
        </div>
        </div>
        @else
            <div class="container fluid" style="min-height: 100%; min-height: 100vh; display: flex; align-items: center;">
                <div unix-time="{{$date->timestamp}}" class="h1 col text-center december-countdown">Loading...</div>
            </div>
        @endif
    </div>
@endsection
