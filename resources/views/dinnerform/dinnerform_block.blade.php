<div class="card mb-3 leftborder leftborder-info">
    <a style="text-decoration: none !important;"
       href="{{ route("dinnerform::show", ['id' => $dinnerform->getPublicId()]) }}">
        <div class="card-body" style="text-align: left;">
            @if($dinnerform->hasEnded())
                <div class="btn btn-danger btn-block mb-3 ">
                    <i class="fas fa-lock fa-fw mr-2" aria-hidden="true"></i>
                    <span> This dinner form has ended </span>
                </div>
            @else
                <div class="btn btn-info btn-block mb-3 ">
                    <i class="fas fa-history fa-fw fa-pulse mr-2" aria-hidden="true"></i>
                    <span class="proto-countdown" data-countdown-start="{{ $dinnerform->end }}" data-countdown-text-counting="Closes in {}" data-countdown-text-finished="Food is underway!">
                            Counting down...
                        </span>
                </div>
            @endif

            <span>
                <i class="fas fa-utensils fa-fw" aria-hidden="true" style="color: gold"></i>
                <strong>{{ $dinnerform->restaurant }}</strong>
            </span>

            <br>

            <span>
                <i class="fas fa-clock fa-fw" aria-hidden="true"></i>
                {{ $dinnerform->generateTimespanText('D j M, H:i', 'H:i', '-') }}
            </span>

            <br>

            <span>
                <i class="fas fa-quote-left fa-fw" aria-hidden="true"></i>
                {{ $dinnerform->description }}
            </span>
        </div>
    </a>
    @if(Auth::user()->can('board'))
        <div class="card-footer bg-light border-bottom">
            <a href="{{ route("dinnerform::delete", ['id' => $dinnerform->id]) }}"
               class="btn btn-danger pull-left">Close</a>

            <a href="{{ route('dinnerform::edit', ['id' => $dinnerform->id]) }}"
               class="btn btn-default">Edit dinner form</a>
        </div>
    @endif

</div>