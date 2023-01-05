<div class="card mb-3 w-100">
    <div class="card-header bg-dark text-white">
        {{$category->title}}

        @can("board")
            <a href="{{ route('feedback::archiveall', ['category' => $category->url]) }}" class="float-end ms-3 btn btn-danger">
                <i class="fas fa-file-archive text-white"></i> Archive all
            </a>

            <a href="{{ route('feedback::archived', ['category' => $category->url]) }}" class="ms-3 btn btn-info">
                <i class="fas fa-box-archive text-white"></i> View archived
            </a>
        @endcan
        @if($data->links()!="")
                {{ $data->withQueryString()->links() }}
        @endif
    </div>

    <div class="card-body">

        @if(count($data) > 0)

            <div class="row">

                @foreach($data as $key => $entry)

                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">

                        @include('feedbackboards.include.feedback', [
                        'feedback' => $entry
                        ])

                    </div>

                @endforeach

            </div>

        @endif

    </div>

    @if($data->links() != "")
        <div class="card-footer">
            {{ $data->withQueryString()->links() }}
        </div>
    @endif

</div>
