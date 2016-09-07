@extends('emails.template')

@section('body')

    <p>
        {{ $text or 'This is a test message.' }}
    </p>

@endsection