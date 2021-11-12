@extends('website.layouts.redesign.dashboard')

@section('page-title')
    {{ ($override == null ? "Create new override." : "Edit override.") }}
@endsection

@section('container')

    <form method="post"
          action="{{ ($override == null ? route("dmx::override::add") : route("dmx::override::edit", ['id' => $override->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="row justify-content-center">

            <div class="col-md-4">

                <div class="card mb-3">

                    <div class="card-header bg-dark text-white">
                        @yield('page-title')
                    </div>

                    <div class="card-body">

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
                            @include('website.layouts.macros.datetimepicker', [
                                'name' => 'start',
                                'format' => 'datetime',
                                'placeholder' => $override ? $override->start : strtotime(Carbon::now())
                            ])
                        </div>

                        <div class="form-group">
                            <label for="end">Override end:</label>
                            @include('website.layouts.macros.datetimepicker', [
                                'name' => 'end',
                                'format' => 'datetime',
                                'placeholder' => $override ? $override->end : strtotime(Carbon::now()->endOfDay())
                            ])
                        </div>

                    </div>

                    <div class="card-footer">

                        <button type="submit" class="btn btn-success float-end">Submit</button>

                        <a href="{{ route("dmx::override::index") }}" class="btn btn-default">
                            Cancel
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </form>

@endsection
