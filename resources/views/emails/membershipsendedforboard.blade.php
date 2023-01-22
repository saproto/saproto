@extends('emails.template')

@section('body')

    <p>
        Hey!
    </p>

    <p>
        I just ran the membership cleanup program.
    </p>

    <p>
        <strong>Members who had their membership automatically ended:</strong>
    <ul>
        @foreach($deleted_memberships as $member)
            <li>{{ $member->user->name }}</li>
        @endforeach
    </ul>
    </p>

    <p>
        Kind regards,<br>
        The Membership Ending Clerk
    </p>

@endsection