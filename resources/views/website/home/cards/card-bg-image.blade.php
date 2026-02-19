@php
    /**
     * @var string|null $id
     * @var string|null $url
     * @var string|null $img
     * @var \Spatie\MediaLibrary\MediaCollections\Models\Media|null $media
     * @var string|null $html
     * @var string|null $footer
     * @var array|null $classes
     * @var string|null $leftborder
     * @var int|null $height
     * @var bool|null $photo_pop
     */
@endphp
<div
    id="{{ $id ?? null }}"
    class="card text-decoration-none {{ isset($classes) ? implode(' ', $classes) : null }} {{ isset($leftborder) ? sprintf('leftborder leftborder-%s', $leftborder) : null }} mb-3"
>
    <a
        href="{{ $url ?? '#' }}"
        class="card-body d-flex justify-content-start p-0 text-decoration-none {{ isset($photo_pop) && $photo_pop ? 'photo_pop' : 'photo' }}"
        style="
            position: relative;
            overflow: hidden;
            background-color: #333;
    height: {{ $height ?? 100 }}px;
    "
    >
    @if(isset($media))
        <img src="{{ $media->getFullUrl() }}" srcset="{{$media->getSrcset()}}" class="card-bg-overlay" alt="">
    @elseif(isset($img))
            <img src="{{ $img }}" class="card-bg-overlay" alt="">
    @endif

    <div class="p-4" style="position: relative; z-index: 2; width: 100%;">
        <p class="card-text ellipsis">
            {!! $html !!}
        </p>
    </div>
    </a>

    @if (isset($footer) && $footer != null)
        <div class="card-footer ellipsis">
            {!! $footer !!}
        </div>
    @endif
</div>

<style>
    .card-bg-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        z-index: 1;
        border: none;
    }

    .photo .card-bg-overlay {
        filter: brightness(0.7);
    }
</style>
