@extends('website.default.container')

@section('page-title')
    Dashboard for {{ $user->name }}
@endsection

@section('container')

    <div class="row">
        <div class="col-md-5 col-xs-12">
            @include('users.dashboard.account')
            @include('users.dashboard.fininfo')
        </div>
        <div class="col-md-7 col-xs-12">
            @include('users.dashboard.addressinfo')
            @include('users.dashboard.studyinfo')
        </div>
    </div>

    @include("users.profile.deletebank");

@endsection
