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