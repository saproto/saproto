<h1 style="text-align: center; color: #fff; margin: 30px;">
    Recent photo albums
</h1>

<div class="row">

    @foreach(Flickr::getAlbums(5) as $key => $album)

        @include('website.home.recentphotos_include', ['colsize'=> isset($newsitems) && count($newsitems) <= 2 ? 6: 4,
        'album'=>$album, 'link_to_photos' => false])

    @endforeach

    @include('website.home.recentphotos_include', ['colsize'=> isset($newsitems) && count($newsitems) <= 2 ? 6: 4,
     'link_to_photos' => true])

</div>