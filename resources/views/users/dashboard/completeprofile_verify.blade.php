@extends('website.layouts.panel')

@section('page-title')
    Complete membership profile
@endsection

@section('panel-title')
    Complete membership profile
@endsection

@section('panel-body')

    <form method="POST" action="{{ route('user::memberprofile::complete') }}">

        @include('users.registerwizard_macro')

        {!! csrf_field() !!}

        <input type="hidden" name="verified" value="true">

        <p style="text-align: center;">
            Please check that you've entered the information below correctly.
        </p>

        <hr>

        <p style="text-align: center;">
            My date of birth is <strong>{{ date('F j, Y', strtotime($userdata['birthdate'])) }}</strong> ({{ $age }}
            years).
        </p>

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-outline-primary pull-right">The information above is correct.</button>

    </form>

@endsection