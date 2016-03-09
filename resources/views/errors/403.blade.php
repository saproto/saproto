@extends('errors/generic')

@section('errornumber')
    403
@endsection

@section('errorshort')
    Unauthorized
@endsection

@section('errormessage')
    {!! $exception->getMessage() !!}
@endsection