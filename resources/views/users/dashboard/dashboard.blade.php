@extends('website.layouts.default-nobg')

@section('page-title')
    Dashboard for {{ $user->name }}
@endsection

@section('content')

    <h2 class="dashboard__divider">
        Personal information
    </h2>

    <div class="row">
        <div class="col-md-4">
            @include('users.dashboard.basicinfo')
            @include('users.dashboard.memberinfo')
            @include('users.dashboard.addressinfo')
            @include('users.dashboard.fininfo')
        </div>
        <div class="col-md-4">
            @include('users.dashboard.profilepic')
            @include('users.dashboard.account')
        </div>
        <div class="col-md-4">
            @include('users.dashboard.maillists')
        </div>
    </div>

    @if($user->bank != null)
        @include("users.dashboard.deletebank")
    @endif

    <h2 class="dashboard__divider">
        Study information
    </h2>

    <div class="row">
        <div class="col-md-4">
            @include('users.dashboard.utwenteinfo')
        </div>
        <div class="col-md-8">
            @include('users.dashboard.studyinfo')
        </div>
    </div>

    <h2 class="dashboard__divider">
        Account details
    </h2>

    <div class="row">
        <div class="col-md-5">
            @include('users.dashboard.2fa')
            @if (!$user->member)
                @include('users.dashboard.deleteaccount')
            @endif
            @if (count($user->roles) > 0)
                @include('users.dashboard.roleinfo')
            @endif
        </div>
        <div class="col-md-7">
            @include('users.dashboard.cardinfo')
        </div>
    </div>

@endsection
