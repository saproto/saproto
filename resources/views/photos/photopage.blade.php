@extends('website.layouts.default-nobg')

@section('page-title')

@endsection

@section('content')

    <div class="header">

    <div class="photo_right">
    @if ($photo->previous != null)
        <a href="{{route("photo::view", ["id"=> $photo->previous])}}" class="photo_move">
            <i class="fa fa-arrow-left"></i>
        </a>
    @endif
        @if (!$photo->previous)
            <p></p>
            @endif
    </div>


    <div class="photo_likebutton">
        @if ($photo->liked == null)
        <a href="{{route("photo::likes", ["id"=> $photo->id])}}" class="photo_move">
            <i class="fa fa-heart-o"></i>
        </a>
        @endif
        @if($photo-> liked != null)
         <a href="{{route("photo::dislikes", ["id"=> $photo->id])}}" class="photo_move">
             <i class="fa fa-heart"></i>
         </a>
            @endif
    </div>


    <div class="photo_likes">
      <a href="{{route("photo::likes", ["id"=> $photo->id])}}" class="photo_move">{{ $photo->likes }}</a>
    </div>


    <div class="photo_next">
    @if($photo->next != null)
        <a href="{{route("photo::view", ["id"=> $photo->next])}}" class="photo_move">
            <i class="fa fa-arrow-right"></i>
        </a>
    @endif
        @if (!$photo->next)
            <p></p>
        @endif
    </div>

    </div>

    <div>
    <img id="photo_size" src="{!! $photo->photo_url !!}" >
    </div>

    <style type="text/css">
        .header {
            width: 100%;
        }
        .photo_right {
            float: left;
            text-align: left;
            width: 19%;
        }
        .photo_next {
            float: right;
            text-align: right;
            width: 19%;
        }
        .photo_move{
            font-size: 20px;

        }
        .photo_likes{
            display: inline-block;
            text-align: left;
            width:29%;
        }
        .photo_likebutton{
            display: inline-block;
            text-align: right;
            width:29%;
        }

        #photo_size {
        display: block;
            margin-left: auto;
            margin-right: auto;
            max-height: 80vh;
            max-width:99%;


        }

    </style>

@endsection

@section('javascript')
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
            }else if (e.keyCode == '40') {
                @if (Auth::check())
                    window.location.href = '{{route("photo::dislikes", ["id"=> $photo->id])}}';
                @endif
            }}



    </script>

    <script>
        (function(window, location) {
            history.replaceState(null, document.title, location.pathname+"#!/stealingyourhistory");
            history.pushState(null, document.title, location.pathname);

            window.addEventListener("popstate", function() {
                if(location.hash === "#!/stealingyourhistory") {
                    history.replaceState(null, document.title, location.pathname);
                    setTimeout(function(){
                        location.replace("{{ route('photo::album::list', ['id' => $photo->album_id]) }}");
                    },0);
                }
            }, false);
        }(window, location));
    </script>

@endsection
