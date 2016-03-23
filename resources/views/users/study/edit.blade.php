@extends('website.layouts.panel')

@section('page-title')
    Edit study for {{ $user->name }}
@endsection

@section('panel-title')
    Edit study {{ $study->name }} for {{ $user->name }}
@endsection

@section('panel-body')

    <form method="post" action="{{ route("user::study::edit", ["id" => $user->id, "study_id" => $study->id]) }}"
          class="form-horizontal">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="study" class="col-sm-2 control-label">Study</label>

            <div class="col-sm-10 control-label" style="text-align: left;">
                {{ $study->name }}
            </div>
        </div>

        <hr>

        <div class="form-group">
            <label for="start" class="col-sm-2 control-label">Start</label>

            <div class="col-sm-10">
                <input type="date" class="form-control" id="start" name="start" required
                       value="{{ date("Y-m-d", strtotime($study->pivot->created_at)) }}">
            </div>
        </div>

        <div class="form-group">
            <label for="end" class="col-sm-2 control-label">End</label>

            <div class="col-sm-10">
                <input type="date" class="form-control" id="end" name="end"
                       value="{{ ($study->pivot->till == null ? '' : date("Y-m-d", strtotime($study->pivot->till))) }}">
            </div>
        </div>

    </form>

@endsection

@section('panel-footer')

    <div class="pull-right">
        <button type="submit" class="btn btn-success">Save</button>
        <a onClick="javascript:history.go(-1);" class="btn btn-default">Cancel</a>
    </div>

@endsection