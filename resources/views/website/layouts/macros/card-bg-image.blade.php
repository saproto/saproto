<div class="card mb-3 {{ isset($classes) ? implode(' ', $classes) : null }}
{{ isset($leftborder) ? sprintf('leftborder leftborder-%s', $leftborder) : null }}"
   style="text-decoration: none !important;">
    <a href="{{ $url or '#' }}" class="card-body" style="display: flex; text-decoration: none !important;
    @if(isset($photo_pop) && $photo_pop)
            color: #fff;
            text-shadow: 0 0 10px #000;
    @else
            color: #222;
            text-shadow: 0 0 10px #fff;
    @endif
    @if(isset($img) && $img)
    @if(isset($photo_pop) && $photo_pop)
            background: {{ sprintf('url(%s);', $img) }};
            background-size: cover; background-position: center center; height: 100px;
    @else
            background: linear-gradient(rgba(255, 255, 255, 0.9),rgba(255, 255, 255, 0.9)), {{ sprintf('url(%s);', $img) }};
            background-size: cover; background-position: center center; height: 100px;
    @endif
    @else
            background: #333;
    @endif
    {{ isset($height) ? sprintf('height: %spx;', $height) : null }}
            ">
        <p class="card-text" style="align-self: flex-end;">
            {!! $html !!}
        </p>
    </a>
    @if(isset($footer) && $footer != null)
        <div class="card-footer ellipsis">
            {!! $footer !!}
        </div>
    @endif
</div>