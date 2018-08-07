@extends('website.layouts.panel')

@section('page-title')
    Clear membership profile
@endsection

@section('panel-title')
    Clear membership profile
@endsection

@section('panel-body')

    <form method="POST" action="{{ route('user::memberprofile::clear') }}">

        {!! csrf_field() !!}

        <p>
            If you confirm below, the following information will be deleted:
        </p>

        <ul>
            <li>Birthdate: <strong>{{ date('F j, Y', strtotime($user->birthdate)) }}</strong></li>
            <li>Phone: <strong>{{ $user->phone }}</strong></li>
        </ul>

        <p>
            Are you sure?
        </p>

        @endsection

        @section('panel-footer')
            <button type="submit" class="btn btn-success pull-right">Yes, clear my profile</button>

    </form>
@endsection