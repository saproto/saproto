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
                        <i class="fas fa-images me-2"></i> {{ $photo->album_name }}
                    </a>

                    @if ($photo->previous != null && $photo->previous != $photo->id)
                        <a href="{{route("photo::view", ["id"=> $photo->previous])}}" class="btn btn-dark me-3">
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
                        <a href="#" class="btn btn-info me-3" data-bs-toggle="tooltip"
                           data-bs-placement="top" title="This photo is only visible to members.">
                            <i class="fas fa-eye-slash"></i>
                        </a>
                    @endif

                    @if($photo->next != null && $photo->next != $photo->id)
                        <a href="{{route("photo::view", ["id"=> $photo->next])}}" class="btn btn-dark">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    @endif

                </div>

                <img class="card-img-bottom" src="{!! $photo->photo_url !!}"
                     style="max-height: 70vh; object-fit:scale-down">

            </div>

            <div class="card mb-3">
                <div class="card-body text-center">
                    <i class="fas fa-shield-alt fa-fw me-3"></i>
                    If there is a photo that you would like removed, please contact
                    <a href="mailto:photos&#64;{{ \Illuminate\Support\Facades\Config::string('proto.emaildomain') }}">
                        photos&#64;{{ \Illuminate\Support\Facades\Config::string('proto.emaildomain') }}.
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

            switch (e.key) {
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
        });
    </script>

    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        history.replaceState(null, document.title, location.pathname + '#!/history');
        history.pushState(null, document.title, location.pathname);

        window.addEventListener('popstate', function() {
            if (location.hash === '#!/history') {
                history.replaceState(null, document.title, location.pathname);
                setTimeout(_ => location.replace("{{ route('photo::album::list', ['id' => $photo->album_id])."?page=".$photo->albumPage }}"), 10);
            }
        }, false);
    </script>
@endpush
