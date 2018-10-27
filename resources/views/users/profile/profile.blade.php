@extends('website.layouts.redesign.generic')

@section('page-title')
    {{ $user->name }}
@endsection

@section('container')

    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-12">
            @include('users.profile.includes.about')
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12">
            @include('users.profile.includes.committees')
        </div>
        <div class="col-xl-3 col-lg-6 col-md-12">
            @include('users.profile.includes.achievements')
        </div>
    </div>

@endsection
