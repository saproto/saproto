<div class="card mb-3 w-100">

    <div class="card-header bg-dark text-white">
        <span class="m-0 float-left">Good Ideas</span>
        @if (Auth::user()->can("board"))
            <a href="{{ route('goodideas::archived') }}" class="float-right ml-3 px-2 py-1 badge badge-info">
                <i class="fas fa-file-archive text-white mr-1"></i> View Archived
            </a>
            @if(count($data) > 0)
                <a href="{{ route('goodideas::archiveall') }}" class="float-right ml-3 px-2 py-1 badge badge-warning">
                    <i class="fas fa-archive text-white mr-1"></i> Archive All
                </a>
            @endif
        @endif
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
