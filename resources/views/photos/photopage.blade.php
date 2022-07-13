<head>
    <style>
        img[data-src] {
            filter: blur(0.3em);
        }
        img {
            filter: blur(0em);
            transition: filter 0.5s;
        }
    </style>
</head>
@extends('website.layouts.redesign.generic')

@section('page-title')
    Photo
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-auto">

            <div class="card mb-3">

                <div class="card-header bg-dark text-end">

                    <a href="{{route("photo::album::list", ["id"=> $photo->album_id])}}"
                       class="btn btn-success float-start me-3">
                        <i class="fas fa-images me-2"></i> {{ $photo->album->name }}
                    </a>

                    @if ($photo->getPreviousPhoto() != null && $photo->getPreviousPhoto()->id != $photo->id)
                        <a href="{{route("photo::view", ["id"=> $photo->getPreviousPhoto()->id])}}" class="btn btn-dark me-3">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    @endif

                    @if (Auth::user() && $photo->likedByUser(Auth::user()->id))
                        <a href="{{route("photo::dislikes", ["id"=> $photo->id])}}" class="btn btn-info me-3">
                            <i class="fas fa-heart"></i> {{ $photo->getLikes() }}
                        </a>
                    @elseif(Auth::user())
                        <a href="{{route("photo::likes", ["id"=> $photo->id])}}" class="btn btn-outline-info me-3">
                            <i class="far fa-heart"></i> {{ $photo->getLikes() }}
                        </a>
                    @endif

                    @if($photo->private)
                        <a href="#" class="btn btn-info me-3" data-bs-toggle="tooltip"
                           data-bs-placement="top" title="This photo is only visible to members.">
                            <i class="fas fa-eye-slash"></i>
                        </a>
                    @endif

                    @if($photo->getNextPhoto() != null && $photo->getNextPhoto()->id != $photo->id)
                        <a href="{{route("photo::view", ["id"=> $photo->getNextPhoto()->id])}}" class="btn btn-dark">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    @endif

                </div>
                @if($photo->mayViewPhoto(Auth::user()))
                <img id="progressive-img" class="card-img-bottom" src="{!!$photo->getTinyUrl()!!}"  data-src="{!!$photo->getOriginalUrl()!!}" style="height: 75vh; object-fit:contain">
                @else
                    <div class="d-flex justify-content-center mb-3 mt-3">
                        This photo is only visible to members!
                    </div>
                @endif
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
        document.addEventListener('keydown', e => {
            if (['ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'].includes(e.key))
                e.preventDefault();

            switch(e.key) {
                @if ($photo->getPreviousPhoto() != null)
                case 'ArrowLeft':
                    window.location.href = '{{route("photo::view", ["id"=> $photo->getPreviousPhoto()->id])}}';
                    break;
                @endif
                @if ($photo->getNextPhoto() != null)
                case 'ArrowRight':
                    window.location.href = '{{route("photo::view", ["id"=> $photo->getNextPhoto()->id])}}';
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
        let image = document.getElementById('progressive-img');
            image.setAttribute('src', image.getAttribute('data-src'));
            image.onload = () => {
                image.removeAttribute('data-src');
            };
    </script>

    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        history.replaceState(null, document.title, location.pathname+"#!/history")
        history.pushState(null, document.title, location.pathname)

        window.addEventListener("popstate", function() {
            if(location.hash === "#!/history") {
                history.replaceState(null, document.title, location.pathname)
                setTimeout(_ => location.replace("{{ route('photo::album::list', ['id' => $photo->album_id])."?page=".$photo->getAlbumPageNumber(24) }}"), 10)
            }
        }, false)
    </script>
@endpush
