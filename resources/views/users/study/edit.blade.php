@extends('website.layouts.panel')

@section('page-title')
    {{ (!$link ? 'Add' : 'Edit') }} study for {{ $user->name }}
@endsection

@section('panel-title')
    {{ (!$link ? 'Add' : 'Edit') }} study for {{ $user->name }}
@endsection

@section('panel-body')

    <form method="post"
          action="{{ route((!$link ? 'user::study::add' : 'user::study::edit'), ["user_id" => $user->id, "link_id" => (!$link ? null : $link->id)]) }}"
          class="form-horizontal">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="study" class="col-sm-2 control-label">Study</label>

            <div class="col-sm-10 control-label" style="text-align: left;">
                @if (!$link)
                    <select name="study" id="study" class="form-control">
                        <option selected disabled>Select your study</option>
                        @foreach($studies as $study)
                            <option value="{{ $study->id }}">{{ $study->name }} ({{ $study->faculty }})</option>
                        @endforeach
                    </select>
                @else
                    {{ $link->study->name }}
                @endif
            </div>
        </div>

        <hr>

        <div class="form-group">
            <label for="start" class="col-sm-2 control-label">Start</label>

            <div class="col-sm-10">
                <input type="text" class="form-control datetime-picker" id="start" name="start"
                       value="{{ ($link ? date('d-m-Y', strtotime($link->created_at)) : '') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="end" class="col-sm-2 control-label">End</label>

            <div class="col-sm-10">
                <input type="text" class="form-control datetime-picker" id="end" name="end"
                       value="{{ ($link && $link->deleted_at ? date('d-m-Y', strtotime($link->deleted_at)) : '') }}">
            </div>
        </div>

        @endsection

        @section('panel-footer')

            <div class="pull-right">
                <input type="submit" class="btn btn-success" value="Save">
                <a onClick="javascript:history.go(-1);" class="btn btn-default">Cancel</a>
            </div>

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