@extends('website.layouts.default-nobg')

@section('page-title')
    Albums
@endsection

@section('content')

    @foreach($albums as $key => $album)

        @if($key % 3 == 0)
            <div class="row">
                @endif

                <div class="col-md-4 col-xs-6">

                    <a href="{{ route('photo::album::list', ['id' => $album->id]) }}" class="album-link">
                        <div class="album"
                             style="background-image: url('{!! $album->primary_photo_extras->url_m !!}')">
                            <div class="album-name">
                                {{ $album->title->_content }}
                            </div>
                        </div>
                    </a>

                </div>

                @if($key % 3 == 2)
            </div>
        @endif

    @endforeach

@endsection

@section('stylesheet')

    @parent

    <style type="text/css">

        .album {
            position: relative;
            width: 100%;
            height: 200px;

            background-color: #666;
            background: linear-gradient(to bottom right, #333, #666);
            background-size: cover;
            background-position: center center;

            margin-bottom: 30px;
        }

        .album-name {
            position: absolute;
            bottom: 0;

            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 10px 30px;
        }

        .album-link:hover {
            text-decoration: none;
        }

        .album-hidden {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;

            opacity: 0.2;

            line-height: 150px;
            text-align: center;
            font-size: 120px;

            color: #fff;
        }

        .album-hidden:hover {
            text-decoration: none;
        }

    </style>

@endsection