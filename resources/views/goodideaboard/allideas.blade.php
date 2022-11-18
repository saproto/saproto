<div class="card mb-3 w-100">

    <div class="card-header bg-dark text-white">
        Good Ideas
        @can("board")
            <a href="{{ route('goodideas::archiveall') }}" class="float-end ms-3 btn btn-danger">
                <i class="fas fa-file-archive text-white"></i> Archive all
            </a>
        @endcan
    </div>

    <div class="card-body">

        @if(count($data) > 0)

            <div class="row">

                @foreach($data as $key => $entry)

                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">

                        @include('goodideaboard.include.idea', [
                        'idea' => $entry
                        ])

                    </div>

                @endforeach

            </div>

        @endif

    </div>

    @if($data->links() != "")
        <div class="card-footer">
            {{ $data->links() }}
        </div>
    @endif

</div>
