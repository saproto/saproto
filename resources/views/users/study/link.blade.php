@extends('website.layouts.panel')

@section('page-title')
    New study for {{ $user->name }}
@endsection

@section('panel-title')
    Add a new study for {{ $user->name }}
@endsection

@section('panel-body')

    <form method="post" action="{{ route("user::study::add", ["id" => $user->id]) }}" class="form-horizontal">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="study" class="col-sm-2 control-label">Study</label>
            <div class="col-sm-10">
                <select name="study" id="study" class="form-control">
                    <option selected disabled>Select your study</option>
                    @foreach($studies as $study)
                        <option value="{{ $study->id }}">{{ $study->name }} ({{ $study->faculty }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <hr>

        <div class="form-group">
            <label for="start" class="col-sm-2 control-label">Start</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" id="start" name="start" required>
            </div>
        </div>

        <div class="form-group">
            <label for="end" class="col-sm-2 control-label">End</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" id="end" name="end">
            </div>
        </div>

        <hr>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-success">Add</button>
                <a onClick="javascript:history.go(-1);" class="btn btn-default">Cancel</a>
            </div>
        </div>

    </form>

@endsection