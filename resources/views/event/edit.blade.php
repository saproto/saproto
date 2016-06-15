@extends('website.layouts.default-nobg')

@section('page-title')
    {{ ($event == null ? "Create new event." : "Edit " . $event->title) }}
@endsection

@section('content')

    <div class="row">

        <div class="col-md-8">

            <div class="panel panel-default">

                <div class="panel-heading">
                    Edit event details
                </div>

                <form method="post"
                      action="{{ ($event == null ? route("event::add") : route("event::edit", ['id' => $event->id])) }}"
                      enctype="multipart/form-data">

                    <div class="panel-body">

                        {!! csrf_field() !!}

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="name">Event name:</label>
                                    <input type="text" class="form-control" id="name" name="title"
                                           placeholder="Lightsaber Building in the SmartXp"
                                           value="{{ $event->title or '' }}"
                                           required>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="location-group">
                                    <label for="slide_duration">Location:</label>
                                    <input type="text" class="form-control" id="location" name="location"
                                           placeholder="SmartXp" value="{{ $event->location or '' }}" required>
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

                        @if($event->image)

                            <hr>

                            <label>Current image:</label>
                            <img src="{{ route("file::get", ['id' => $event->image->id]) }}" style="width: 100%">

                        @endif

                    </div>

                    <div class="panel-footer clearfix">

                        <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit
                        </button>

                        @if($event)
                            <a href="{{ route("event::delete", ['id' => $event->id]) }}"
                               class="btn btn-danger pull-left">Delete</a>
                        @endif

                        <a href="javascript:history.go(-1)" class="btn btn-default pull-right">Cancel</a>

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

                    <form method="post" action="{{ route('event::addsignup', ['id'=>$event->id]) }}"
                          enctype="multipart/form-data">

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
                                        <label for="participants">Participant limit:</label>
                                        <input type="text" class="form-control" id="participants"
                                               name="participants"
                                               value="{{ ($event->activity ? $event->activity->participants : '') }}"
                                               placeholder="0 for no limit" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price">Participation cost:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">&euro;</span>
                                            <input type="text" class="form-control" id="price" name="price"
                                                   value="{{ ($event->activity ? $event->activity->price : '') }}"
                                                   placeholder="15"
                                                   required>
                                        </div>
                                    </div>
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

        </div>

    </div>

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