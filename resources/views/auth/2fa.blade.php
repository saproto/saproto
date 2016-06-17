@extends('website.layouts.panel')

@section('page-title')
    Two Factor Authentication
@endsection

@section('panel-title')
    Two Factor Authentication
@endsection

@section('panel-body')

    <form method="POST" action="{{ route('login::post') }}">

        {!! csrf_field() !!}

        <p>
            This account is protected by two factor authentication. Please provide your authentication code from your
            two factor authentication app to continue.
        </p>

        <div class="form-group">
            <label for="code" class="control-label">Your token:</label>
            <input type="text" class="form-control" id="code" name="2fa_token" placeholder="123456">
        </div>

        @endsection

        @section('panel-footer')
            <button type="submit" class="btn btn-success">LOG-IN</button>

    </form>
@endsection