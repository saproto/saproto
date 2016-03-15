@extends('website.master')

@section('body')

    @include('website.navigation.navbar')

    <div class="container">
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
    </div>

    <div class="container">

        @yield('content')

    </div>

@endsection