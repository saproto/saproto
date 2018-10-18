@extends('website.layouts.redesign.generic-sidebar')

@section('page-title')
    {{ $user->name }}
@endsection

@section('container')

    <div class="row">
        <div class="col-md-4 col-sm-8 col-xs-12">
            @include('users.profile.includes.about')
            @include('users.profile.includes.achievements')
        </div>
        <div class="col-md-8">
            @include('users.profile.includes.committees')
        </div>
    </div>

@endsection
