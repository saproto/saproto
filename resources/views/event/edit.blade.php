@extends('website.layouts.default-nobg')

@section('page-title')
    {{ ($event == null ? "Create new event." : "Edit " . $event->title) }}
@endsection

@section('content')

    <div class="row">

        <div class="col-md-8">

            <div class="panel panel-default">

                <div class="panel-heading">
                    Event details
                </div>

                <form method="post"
                      action="{{ ($event == null ? route("event::add") : route("event::edit", ['id' => $event->id])) }}"
                      enctype="multipart/form-data">

                    <div class="panel-body">

                        {!! csrf_field() !!}

                        <div class="row">

                            <div class="col-md-4">

                                <div class="form-group">
                                    <label for="name">Event name:</label>
                                    <input type="text" class="form-control" id="name" name="title"
                                           placeholder="Lightsaber Building in the SmartXp"
                                           value="{{ $event->title or '' }}"
                                           required>
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="location-group">
                                    <label for="location">Location:</label>
                                    <input type="text" class="form-control" id="location" name="location"
                                           placeholder="SmartXp" value="{{ $event->location or '' }}" required>
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="location-group">
                                    <label for="organisation">Organization:</label>
                                    <select class="form-control" id="organisation" name="committee">
                                        <option selected>None</option>
                                        @foreach(Committee::orderBy('name', 'asc')->get() as $committee)
                                            <option value="{{ $committee->id }}" {{ ($event && $event->committee ? ($event->committee->id == $committee->id ? 'selected' : '') : '') }}>
                                                {{ $committee->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="event_start">Event start:</label>
                                    <input type="text" class="form-control datetime-picker" id="event_start"
                                           name="start"
                                           value="{{ ($event ? date('d-m-Y H:i', $event->start) : '') }}" required>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="event_end">Event end:</label>
                                    <input type="text" class="form-control datetime-picker" id="event_end" name="end"
                                           value="{{ ($event ? date('d-m-Y H:i', $event->end) : '') }}" required>
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Event visibility:</label>
                                    <select name="secret" class="form-control">
                                        <option value="1" {{ ($event != null && $event->secret ? 'selected' : '') }}>
                                            This activity is
                                            secret.
                                        </option>
                                        <option value="0" {{ ($event != null && !$event->secret ? 'selected' : '') }}>
                                            This activity is
                                            public.
                                        </option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="image">Image file:</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="involves_food"
                                                {{ ($event && $event->involves_food ? 'checked' : '') }}>
                                        This activity involves people eating food.
                                    </label>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="is_external"
                                                {{ ($event && $event->is_external ? 'checked' : '') }}>
                                        This activity is not organized by Proto.
                                    </label>
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="force_calendar_sync"
                                                {{ ($event && $event->force_calendar_sync ? 'checked' : '') }}>
                                        Always sync this event to user calendars.
                                    </label>
                                </div>

                            </div>

                        </div>

                        <div class="form-group">
                            <label for="editor">Description</label>
                            @if (!$event)
                                <textarea id="editor" name="description"
                                          placeholder="Please elaborate on why this event is awesome."></textarea>
                            @else
                                <textarea id="editor" name="description">{{ $event->description }}</textarea>
                            @endif
                        </div>


                        <div class="form-group">
                            <label for="editor-summary">Summary</label>
                            @if (!$event)
                                <textarea id="editor-summary" name="summary"
                                          placeholder="A summary (used in the newsletter for example). Only a description, all other data (date, time, location, costs, sign-up info) will be added automaticall where needed."></textarea>
                            @else
                                <textarea id="editor-summary" name="summary">{{ $event->summary or '' }}</textarea>
                            @endif
                        </div>

                        @if($event && $event->image)

                            <hr>

                            <label>Current image:</label>
                            <img src="{!! $event->image->generateImagePath(500,null) !!}" style="width: 100%">

                        @endif

                    </div>

                    <div class="panel-footer clearfix">

                        <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit
                        </button>

                        @if($event)
                            <a href="{{ route("event::delete", ['id' => $event->id]) }}"
                               class="btn btn-danger pull-left">Delete</a>
                        @endif

                        <a href="{{ $event ? route('event::show', ['id' => $event->getPublicId()]) : URL::previous() }}"
                           class="btn btn-default pull-right">Cancel</a>

                    </div>

                </form>

            </div>

        </div>

        <div class="col-md-4">

            <div class="panel panel-default">

                <div class="panel-heading">
                    Edit sign-up details
                </div>

                @if ($event != null)

                    <form method="post" action="{{ route('event::addsignup', ['id'=>$event->id]) }}">

                        {!! csrf_field() !!}

                        <div class="panel-body">

                            @if(!$event->activity)
                                <p style="text-align: center;">
                                    <strong>For this activity no sign-up details are configured.</strong>
                                </p>
                                <hr>
                            @endif

                            <div class="form-group">
                                <label for="signup_start">Sign-up start:</label>
                                <input type="text" class="form-control datetime-picker" id="signup_start"
                                       name="registration_start"
                                       value="{{ ($event->activity ? date('d-m-Y H:i', $event->activity->registration_start) : '') }}"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="signup_end">Sign-up end:</label>
                                <input type="text" class="form-control datetime-picker" id="signup_end"
                                       name="registration_end"
                                       value="{{ ($event->activity ? date('d-m-Y H:i', $event->activity->registration_end) : '') }}"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="signout_end">Sign-out end:</label>
                                <input type="text" class="form-control datetime-picker" id="signout_end"
                                       name="deregistration_end"
                                       value="{{ ($event->activity ? date('d-m-Y H:i', $event->activity->deregistration_end) : '') }}"
                                       required>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price">Participation cost:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">&euro;</span>
                                            <input type="text" class="form-control" id="price" name="price"
                                                   value="{{ ($event->activity ? $event->activity->price : '0') }}"
                                                   placeholder="15"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_show_fee">No show fee:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">&euro;</span>
                                            <input type="text" class="form-control" id="no_show_fee" name="no_show_fee"
                                                   value="{{ ($event->activity ? $event->activity->no_show_fee : '0') }}"
                                                   placeholder="15"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="participants">Participant limit:</label>
                                        <input type="number" class="form-control" id="participants"
                                               name="participants" min="-1"
                                               value="{{ ($event->activity ? $event->activity->participants : '') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <sub>-1 for no limit, 0 for only helpers</sub>
                                </div>
                            </div>

                        </div>

                        <div class="panel-footer clearfix">

                            <input type="submit" class="btn btn-success pull-right" value="Save sign-up details">

                            @if($event->activity)
                                <a href="{{ route('event::deletesignup', ['id'=>$event->id]) }}" class="btn btn-danger">Remove
                                    sign-up</a>
                            @endif

                        </div>

                    </form>

                @else

                    <div class="panel-body">

                        <p style="text-align: center;">
                            <strong>You must save this event before being able to add sign-up details.</strong>
                        </p>

                    </div>

                @endif

            </div>

            @if($event)

                <div class="panel panel-default">

                    <div class="panel-heading">
                        Photo albums
                    </div>

                    <form method="post" action="{{ route('event::linkalbum', ['event'=> $event->id]) }}">

                        {!! csrf_field() !!}

                        <div class="panel-body">
                            @foreach($event->albums as $album)
                                {{ $album->name }} <a
                                        href="{{ route('event::unlinkalbum', ['album'=>$album->id]) }}">[X]</a> <br>
                            @endforeach

                            <hr>

                            <select name="album_id" class="form-control" required>
                                @foreach(FlickrAlbum::whereNull('event_id')->orderBy('date_taken', 'desc')->get() as $album)
                                    <option value="{{ $album->id }}">{{ date('Y-m-d', $album->date_taken) }}
                                        : {{ $album->name }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="panel-footer">

                            <input type="submit" class="btn btn-success" value="Link photo album!">

                        </div>

                    </form>

                </div>

                @if($event->activity)

                    <div class="panel panel-default">

                        <div class="panel-heading">
                            Edit helping committees
                        </div>

                        <form method="post" action="{{ route('event::addhelp', ['id'=>$event->id]) }}">

                            {!! csrf_field() !!}

                            <div class="panel-body">

                                <div class="form-group">
                                    <select class="form-control" name="committee">
                                        <option disabled selected>Select a committee below:</option>
                                        @foreach(Committee::orderBy('name', 'asc')->get() as $committee)
                                            <option value="{{ $committee->id }}">{{ $committee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="amount" placeholder="15"
                                                   min="1" required>
                                            <span class="input-group-addon">people</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="submit" class="btn btn-success pull-right" value="Add">
                                    </div>
                                </div>

                                @if($event->activity->helpingCommittees->count() > 0)
                                    <hr>
                                    @foreach($event->activity->helpingCommittees as $committee)
                                        <p>
                                            <strong>{{ $committee->name }}</strong><br>
                                            Helps with
                                            {{ $event->activity->helpingUsers($committee->pivot->id)->count() }} people.
                                            {{ $committee->pivot->amount }} are needed.
                                            <a href="{{ route('event::deletehelp', ['id'=>$committee->pivot->id]) }}">
                                                Delete.
                                            </a>
                                        </p>
                                    @endforeach
                                @endif

                            </div>

                        </form>

                    </div>

                @endif

            @endif

        </div>

    </div>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">

        var simplemde = new SimpleMDE({
            element: $("#editor")[0],
            toolbar: ["bold", "italic", "|", "unordered-list", "ordered-list", "|", "link", "quote", "table", "code", "|", "preview"],
            spellChecker: false
        });

        var simplemde = new SimpleMDE({
            element: $("#editor-summary")[0],
            toolbar: ["bold", "italic", "|", "unordered-list", "ordered-list", "|", "link", "quote", "table", "code", "|", "preview"],
            spellChecker: false
        });

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