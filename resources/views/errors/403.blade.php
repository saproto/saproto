@extends('errors.template')

@section('page-title')

    Unauthorised

@endsection

@section('page-body')

    @if($exception->getMessage() == null)
        You are not allowed to access this page.
    @else
        {{ $exception->getMessage() }}
    @endif

@endsection