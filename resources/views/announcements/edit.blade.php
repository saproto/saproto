@extends('website.layouts.panel')

@section('page-title')
    Announcements
@endsection

@section('panel-title')
    {{ ($announcement == null ? "Add announcement" : "Edit announcement.") }}
@endsection

@section('panel-body')

    <form method="post"
          action="{{ ($announcement == null ? route("announcement::add") : route("announcement::edit", ['id' => $announcement->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="name">Description:</label>
            <input type="text" class="form-control" id="description" name="description"
                   placeholder="Internal description." value="{{ $announcement->description or '' }}" required>
        </div>

        <div class="form-group">
            <label for="editor">Announcement:</label>
            @if (!$announcement)
                <textarea id="editor" name="content"
                          placeholder="The actual announcement. Markdown allowed."></textarea>
            @else
                <textarea id="editor" name="content">{{ $announcement->content }}</textarea>
            @endif
        </div>

        <div class="form-group">
            <label for="campaign_end">Start:</label>
            <input type="text" class="form-control datetime-picker" id="display_from" name="display_from"
                   value="{{ ($announcement ? date('Y-m-d H:i', strtotime($announcement->display_from)) : '') }}" required>
        </div>

        <div class="form-group">
            <label for="campaign_end">End:</label>
            <input type="text" class="form-control datetime-picker" id="display_till" name="display_till"
                   value="{{ ($announcement ? date('Y-m-d H:i', strtotime($announcement->display_till)) : '') }}" required>
        </div>

        <hr>

        <p>
            <strong>Announcement settings:</strong>
        </p>

        <div class="row">
            <div class="col-md-4">
                <div class="checkbox">
                    <label>
                        <input type="hidden" name="show_only_homepage" value="0">
                        <input type="checkbox" name="show_only_homepage" value="1"
                                {{ ($announcement == null ? 'checked' : $announcement->show_only_homepage ? 'checked' : '') }}>
                        Homepage only
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="checkbox">
                    <label>
                        <input type="hidden" name="show_as_popup" value="0">
                        <input type="checkbox" name="show_as_popup" value="1"
                                {{ ($announcement != null && $announcement->show_as_popup ? 'checked' : '') }}>
                        Pop-up
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="checkbox">
                    <label>
                        <input type="hidden" name="is_dismissable" value="0">
                        <input type="checkbox" name="is_dismissable" value="1"
                                {{ ($announcement == null ? 'checked' : $announcement->is_dismissable ? 'checked' : '') }}>
                        Dismissable
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Announcement style:</label>
            <select name="show_style" class="form-control">
                <option value="0" {{ ($announcement != null && $announcement->show_style == 0 ? 'selected' : '') }}>
                    Success (Green)
                </option>
                <option value="1" {{ ($announcement != null && $announcement->show_style == 1 ? 'selected' : '') }}>
                    Info (Blue)
                </option>
                <option value="2" {{ ($announcement != null && $announcement->show_style == 2 ? 'selected' : '') }}>
                    Warning (Yellow)
                </option>
                <option value="3" {{ ($announcement != null && $announcement->show_style == 3 ? 'selected' : '') }}>
                    Danger (Red)
                </option>
            </select>
        </div>

        <p>
            <strong>Users that can see this announcement:</strong>
        </p>

        <div class="row">
            <div class="col-md-4">
                <div class="checkbox">
                    <label>
                        <input type="hidden" name="show_guests" value="0">
                        <input type="checkbox" name="show_guests" value="1"
                                {{ ($announcement != null && $announcement->show_guests ? 'checked' : '') }}>
                        Guests
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="checkbox">
                    <label>
                        <input type="hidden" name="show_users" value="0">
                        <input type="checkbox" name="show_users" value="1"
                                {{ ($announcement != null && $announcement->show_users ? 'checked' : '') }}>
                        Users
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="checkbox">
                    <label>
                        <input type="hidden" name="show_members" value="0">
                        <input type="checkbox" name="show_members" value="1"
                                {{ ($announcement != null && $announcement->show_members ? 'checked' : '') }}>
                        Members
                    </label>
                </div>
            </div>
        </div>

        <p>
            <strong>Further restrict this announcement:</strong>
        </p>

        <div class="row">
            <div class="col-md-4">
                <div class="checkbox">
                    <label>
                        <input type="hidden" name="show_only_new" value="0">
                        <input type="checkbox" name="show_only_new" value="1"
                                {{ ($announcement != null && $announcement->show_only_new ? 'checked' : '') }}>
                        New users
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="checkbox">
                    <label>
                        <input type="hidden" name="show_only_firstyear" value="0">
                        <input type="checkbox" name="show_only_firstyear" value="1"
                                {{ ($announcement != null && $announcement->show_only_firstyear ? 'checked' : '') }}>
                        First years
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="checkbox">
                    <label>
                        <input type="hidden" name="show_only_active" value="0">
                        <input type="checkbox" name="show_only_active" value="1"
                                {{ ($announcement != null && $announcement->show_only_active ? 'checked' : '') }}>
                        Active members
                    </label>
                </div>
            </div>
        </div>

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

            <a href="{{ route("announcement::index") }}" class="btn btn-default pull-right">Back</a>

    </form>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">

        var simplemde = new SimpleMDE({
            element: $("#editor")[0],
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
            format: 'YYYY-MM-DD HH:mm'
        });

    </script>

@endsection
