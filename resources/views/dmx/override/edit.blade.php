@extends('website.layouts.panel')

@section('page-title')
    DMX Override
@endsection

@section('panel-title')
    {{ ($override == null ? "Create new override." : "Edit override.") }}
@endsection

@section('panel-body')

    <form method="post"
          action="{{ ($override == null ? route("dmx::override::add") : route("dmx::override::edit", ['id' => $override->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="name">Fixtures to override:</label>
            <select class="form-control" name="fixtures[]" multiple required>
                @foreach($fixtures as $fixture)
                    <option value="{{ $fixture->id }}" {{ ($override && in_array($fixture->id, $override->getFixtureIds()) ? 'selected' : '') }}>
                        {{ $fixture->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-4">
                    <label for="red">Red:</label>
                    <input type="number" class="form-control" id="red" name="red"
                           value="{{ $override ? $override->red() : '' }}" required>
                </div>
                <div class="col-md-4">
                    <label for="green">Green:</label>
                    <input type="number" class="form-control" id="green" name="green"
                           value="{{ $override ? $override->green() : '' }}" required>
                </div>
                <div class="col-md-4">
                    <label for="blue">Blue:</label>
                    <input type="number" class="form-control" id="blue" name="blue"
                           value="{{ $override ? $override->blue() : '' }}" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="brightness">Brightness:</label>
            <input type="number" class="form-control" id="brightness" name="brightness"
                   value="{{ $override ? $override->brightness() : '' }}" required>
        </div>

        <hr>

        <div class="form-group">
            <label for="start">Override start:</label>
            <input type="text" class="form-control datetime-picker" id="start" name="start"
                   value="{{ ($override ? date('d-m-Y H:i', $override->start) : '') }}" required>
        </div>

        <div class="form-group">
            <label for="end">Override end:</label>
            <input type="text" class="form-control datetime-picker" id="end" name="end"
                   value="{{ ($override ? date('d-m-Y H:i', $override->end) : '') }}" required>
        </div>

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

            <a href="{{ route("dmx::override::index") }}"
               class="btn btn-default pull-right">{{ ($override == null ? "Cancel" : "Overview") }}</a>

    </form>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">
        // Initializes datetimepickers for consistent options
        $('.datetime-picker').datetimepicker({
            icons: {
                time: "far fa-clock",
                date: "fas fa-calendar",
                up: "fas fa-arrow-up",
                down: "fas fa-arrow-down",
                next: "fas fa-chevron-right",
                previous: "fas fa-chevron-left"
            },
            format: 'DD-MM-YYYY HH:mm'
        });
    </script>

@endsection
