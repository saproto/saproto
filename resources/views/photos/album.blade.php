@extends('website.layouts.default-nobg')

@section('page-title')
    {{ $photos->album_title }}
@endsection

@section('content')

    <div id="album" data-chocolat-title="{{ $photos->album_title }}">

        @foreach($photos->photos as $key => $photo)

            @if($key % 4 == 0)
                <div class="row">
                    @endif

                    <div class="col-md-3 col-xs-6">

                        <a href="{!! ($photo->url) !!}" class="photo-link chocolat-image">
                            <div class="photo" style="background-image: url('{!! $photo->thumb !!}')"></div>
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
        $(document).ready(function () {
            $('#album').Chocolat();
        });
    </script>

@endsection