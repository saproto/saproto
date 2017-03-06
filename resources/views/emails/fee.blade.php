@extends('emails.template')

@section('body')

    <p>
        Hey!
    </p>

    <p>
        I just ran the membership fee program. The following people had their membership fee charged.
    </p>

    @if (count($data['regular']) > 0)
        <p>
            <strong>Creative Technology students paying the regular fee</strong>
        <ul>
            @foreach($data['regular'] as $user)
                <li>{{ $user }}</li>
            @endforeach
        </ul>
        </p>
    @endif

    @if (count($data['reduced']) > 0)
        <p>
            <strong>Other people paying the reduced fee</strong>
        <ul>
            @foreach($data['reduced'] as $user)
                <li>{{ $user }}</li>
            @endforeach
        </ul>
        </p>
    @endif

    @if (count($data['remitted']) > 0)
        <p>
            <strong>Exceptions who don't pay membership fee, resolve manually as needed</strong>
        <ul>
            @foreach($data['remitted'] as $user)
                <li>{{ $user }}</li>
            @endforeach
        </ul>
        </p>
    @endif

    <p>
        Kind regards,
        The Membership Fee Clerk
    </p>

@endsection