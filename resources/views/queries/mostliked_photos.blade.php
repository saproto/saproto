@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Actual membership totals
@endsection

@section('container')
    <div class="row d-inline-flex justify-content-center w-100">
        <div class="col-10">
            <div class="card mb-3">
                <div class="card-header">
                    <form method="get">
                        <div class="row">
                            <label
                                for="datetimepicker-start"
                                class="col-sm-auto col-form-label pe-0"
                            >
                                Start:
                            </label>
                            <div class="col-sm-auto">
                                @include(
                                    'components.forms.datetimepicker',
                                    [
                                        'name' => 'start',
                                        'format' => 'date',
                                        'placeholder' => $start->timestamp,
                                    ]
                                )
                            </div>
                            <label
                                for="datetimepicker-start"
                                class="col-sm-auto col-form-label pe-0"
                            >
                                End:
                            </label>
                            <div class="col-sm-auto">
                                @include(
                                    'components.forms.datetimepicker',
                                    [
                                        'name' => 'end',
                                        'format' => 'date',
                                        'placeholder' => $end->timestamp,
                                    ]
                                )
                            </div>

                            <div class="col-sm-auto">
                                <button type="submit" class="btn btn-success">
                                    Find activities!
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="row">
                        @foreach ($photos as $photo)
                            <div class="col-lg-2 col-lg-3 col-md-4 col-sm-6">
                                @include(
                                    'website.home.cards.card-bg-image',
                                    [
                                        'id' => sprintf('photo_%s', $photo->id),
                                        'url' => route('albums::album::show', [
                                            'album' => $album?->id ?? 'liked',
                                            'photo' => $photo,
                                        ]),
                                        'img' => $photo->getUrl(\App\Enums\PhotoEnum::SMALL),
                                        'html' => sprintf(
                                            '<i class="fas fa-heart %s"></i> %s %s',
                                            ! $photo->liked_by_me ? '' : 'text-danger',
                                            $photo->likes_count,
                                            $photo->private
                                                ? '<i class="fas fa-eye-slash ms-4 me-2 text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="This photo is only visible to members."></i>'
                                                : null,
                                        ),
                                        'photo_pop' => true,
                                        'height' => 200,
                                    ]
                                )
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    {{ $photos->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
