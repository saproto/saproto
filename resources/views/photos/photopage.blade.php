@extends('website.layouts.redesign.generic')

@section('page-title')
    Photo
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-12 col-lg-10 col-xl-8">

            <div class="card mb-3">

                <div class="card-header bg-dark text-right">

                    <a href="{{route("photo::album::list", ["id"=> $photo->album_id])}}"
                       class="btn btn-success float-left mr-3">
                        <i class="fas fa-images mr-3"></i> {{ $photo->album_name }}
                    </a>

                    @if ($photo->previous != null)
                        <a href="{{route("photo::view", ["id"=> $photo->previous])}}" class="btn btn-dark mr-3">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    @else
                        <a class="btn btn-dark mr-3" disabled>
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    @endif

                    @if ($photo->liked == null)
                        <a href="{{route("photo::likes", ["id"=> $photo->id])}}" class="btn btn-outline-info mr-3">
                            <i class="far fa-heart"></i> {{ $photo->likes }}
                        </a>
                    @endif

                    @if($photo->liked != null)
                        <a href="{{route("photo::dislikes", ["id"=> $photo->id])}}" class="btn btn-info mr-3">
                            <i class="fas fa-heart"></i> {{ $photo->likes }}
                        </a>
                    @endif

                    @if($photo->private)
                        <a href="javascript:void();" class="btn btn-info mr-3" data-toggle="tooltip"
                           data-placement="top" title="This photo is only visible to members.">
                            <i class="fas fa-eye-slash"></i>
                        </a>
                    @endif

                    @if($photo->next != null)
                        <a href="{{route("photo::view", ["id"=> $photo->next])}}" class="btn btn-dark">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    @else
                        <a class="btn btn-dark" disabled>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    @endif

                </div>

                <img class="card-img-bottom" src="{!! $photo->photo_url !!}">

            </div>

            <div class="card mb-3">
                <div class="card-body text-center">
                    <i class="fas fa-shield-alt fa-fw mr-3"></i>
                    If there is a photo that you would like removed, please contact
                    <a href="mailto:photos&#64;{{ config('proto.emaildomain') }}">
                        photos&#64;{{ config('proto.emaildomain') }}.
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

            e.preventDefault();

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
