@extends('errors.template')

@section('page-title')

    Error {{ $exception->getStatusCode() }}

@show

@section('page-body')

    <p>
        {{ $exception->getMessage() }}
    </p>

@endsection