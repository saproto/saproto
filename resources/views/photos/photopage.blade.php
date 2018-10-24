@extends('website.layouts.redesign.generic-sidebar')

@section('page-title')
    Photo
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-12 col-lg-10 col-xl-8">

            <div class="card mb-3">
                <div class="card-header bg-dark text-center">

                    @if ($photo->previous != null)
                        <a href="{{route("photo::view", ["id"=> $photo->previous])}}" class="btn btn-dark mr-3">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    @endif

                    @if ($photo->liked == null)
                        <a href="{{route("photo::likes", ["id"=> $photo->id])}}" class="btn btn-outline-info mr-3">
                            <i class="far fa-heart"></i> {{ $photo->likes }}
                        </a>
                    @endif

                    @if($photo-> liked != null)
                        <a href="{{route("photo::dislikes", ["id"=> $photo->id])}}" class="btn btn-info mr-3">
                            <i class="fas fa-heart"></i> {{ $photo->likes }}
                        </a>
                    @endif

                    <a href="{{route("photo::album::list", ["id"=> $photo->album_id])}}"
                       class="btn btn-success mr-3">
                        <i class="fas fa-arrow-up mr-2" aria-hidden="true"></i> <i class="fas fa-images"></i>
                    </a>

                    @if($photo->next != null)
                        <a href="{{route("photo::view", ["id"=> $photo->next])}}" class="btn btn-dark">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    @endif

                </div>
            </div>

            <div class="card mb-3">
                <img class="card-img-bottom card-img-top" src="{!! $photo->photo_url !!}">
            </div>

            <div class="card mb-3">
                <div class="card-body bg-light">
                    <a href="mailto:photos&#64;{{ config('proto.emaildomain') }}" class="btn btn-default btn-block">
                        <i class="fas fa-shield-alt fa-fw mr-3"></i>
                        If you would like this photo removed, please contact photos&#64;{{ config('proto.emaildomain') }}.
                    </a>
                </div>
            </div>

        </div>

    </div>

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
