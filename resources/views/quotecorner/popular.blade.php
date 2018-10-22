@if($popular)

    <div class="card">

        <div class="card-header bg-dark text-white">
            Most popular recent quote
        </div>

        <div class="card-body">

            @include('quotecorner.include.quote', [
            'quote' => $popular
            ])

        </div>

    </div>

@endif