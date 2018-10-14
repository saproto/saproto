@extends('website.layouts.panel')

@section('page-title')
    Video Admin
@endsection

@section('panel-title')
    Edit video
@endsection

@section('panel-body')

    <form method="post" action="{{ route("video::admin::edit", ['id' => $video->id]) }}" enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Video date:</label>
                    <input type="text" class="form-control datetime-picker" name="video_date"
                           value="{{ $video->getFormDate() }}" required>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Link to event:</label>
                    <select class="form-control event-search" name="event"></select>
                </div>
            </div>
        </div>

        @if ($video->event)
            <p style="text-align: center;">
                Currently linked to:<br>
                <strong>{{ $video->event->title }} ({{ date('d-m-Y', $video->event->start) }})</strong>
            </p>
        @endif

        <hr>

        <img src="{{ $video->youtube_thumb_url }}" width="100%">

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

            <a href="{{ route("video::admin::index") }}" class="btn btn-default pull-right">Cancel</a>

    </form>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">
        // Initializes datetimepickers for consistent options
        $('.datetime-picker').datetimepicker({
            icons: {
                time: "fas fa-clock-o",
                date: "fas fa-calendar",
                up: "fas fa-arrow-up",
                down: "fas fa-arrow-down",
                next: "fas fa-chevron-right",
                previous: "fas fa-chevron-left"
            },
            format: 'DD-MM-YYYY'
        });
    </script>

@endsection
