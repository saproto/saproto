@extends('errors.template')

@section('page-title')

    Unauthorised

@endsection

@section('page-body')

    @if(! isset($exception))
        You are not allowed to access this page.
    @else
        {{ $exception->getMessage() }}
    @endif

@endsection