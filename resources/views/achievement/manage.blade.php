@extends('website.layouts.redesign.dashboard')

@section('page-title')
    {{ ($new ? "Create a new Achievement" : "Edit Achievement " . $achievement->name) }}
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-3">

            @if(!$new)
                @include('achievement.includes.achievement_include', [
                    'achievement' => $achievement
                ])
            @endif

            @include('achievement.admin_includes.edit')

        </div>

        @if(!$new)
            <div class="col-md-3">
                @include('achievement.admin_includes.icon')
            </div>
            <div class="col-md-3">
                @include('achievement.admin_includes.awards')
            </div>
        @endif

    </div>

@endsection