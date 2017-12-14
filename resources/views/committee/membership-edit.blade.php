@extends('website.layouts.panel')

@section('page-title')
    Edit committee membership
@endsection

@section('panel-title')
    {{ $membership->user->name }} @ {{ $membership->committee->name }}
@endsection

@section('panel-body')

    <form class="form-horizontal" action="{{ route('committee::membership::edit', ["id" => $membership->id]) }}"
          method="post">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="role" class="col-sm-2 control-label">Role</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="role" name="role" placeholder="General Member"
                       value="{{ $membership->role }}">
            </div>
        </div>

        <div class="form-group">
            <label for="edition" class="col-sm-2 control-label">Edition</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="edition" name="edition" value="{{ $membership->edition }}">
            </div>
        </div>

        <hr>

        <div class="form-group">
            <label for="start" class="col-sm-2 control-label">Since</label>
            <div class="col-sm-10">
                <input type="text" class="form-control datetime-picker" id="start" name="start"
                       value="{{ date("d-m-Y", strtotime($membership->created_at)) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="end" class="col-sm-2 control-label">Till</label>
            <div class="col-sm-10">
                <input type="text" class="form-control datetime-picker" id="end" name="end"
                       value="{{ ($membership->deleted_at == null ? "" : date("d-m-Y", strtotime($membership->deleted_at))) }}">
            </div>
        </div>

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right">
                Save
            </button>

            <a href="{{ route('committee::membership::delete', ["id" => $membership->id]) }}"
               class="btn btn-danger pull-right" style="margin-right: 15px;">
                Delete
            </a>

            <a href="javascript:history.go(-1);" class="btn btn-default pull-right" style="margin-right: 15px;">
                Cancel
            </a>

    </form>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">
        // Initializes datetimepickers for consistent options
        $('.datetime-picker').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                next: "fa fa-chevron-right",
                previous: "fa fa-chevron-left"
            },
            format: 'DD-MM-YYYY'
        });
    </script>

@endsection