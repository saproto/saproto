<div class="card achievement-{{ strtolower($achievement->tier) }} mb-3">

    <div class="card-header">

        <i class="{{ $achievement->fa_icon }} fa-fw me-2 text-white"></i>

        <strong class="text-white">{{ $achievement->name }}</strong>

        @foreach(Auth::user()->achieved() as $achievedMent)
            @if($achievedMent->id==$achievement->id)
            <i class="fas fa-check text-primary fa-fw" aria-hidden="true"
               data-bs-toggle="tooltip" data-bs-placement="top" title="You have achieved this!"></i>
            @endif
        @endforeach

        @if(isset($include_delete_for) && $include_delete_for)
            <a href="{{ route('achievement::take', ['id' => $achievement->id, 'user' => $user->id]) }}"
               class="float-end text-white">
                <i class="fas fa-trash fa-fw ms-3"></i>
            </a>
        @endif

        <span class="float-end">
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