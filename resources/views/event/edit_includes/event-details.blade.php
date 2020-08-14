<form method="post"
      action="{{ ($event == null ? route("event::add") : route("event::edit", ['id' => $event->id])) }}"
      enctype="multipart/form-data">

    {!! csrf_field() !!}

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Event details
        </div>

        @include('event.edit_includes.buttonbar')

        <div class="card-body">

            <div class="row">

                <div class="col-md-7">

                    <div class="row align-items-end mb-3">

                        <div class="col-md-4 mb-3">

                            <label for="name">Event name:</label>
                            <input type="text" class="form-control" id="name" name="title"
                                   placeholder="Lightsaber Building in the SmartXp"
                                   value="{{ $event->title or '' }}"
                                   required>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label for="location">Location:</label>
                            <input type="text" class="form-control" id="location" name="location"
                                   placeholder="SmartXp" value="{{ $event->location or '' }}" required>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label for="organisation">Organisation: {!! $event && $event->committee ? $event->committee->name : null !!}</label>
                            <select class="form-control committee-search" id="organisation" name="committee"></select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <div class="form-group">
                                <label for="event_start">Event start:</label>
                                @include('website.layouts.macros.datetimepicker',[
                                    'name' => 'start',
                                    'format' => 'datetime',
                                    'placeholder' => $event ? $event->start : null
                                ])
                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <div class="form-group">
                                <label for="event_end">Event end:</label>
                                @include('website.layouts.macros.datetimepicker',[
                                    'name' => 'end',
                                    'format' => 'datetime',
                                    'placeholder' => $event ? $event->end : null
                                ])
                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Event image:</label>
                            <div class="custom-file">
                                <label class="custom-file-label" for="customFile">Update event image.</label>
                                <input type="file" class="custom-file-input" name="image">
                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Event category:</label>
                            <select name="category" class="form-control" required>
                                @foreach(config('event.category') as $category=>$index)
                                    <option value="{{ $index }}" {{ ($event != null && $event->category == $index ? 'selected' : '') }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="secret"
                                            {{ ($event && $event->secret ? 'checked' : '') }}>
                                    This event is secret and can only be seen by admins.
                                </label>
                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="involves_food"
                                            {{ ($event && $event->involves_food ? 'checked' : '') }}>
                                    This activity involves people eating food.
                                </label>
                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="force_calendar_sync"
                                            {{ ($event && $event->force_calendar_sync ? 'checked' : '') }}>
                                    Always sync this event to user calendars. <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="This will also sync this event to the calendars of users that specifically opted to only sync events they are either attending, organizing or helping at. This feature should only be used for events like GMMs."></i>
                                </label>
                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="is_external"
                                            {{ ($event && $event->is_external ? 'checked' : '') }}>
                                    This activity is not organized by Proto.
                                </label>
                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="is_featured"
                                            {{ ($event && $event->is_featured ? 'checked' : '') }}>
                                    Feature this event on the homepage.
                                </label>
                            </div>

                        </div>

                    </div>

                    @if($event && $event->image)

                        <hr>

                        <h5>Current image:</h5>
                        <img src="{!! $event->image->generateImagePath(800,300) !!}" class="w-100 border">

                    @endif

                </div>

                <div class="col-md-5">

                    <div class="form-group">
                        <label for="editor">Description</label>
                        @include('website.layouts.macros.markdownfield', [
                            'name' => 'description',
                            'placeholder' => $event == null ? "Please elaborate on why this event is awesome." : null,
                            'value' => $event == null ? null : $event->description
                        ])
                    </div>

                    <div class="form-group">
                        <label for="editor-summary">Summary</label>
                        @include('website.layouts.macros.markdownfield', [
                            'name' => 'summary',
                            'placeholder' => $event == null ? "A summary (used in the newsletter for example). Only a small description is required, other details will be added." : null,
                            'value' => $event == null ? null : $event->summary
                        ])
                    </div>

                </div>

            </div>

        </div>

        @include('event.edit_includes.buttonbar')

    </div>

</form>