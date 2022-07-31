<head>
    <style>
        img[data-src] {
            filter: blur(0.3em);
        }

        img {
            filter: blur(0em);
            transition: filter 0.1s;
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

                    <a id="albumUrl"
                       href="{{route("photo::album::list", ["id"=> $photo->album_id])."?page=".$photo->getAlbumPageNumber(24)}}"
                       class="btn btn-success float-start me-3">
                        <i class="fas fa-images me-2"></i> {{ $photo->album->name }}
                    </a>

                    <a id="download" href="{{$photo->getOriginalUrl()}}" download
                       class="btn btn-success float-start me-3">
                        <i class="fas fa-download me-2"></i> high-res
                    </a>


                    <button id="previousBtn"
                            class="btn btn-dark me-3 {{$photo->getPreviousPhoto(Auth::user()) != null?'' : 'd-none'}}">
                        <i class="fas fa-arrow-left"></i>
                    </button>


                    <button id="likeBtn" class="btn btn-info me-3 {{Auth::user() != null?'' : 'd-none'}}">
                        <i class="{{Auth::user()&&$photo->likedByUser(Auth::user())?'fas':'far'}} fa-heart"></i><span> {{ $photo->getLikes() }}</span>
                    </button>


                    @if($photo->private)
                        <a href="#" class="btn btn-info me-3" data-bs-toggle="tooltip"
                           data-bs-placement="top" title="This photo is only visible to members.">
                            <i class="fas fa-eye-slash"></i>
                        </a>
                    @endif

                    <button id="nextBtn"
                            class="btn btn-dark {{$photo->getNextPhoto(Auth::user()) != null?'' : 'd-none'}}">
                    <i class="fas fa-arrow-right"></i>
                    </button>

                </div>
                @if($photo->mayViewPhoto(Auth::user()))
                    <img id="photo" class="card-img-bottom" src="{!!$photo->getTinyUrl()!!}"
                         data-src="{!!$photo->getLargeUrl()!!}" style="height: 75vh; object-fit:contain">
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
        let id = {{$photo->id}};
        const likeBtn = document.getElementById('likeBtn');
        const albumUrl = document.getElementById('albumUrl');
        const downloadUrl = document.getElementById('download');
        const nextBtn = document.getElementById('nextBtn');
        const previousBtn = document.getElementById('previousBtn');
        const photoElement = document.getElementById('photo');
        likeBtn.addEventListener('click', _ => {
            switchLike(likeBtn)
        })
        nextBtn.addEventListener('click', _ => {
            swapPhoto(true);
        })
        previousBtn.addEventListener('click', _ => {
            if (!previousBtn.classList.contains('d-none')) {
                swapPhoto(false);
            }
        })

        function swapPhoto(next) {
            var route = next ? '{{ route('api::photos::getNextPhoto', ['id' => ':id']) }}' : '{{ route('api::photos::getPreviousPhoto', ['id' => ':id']) }}';
            get(route.replace(':id', id), null, {parse: true})
                .then((nextPhoto) => {
                    if (nextPhoto.hasOwnProperty('message')) {
                        throw nextPhoto.message;
                    }
                    id = nextPhoto.id
                    photoElement.setAttribute('data-src', nextPhoto.largeUrl)
                    photoElement.setAttribute('src', nextPhoto.tinyUrl)
                    const icon = likeBtn.children[0]
                    const likes = likeBtn.children[1]
                    nextPhoto.likedByUser ? icon.classList.replace('far', 'fas') : icon.classList.replace('fas', 'far')
                    nextPhoto.hasNextPhoto ? nextBtn.classList.remove('d-none') : nextBtn.classList.add('d-none');
                    nextPhoto.hasPreviousPhoto ? previousBtn.classList.remove('d-none') : nextBtn.classList.add('d-none');
                    likes.innerHTML = nextPhoto.likes;
                    albumUrl.href = nextPhoto.albumUrl;
                    downloadUrl.href = nextPhoto.originalUrl;
                    window.history.replaceState(document.title, '', id);
                })
                .catch(err => {
                    console.error(err)
                    window.alert('Something went wrong getting the photo. '.concat(err))
                })
        }

        function switchLike(outputElement) {
            get('{{ route('photo::like', ['id' => ':id']) }}'.replace(':id', id), null, {parse: true})
                .then((data) => {
                    const icon = outputElement.children[0]
                    const likes = outputElement.children[1]
                    data.likedByUser ? icon.classList.replace('far', 'fas') : icon.classList.replace('fas', 'far')
                    likes.innerHTML = data.likes;
                })
                .catch(err => {
                    console.error(err)
                    window.alert('Something went wrong (dis)liking the photo. Please try again.')
                })
        }

        document.addEventListener('keydown', e => {
            if (['ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'].includes(e.key))
                e.preventDefault();

            switch (e.key) {
                case 'ArrowLeft':
                    if (!previousBtn.classList.contains('d-none')) {
                        swapPhoto(false);
                    }
                    break;
                case 'ArrowRight':
                    if (!nextBtn.classList.contains('d-none')) {
                        swapPhoto(true);
                    }
                    break;
                @if (Auth::check())
                case 'ArrowUp':
                    switchLike(likeBtn);
                    break;
                @endif
                @if (Auth::check())
                case 'ArrowDown':
                    document.getElementById('download').click();
                    break;
                    @endif
            }
        })

        photoElement.onload = () => {
            changeToLargeImage();
        };

        if(photoElement.complete){
            changeToLargeImage();
        }

        function changeToLargeImage(){
            if (photoElement.hasAttribute('data-src')) {
                photoElement.setAttribute('src', photoElement.getAttribute('data-src'));
                photoElement.removeAttribute('data-src');
                photoElement.style["-webkit-filter"] = "blur(0px)";
            }
        }
    </script>
@endpush
