@extends('website.layouts.default-nobg')

@section('page-title')

@endsection

@section('content')

    <div class="photo_right">
    @if ($photo->previous != null)
        <a href="{{route("photo::view", ["id"=> $photo->previous])}}" class="photo_move">
            Previous
        </a>
    @endif
    </div>

    @if ($photo->liked == null)
    <div class="photo_likebutton">
        <a href="{{route("photo::likes", ["id"=> $photo->id])}}" class="photo_move">
            <i class="fa fa-heart-o"></i>
        </a>
    </div>
    @endif
    @if ($photo->liked != null)
        <div class="photo_likebutton">
            <a href="{{route("photo::dislikes", ["id"=> $photo->id])}}" class="photo_move">
                <i class="fa fa-heart"></i>
            </a>
        </div>
    @endif

    <div class="photo_likes">
      <a href="{{route("photo::likes", ["id"=> $photo->id])}}" class="photo_move">{{ $photo->likes }}</a>
    </div>


    <div class="photo_next">
    @if($photo-> next != null)
        <a href="{{route("photo::view", ["id"=> $photo->next])}}" class="photo_move">
           Next
        </a>
    @endif
    </div>


    <img id="photo_size" src="{!! $photo->photo_url !!}" >

    <style type="text/css">

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
        width: 100%;
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
