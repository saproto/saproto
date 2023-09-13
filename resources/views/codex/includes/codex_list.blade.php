<div class="card mb-3">
    <div class="card-header d-inline-flex justify-content-between">
        Codices
        <a href="{{ route('codex::add-codex') }}" class="btn btn-info badge">
            New Codex
        </a>
    </div>
    <div class="card-body">

            @foreach($codices as $codex)
            <div class="card border">
                <div class="card-header border-bottom-0 d-inline-flex justify-content-between w-100">
                    {{ $codex->name }}
                    <span>
                        <a href="{{ route('codex::export', ['id' => $codex->id]) }}" class="btn btn-primary badge">Export</a>
                        <a href="{{ route('codex::edit-codex', ['codex' => $codex]) }}" class="btn btn-info badge">Edit</a>
                        <a href="{{ route('codex::delete-codex', ['codex' => $codex]) }}" class="btn btn-danger badge">Delete</a>
                    </span>
                </div>
            </div>
            @endforeach
    </div>
</div>