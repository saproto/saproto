@extends('emails.template')

@section('body')

    <p>
        Hey!
    </p>

    @if (count($unlinked) > 0)

        <p>
            I just checked the validity of UTwente accounts. I found {{ count($unlinked) }} inactive accounts:
        <ul>
            @foreach($unlinked as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
        </p>
    @else
        <p>
            I just checked the validity of UTwente accounts. All accounts seem to be active.
        </p>
    @endif

    <p>
        Kind regards,
        The System
    </p>

@endsection