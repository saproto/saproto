@php
    /** @var App\Models\NarrowcastingItem $item */
    use App\Enums\NarrowcastingEnum;
@endphp

@extends('website.layouts.redesign.dashboard')

@section('page-title')
    {{ $item == null ? 'Create new campaign.' : 'Edit campaign ' . $item->name . '.' }}
@endsection

@section('container')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card mb-3">
                <form
                    method="post"
                    action="{{ $item == null ? route('narrowcasting::store') : route('narrowcasting::update', ['id' => $item->id]) }}"
                    enctype="multipart/form-data"
                >
                    @csrf

                    <div class="card-header bg-dark text-white">
                        @yield('page-title')
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Campaign name:</label>
                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                placeholder="Lightsaber Building in the SmartXp"
                                value="{{ $item->name ?? '' }}"
                                required
                            />
                        </div>

                        @include(
                            'components.forms.datetimepicker',
                            [
                                'name' => 'campaign_start',
                                'label' => 'Campaign start:',
                                'placeholder' => $item ? $item->campaign_start : date('U'),
                            ]
                        )

                        @include(
                            'components.forms.datetimepicker',
                            [
                                'name' => 'campaign_end',
                                'label' => 'Campaign end:',
                                'placeholder' => $item ? $item->campaign_end : null,
                            ]
                        )

                        <div class="form-group mb-3">
                            <label for="slide_duration">
                                Slide duration in seconds:
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="slide_duration"
                                name="slide_duration"
                                value="{{ $item->slide_duration ?? '30' }}"
                                required
                            />
                        </div>

                        <div class="custom-file mb-3">
                            <input
                                id="image"
                                type="file"
                                class="form-control"
                                name="image"
                            />
                            <label class="form-label">
                                Upload an image or video
                            </label>
                        </div>

                        <p>
                            <sup>
                                <strong>Images should be</strong>
                                1366 x 768 pixels.
                            </sup>

                            @if ($item?->hasMedia())
                                @if ($item->isVideo())
                                    <video
                                        width="320"
                                        height="240"
                                        autoplay
                                        muted
                                    >
                                        <source
                                            src="{!! $item->getImageUrl() !!}"
                                            type="video/mp4"
                                        />
                                        Your browser does not support
                                        the video tag.
                                    </video>
                                @else
                                    <label>Current image:</label>
                                    <img
                                        src="{!! $item->getImageUrl(NarrowcastingEnum::SMALL) !!}"
                                        class="w-100"
                                        alt="{{ $item->name }}'s image"
                                    />
                                @endif
                            @endif
                        </p>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success float-end">
                            Submit
                        </button>

                        <a
                            href="{{ route('narrowcasting::index') }}"
                            class="btn btn-default"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
