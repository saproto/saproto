@extends('website.layouts.redesign.generic')

@section('page-title')
    Photo
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-12 col-lg-10 col-xl-8">

            <div class="card mb-3">

                <div class="card-header bg-dark text-end">

                    <a href="{{route("photo::album::list", ["id"=> $photo->album_id])}}"
                       class="btn btn-success float-start me-3">
                        <i class="fas fa-images me-3"></i> {{ $photo->album_name }}
                    </a>

                    @if ($photo->previous != null)
                        <a href="{{route("photo::view", ["id"=> $photo->previous])}}" class="btn btn-dark me-3">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    @else
                        <a class="btn btn-dark me-3" disabled>
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    @endif

                    @if ($photo->liked == null)
                        <a href="{{route("photo::likes", ["id"=> $photo->id])}}" class="btn btn-outline-info me-3">
                            <i class="far fa-heart"></i> {{ $photo->likes }}
                        </a>
                    @endif

                    @if($photo->liked != null)
                        <a href="{{route("photo::dislikes", ["id"=> $photo->id])}}" class="btn btn-info me-3">
                            <i class="fas fa-heart"></i> {{ $photo->likes }}
                        </a>
                    @endif

                    @if($photo->private)
                        <a href="javascript:void();" class="btn btn-info me-3" data-bs-toggle="tooltip"
                           data-bs-placement="top" title="This photo is only visible to members.">
                            <i class="fas fa-eye-slash"></i>
                        </a>
                    @endif

                    @if($photo->next != null)
                        <a href="{{route("photo::view", ["id"=> $photo->next])}}" class="btn btn-dark">
                            <i class="fas fa-arrow-end"></i>
                        </a>
                    @else
                        <a class="btn btn-dark" disabled>
                            <i class="fas fa-arrow-end"></i>
                        </a>
                    @endif

                </div>

                <img class="card-img-bottom" src="{!! $photo->photo_url !!}">

            </div>

            <div class="card mb-3">
                <div class="card-body text-center">
                    <i class="fas fa-shield-alt fa-fw me-3"></i>
                    If there is a photo that you would like removed, please contact
                    <a href="mailto:photos&#64;{{ config('proto.emaildomain') }}">
                        photos&#64;{{ config('proto.emaildomain') }}.
                    </a>
                </div>
            </div>

        </div>

    </div>

@endsection

@push('javascript')

    <script type="text/javascript" nonce="{{ csp_nonce() }}">

        $('main').on('keydown', (e) => {
            if (['ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'].includes(e.key))
                e.preventDefault();

            switch(e.key) {
                @if ($photo->previous != null)
                case 'ArrowLeft':
                    window.location.href = '{{route("photo::view", ["id"=> $photo->previous])}}';
                    break;
                @endif
                @if ($photo->next != null)
                case 'ArrowRight':
                    window.location.href = '{{route("photo::view", ["id"=> $photo->next])}}';
                    break;
                @endif
                @if (Auth::check())
                case 'ArrowUp':
                    window.location.href = '{{route("photo::likes", ["id"=> $photo->id])}}';
                    break;
                @endif
                @if (Auth::check())
                case 'ArrowDown':
                    window.location.href = '{{route("photo::dislikes", ["id"=> $photo->id])}}';
                    break;
                @endif
            }
        })

    </script>

    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        (function (window, location) {
            history.replaceState(null, document.title, location.pathname + "#!/stealingyourhistory");
            history.pushState(null, document.title, location.pathname);

            window.addEventListener("popstate", function () {
                if (location.hash === "#!/stealingyourhistory") {
                    history.replaceState(null, document.title, location.pathname);
                    setTimeout(function () {
                        location.replace("{{ route('photo::album::list', ['id' => $photo->album_id])."#photo_".$photo->id }}");
                    }, 0);
                }
            }, false);
        }(window, location));
    </script>

@endpush
