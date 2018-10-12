<a href="{{ $url or '#' }}" class="card mb-3 {{ isset($classes) ? implode(' ', $classes) : null }}"
   style="text-decoration: none !important;
   {{ isset($height) ? sprintf('height: %spx;', $height) : null }}
           ">
    <div class="card-body" style="display: flex;
    @if(isset($photo_pop))
            color: #fff;
            text-shadow: 0 0 10px #000;
    @else
            text-shadow: 0 0 10px #fff;
    @endif
    @if(isset($img))
    @if(isset($photo_pop))
            background: linear-gradient(rgba(0, 0, 0, 0.2),rgba(0, 0, 0, 0.2)), {{ sprintf('url(%s);', $img) }};
            background-size: cover; background-position: center center; height: 100px;
    @else
            background: linear-gradient(rgba(255, 255, 255, 0.9),rgba(255, 255, 255, 0.9)), {{ sprintf('url(%s);', $img) }};
            background-size: cover; background-position: center center; height: 100px;
    @endif
    @else
            background: #333;
    @endif">
        <p class="card-text" style="align-self: flex-end;">
            {!! $html !!}
        </p>
    </div>
</a>