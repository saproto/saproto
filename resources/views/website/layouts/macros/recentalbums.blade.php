<div class="card mb-3">
    <div class="card-header bg-dark text-white">Recent photo albums</div>
    <div class="card-body">

        @foreach(Flickr::getAlbums($n) as $key => $album)

            @include('website.layouts.macros.card-bg-image', [
            'url' => route('photo::album::list', ['id' => $album->id]) ,
            'img' => $album->thumb,
            'html' => sprintf('%s<br><strong>%s</strong>', date("M j, Y", $album->date_taken), $album->name)
            ])

        @endforeach

        <a href="{{ route('photo::albums') }}" class="btn btn-info btn-block">All photos</a>

    </div>
</div>