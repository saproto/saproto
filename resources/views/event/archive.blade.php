@extends('website.layouts.redesign.generic')

@section('page-title')
    Archive for {{ $year }}
@endsection

@section('container')

    @include('event.calendar_includes.archivebar')

    <div class="row justify-content-center">

        @foreach($months as $key => $month)

            @if(date('F Y', strtotime($year.'-'.$key.'-25')) < date('U') || count($month) > 0)

                @include('event.calendar_includes.rendermonth', [
                    'events' => $month,
                    'month_name' => date('F Y', strtotime($year.'-'.$key.'-25'))
                ])

            @endif

        @endforeach

    </div>

@endsection
