<div class="card h-100">

    <div class="card-header bg-dark text-white">

        <span class="qq_like me-3 cursor-pointer" data-id="{{ $quote->id }}">
            <i class="fa-thumbs-up {{ $quote->liked(Auth::user()->id) ? "fas" : "far" }}"></i>
            <span>{{ count($quote->likes()) }}</span>
        </span>

        Posted by
        @if($quote->user->isMember)
            <a href="{{ route('user::profile', ['id' => $quote->user->getPublicId()]) }}" class="text-white">
                {{ $quote->user->name }}
            </a>
        @else
            {{ $quote->user->name }}
        @endif

        @can("board")
            <a href="{{ route('quotes::delete', ['id' => $quote->id]) }}" class="float-end ms-3"><i
                        class="fas fa-trash-alt text-white"></i></a>
        @endcan

    </div>

    <div class="card-body">

        <i class="text-muted fas fa-quote-left fa-pull-left"></i>

        {!! $quote["quote"] !!}


        <i class="text-muted fas fa-quote-right fa-pull-right"></i>

        <div class="text-muted text-end mt-2">
            <em><sub>-- {{ $quote->created_at->format("j M Y, H:i") }}</sub></em>
        </div>

    </div>

</div>
