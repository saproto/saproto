@extends('errors.template')

@section('page-title')

    Error {{ $exception->getStatusCode() }}

@endsection

@section('page-body')

    <p>
        {{ $exception->getMessage() }}
    </p>

@endsection