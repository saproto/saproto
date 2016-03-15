@extends('website.layouts.panel')

@section('panel-title')
    Request password reset
@endsection

@section('panel-body')

    <form method="POST" action="{{ route('login::resetpass') }}">

        <div class="form-group">
            <label for="email" class="control-label">E-mail:</label>
            <input type="text" class="form-control" id="email" name="email"
                   placeholder="d.adams@student.utwente.nl">
        </div>

        {!! csrf_field() !!}

@endsection

@section('panel-footer')

        <button type="submit" class="btn btn-success pull-right">Request reset</button>

    </form>

@endsection