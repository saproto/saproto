@extends('website.layouts.redesign.generic-sidebar')

@section('page-title')
    Albums
@endsection

@section('container')

    <div class="card mb-3">

        <div class="card-body">

            <div class="row">

                @foreach(Flickr::getAlbums() as $key => $album)

                    <div class="col-lg-2 col-lg-3 col-md-4 col-sm-6">

                        @include('website.layouts.macros.card-bg-image', [
                        'url' => route('photo::album::list', ['id' => $album->id]) ,
                        'img' => $album->thumb,
                        'html' => sprintf('<sub>%s</sub><br><strong>%s</strong>', date("M j, Y", $album->date_taken), $album->name),
                        'photo_pop' => true,
                        'height' => 150
                        ])

                    </div>

                @endforeach

            </div>

        </div>

    </div>

@endsection
