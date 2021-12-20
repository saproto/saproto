@extends('website.layouts.redesign.dashboard')

@section('page-title')
    {{ ($announcement == null ? "Add announcement" : "Edit announcement.") }}
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-4">

            <form method="post"
                  action="{{ ($announcement == null ? route("announcement::add") : route("announcement::edit", ['id' => $announcement->id])) }}"
                  enctype="multipart/form-data">

                <div class="card mb-3">

                    <div class="card-header bg-dark text-white">
                        @yield('page-title')
                    </div>

                    <div class="card-body">

                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label for="name">Description:</label>
                            <input type="text" class="form-control" id="description" name="description"
                                   placeholder="Internal description." value="{{ $announcement->description ?? '' }}"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="editor">Announcement:</label>
                            @include('website.layouts.macros.markdownfield', [
                                'name' => 'content',
                                'placeholder' => "Awesome announcement goes here.",
                                'value' => $announcement == null ? null : $announcement->content
                            ])
                        </div>

                        @include('website.layouts.macros.datetimepicker', [
                            'name' => 'display_from',
                            'label' => 'Start:',
                            'placeholder' => $announcement ? strtotime($announcement->display_from) : strtotime(Carbon::now())
                        ])

                        @include('website.layouts.macros.datetimepicker', [
                            'name' => 'display_till',
                            'label' => 'End:',
                            'placeholder' => $announcement ? strtotime($announcement->display_till) : strtotime(Carbon::now()->endOfDay()   )
                        ])

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
                            <label for="show-style">Announcement style:</label>
                            <select id="show-style" name="show_style" class="form-control">
                                <option value="0" {{ ($announcement != null && $announcement->show_style == 0 ? 'selected' : '') }}>
                                    Primary (Green)
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

                    </div>

                    <div class="card-footer">

                        <button type="submit" class="btn btn-success float-end ms-4">
                            Submit
                        </button>

                        <a href="{{ route("announcement::index") }}" class="btn btn-default pull-end">Back</a>

                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection
