@extends('website.layouts.redesign.generic')

@section('page-title')
    advent
@endsection

@section('container')

    @if($date->timestamp<Carbon::now()->timestamp)
        <div class="row d-flex justify-content-center" style="z-index: -12">
            <div class="col-xl-8 col-lg-10 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h1>12th Month Advent Calender</h1>
                    </div>
                    <div class="row row-cols-3 card-body">
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
                                                    <div unix-time="{{$event->publication}}"
                                                         class="h2 col text-center december-countdown">Loading...
                                                    </div>
                                                </div>
                                            </a>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container fluid" style="min-height: 100%; min-height: 100vh; display: flex; align-items: center;">
            <div unix-time="{{$date->timestamp}}" class="h1 col text-center december-countdown" style="font-size: 8rem">
                Loading...
            </div>
        </div>
    @endif
@endsection
