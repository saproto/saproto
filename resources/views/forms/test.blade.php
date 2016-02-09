@extends('website.default.default')

@section('content')
    <div class="container">
        {!! BootForm::open(['model' => $user, 'store' => 'FormTestController@store', 'update' => 'FormTestController@update']) !!}
            {!! BootForm::text('name') !!}
            {!! BootForm::text('email') !!}
            {!! BootForm::password('password') !!}
            {!! BootForm::submit('Submit') !!}
        {!! BootForm::close() !!}
    </div>
@endsection