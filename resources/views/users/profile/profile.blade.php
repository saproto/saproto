@extends('website.layouts.default')

@section('page-title')
    {{ $user->name }}
@endsection

@section('content')

    <div class="panel btn-group btn-group-justified" role="group">
        @if($user->member == null)
            <a class="btn btn-warning">
                {{ $user->name_first }} is not a member of {{ config('association.name') }}.
            </a>
        @else
            <a class="btn btn-primary">
                {{ $user->name_first }} is a member
                @if(date('U', strtotime($user->member->created_at)) > 0)
                    as of {{ date('F j, Y', strtotime($user->member->created_at)) }}.
                @else
                    since <strong>ancient times</strong>!
                @endif
            </a>
        @endif
    </div>

    <div class=row">
        <div class="col-md-4">
            @include('users.profile.about')
        </div>
        <div class="col-md-4" style="border-left: 1px solid #ddd;">
            @include('users.profile.committees')
        </div>
        <div class="col-md-4">
            @include('users.profile.timeline')
        </div>
    </div>

@endsection
