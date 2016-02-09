@extends('website.default.container')

@section('container')

    {!! BootForm::open(['model' => $user, 'update' => 'UserPreferenceController@updateOwn']) !!}
        {!! BootForm::text('name') !!}
        {!! BootForm::text('email') !!}
        {!! BootForm::password('password') !!}
        {!! BootForm::submit('Submit') !!}
    {!! BootForm::close() !!}

@endsection