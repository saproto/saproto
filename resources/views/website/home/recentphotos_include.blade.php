<div class="col-md-{{ $colsize }} col-xs-6">

    <a href="{{ $link_to_photos ? route('photo::albums') : route('photo::album::list', ['id' => $album->id]) }}"
       class="album-link">
        <div class="album"
             style="background-image: url('{!! $link_to_photos ? '': $album->thumb !!}'); background-color: #555;">
            @if($link_to_photos)
                <p style="color: #fff; font-size: 100px; text-align: center;">
                    ...
                </p>
            @endif
            <div class="album-name">
                @if ($link_to_photos)
                    View all photo albums!
                @else
                    {{ date('M j, Y', $album->date_taken) }}<br>
                    <strong>{{ $album->name }}</strong>
                @endif
                @if ($album->private)
                    <div class="photo__hidden">
                        <i class="fa fa-low-vision" aria-hidden="true"></i>
                    </div>
                @endif
            </div>
        </div>
    </a>

</div>