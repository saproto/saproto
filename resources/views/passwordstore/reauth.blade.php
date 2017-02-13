@extends('website.layouts.panel')

@section('page-title')
    Authentication
@endsection

@section('panel-title')
    Authentication
@endsection

@section('panel-body')

    <form method="POST" action="{{ route('passwordstore::auth') }}">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="message-text" class="control-label">Password:</label>
            <input type="password" class="form-control" id="password" name="password"
                   placeholder="Proto password or UTwente password">
        </div>

        @endsection

        @section('panel-footer')
            <button type="submit" class="btn btn-success">Confirm</button>

    </form>
@endsection