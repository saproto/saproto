<a href="{{ $url or '#' }}" class="card mb-3"
   style="text-decoration: none !important;">
    <div class="card-body" style="display: flex;
            text-shadow: 0 0 20px #fff;
            @if(isset($img))
            background: linear-gradient(rgba(255, 255, 255, 0.75),rgba(255, 255, 255, 0.75)), {{ sprintf('url(%s);', $img) }};
            background-size: cover; background-position: center center; height: 100px;
            @else
            background: #333;
            @endif">
        <p class="card-text" style="align-self: flex-end;">
            {!! $html !!}
        </p>
    </div>
</a>