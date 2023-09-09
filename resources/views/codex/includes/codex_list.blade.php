<div class="card mb-3">
    <div class="card-header">
        Codices
    </div>
    <div class="card-body">
        <ul>
            @foreach($codices as $codex)
                <li>
                    {{ $codex->name }}
                </li>
            @endforeach
        </ul>
    </div>
</div>