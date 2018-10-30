@extends('website.layouts.redesign.generic-sidebar')

@section('page-title')
    {{ $photos->album_title }} ({{ date('M j, Y', $photos->album_date) }})
@endsection

@section('container')

    @if($photos->event !== null)

        <a class="btn btn-info btn-block mb-3" href="{{ route('event::show', ['event_id'=>$photos->event->getPublicId()]) }}">
            These photos were taken at the event {{ $photos->event->title }}, click here for more info.
        </a>

    @endif

    <div class="card mb-3">

        <div class="card-header bg-dark text-white text-center">
            {{ $photos->album_title }} ({{ date('M j, Y', $photos->album_date) }})
        </div>

        <div class="card-body">

            <div class="row">

                @foreach($photos->photos as $key => $photo)

                    <div class="col-lg-2 col-lg-3 col-md-4 col-sm-6">

                        @include('website.layouts.macros.card-bg-image', [
                        'url' => route("photo::view", ["id"=> $photo->id]),
                        'img' => $photo->thumb,
                        'html' => sprintf('<i class="fas fa-heart"></i> %s %s',
                            $photo->getLikes(), $photo->private ?
                            '<i class="fas fa-eye-slash ml-4 mr-2 text-info" data-toggle="tooltip" data-placement="top" title="This photo is only visible to members."></i>'
                             : null),
                        'photo_pop' => true,
                        'height' => 200
                        ])

                    </div>

                @endforeach

            </div>

        </div>

        <div class="card-footer text-center">
            <i class="fas fa-shield-alt fa-fw mr-3"></i>
            If there is a photo that you would like removed, please contact
            <a href="mailto:photos&#64;{{ config('proto.emaildomain') }}">
                photos&#64;{{ config('proto.emaildomain') }}.
            </a>
        </div>

    </div>

@endsection

@section('javascript')

    @parent

    <script>
        (function (window, location) {
            history.replaceState(null, document.title, location.pathname + "#!/stealingyourhistory");
            history.pushState(null, document.title, location.pathname);

            window.addEventListener("popstate", function () {
                if (location.hash === "#!/stealingyourhistory") {
                    history.replaceState(null, document.title, location.pathname);
                    setTimeout(function () {
                        location.replace("{{ route('photo::albums')}}");
                    }, 0);
                }
            }, false);
        }(window, location));
    </script>

@endsection
