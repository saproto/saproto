@extends('website.layouts.default-nobg')

@section('page-title')
    {{ $photos->title }}
@endsection

@section('content')

    <div id="album" data-chocolat-title="{{ $photos->title }}">

    @foreach($photos->photo as $key => $photo)

        @if($key % 4 == 0)
            <div class="row">
                @endif

                <div class="col-md-3 col-xs-6">

                    <a href="{!! $photo->url_l !!}" class="photo-link chocolat-image">
                        <div class="photo"
                             style="background-image: url('{!! $photo->url_m !!}')">
                        </div>
                    </a>

                </div>

                @if($key % 4 == 3)
            </div>
        @endif

    @endforeach

    </div>

@endsection

@section('javascript')

    @parent

    <script>
        $(document).ready(function() {
            $('#album').Chocolat();
        });
    </script>

@endsection

@section('stylesheet')

    @parent

    <style type="text/css">

        .photo {
            position: relative;
            width: 100%;
            height: 200px;

            background-color: #666;
            background: linear-gradient(to bottom right, #333, #666);
            background-size: cover;
            background-position: center center;

            margin-bottom: 30px;
        }

        .photo-name {
            position: absolute;
            bottom: 0;

            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 10px 30px;
        }

        .photo-link:hover {
            text-decoration: none;
        }

        .photo-hidden {
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

        .photo-hidden:hover {
            text-decoration: none;
        }

        .chocolat-wrapper {
            z-index: 10000;
        }

    </style>

@endsection