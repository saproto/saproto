<div class="card mb-3 {{ isset($classes) ? implode(' ', $classes) : null }}
{{ isset($leftborder) ? sprintf('leftborder leftborder-%s', $leftborder) : null }}"
   style="text-decoration: none !important;">
    <a href="{{ $url or '#' }}" class="card-body
    @if(isset($photo_pop) && $photo_pop)
            photo_pop
    @else
            photo
    @endif
            " style="display: flex; text-decoration: none !important;
    @if(isset($img) && $img)
    @if(isset($photo_pop) && $photo_pop)
            background-image: {{ sprintf('url(%s);', $img) }};
    @else
            background-image: {{ sprintf('url(%s);', $img) }};
    @endif
    @else
            background: #333;
    @endif
    {{ isset($height) ? sprintf('height: %spx;', $height) : null }}
            ">
        <p class="card-text ellipsis" style="align-self: flex-end;">
            {!! $html !!}
        </p>
    </a>

    @if(isset($footer) && $footer != null)
        <div class="card-footer ellipsis">
            {!! $footer !!}
        </div>
    @endif
</div>