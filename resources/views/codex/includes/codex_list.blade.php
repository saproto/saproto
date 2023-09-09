<div class="card mb-3">
    <div class="card-header d-inline-flex justify-content-between">
        Codices
        <a href="{{ route('codex::add-codex') }}" class="btn btn-info badge">
            New Codex
        </a>
    </div>
    <div class="card-body">
        <ul>
            @foreach($codices as $codex)
                <li>
                    {{ $codex->name }}
                    <a href="{{ route('codex::edit-codex', ['codex' => $codex]) }}" class="btn btn-info badge">Edit</a>
                </li>
            @endforeach
        </ul>
    </div>
</div>