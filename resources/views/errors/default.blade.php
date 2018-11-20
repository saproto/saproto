@extends('errors.template')

@section('page-title')

    Error {{ $exception->getStatusCode() }}

@endsection

@section('page-body')

    {{ $exception->getMessage() }}

@endsection