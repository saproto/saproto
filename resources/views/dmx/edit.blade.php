@extends('website.layouts.redesign.dashboard')

@section('page-title')
    {{ ($fixture == null ? "Create new fixture." : "Edit fixture " . $fixture->name .".") }}
@endsection

@section('container')

    <form method="post"
          action="{{ ($fixture == null ? route("dmx::add") : route("dmx::edit", ['id' => $fixture->id])) }}"
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
                            <label for="name">Fixture name:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Ground Lights Section 1" value="{{ $fixture->name ?? '' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="channel_start">Fixture behavior:</label>
                            <select class="form-control" name="follow_timetable">
                                <option value="0" {{ $fixture && !$fixture->follow_timetable ? 'selected' : '' }}>Manual</option>
                                <option value="1" {{ $fixture && $fixture->follow_timetable ? 'selected' : '' }}>
                                    Automatic via timetable
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="channel_start">First channel:</label>
                            <input type="number" class="form-control" id="channel_start" name="channel_start"
                                   value="{{ $fixture->channel_start ?? '' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="channel_end">Last channel:</label>
                            <input type="number" class="form-control" id="channel_end" name="channel_end"
                                   value="{{ $fixture->channel_end ?? '' }}" required>
                        </div>

                        @if ($fixture != null)

                            <hr>

                            @foreach($fixture->getChannels() as $channel)

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Name for channel {{ $channel->id }}:</label>
                                            <input type="text" class="form-control" name="channel_name[{{ $channel->id }}]"
                                                   value="{{ $channel->name }}" required>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="channel_start">Channel type:</label>
                                                <select class="form-control" name="special_function[{{ $channel->id }}]">
                                                    <option value="none">
                                                        None
                                                    </option>
                                                    <option value="red" {{ $channel->special_function == 'red' ? 'selected' : '' }}>
                                                        Red
                                                    </option>
                                                    <option value="green" {{ $channel->special_function == 'green' ? 'selected' : '' }}>
                                                        Green
                                                    </option>
                                                    <option value="blue" {{ $channel->special_function == 'blue' ? 'selected' : '' }}>
                                                        Blue
                                                    </option>
                                                    <option value="brightness" {{ $channel->special_function == 'brightness' ? 'selected' : '' }}>
                                                        Brightness
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                        @endif

                    </div>

                    <div class="card-footer">

                        <button type="submit" class="btn btn-success float-right">Submit</button>

                        <a href="{{ route("dmx::index") }}" class="btn btn-default">
                            Cancel
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </form>

@endsection