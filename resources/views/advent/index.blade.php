@extends('website.layouts.redesign.generic')

@section('page-title')
    advent
@endsection

@section('container')
    <div class="p-5">
        <div class="row justify-content-start">
            <h1>12 'VO</h1>
        </div>
        <div class="row justify-content-between">
            @foreach($events as $column)
                <div class="col">
                    @foreach($column as $event)
                        <div>
                            @include('event.display_includes.event_block', ['event'=> $event])
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection