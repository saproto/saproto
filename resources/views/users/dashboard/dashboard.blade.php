@extends('website.layouts.default-nobg')

@section('page-title')
    Dashboard for {{ $user->name }}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-5 col-xs-12">
            @include('users.dashboard.account')
            @include('users.dashboard.2fa')
        </div>
        <div class="col-md-4 col-xs-12">
            @include('users.dashboard.addressinfo')
            @include('users.dashboard.fininfo')
        </div>
        <div class="col-md-3 col-xs-12">
            @include('users.dashboard.studyinfo')
        </div>
    </div>

    @if($user->bank != null)
        @include("users.dashboard.deletebank")
    @endif

@endsection
