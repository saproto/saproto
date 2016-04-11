@extends('website.layouts.content')

@section('header')

    <div id="header">

        <div class="container">

            <h1>
                <strong>Welcome to Study Association Proto</strong>
            </h1>
            <h3>
                S.A. Proto is the study association for Creative Technology at the University of Twente.
            </h3>

        </div>

    </div>

@endsection

@section('container')

    <div id="container" class="container home-container">

        @if (Session::has('flash_message'))
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('flash_message') }}
            </div>
        @endif

        @foreach($errors->all() as $e)
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ $e }}
            </div>
        @endforeach

        This is the landing page for external visitors!

    </div>

@endsection