@extends('website.layouts.default-nobg')

@section('page-title')
    {{ $photos->album_title }} ({{ date('M j, Y', $photos->album_date) }})
@endsection

@section('content')

    @if($photos->event !== null)

        <p style="text-align: center;">

            <a class="btn btn-info" href="{{ route('event::show', ['event_id'=>$photos->event->id]) }}">
                Visit event information of {{ $photos->event->title }}
            </a>

        </p>

        <hr>

    @endif

    <div id="album" data-chocolat-title="{{ $photos->album_title }}">

        @foreach($photos->photos as $key => $photo)

            @if($key % 4 == 0)
                <div class="row">
                    @endif

                    <div class="col-md-3 col-xs-6">

                        <a href="{{route("photo::view", ["id"=> $photo->id])}}" class="photo-link">
                            <div class="photo" style="background-image: url('{!! $photo->thumb !!}')">
                                <div class="album-name">


                               Likes: {{$photo->getLikes()}}


                                </div>
                                @if ($photo->private)
                                    <div class="photo__hidden">
                                        <i class="fa fa-low-vision" aria-hidden="true"></i>
                                    </div>
                                @endif
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
        $(document).ready(function () {
            $('#album').Chocolat();
        });




    </script>

    <script>
        (function(window, location) {
            history.replaceState(null, document.title, location.pathname+"#!/stealingyourhistory");
            history.pushState(null, document.title, location.pathname);

            window.addEventListener("popstate", function() {
                if(location.hash === "#!/stealingyourhistory") {
                    history.replaceState(null, document.title, location.pathname);
                    setTimeout(function(){
                        location.replace("{{ route('photo::albums')}}");
                    },0);
                }
            }, false);
        }(window, location));
    </script>

@endsection