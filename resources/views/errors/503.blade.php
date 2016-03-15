@extends('website.master')

@section('page-title')
    Maintenance
@endsection

@section('stylesheet')
    @parent

    html, body {
        min-width: 100%;
        min-height: 100%;
    }

    body {
        background-image: url('{{ asset('images/application/maintenancebg.jpg') }}');
        background-position: center center;
        background-size: cover;
        background-repeat: no-repeat;
    }

    #maintenance {
        padding: 15% 0;
        color: #fff;
        text-align: center;
        text-shadow: 0px 0px 10px #000;
    }
@endsection

@section('body')
    <div id="maintenance">
        <h1>Maintenance mode.</h1>
        Oh snap! This site is currently in maintenance mode. Check back in a few moments.
    </div>
@endsection