@extends('website.layouts.redesign.generic-nonav')

@section('body')
    @if(!$activeDrink)
        No active drink!
    @else
        <div class="swiper-container swiper-container-free-mode h-50">
            <div class="swiper-wrapper h-100">
                @foreach($prices as $price)
                    <div id="{{$price->name}}" class="swiper-slide card w-25 h-25">
                        <div class="card-body event text-start {{ $price->image_url ? 'bg-img' : 'no-img'}}"
                             style="{{ sprintf('background: center no-repeat url(%s);', $price->img) }} background-size: cover;">

                            <strong>
                                {{$price->name}}
                            </strong>
                            <span>
                                {{$price->price}}
                            </span>
                                {{$price->diff}}
                            </div>
                        </div>
                @endforeach
            </div>
        </div>

        <div class="swiper-container swiper-container-free-mode h-50">
            <div class="swiper-wrapper h-100">
                @foreach($prices as $price)
                    <div id="{{$price->name}}" class="swiper-slide card w-25 h-25">
                        <div class="card-body event text-start {{ $price->image_url ? 'bg-img' : 'no-img'}} ml-10 mr-10"
                             style="{{ sprintf('background: center no-repeat url(%s);', $price->img) }} background-size: cover;">

                            <strong>
                                {{$price->name}}
                            </strong>
                            <span>
                                {{$price->price}}
                            </span>
                            {{$price->diff}}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection

@push('javascript')

    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js" nonce='{{ csp_nonce() }}'></script>
    <script type='text/javascript' nonce='{{ csp_nonce() }}'>
        get('{{route('api::wallstreet::updated_prices', ['id' => $activeDrink->id])}}').then((response)=>{
            console.log(response);
            }
        )
        var swiperOptions = {
            loop: true,
            autoplay: {
                delay: 1,
                disableOnInteraction: false,
                reverseDirection:true,
            },
            slidesPerView: 'auto',
            speed: 5000,
        };

        var swiper = new Swiper(".swiper-container", swiperOptions);
    </script>
    <style nonce='{{ csp_nonce() }}'>
        .swiper-container-free-mode > .swiper-wrapper{
            transition-timing-function : linear;
        }
        body{
            height:100vh;
        }
    </style>
@endpush