<div class="card achievement-{{ strtolower($achievement->tier) }} mb-3">

    <div class="card-header">

        <i class="{{ $achievement->fa_icon }} fa-fw mr-2 text-white"></i>

        <strong class="text-white">{{ $achievement->name }}</strong>

        @if(Auth::user()&&in_array($achievement, Auth::user()->achieved(), True))
            <i class="fas fa-check text-primary fa-fw" aria-hidden="true"
               data-toggle="tooltip" data-placement="top" title="You have achieved this!"></i>
        @endif

        @if(isset($include_delete_for) && $include_delete_for)
            <a href="{{ route('achievement::take', ['id' => $achievement->id, 'user' => $user->id]) }}"
               class="float-right text-white">
                <i class="fas fa-trash fa-fw ml-3"></i>
            </a>
        @endif

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

    <div class="card-body text-dark">

        {{ $achievement->desc }}

    </div>

    @if(isset($footer) && $footer)

        <div class="card-footer">
            {!! $footer !!}
        </div>

    @endif

</div>