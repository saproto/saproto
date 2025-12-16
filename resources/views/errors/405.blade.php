@extends('errors.template')

@section('page-title')
        Error {{ $exception->getStatusCode() }}
@endsection

@section('page-body')
        The {{ request()->getMethod() }} method is not allowed on this route!
@endsection
