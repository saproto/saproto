@extends('website.layouts.panel')

@section('page-title')
    Narrowcasting Admin
@endsection

@section('panel-title')
    {{ ($item == null ? "Create new campaign." : "Edit campaign " . $item->name .".") }}
@endsection

@section('panel-body')

    <form method="post"
          action="{{ ($item == null ? route("narrowcasting::add") : route("narrowcasting::edit", ['id' => $item->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="name">Campaign name:</label>
            <input type="text" class="form-control" id="name" name="name"
                   placeholder="Lightsaber Building in the SmartXp" value="{{ $item->name or '' }}" required>
        </div>

        <div class="form-group">
            <label for="campaign_start">Campaign start:</label>
            <input type="text" class="form-control datetime-picker" id="campaign_start" name="campaign_start"
                   value="{{ ($item ? date('d-m-Y H:i', $item->campaign_start) : '') }}" required>
        </div>

        <div class="form-group">
            <label for="campaign_end">Campaign end:</label>
            <input type="text" class="form-control datetime-picker" id="campaign_end" name="campaign_end"
                   value="{{ ($item ? date('d-m-Y H:i', $item->campaign_end) : '') }}" required>
        </div>

        <div class="form-group">
            <label for="slide_duration">Slide duration in seconds:</label>
            <input type="text" class="form-control" id="slide_duration" name="slide_duration"
                   value="{{ $item->slide_duration or '30' }}" required>
        </div>

        <div class="form-group">
            <label for="youtube_id">YouTube ID:</label>
            <input type="text" class="form-control" id="youtube_id" name="youtube_id"
                   placeholder="Only the ID!" value="{{ $item->youtube_id or '' }}">
        </div>

        <p>
            <sup><strong>Note:</strong> if a YouTube ID is present, the image file and slide duration field is ignored and hidden.</sup>
        </p>

        @if($item && $item->video())

            <label>Current video:</label>

            <div class="row">

                <div class="col-md-6">
                    <img src="{!! $item->video()->snippet->thumbnails->high->url !!}" style="width: 100%">
                </div>
                <div class="col-md-6">
                    <strong><a href="https://youtu.be/{{ $item->video()->id }}"
                               target="_blank">{{ $item->video()->snippet->title }}</a></strong>
                    <br>
                    <strong>{{ $item->video()->snippet->channelTitle }}</strong>
                </div>

            </div>

        @else

            <div class="form-group">
                <label for="image">Image file:</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>

            <p>
                <sup><strong>Screen resolution</strong> is 1680 x 1050 pixels.</sup>
            </p>

            @if($item && $item->image)

                <label>Current image:</label>
                <img src="{!! $item->image->generateImagePath(500, null) !!}" style="width: 100%">

            @endif

        @endif

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

            <a href="{{ route("narrowcasting::list") }}" class="btn btn-default pull-right">Cancel</a>

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
            format: 'DD-MM-YYYY HH:mm'
        });
    </script>

@endsection
