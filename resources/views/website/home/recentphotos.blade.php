<h1 style="text-align: center; color: #fff; margin: 30px;">
    Recent photo albums
</h1>

<div class="row">

    @foreach(Flickr::getAlbums(6) as $key => $album)

        @if(isset($newsitems) && count($newsitems) <= 2)
            <div class="col-md-6 col-xs-6">
                @else
                    <div class="col-md-4 col-xs-6">
                        @endif

                        <a href="{{ route('photo::album::list', ['id' => $album->id]) }}" class="album-link">
                            <div class="album"
                                 style="background-image: url('{!! $album->thumb !!}')">
                                <div class="album-name">
                                    {{ date('M j, Y', $album->date_taken) }}: {{ $album->name }}
                                    @if ($album->private)
                                        <div class="photo__hidden">
                                            <i class="fa fa-low-vision" aria-hidden="true"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>

                    </div>

                    @endforeach

            </div>