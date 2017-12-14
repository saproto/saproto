@extends('website.layouts.default-nobg')

@section('page-title')
    {{ $user->name }}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-4">
            @include('users.profile.about')
        </div>
        <div class="col-md-8">
            <div class="panel panel-default container-panel">
                <div class="panel-body">
                    @include('users.profile.committees')

                    <hr class="rule">

                    @include('users.profile.committeespast')
                </div>
            </div>
            <div class="panel panel-default container-panel">
                <div class="panel-body">
                    @include('users.profile.achieved')
                </div>
            </div>
        </div>
    </div>

@endsection
