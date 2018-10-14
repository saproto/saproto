@extends('website.layouts.default-nobg')

@section('page-title')
    Create new e-mail
@endsection

@section('content')

    <div class="row">

        <form method="post"
              action="{{ ($email == null ? route("email::add") : route("email::edit", ['id' => $email->id])) }}"
              enctype="multipart/form-data">

            <div class="col-md-8">

                <div class="panel panel-default">

                    <div class="panel-heading">
                        E-mail details
                    </div>

                    <div class="panel-body">

                        {!! csrf_field() !!}

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="description">Internal description:</label>
                                    <input type="text" class="form-control" id="description" name="description"
                                           placeholder="A short descritpion that only the board can see."
                                           value="{{ $email->description or '' }}" required>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="subject">E-mail subject:</label>
                                    <input type="text" class="form-control" id="subject" name="subject"
                                           placeholder="The e-mail subject."
                                           value="{{ $email->subject or '' }}" required>
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="sender_name">Sender name:</label>
                                    <input type="text" class="form-control" id="sender_name" name="sender_name"
                                           placeholder="{{ Auth::user()->name }}"
                                           value="{{ $email->sender_name or Auth::user()->name }}" required>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="sender_address">Sender e-mail:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="sender_address"
                                               name="sender_address" placeholder="board"
                                               value="{{ $email->sender_address or '' }}" required>
                                        <span class="input-group-addon">@ {{ config('proto.emaildomain') }}</span>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="form-group">
                            <label for="editor">E-mail</label>
                            @if ($email == null)
                                <textarea id="editor" name="body"
                                          placeholder="What do you you wish to tell the recipient?"></textarea>
                            @else
                                <textarea id="editor" name="body">{{ $email->body }}</textarea>
                            @endif
                        </div>

                        <div class="row">


                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Recipients:</label>

                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="destinationType" id="destinationMembers" required
                                                   value="members" {{ ($email && $email->to_member ? 'checked' : '') }}>
                                            All members
                                        </label>
                                    </div>

                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="destinationType" id="destinationActiveMembers"
                                                   required
                                                   value="active" {{ ($email && $email->to_active ? 'checked' : '') }}>
                                            All active members
                                        </label>
                                    </div>

                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="destinationType" id="destinationEvent" required
                                                   value="event" {{ ($email && $email->to_event ? 'checked' : '') }}>
                                            These events:
                                        </label>
                                    </div>

                                    @if($email && $email->to_event)
                                        <p>
                                            <strong>Current selection</strong>
                                        </p>

                                        <p>
                                        <ul class="list-group">
                                            @foreach($email->events as $event)
                                                <li class="list-group-item">
                                                    {{ $event->title }} ({{ $event->formatted_date->simple }})
                                                </li>
                                            @endforeach
                                        </ul>
                                        </p>

                                        <p>
                                            <strong>Replace selection</strong>
                                        </p>
                                    @endif

                                    <select class="form-control event-search" id="eventSelect" name="eventSelect[]"
                                            {{ ($email && $email->to_event ? '' : 'disabled="disabled"') }} multiple></select>

                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="destinationType" id="destinationLists" required
                                                   value="lists" {{ ($email && $email->to_list ? 'checked' : '') }}>
                                            These e-mail lists:
                                        </label>
                                    </div>

                                    <select multiple name="listSelect[]" id="listSelect" class="form-control"
                                            {{ ($email && $email->to_list ? '' : 'disabled="disabled"') }}>

                                        @foreach(EmailList::all() as $list)

                                            <option value="{{ $list->id }}" {{ ($email && $email->hasRecipientList($list) ? 'selected' : '' ) }}>
                                                {{ $list->name }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="time">Scheduled:</label>
                                    <input type="text" class="form-control datetime-picker" id="time" name="time"
                                           placeholder="When should this e-mail be sent?"
                                           value="{{ ($email ? date('d-m-Y H:i', $email->time) : '') }}" required>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="panel-footer">

                        <button type="submit" class="btn btn-success" style="margin-left: 15px;">Save
                        </button>

                        <a href="{{ route("email::admin") }}" class="btn btn-default">Cancel</a>

                    </div>

                </div>

            </div>

        </form>

        <div class="col-md-4">

            <div class="panel panel-default">

                <div class="panel-heading">
                    Variables
                </div>

                <div class="panel-body">

                    <p>
                        <strong>
                            You can use the following variables in the e-mail.
                        </strong>
                    </p>

                    <p>
                        <i>$name</i> - The name of the recipient.
                        <i>$calling_name</i> - The calling name of the recipient.
                    </p>

                </div>

            </div>

            <div class="panel panel-default">

                <div class="panel-heading">
                    Attachments
                </div>

                <div class="panel-body">

                    @if($email)

                        @if($email->attachments->count() > 0)

                            <table class="table">

                                <thead>
                                <th>File</th>
                                <th>Size</th>
                                <th>Controls</th>
                                </thead>

                                @foreach($email->attachments as $attachment)

                                    <tr>
                                        <td>
                                            <a href="{{ $attachment->generatePath() }}">{{ $attachment->original_filename }}</a>
                                        </td>
                                        <td>
                                            <i>{{ $attachment->getFileSize() }}</i>
                                        </td>
                                        <td>
                                            <a class="btn btn-xs btn-danger"
                                               onclick="return confirm('You sure you want to delete this attachment?')"
                                               href="{{ route('email::attachment::delete', ['id' => $email->id, 'file_id' => $attachment->id]) }}"
                                               role="button">
                                                <i class="fas fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>

                                @endforeach

                            </table>

                        @else

                            <p>There are no attachments to this e-mail.</p>

                        @endif

                        <hr>

                        <form method="post" enctype="multipart/form-data"
                              action="{{ route('email::attachment::add', ['id'=>$email->id]) }}">

                            {{ csrf_field() }}

                            <input name="attachment" type="file" class="form-control" required>
                            <br>
                            <button type="submit"
                                    onclick="return confirm('Any unsaved changes to the e-mail will be discarded if you continue.')"
                                    class="btn btn-success" style="margin-left: 15px;">
                                Upload
                            </button>

                        </form>

                    @else

                        <p>Please save this e-mail before attaching attachements.</p>

                    @endif

                </div>

            </div>

            <div class="panel panel-default">

                <div class="panel-heading">
                    Recipients
                </div>

                <div class="panel-body" style="max-height: 400px; overflow: auto;">

                    @if($email)

                        <p>
                            <strong>
                                {{ $email->recipients()->count() }} people will receive this e-mail:
                            </strong>
                        </p>

                        <p>

                            @foreach($email->recipients() as $recipient)

                                {{ $recipient->name }}<br>

                            @endforeach

                        </p>

                    @else

                        <p>Please save this e-mail before viewing recipients.</p>

                    @endif

                </div>

            </div>

        </div>

    </div>

@endsection

@section('javascript')

    @parent

    <script>
        var simplemde = new SimpleMDE({
            element: $("#editor")[0],
            toolbar: ["bold", "italic", "|", "unordered-list", "ordered-list", "|", "link", "quote", "table", "code", "|", "preview"],
            spellChecker: false
        });
    </script>

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

        $("#destinationEvent").click(function () {
            $("#listSelect").prop('disabled', true);
            $("#eventSelect").prop('disabled', false);
        });
        $("#destinationLists").click(function () {
            $("#listSelect").prop('disabled', false);
            $("#eventSelect").prop('disabled', true);
        });
        $("#destinationMembers").click(function () {
            $("#listSelect").prop('disabled', true);
            $("#eventSelect").prop('disabled', true);
        });
        $("#destinationUsers").click(function () {
            $("#listSelect").prop('disabled', true);
            $("#eventSelect").prop('disabled', true);
        });
        $("#destinationActiveMembers").click(function () {
            $("#listSelect").prop('disabled', true);
            $("#eventSelect").prop('disabled', true);
        });
    </script>

@endsection