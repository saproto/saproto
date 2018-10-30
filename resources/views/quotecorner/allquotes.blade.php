<div class="card">

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

                {{ $data->links() }}

        @endif

    </div>

</div>
