@extends('errors/generic')

@section('errornumber')
    404
@endsection

@section('errorshort')
    Not found
@endsection

@section('errormessage')
    {!! $exception->getMessage() !!}
@endsection