@extends('errors.template')

@section('page-title')

    Error {{ $exception->getStatusCode() }}

@endsection

@section('page-body')

    Sorry, but we could not find the page or resource you were looking for.

@endsection