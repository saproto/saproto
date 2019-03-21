@extends('website.layouts.redesign.generic')

@section('page-title')
    {{ $user->name }}
@endsection

@section('container')

    <div class="row justify-content-center">
        <div class="col-xl-3 col-lg-6 col-md-12">
            @include('users.profile.includes.about')
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12">
            @include('users.profile.includes.committees')
        </div>
        @if($user->show_achievements && count($user->achieved()) > 0)
            <div class="col-xl-3 col-lg-6 col-md-12">
                @include('users.profile.includes.achievements')
            </div>
        @endif
    </div>

@endsection
