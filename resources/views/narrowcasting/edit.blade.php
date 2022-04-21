@extends('website.layouts.redesign.dashboard')

@section('page-title')
    {{ ($item == null ? "Create new campaign." : "Edit campaign " . $item->name .".") }}
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-4">

            <div class="card mb-3">

                <form method="post"
                      action="{{ ($item == null ? route("narrowcasting::add") : route("narrowcasting::edit", ['id' => $item->id])) }}"
                      enctype="multipart/form-data">

                    {!! csrf_field() !!}

                    <div class="card-header bg-dark text-white">
                        @yield('page-title')
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label for="name">Campaign name:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Lightsaber Building in the SmartXp" value="{{ $item->name ?? '' }}"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="campaign_start">Campaign start:</label>
                            @include('website.layouts.macros.datetimepicker', [
                                'name' => 'campaign_start',
                                'format' => 'datetime',
                                'placeholder' => $item ? $item->campaign_start : date('U')
                            ])
                        </div>

                        <div class="form-group">
                            <label for="campaign_end">Campaign end:</label>
                            @include('website.layouts.macros.datetimepicker', [
                                'name' => 'campaign_end',
                                'format' => 'datetime',
                                'placeholder' => $item ? $item->campaign_end : null
                            ])
                        </div>

                        <div class="form-group">
                            <label for="slide_duration">Slide duration in seconds:</label>
                            <input type="text" class="form-control" id="slide_duration" name="slide_duration"
                                   value="{{ $item->slide_duration ?? '30' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="youtube_id">YouTube ID:</label>
                            <input type="text" class="form-control" id="youtube_id" name="youtube_id"
                                   placeholder="Only the ID!" value="{{ $item->youtube_id ?? '' }}">
                        </div>

                        <p>
                            <sup><strong>Note:</strong> if a YouTube ID is present, the image file and slide duration
                                field is ignored and hidden.</sup>
                        </p>

                        @if($item && $item->youtube_id)

                            <label>Current video:</label>

                            <div class="row">

                                <div class="col-md-6">
                                    <img src="https://i.ytimg.com/vi/{{ $item->youtube_id }}/hqdefault.jpg"
                                         style="width: 100%">
                                </div>
                                <div class="col-md-6">
                                    <strong><a href="https://youtu.be/{{ $item->youtube_id }}"
                                               target="_blank">{{ $item->video()->snippet->title }}</a></strong>
                                    <br>
                                    <strong>{{ $item->video()->snippet->channelTitle }}</strong>
                                </div>

                            </div>

                        @else

                            <div class="custom-file mb-3">
                                <input type="file" class="custom-file-input" name="image">
                                <label class="custom-file-label">Upload an image</label>
                            </div>

                            <p>
                                <sup><strong>Screen resolution</strong> is 1680 x 1050 pixels.</sup>
                            </p>

                            @if($item && $item->image)

                                <label>Current image:</label>
                                <img src="{!! $item->image->generateImagePath(500, null) !!}" style="width: 100%">

                            @endif

                        @endif

                    </div>

                    <div class="card-footer">

                        <button type="submit" class="btn btn-success float-right">
                            Submit
                        </button>

                        <a href="{{ route("narrowcasting::list") }}" class="btn btn-default">Cancel</a>

                        <p class="text-center mb-0 mt-2">
                            Developed with <span class="text-danger"><i class="fab fa-youtube fa-fw"></i> YouTube</span>
                        </p>

                    </div>

                </form>

            </div>

        </div>

    </div>

    </form>

@endsection