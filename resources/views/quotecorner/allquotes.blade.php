<div class="card mb-3">

    <div class="card-header pb-0 overflow-auto">
        {{ $data->links() }}
    </div>

    <div class="card-body">

        @if(count($data) > 0)

            <div class="row">

                @foreach($data as $key => $entry)

                    <div class="col-md-6 col-sm-12 mb-3">

                        @include('quotecorner.include.quote', [
                        'quote' => $entry
                        ])

                    </div>

                @endforeach

            </div>

        @endif

    </div>

    @if(count($data)>10)
    <div class="card-header pb-0 overflow-auto">
        {{ $data->links() }}
    </div>
    @endif
</div>
