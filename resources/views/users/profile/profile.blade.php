@extends('website.default.container')

@section('page-title')
    {{ $user->name }}
@endsection

@section('pre-container')

    <h3 style="text-align: center;"><strong>{{ $user->name }}</strong></h3>

    <hr>

@endsection

@section('container')

    <div class=row">
        <div class="col-md-4">
            @include('users.profile.about')
        </div>
        <div class="col-md-8">
            @include('users.profile.timeline')
        </div>
    </div>

@endsection
