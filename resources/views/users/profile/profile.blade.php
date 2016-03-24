@extends('website.layouts.default')

@section('page-title')
    {{ $user->name }}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-4">
            @include('users.profile.about')
        </div>
        <div class="col-md-4">
            <h3>Profile picture</h3>
        </div>
        <div class="col-md-4">
            <h3>Achievements</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            @include('users.profile.committees')
        </div>
        <div class="col-md-4">
            @include('users.profile.timeline')
        </div>
        <div class="col-md-4">
            @include('users.profile.committeespast')
        </div>
    </div>

@endsection
