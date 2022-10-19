@extends('website.layouts.redesign.generic')

@section('page-title')
    advent
@endsection

@section('container')
    @foreach($events as $event)
        @include('event.display_includes.event_block', ['event'=> $event])
    @endforeach
@endsection