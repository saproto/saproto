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
            <li>Birthdate: <strong>{{ $user->birthdate }}</strong></li>
            <li>Nationality: <strong>{{ $user->nationality }}</strong></li>
            <li>
                Gender:
                <strong>
                    @if($user->gender == 1)
                        Male
                    @elseif($user->gender == 2)
                        Female
                    @elseif($user->gender == 0)
                        Unknown
                    @elseif($user->gender == 9)
                        Not applicable
                    @else
                        Invalid gender value
                    @endif
                </strong>
            </li>
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