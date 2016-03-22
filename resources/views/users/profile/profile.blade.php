@extends('website.layouts.default')

@section('page-title')
    {{ $user->name }}
@endsection

@section('content')

    <div class=row">
        <div class="col-md-4">
            @include('users.profile.about')
        </div>
        <div class="col-md-4">
            @include('users.profile.committees')
        </div>
        <div class="col-md-4">
            @include('users.profile.timeline')
        </div>
    </div>

@endsection
