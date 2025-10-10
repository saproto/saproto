@extends('website.layouts.redesign.generic')
@php
    use App\Enums\PhotoEnum;
    /**
     * @var \App\Models\PhotoAlbum|null $album
     * @var \Illuminate\Support\Collection<\App\Models\Photo> $photos
     */

    $title = ($album?->name ?? 'My liked photos') . ' ' . date('M j, Y', $album?->date_taken ?? time());
@endphp

@section('page-title')
    {{ $title }}
@endsection

@section('container')
    @if ($album?->event)
        <a
            class="btn btn-info btn-block mb-3"
            href="{{ route('event::show', ['event' => $album->event]) }}"
        >
            These photos were taken at the event {{ $album->event->title }},
            click here for more info.
        </a>
    @endif

    <div class="card mb-3">
        <div class="card-header bg-dark text-end text-white">
            <a
                href="{{ route('albums::index') }}"
                class="btn btn-success float-start me-3"
            >
                <i class="fas fa-list"></i>
                <span class="d-none d-sm-inline">Album overview</span>
            </a>
            @can('protography')
                @if ($album)
                    <a
                        href="{{ route('albums::admin::edit', ['id' => $album->id]) }}"
                        class="btn btn-success float-start me-3"
                    >
                        <i class="fas fa-edit"></i>
                        <span class="d-none d-sm-inline">Edit album</span>
                    </a>
                @endif
            @endcan

            <div class="fw-bold m-1 p-1">
                {{ $title }}
            </div>
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
                                'img' => $photo->getUrl(PhotoEnum::SMALL),
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

        <div class="card-footer text-center">
            <i class="fas fa-shield-alt fa-fw me-3"></i>
            If there is a photo that you would like removed, please contact
            <a
                href="mailto:photos&#64;{{ Config::string('proto.emaildomain') }}"
            >
                photos&#64;{{ Config::string('proto.emaildomain') }}.
            </a>
        </div>
    </div>

    &nbsp;
@endsection
