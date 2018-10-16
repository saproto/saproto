<div class="card achievement-{{ strtolower($achievement->tier) }} mb-3">

    <div class="card-header">

        <i class="fas fa-{{ $achievement->fa_icon }} fa-fw mr-2 text-white"></i>

        <strong class="text-white">{{ $achievement->name }}</strong>

        <span class="float-right">
                @for($i = 0; $i < 5; $i++)
                @if ($i >= $achievement->numberOfStars())
                    <i class="far fa-star"></i>
                @else
                    <i class="fas fa-star"></i>
                @endif
            @endfor
            </span>

    </div>

    <div class="card-body bg-white text-dark">

            {{ $achievement->desc }}

    </div>

</div>