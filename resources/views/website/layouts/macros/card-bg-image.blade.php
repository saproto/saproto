<div id="{{ isset($id) ? $id : null  }}" class="card mb-3 text-decoration-none {{ isset($classes) ? implode(' ', $classes) : null }}
{{ isset($leftborder) ? sprintf('leftborder leftborder-%s', $leftborder) : null }}">
    <a href="{{ $url ?? '#' }}" class="card-body d-flex justify-content-end text-decoration-none {{ (isset($photo_pop)&&$photo_pop) ? 'photo_pop' : 'photo' }}"
       style="height: 100px; background: {{ isset($img) ? "url($img)" : '#333' }}{{ isset($height) ? sprintf('height: %spx;', $height) : null }}">
        <p class="card-text ellipsis">
            {!! $html !!}
        </p>
    </a>

    @if(isset($footer) && $footer != null)
        <div class="card-footer ellipsis">
            {!! $footer !!}
        </div>
    @endif
</div>