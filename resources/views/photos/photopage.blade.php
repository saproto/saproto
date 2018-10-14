@extends('website.layouts.default-nobg')

@section('page-title')

@endsection

@section('content')

    <div id="photo_buttons">

        @if ($photo->previous != null)
            <a href="{{route("photo::view", ["id"=> $photo->previous])}}">
                <i class="fas fa-arrow-left"></i>
            </a>
            &nbsp;&nbsp;&nbsp;
        @endif

        @if ($photo->liked == null)
            <a href="{{route("photo::likes", ["id"=> $photo->id])}}">
                <i class="fas fa-heart-o"></i> {{ $photo->likes }}
            </a>
        @endif

        @if($photo-> liked != null)
            <a href="{{route("photo::dislikes", ["id"=> $photo->id])}}">
                <i class="fas fa-heart"></i> {{ $photo->likes }}
            </a>
        @endif

        &nbsp;&nbsp;&nbsp;

        <a href="{{route("photo::album::list", ["id"=> $photo->album_id])}}">
            <i class="fas fa-arrow-up" aria-hidden="true"></i> Album
        </a>

        @if($photo->next != null)
            &nbsp;&nbsp;&nbsp;
            <a href="{{route("photo::view", ["id"=> $photo->next])}}">
                <i class="fas fa-arrow-right"></i>
            </a>
        @endif

    </div>

    <div>
        <img id="photo_size" src="{!! $photo->photo_url !!}">
    </div>

    <style type="text/css">
        #photo_buttons {
            width: 100%;
            text-align: center;
            margin-bottom: 15px;
            font-size: 20px;
        }

        #photo_size {
            display: block;
            margin-left: auto;
            margin-right: auto;
            max-height: 80vh;
            max-width: 99%;

        }

    </style>

@endsection

@section('javascript')

    @parent

    <script>

        document.onkeydown = checkKey;

        function checkKey(e) {

            e = e || window.event;

            if (e.keyCode == '37') {
                @if ($photo->previous != null)
                    window.location.href = '{{route("photo::view", ["id"=> $photo->previous])}}';
                @endif
            }
            else if (e.keyCode == '39') {
                @if ($photo->next != null)
                    window.location.href = '{{route("photo::view", ["id"=> $photo->next])}}';
                @endif
            } else if (e.keyCode == '38') {
                @if (Auth::check())
                    window.location.href = '{{route("photo::likes", ["id"=> $photo->id])}}';
                @endif
            } else if (e.keyCode == '40') {
                @if (Auth::check())
                    window.location.href = '{{route("photo::dislikes", ["id"=> $photo->id])}}';
                @endif
            }
        }


    </script>

    <script>
        (function (window, location) {
            history.replaceState(null, document.title, location.pathname + "#!/stealingyourhistory");
            history.pushState(null, document.title, location.pathname);

            window.addEventListener("popstate", function () {
                if (location.hash === "#!/stealingyourhistory") {
                    history.replaceState(null, document.title, location.pathname);
                    setTimeout(function () {
                        location.replace("{{ route('photo::album::list', ['id' => $photo->album_id]) }}");
                    }, 0);
                }
            }, false);
        }(window, location));
    </script>

@endsection
