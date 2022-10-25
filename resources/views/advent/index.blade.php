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
        <div class="row justify-content-between">
            @foreach($eventsArray as $colIndex=>$column)
                <div class="col">
                    @foreach($column as $rowIndex=>$event)
                        @if($event->isPublished())
                        <div>
                            @include('event.display_includes.event_block', ['event'=> $event])
                        </div>
                        @else
                            <a class="card mb-3 leftborder leftborder-info text-decoration-none text-primary">
                            <div>
                                <div unix-time="{{$event->publication}}" class="h1 col text-center december-countdown">Loading...</div>
                            </div>
                            </a>
                        @endif
                        {{$event->title}}
                    @endforeach
                </div>
            @endforeach
        </div>
        </div>
        @else
            <div class="container fluid" style="min-height: 100%; min-height: 100vh; display: flex; align-items: center;">
                <div unix-time="{{$date->timestamp}}" class="h1 col text-center countdown">Loading...</div>
            </div>
        @endif
    </div>
@endsection
